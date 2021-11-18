<?php

namespace App\Entity;

use App\Repository\ScaleQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ScaleQuestionRepository::class)
 */
class ScaleQuestion extends Entity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={"unsigned": true})
     */
    private $id;

    /**
     * @ORM\Column(name="min_text", type="string", length=255)
     */
    private $minText;

    /**
     * @ORM\Column(name="min_value", type="integer")
     */
    private $minValue;

    /**
     * @ORM\Column(name="max_text", type="string", length=255)
     */
    private $maxText;

    /**
     * @ORM\Column(name="max_value", type="integer")
     */
    private $maxValue;

    /**
     * @ORM\Column(name="answer_id", type="string", length=255)
     */
    private $answerId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MetaQuestion", inversedBy="scaleQuestions", cascade={"persist"})
     * @ORM\JoinColumn(name="meta_question", referencedColumnName="id", nullable=false)
     */
    private $metaQuestion;

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
    public function getMinText(): ?string
    {
        return $this->minText;
    }

    /**
     * @param string $minText
     * @return ScaleQuestion
     */
    public function setMinText(string $minText): self
    {
        $this->minText = $minText;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinValue(): ?int
    {
        return $this->minValue;
    }

    /**
     * @param int $minValue
     * @return ScaleQuestion
     */
    public function setMinValue(int $minValue): self
    {
        $this->minValue = $minValue;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMaxText(): ?string
    {
        return $this->maxText;
    }

    /**
     * @param string $maxText
     * @return ScaleQuestion
     */
    public function setMaxText(string $maxText): self
    {
        $this->maxText = $maxText;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxValue(): ?int
    {
        return $this->maxValue;
    }

    /**
     * @param int $maxValue
     * @return ScaleQuestion
     */
    public function setMaxValue(int $maxValue): self
    {
        $this->maxValue = $maxValue;

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
     * @return ScaleQuestion
     */
    public function setAnswerId(string $answerId): self
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
     * @return ScaleQuestion
     */
    public function setMetaQuestion(MetaQuestion $metaQuestion): self
    {
        $this->metaQuestion = $metaQuestion;

        return $this;
    }
}

