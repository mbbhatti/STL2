<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(name="key_hash", type="string", length=255)
     */
    private $keyHash;

    /**
     * @ORM\Column(name="left_at", type="datetime", nullable=true)
     */
    private $leftAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="`group`", referencedColumnName="id", nullable=false)
     */
    private $group;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Study", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="study", referencedColumnName="id", nullable=false)
     */
    private $study;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $answers;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

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
    public function getKeyHash(): ?string
    {
        return $this->keyHash;
    }

    /**
     * @param string $keyHash
     * @return User
     */
    public function setKeyHash(string $keyHash): self
    {
        $this->keyHash = $keyHash;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getLeftAt(): ?DateTimeInterface
    {
        return $this->leftAt;
    }

    /**
     * @param DateTimeInterface|null $leftAt
     * @return User
     */
    public function setLeftAt(?DateTimeInterface $leftAt): self
    {
        $this->leftAt = $leftAt;

        return $this;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     * @return User
     */
    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Study
     */
    public function getStudy(): Study
    {
        return $this->study;
    }

    /**
     * @param Study $study
     * @return User
     */
    public function setStudy(Study $study): self
    {
        $this->study = $study;

        return $this;
    }

    /**
     * @param Answer $answer
     * @return User
     */
    public function addAnswer(Answer $answer): self
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * @param Answer $answer
     * @return bool
     */
    public function removeAnswer(Answer $answer): bool
    {
        return $this->answers->removeElement($answer);
    }

    /**
     * @return Collection
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }
}

