<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ChoiceQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChoiceQuestionRepository::class)
 */
class ChoiceQuestion extends Entity
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
    private $type;

    /**
     * @ORM\Column(name="answer_id", type="string", length=255, nullable=true)
     */
    private $answerId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MetaQuestion", inversedBy="choiceQuestions", cascade={"persist"})
     * @ORM\JoinColumn(name="meta_question", referencedColumnName="id", nullable=false)
     */
    private $metaQuestion;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Choice", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="choice_question_choice",
     *     joinColumns={
     *          @ORM\JoinColumn(name="choice_question", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="choice", referencedColumnName="id")
     *     }
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $choices;

    /**
     * ChoiceQuestion constructor.
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return ChoiceQuestion
     */
    public function setType(string $type): self
    {
        $this->type = $type;

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
     * @param string|null $answerId
     * @return ChoiceQuestion
     */
    public function setAnswerId(?string $answerId): self
    {
        $this->answerId = $answerId;

        return $this;
    }

    /**
     * @return MetaQuestion
     */
    public function getMetaQuestion(): MetaQuestion
    {
        return $this->metaQuestion;
    }

    /**
     * @param MetaQuestion $metaQuestion
     * @return ChoiceQuestion
     */
    public function setMetaQuestion(MetaQuestion $metaQuestion): self
    {
        $this->metaQuestion = $metaQuestion;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getChoices(): ?array
    {
        return $this->choices->toArray();
    }

    /**
     * @param Collection $choices
     * @return ChoiceQuestion
     */
    public function setChoices(Collection $choices):self
    {
        $this->choices = $choices;

        return $this;
    }

    /**
     * @param Choice $choice
     * @return ChoiceQuestion
     */
    public function addChoice(Choice $choice):self
    {
        $this->choices->add($choice);

        return $this;
    }

    /**
     * @param Choice $choice
     * @return bool
     */
    public function removeChoice(Choice $choice): bool
    {
        return $this->choices->removeElement($choice);
    }
}

