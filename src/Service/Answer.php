<?php

namespace App\Service;

use App\Entity\Answer AS AnswerEntity;
use App\Entity\Study;
use App\Entity\User;
use DateTime;
use Exception;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityManagerInterface;

class Answer
{
    const FIELD_ANSWER_ID = 'answer_id';
    const CYCLE = 'cycle';
    const DAY = 'day';
    const ANSWER = 'answer';
    const APP_VERSION = 'app_version';
    const QUESTION_NOT_ANSWERED = '-1';
    const QUESTION_NOT_ASKED = '-2';
    const ID_SEPARATOR = '_';
    const CSV_DELIMITER = ';';

    /**
     * @var array
     */
    private $defaultAnswers;

    /**
     * @var AnswerRepository
     */
    private $answerRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Answer constructor.
     * @param AnswerRepository $answerRepository
     * @param UserRepository $userRepository
     * @param Reader $reader
     * @param EntityManagerInterface $em
     */
    public function __construct(
        AnswerRepository $answerRepository,
        UserRepository $userRepository,
        Reader $reader,
        EntityManagerInterface $em
    )
    {
        $this->answerRepository = $answerRepository;
        $this->userRepository = $userRepository;
        $this->reader = $reader;
        $this->em = $em;
    }

    /**
     * @param int $user
     * @return array
     */
    public function get(int $user): array
    {
        $answers = $this->answerRepository->getByUser($user);

        return array_map(function(array $answer) {
            $answer['id'] = (int)$answer['id'];
            $answer[static::CYCLE] = $answer[static::CYCLE] !== null ? (int)$answer[static::CYCLE] : null;
            $answer[static::DAY] = $answer[static::DAY] !== null ? (int)$answer[static::DAY] : null;
            return $answer;
        }, $answers);
    }

    /**
     * @param $handle
     * @param int $study
     */
    public function writeCSV($handle, int $study)
    {
        $writeToCSV = function(array $data) use ($handle) {
            fputcsv($handle, $data, static::CSV_DELIMITER);
            ob_flush();
            flush();
        };

        $answerIds = $this->getAnswerIds($study);
        $headlines = array_merge(['User', 'Group', 'Agreement to Consent', 'App Version'], $answerIds);
        $writeToCSV($headlines);

        $answers = $this->answerRepository->getByStudy($study);
        $userGroupMap = $this->userRepository->getGroupsByStudy($study);
        $answerIdToColumn = array_flip($answerIds);
        $userGroups = $this->userRepository->getGroupNamesByStudy($study);

        $row = [];
        $curUser = null;
        foreach ($answers as $answer) {
            $user = $answer['user'];
            $write = null;
            if ($user != $curUser) {
                if ($curUser !== null) {
                    $write = $row;
                }
                $curUser = $user;
                $row = array_merge([
                    $user,
                    $userGroups[$user],
                    'yes',
                    $answer[static::APP_VERSION]
                ], $this->getDefaultAnswersStudyGroup($study, (int)$userGroupMap[$user]));
            }

            if ($write !== null) {
                $writeToCSV($write);
            }
            $id = $this->getCompleteAnswerId($answer);

            // + 4 due to user id, group, agreement to consent and app version
            $row[$answerIdToColumn[$id] + 4] = $answer[static::ANSWER];
        }

        $writeToCSV($row);
    }


    /**
     * @param array $answer
     * @return string
     */
    protected function getCompleteAnswerId(array $answer): string
    {
        $prefix = function(string $field, string $type) use ($answer) {
            if ($answer[$field] !== null) {
                return '_'.$type.$answer[$field];
            }

            return '';
        };

        $id = $answer[static::FIELD_ANSWER_ID];
        $id .= $prefix(static::CYCLE, 'c');

        return $id . $prefix(static::DAY, 'd');
    }

    /**
     * @param int $study
     * @param int $group
     * @return array
     */
    protected function getDefaultAnswersStudyGroup(int $study, int $group): array
    {
        if(!isset($this->defaultAnswers[$study])) {
            $this->defaultAnswers[$study] = [];
        }

        if(!isset($this->defaultAnswers[$study][$group])) {
            $questions = $this->reader->read($group, $study, Localization::DEFAULT_LOCALE);
            $askedQuestions = $this->recursiveSearch($questions, static::FIELD_ANSWER_ID);
            $answerIds = $this->getAnswerIds($study);

            $result = array_map(function(string $id) use ($askedQuestions) {
                return isset($askedQuestions[explode(static::ID_SEPARATOR, $id)[0]]) ?
                    static::QUESTION_NOT_ANSWERED :
                    static::QUESTION_NOT_ASKED;
            }, $answerIds);

            $this->defaultAnswers[$study][$group] = $result;
        }

        return $this->defaultAnswers[$study][$group];
    }

