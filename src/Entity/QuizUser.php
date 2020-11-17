<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QuizUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizUserRepository::class)
 */
class QuizUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="quizUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $currentQuestion;

    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="quizUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getCurrentQuestion(): ?int
    {
        return $this->currentQuestion;
    }

    public function setCurrentQuestion(int $currentQuestion): self
    {
        $this->currentQuestion = $currentQuestion;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
