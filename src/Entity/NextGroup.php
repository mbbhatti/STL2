<?php

namespace App\Entity;

use App\Repository\NextGroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NextGroupRepository::class)
 */
class NextGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(name="group_name", type="string", length=255)
     */
    private $groupName;

    /**
     * @ORM\Column(type="integer", length=1, options={"default" : 1})
     */
    private $used;

    /**
     * @ORM\Column(type="integer", length=1, options={"default" : 0})
     */
    private $invalid;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     * @return NextGroup
     */
    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUsed(): ?int
    {
        return $this->used;
    }

    /**
     * @param int $used
     * @return NextGroup
     */
    public function setUsed(int $used): self
    {
        $this->used = $used;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInvalid(): ?int
    {
        return $this->invalid;
    }

    /**
     * @param int $invalid
     * @return NextGroup
     */
    public function setInvalid(int $invalid): self
    {
        $this->invalid = $invalid;

        return $this;
    }
}

