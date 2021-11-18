<?php

namespace App\Entity;

use App\Repository\FreeInputQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FreeInputQuestionRepository::class)
 */
class FreeInputQuestion extends Entity
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
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(name="answer_id", type="string", length=255)
     */
    private $answerId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MetaQuestion", inversedBy="freeInputQuestions", cascade={"persist"})
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
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return FreeInputQuestion
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
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
     * @return FreeInputQuestion
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
     * @param string $answerId
     * @return FreeInputQuestion
     */
    public function setAnswerId(string $answerId): self
    {
        $this->answerId = $answerId;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /**
     * @param int|null $min
     * @return FreeInputQuestion
     */
    public function setMin(?int $min): self
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getMax(): ?int
    {
        return $this->max;
    }

    /**
     * @param int|null $max
     * @return FreeInputQuestion
     */
    public function setMax(?int $max): self
    {
        $this->max = $max;

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
     * @return FreeInputQuestion
     */
    public function setMetaQuestion(MetaQuestion $metaQuestion): self
    {
        $this->metaQuestion = $metaQuestion;

        return $this;
    }
}

