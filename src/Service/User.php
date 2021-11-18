<?php

namespace App\Service;

use App\Entity\User AS UserEntity;
use App\Entity\Group;
use App\Entity\Study;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use BadFunctionCallException;
use DateTime;
use DateTimeZone;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;
use InvalidArgumentException;
use Doctrine\ORM\NonUniqueResultException;
use App\Repository\GroupRepository;
use App\Repository\StudyRepository;
use App\Repository\UserRepository;
use App\Repository\FeatureRepository;

class User
{
    const USER_ID_LENGTH = 32;
    const ERROR_NO_USER_FOUND_WITH_GIVEN_AUTH = 'No user found with given auth.';
    const FIELD_LEFT_AT = 'left_at';

    /**
     * @var array
     */
    private $lastUser;

    /**
     * @var NextGroup
     */
    private $nextGroup;

    /**
     * @var GroupRepository
     */
    private $group;

    /**
     * @var StudyRepository
     */
    private $study;

    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var FeatureRepository
     */
    private $feature;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * User constructor.
     * @param NextGroup $nextGroup
     * @param GroupRepository $group
     * @param StudyRepository $study
     * @param UserRepository $user
     * @param FeatureRepository $feature
     * @param EntityManagerInterface $em
     */
    public function __construct(
        NextGroup $nextGroup,
        GroupRepository $group,
        StudyRepository $study,
        UserRepository $user,
        FeatureRepository $feature,
        EntityManagerInterface $em
    )
    {
        $this->nextGroup = $nextGroup;
        $this->group = $group;
        $this->study = $study;
        $this->user = $user;
        $this->feature = $feature;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function checkAuth(Request $request)
    {
        $auth = $request->headers->get('User-Auth');
        try {
            $this->get($auth);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['ok' => false], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @return string
     * @throws NonUniqueResultException
     */
    public function create(): string
    {
        $groupId = $this->consumeGroup();
        $key = $this->generatePassword();
        $hash = password_hash($key, PASSWORD_BCRYPT);
        $study = $this->getCurrentStudy();
        $id = $this->insert($hash, $groupId, $study);

        return $id.'_'.$key;
    }

    /**
     * @param string $hash
     * @param int $groupId
     * @param int $studyId
     * @return int|null
     * @throws Exception
     */
    public function insert(string $hash, int $groupId, int $studyId): ?int
    {
        // Manage entity relationship
        $study = $this->em->getRepository(Study::class)->findOneById($studyId);
        $group = $this->em->getRepository(Group::class)->findOneById($groupId);

        if($study === null || $group === null) {
            return null;
        }

        $user = new UserEntity();
        $user->setVersion(0);
        $user->setKeyHash($hash);
        $user->setGroup($group);
        $user->setStudy($study);
        $user->setCreatedAt(new DateTime());
        $user->setUpdatedAt(new DateTime());
        $this->em->persist($user);
        $this->em->flush();

        return $user->getId();
    }

    /**
     * @return int
     * @throws NonUniqueResultException
     */
    protected function consumeGroup(): int
    {
        $groupName = $this->nextGroup->consume();
        $group = $this->group->getIdsByName($groupName);
        if ($group === null) {
            $this->nextGroup->invalidate($groupName);
            throw new UnexpectedValueException('Next group resulted in invalid group name.');
        }

        return $group['id'];
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function generatePassword(): string
    {
        return bin2hex(random_bytes(static::USER_ID_LENGTH));
    }

    /**
     * @return int
     * @throws NonUniqueResultException
     */
    protected function getCurrentStudy(): int
    {
        $study = $this->study->getLatestIds();
        if ($study === null) {
            throw new UnexpectedValueException('No current study available.');
        }

        return $study['id'];
    }

    /**
     * @param $auth
     * @return array
     * @throws Exception
     */
    public function get($auth): array
    {
        if (!$auth) {
            throw new InvalidArgumentException(static::ERROR_NO_USER_FOUND_WITH_GIVEN_AUTH);
        }

        $idAndKey = explode('_', $auth, 2);
        if (count($idAndKey) !== 2) {
            throw new InvalidArgumentException(static::ERROR_NO_USER_FOUND_WITH_GIVEN_AUTH);
        }

        $user = $this->user->getById((int)$idAndKey[0]);
        if ($user && password_verify($idAndKey[1], $user['key_hash'])) {
            unset($user['key_hash']);
            if ($user[static::FIELD_LEFT_AT] !== null) {
                $leftAt = $user[static::FIELD_LEFT_AT]->format('Y-m-d H:i:s');
                $user[static::FIELD_LEFT_AT] = $this->toISO8601UTCDateTime($leftAt);
            }
            $feature = $this->feature->getNamesByGroup((int)$user['group']);
            $features = array_column($feature, 'name');
            $user['features'] = $features;
            $this->lastUser = $user;

            return $user;
        }

        throw new InvalidArgumentException(static::ERROR_NO_USER_FOUND_WITH_GIVEN_AUTH);
    }

    /**
     * @return array
     */
    public function getLast(): array
    {
        if ($this->lastUser === null) {
            $message = 'The method "get" must be called before a last user can be fetched.';
            throw new BadFunctionCallException($message);
        }

        return $this->lastUser;
    }

    /**
     * @param string $datetime
     * @return string
     * @throws Exception
     */
    protected function toISO8601UTCDateTime(string $datetime): string
    {
        $iso8601Datetime = new DateTime($datetime);
        $iso8601Datetime->setTimezone(new DateTimeZone('UTC'));

        return $iso8601Datetime->format('Y-m-d\TH:i:s\Z');
    }

    /**
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function leaveStudy(int $id): bool
    {
        return $this->user->updateLeftAtById($id) == 1;
    }
}

