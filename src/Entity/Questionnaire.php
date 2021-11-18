<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\QuestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire extends Entity
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
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="integer")
     */
    private $order;

    /**
     * @ORM\Column(type="string",columnDefinition="enum('baseline','daily_calculated_five_days_before_menstruation','calculated_five_days_before_menstruation','calculated_first_day_of_menstruation','daily_during_menstruation','end_of_each_menstruation','end_of_every_third_menstruation','miscellaneous')")
     */
    private $moment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Study", inversedBy="questionnaires", cascade={"persist"})
     * @ORM\JoinColumn(name="study", referencedColumnName="id", nullable=false)
     */
    private $study;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MetaQuestion", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *     name="questionnaire_meta_question",
     *     joinColumns={
     *          @ORM\JoinColumn(name="questionnaire", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="meta_question", referencedColumnName="id")
     *     }
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $metaQuestions;

    /**
     * Questionnaire constructor.
     */
    public function __construct()
    {
        $this->metaQuestions = new ArrayCollection();
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
     * @return Questionnaire
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
     * @param string $label
     * @return Questionnaire
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

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
     * @return Questionnaire
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMoment(): ?string
    {
        return $this->moment;
    }

    /**
     * @param string $moment
     * @return Questionnaire
     */
    public function setMoment(string $moment): self
    {
        $this->moment = $moment;

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
     * @return Questionnaire
     */
    public function setStudy(Study $study): self
    {
        $this->study = $study;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getMetaQuestions(): ?array
    {
        return $this->metaQuestions->toArray();
    }

    /**
     * @param Collection $metaQuestions
     * @return Questionnaire
     */
    public function setMetaQuestions(Collection $metaQuestions):self
    {
        $this->metaQuestions = $metaQuestions;

        return $this;
    }

    /**
     * @param MetaQuestion $metaQuestion
     * @return Questionnaire
     */
    public function addMetaQuestion(MetaQuestion $metaQuestion):self
    {
        $this->metaQuestions->add($metaQuestion);

        return $this;
    }

    /**
     * @param MetaQuestion $metaQuestion
     * @return bool
     */
    public function removeMetaQuestion(MetaQuestion $metaQuestion): bool
    {
        return $this->metaQuestions->removeElement($metaQuestion);
    }
}

