<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\StudyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudyRepository::class)
 */
class Study extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="study", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="study", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Questionnaire", mappedBy="study", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $questionnaires;

    /**
     * Study constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->questionnaires = new ArrayCollection();
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Study
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getPublished(): ?DateTimeInterface
    {
        return $this->published;
    }

    /**
     * @param DateTimeInterface|null $published
     * @return Study
     */
    public function setPublished(?DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @param User $user
     * @return Study
     */
    public function addUser(User $user): self
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function removeUser(User $user): bool
    {
        return $this->users->removeElement($user);
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param Answer $answer
     * @return Study
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

    /**
     * @param Questionnaire $questionnaire
     * @return Study
     */
    public function addQuestionnaire(Questionnaire $questionnaire): self
    {
        $this->questionnaires[] = $questionnaire;

        return $this;
    }

    /**
     * @param Questionnaire $questionnaire
     * @return bool
     */
    public function removeQuestionnaire(Questionnaire $questionnaire): bool
    {
        return $this->questionnaires->removeElement($questionnaire);
    }

    /**
     * @return Collection
     */
    public function getQuestionnaires(): Collection
    {
        return $this->questionnaires;
    }
}

