<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $answer;

    /**
     * @ORM\Column(name="answer_id", type="string", length=255)
     */
    private $answerId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cycle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day;

    /**
     * @ORM\Column(name="app_version", type="string", length=255, nullable=true)
     */
    private $appVersion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Study", inversedBy="answers", cascade={"persist"})
     * @ORM\JoinColumn(name="study", referencedColumnName="id", nullable=false)
     */
    private $study;

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
    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    /**
     * @param string|null $answer
     * @return Answer
     */
    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnswerId(): ?string
    {
        return $this->answerId;
    }

    /**
     * @param string $answerId
     * @return Answer
     */
    public function setAnswerId(string $answerId): self
    {
        $this->answerId = $answerId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCycle(): ?int
    {
        return $this->cycle;
    }

    /**
     * @param int|null $cycle
     * @return Answer
     */
    public function setCycle(?int $cycle): self
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getDay(): ?int
    {
        return $this->day;
    }

    /**
     * @param int|null $day
     * @return Answer
     */
    public function setDay(?int $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAppVersion(): ?string
    {
        return $this->appVersion;
    }

    /**
     * @param string|null $appVersion
     * @return Answer
     */
    public function setAppVersion(?string $appVersion): self
    {
        $this->appVersion = $appVersion;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Answer
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

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
     * @return Answer
     */
    public function setStudy(Study $study): self
    {
        $this->study = $study;

        return $this;
    }
}