    /**
     * @param $where
     * @param string $key
     * @param bool $value
     * @return array of key (value of former array) => true (resp. value given as default)
     */
    protected function recursiveSearch($where, string $key, bool $value = true): array
    {
        $results = [];
        if (is_array($where)) {
            if (isset($where[$key])) {
                $results[$where[$key]] = $value;
            }
            
            foreach ($where as $subarray) {
                $results = $results + $this->recursiveSearch($subarray, $key);
            }
        }

        return $results;
    }

    /**
     * @param int $study
     * @return array
     */
    protected function getAnswerIds(int $study): array
    {
        $answerIds = $this->answerRepository->getIdsByStudy($study);

        return array_map([$this, 'getCompleteAnswerId'], $answerIds);
    }

    /**
     * @param array $answers
     * @param int $userId
     * @param int $userStudy
     * @throws Exception
     */
    public function insertUserAnswers(array $answers, int $userId , int $userStudy)
    {
        array_walk($answers, function(&$answer) {
            $answer[static::CYCLE] = isset($answer[static::CYCLE]) ?  $answer[static::CYCLE] : null;
            $answer[static::DAY] = isset($answer[static::DAY]) ?  $answer[static::DAY] : null;
            $answer[static::APP_VERSION] = isset($answer[static::APP_VERSION]) ?  $answer[static::APP_VERSION] : null;
        });

        $rows = $this->answerRepository->getByUser($userId);
        $existingAnswers = [];
        foreach ($rows as $row) {
            $row[static::CYCLE] = $row[static::CYCLE] !== null ? (int)$row[static::CYCLE] : null;
            $row[static::DAY] = $row[static::DAY] !== null ? (int)$row[static::DAY] : null;
            $existingAnswers[$row[static::FIELD_ANSWER_ID].'_'.$row[static::CYCLE].'_'.$row[static::DAY]] = $row['id'];
        }

        $this->insertUpdate($existingAnswers, $answers, $userId, $userStudy);
    }

    /**
     * @param array $existingAnswers
     * @param array $answers
     * @param int $user
     * @param int $study
     * @throws Exception
     */
    protected function insertUpdate(array $existingAnswers, array $answers, int $user, int $study)
    {
        foreach ($answers as $answer) {
            $key = $answer[static::FIELD_ANSWER_ID].'_'.$answer[static::CYCLE].'_'.$answer[static::DAY];
            if (array_key_exists($key, $existingAnswers)) {
                $this->answerRepository->updateAnswer(
                    $answer[static::ANSWER],
                    $study,
                    $existingAnswers[$key],
                    $answer[static::APP_VERSION]
                );
            } else {
                $this->add(
                    $answer[static::ANSWER],
                    (int)$answer[static::FIELD_ANSWER_ID],
                    $user,
                    $study,
                    $answer[static::CYCLE],
                    $answer[static::DAY],
                    $answer[static::APP_VERSION]
                );
            }
        }
    }

    /**
     * @param string $text
     * @param int $answerId
     * @param int $user
     * @param int $study
     * @param int|null $cycle
     * @param int|null $day
     * @param string|null $appVersion
     * @return int|null
     * @throws Exception
     */
    public function add(
        string $text,
        int $answerId,
        int $user,
        int $study,
        int $cycle = null,
        int $day = null,
        string $appVersion = null
    ): ?int
    {
        // Manage entity relationship
        $study = $this->em->getRepository(Study::class)->findOneById($study);
        $user = $this->em->getRepository(User::class)->findOneById($user);

        if($study === null || $user === null) {
            return null;
        }

        $answer = new AnswerEntity();
        $answer->setVersion(0);
        $answer->setAnswer($text);
        $answer->setAnswerId($answerId);
        $answer->setCycle($cycle ?? null);
        $answer->setDay($day ?? null);
        $answer->setUser($user);
        $answer->setStudy($study);
        $answer->setAppVersion($appVersion ?? null);
        $answer->setCreatedAt(new DateTime());
        $answer->setUpdatedAt(new DateTime());
        $this->em->persist($answer);
        $this->em->flush();

        return $answer->getId();
    }
}

