<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $istrue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getQuestionId(): ?Question
    {
        return $this->question_id;
    }

    public function setQuestionId(?Question $question_id): self
    {
        $this->question_id = $question_id;

        return $this;
    }

    public function getIstrue(): ?bool
    {
        return $this->istrue;
    }

    public function setIstrue(bool $istrue): self
    {
        $this->istrue = $istrue;

        return $this;
    }
}
