<?php
namespace App\Tests\TestEnv;

use App\Service\NextGroup AS NextGroupService;
use App\Service\User AS UserService;
use App\Service\Answer AS AnswerService;
use App\Entity\Answer;
use App\Entity\Choice;
use App\Entity\ChoiceQuestion;
use App\Entity\Feature;
use App\Entity\FreeInputQuestion;
use App\Entity\Group;
use App\Entity\MetaQuestion;
use App\Entity\NextGroup;
use App\Entity\Questionnaire;
use App\Entity\ScaleQuestion;
use App\Entity\Study;
use App\Entity\User;
use App\Service\Localization;
use App\Service\Reader;
use App\Service\Reader\ChoiceQuestionReader;
use App\Service\Reader\ChoiceQuestionsChoiceReader;
use App\Service\Reader\FreeInputQuestionReader;
use App\Service\Reader\MetaQuestionGroupReader;
use App\Service\Reader\MetaQuestionReader;
use App\Service\Reader\QuestionnaireMetaQuestionReader;
use App\Service\Reader\QuestionnaireReader;
use App\Service\Reader\ScaleQuestionReader;
use DateTime;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use ReflectionClass;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class TestUtils
 * @package App\Tests\TestEnv
 */
class TestUtils extends KernelTestCase
{
    /**
     * @param $object
     * @param $property
     * @param $value
     * @throws \ReflectionException
     */
    public static function setProperty(&$object, $property, $value)
    {
        $reflectionClass = new ReflectionClass(get_class($object));
        $reflectionProperty = $reflectionClass->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $value);
    }

    /**
     * @return array
     */
    public static function getAdminAuth(): array
    {
        return ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin'];
    }

    /**
     * @return array
     */
    public static function getApiAuth(): array
    {
        return ['PHP_AUTH_USER' => 'api', 'PHP_AUTH_PW' => 'api'];
    }

    /**
     * @return string
     */
    public static function getAuthUser(): string
    {
        return '1105_650d143a9495d0bd22006a0b5d305b6897eb75c74dcf44990fb67598246c3b8d';
    }

    /**
     * @return array
     */
    public static function getApiAuthWithUserAuth(): array
    {
        return [
            'PHP_AUTH_USER' => 'api',
            'PHP_AUTH_PW' => 'api',
            'HTTP_USER_AUTH' => '1105_650d143a9495d0bd22006a0b5d305b6897eb75c74dcf44990fb67598246c3b8d'
        ];
    }

    public static function getApiAuthWrongUserAuth(): array
    {
        return [
            'PHP_AUTH_USER' => 'api',
            'PHP_AUTH_PW' => 'api',
            'HTTP_USER_AUTH' => 'test_7aedf61173a71b65005df15861db407c2deca78a51a884937c42f920a4dbd318'
        ];
    }

    /**
     * @return array
     */
    public static function getHeader(): array
    {
        return ['headers' => ['Content-Type' => 'application/json']];
    }

    /**
     * @return string
     */
    public static function getWrongAnswerData(): string
    {
        $answer = ['answers' => [
            ['answer' => 'nisieliteu', 'answer_id' => 36245, 'cycle' => 23],
            ['answer' => 'Utullamcoincididun', 'answer_id' => 9510, 'cycle' => null],
            ['answer' => 'nisisitExcepteur', 'answer_id' => 4119, 'cycle' => 6]
        ]];

        return json_encode($answer);
    }

    /**
     * @return string
     */
    public static function getCorrectAnswerData(): string
    {
        $answer = ['answers' => [
            ['answer' => 'Utullamcoincididun', 'answer_id' => '9510', 'cycle' => null],
            ['answer' => 'nisisitExcepteur', 'answer_id' => '4119', 'cycle' => 6]
        ]];

        return json_encode($answer);
    }

    /**
     * @param $entityManager
     */
    public static function removeLastAnswersData($entityManager)
    {
        $answers =  $entityManager->getRepository(Answer::class)->createQueryBuilder('a')
            ->select('a.id')
            ->orderBy('a.id', 'DESC')
            ->getQuery()
            ->setMaxResults(2)
            ->getResult();

        foreach ($answers as $answer) {
            $record = $entityManager->getRepository(Answer::class)->find($answer['id']);
            $entityManager->remove($record);
            $entityManager->flush();
        }
    }

    /**
     * @param $entityManager
     */
    public static function removeLastNextGroupData($entityManager)
    {
        $nextGroups =  $entityManager->getRepository(NextGroup::class)->createQueryBuilder('ng')
            ->select('ng.id')
            ->orderBy('ng.id', 'DESC')
            ->getQuery()
            ->setMaxResults(12)
            ->getResult();

        foreach ($nextGroups as $nextGroup) {
            $record = $entityManager->getRepository(NextGroup::class)->find($nextGroup['id']);
            $entityManager->remove($record);
            $entityManager->flush();
        }
    }

    /**
     * @param $entityManager
     * @return Reader
     */
    public static function getReader($entityManager)
    {
        $metaQuestionRepository = $entityManager->getRepository(MetaQuestion::class);
        $freeInputQuestionRepository = $entityManager->getRepository(FreeInputQuestion::class);
        $scaleQuestionRepository = $entityManager->getRepository(ScaleQuestion::class);
        $choiceRepository = $entityManager->getRepository(Choice::class);
        $choiceQuestionRepository = $entityManager->getRepository(ChoiceQuestion::class);
        $questionnaireRepository = $entityManager->getRepository(Questionnaire::class);
        $localizationRepository = $entityManager->getRepository(\App\Entity\Localization::class);
        $localization = new Localization($localizationRepository);

        $metaQuestion = new MetaQuestionReader($metaQuestionRepository, $localization);
        $freeInputQuestion = new FreeInputQuestionReader($freeInputQuestionRepository, $localization);
        $scaleQuestion = new ScaleQuestionReader($scaleQuestionRepository, $localization);
        $cqc = new ChoiceQuestionsChoiceReader($choiceQuestionRepository, $choiceRepository, $localization);
        $choiceQuestion = new ChoiceQuestionReader($choiceQuestionRepository, $localization);
        $metaQuestionGroup = new MetaQuestionGroupReader($metaQuestionRepository, $localization);
        $qmq = new QuestionnaireMetaQuestionReader($questionnaireRepository, $localization);
        $questionnaire = new QuestionnaireReader($questionnaireRepository, $localization);

        return new Reader(
            $metaQuestion,
            $freeInputQuestion,
            $scaleQuestion,
            $cqc,
            $choiceQuestion,
            $metaQuestionGroup,
            $qmq,
            $questionnaire
        );
    }

    /**
     * @param $entityManager
     * @return object
     */
    public static function getUser($entityManager): object
    {
        $nextGroupRepository = $entityManager->getRepository(NextGroup::class);
        $groupRepository = $entityManager->getRepository(Group::class);

        $nextGroup = new NextGroupService(
            $nextGroupRepository,
            $groupRepository,
            $entityManager
        );

        $studyRepository = $entityManager->getRepository(Study::class);
        $userRepository = $entityManager->getRepository(User::class);
        $featureRepository = $entityManager->getRepository(Feature::class);

        return new UserService(
            $nextGroup,
            $groupRepository,
            $studyRepository,
            $userRepository,
            $featureRepository,
            $entityManager
        );
    }

    /**
     * @param $entityManager
     * @return object
     */
    public static function getAnswer($entityManager): object
    {
        $answerRepository = $entityManager->getRepository(Answer::class);
        $userRepository = $entityManager->getRepository(User::class);

        return new AnswerService(
            $answerRepository,
            $userRepository,
            static::getReader($entityManager),
            $entityManager
        );
    }

    /**
     * @param $entityManager
     * @return object
     */
    public static function getNextGroup($entityManager): object
    {
        $nextGroupRepository = $entityManager->getRepository(NextGroup::class);
        $groupRepository = $entityManager->getRepository(Group::class);

        return new NextGroupService($nextGroupRepository, $groupRepository, $entityManager);
    }

    /**
     * @param $entityManager
     * @return int
     */
    public static function updateInvalidByName($entityManager): int
    {
        return $entityManager->getRepository(NextGroup::class)->createQueryBuilder('ng')
            ->update()
            ->set('ng.invalid', 2)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $entityManager
     * @throws Exception
     */
    public static function updateStudy($entityManager)
    {
        $study = $entityManager->getRepository(Study::class)->find(1);
        $study->setDeletedAt(new DateTime());
        $entityManager->flush();
    }

    /**
     * @param $entityManager
     * @return bool
     */
    public static function updateGroupName($entityManager): bool
    {
        return $entityManager->getRepository(Group::class)->createQueryBuilder('g')
            ->update()
            ->set('g.name', ':name')
            ->setParameter('name', 'test')
            ->getQuery()
            ->execute();
    }

    /**
     * @return bool
     */
    public static function rollbackGroups(): bool
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $groups = [
            1 => 'acupressure',
            2 => 'recommendations',
            3 => 'acupressure_recommendations'
        ];

        $groupRepository = $entityManager->getRepository(Group::class);
        foreach ($groups as $key => $value) {
            $group = $groupRepository->find($key);
            $group->setName($value);
            $entityManager->flush();
        }

        return true;
    }

    /**
     * @return bool
     */
    public static function rollbackNextGroupInvalid(): bool
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(NextGroup::class)->createQueryBuilder('ng')
            ->update()
            ->set('ng.invalid', 0)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return bool
     */
    public static function rollbackNextGroupInvalidUsed(): bool
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        return $entityManager->getRepository(NextGroup::class)->createQueryBuilder('ng')
            ->update()
            ->set('ng.invalid', 0)
            ->set('ng.used', 0)
            ->where('ng.id > 1')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $userId
     */
    public static function deleteLastUser(int $userId)
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $user = $entityManager->getRepository(User::class)->find($userId);
        $entityManager->remove($user);
        $entityManager->flush();
    }

    /**
     * @throws Exception
     */
    public static function setLeftAt()
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $userId = explode('_', static::getAuthUser())[0];
        $user = $entityManager->getRepository(User::class)->find($userId);
        $user->setLeftAt(new DateTime());
        $entityManager->flush();
    }

    public static function rollbackLeftAt()
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $userId = explode('_', static::getAuthUser())[0];
        $user = $entityManager->getRepository(User::class)->find($userId);
        $user->setLeftAt(null);
        $entityManager->flush();
    }

    /**
     * @param $file
     * @throws DBALException
     */
    public static function execSQL($file)
    {
        $connectionParams = ['url' => $_ENV['DATABASE_URL']];
        $db = DriverManager::getConnection($connectionParams);
        $db->executeQuery(file_get_contents($file));
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public static function updateMaxDate()
    {
        $kernel = self::bootKernel();
        $entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $group = $entityManager->getRepository(Group::class)->find(1);
        $group->setCreatedAt(new DateTime());
        $entityManager->flush();

        return $entityManager->getRepository(Group::class)->getEtag();
    }
}

