<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\MetaQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MetaQuestionRepository::class)
 */
class MetaQuestion extends Entity
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $headline;

    /**
     * @ORM\Column(type="integer")
     */
    private $published;

    /**
     * @ORM\Column(type="integer")
     */
    private $order;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Choice", mappedBy="metaQuestion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $choices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ChoiceQuestion", mappedBy="metaQuestion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $choiceQuestions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FreeInputQuestion", mappedBy="metaQuestion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $freeInputQuestions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScaleQuestion", mappedBy="metaQuestion", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $scaleQuestions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="meta_question_group",
     *     joinColumns={
     *          @ORM\JoinColumn(name="meta_question", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="group", referencedColumnName="id")
     *     }
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $groups;

    /**
     * MetaQuestion constructor.
     */
    public function __construct()
    {
        $this->choices = new ArrayCollection();
        $this->choiceQuestions = new ArrayCollection();
        $this->freeInputQuestions = new ArrayCollection();
        $this->scaleQuestions = new ArrayCollection();
        $this->groups = new ArrayCollection();
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
     * @return MetaQuestion
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return MetaQuestion
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHeadline(): ?string
    {
        return $this->headline;
    }

    /**
     * @param string|null $headline
     * @return MetaQuestion
     */
    public function setHeadline(?string $headline): self
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPublished(): ?int
    {
        return $this->published;
    }

    /**
     * @param int $published
     * @return MetaQuestion
     */
    public function setPublished(int $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOrder(): ?int
    {
        return $this->order;
    }

    /**
     * @param int $order
     * @return MetaQuestion
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param Choice $choice
     * @return MetaQuestion
     */
    public function addChoice(Choice $choice): self
    {
        $this->choices[] = $choice;

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

    /**
     * @return Collection
     */
    public function getChoice(): Collection
    {
        return $this->choices;
    }

    /**
     * @param ChoiceQuestion $choiceQuestion
     * @return MetaQuestion
     */
    public function addChoiceQuestion(ChoiceQuestion $choiceQuestion): self
    {
        $this->choiceQuestions[] = $choiceQuestion;

        return $this;
    }

    /**
     * @param ChoiceQuestion $choiceQuestion
     * @return bool
     */
    public function removeChoiceQuestion(ChoiceQuestion $choiceQuestion): bool
    {
        return $this->choiceQuestions->removeElement($choiceQuestion);
    }

    /**
     * @return Collection
     */
    public function getChoiceQuestions(): Collection
    {
        return $this->choiceQuestions;
    }

    /**
     * @param FreeInputQuestion $freeInputQuestions
     * @return MetaQuestion
     */
    public function addFreeInputQuestion(FreeInputQuestion $freeInputQuestions): self
    {
        $this->freeInputQuestions[] = $freeInputQuestions;

        return $this;
    }

    /**
     * @param FreeInputQuestion $freeInputQuestions
     * @return bool
     */
    public function removeFreeInputQuestion(FreeInputQuestion $freeInputQuestions): bool
    {
        return $this->freeInputQuestions->removeElement($freeInputQuestions);
    }

    /**
     * @return Collection
     */
    public function getFreeInputQuestions(): Collection
    {
        return $this->freeInputQuestions;
    }

    /**
     * @param ScaleQuestion $scaleQuestion
     * @return MetaQuestion
     */
    public function addScaleQuestion(ScaleQuestion $scaleQuestion): self
    {
        $this->scaleQuestions[] = $scaleQuestion;

        return $this;
    }

    /**
     * @param ScaleQuestion $scaleQuestion
     * @return bool
     */
    public function removeScaleQuestion(ScaleQuestion $scaleQuestion): bool
    {
        return $this->scaleQuestions->removeElement($scaleQuestion);
    }

    /**
     * @return Collection
     */
    public function getScaleQuestions(): Collection
    {
        return $this->scaleQuestions;
    }

    /**
     * @return array|null
     */
    public function getGroups(): ?array
    {
        return $this->groups->toArray();
    }

    /**
     * @param Collection $group
     * @return MetaQuestion
     */
    public function setGroups(Collection $group):self
    {
        $this->groups = $group;

        return $this;
    }

    /**
     * @param Group $group
     * @return MetaQuestion
     */
    public function addGroup(Group $group):self
    {
        $this->groups->add($group);

        return $this;
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function removeGroup(Group $group): bool
    {
        return $this->groups->removeElement($group);
    }
}

