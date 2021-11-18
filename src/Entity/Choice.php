<?php

namespace App\Entity;

use App\Repository\ChoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChoiceRepository::class)
 */
class Choice extends Entity
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
    private $text;

    /**
     * @ORM\Column(type="integer")
     */
    private $order;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "choice"})
     */
    private $type;

    /**
     * @ORM\Column(name="answer_id", type="string", length=255, nullable=true)
     */
    private $answerId;

    /**
     * @ORM\Column(name="answer_value", type="string", length=255, nullable=true)
     */
    private $answerValue;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $default;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MetaQuestion", inversedBy="choices", cascade={"persist"})
     * @ORM\JoinColumn(name="meta_question", referencedColumnName="id", nullable=true)
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Choice
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     * @return Choice
     */
    public function setText(?string $text): self
    {
        $this->text = $text;

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
     * @return Choice
     */
    public function setOrder(int $order): self
    {
        $this->order = $order;

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
     * @return Choice
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
     * @return Choice
     */
    public function setAnswerId(?string $answerId): self
    {
        $this->answerId = $answerId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnswerValue(): ?string
    {
        return $this->answerValue;
    }

    /**
     * @param string|null $answerValue
     * @return Choice
     */
    public function setAnswerValue(?string $answerValue): self
    {
        $this->answerValue = $answerValue;

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
     * @return Choice
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
     * @return Choice
     */
    public function setMax(?int $max): self
    {
        $this->max = $max;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @param string|null $default
     * @return Choice
     */
    public function setDefault(?string $default): self
    {
        $this->default = $default;

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
     * @return Choice
     */
    public function setMetaQuestion(MetaQuestion $metaQuestion): self
    {
        $this->metaQuestion = $metaQuestion;

        return $this;
    }
}

