<?php

namespace App\Service;

use App\Entity\NextGroup AS NextGroupEntity;
use UnderflowException;
use DomainException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use App\Repository\NextGroupRepository;
use App\Repository\GroupRepository;

class NextGroup
{
    /**
     * @var NextGroupRepository
     */
    private $nextGroup;

    /**
     * @var GroupRepository
     */
    private $group;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * NextGroup constructor.
     * @param NextGroupRepository $nextGroup
     * @param GroupRepository $group
     * @param EntityManagerInterface $em
     */
    public function __construct(
        NextGroupRepository $nextGroup,
        GroupRepository $group,
        EntityManagerInterface $em
    )
    {
        $this->nextGroup = $nextGroup;
        $this->group = $group;
        $this->em = $em;
    }

    /**
     * @return string
     * @throws NonUniqueResultException
     */
    public function consume(): string
    {
        $nextGroup = $this->nextGroup->checkIfExists();
        if ($nextGroup === null) {
            throw new UnderflowException('No next group available.');
        }
        $this->nextGroup->updateUsedById($nextGroup['id']);

        return $nextGroup['group_name'];
    }

    /**
     * @param string $name
     */
    public function invalidate(string $name)
    {
        $this->nextGroup->updateInvalidByName($name);
    }

    /**
     * @param string $csvContent
     * @return int
     */
    public function importCSV(string $csvContent): int
    {
        $csvContent = preg_replace('~\r\n?~', "\n", $csvContent);
        $groupNames = [];
        $csvLines = str_getcsv($csvContent, "\n");
        foreach($csvLines as $index => $row) {
            if ($index === 0) {
                continue;
            }
            $values = str_getcsv($row, ';');
            if (count($values) < 2) {
                throw new DomainException('Group column not found in csv file.');
            }
            $groupNames[] = $values[1];
        }

        $this->validateGroupNames($groupNames);
        foreach ($groupNames as $item) {
            $this->add($item);
        }

        return count($groupNames);
    }

    /**
     * @param array $groupNames
     */
    protected function validateGroupNames(array $groupNames)
    {
        $names = $this->group->getNames();
        $groups = array_column($names, 'name');
        $uniqueGroupNames = array_unique($groupNames);
        $diff = array_diff($uniqueGroupNames, $groups);
        if (count($diff) > 0) {
            $implode = implode(', ', $diff);
            throw new DomainException('The following groups to import don\'t exist yet: ' . $implode);
        }
    }

    /**
     * @param string $name
     * @return int
     */
    public function add(string $name): int
    {
        $nextGroup = new NextGroupEntity();
        $nextGroup->setGroupName($name);
        $nextGroup->setUsed(0);
        $nextGroup->setInvalid(0);
        $this->em->persist($nextGroup);
        $this->em->flush();

        return $nextGroup->getId();
    }
}

