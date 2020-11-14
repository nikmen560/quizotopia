<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuizRepository::class)
 */
class Quiz
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=QuizQuestion::class, mappedBy="quiz", orphanRemoval=true)
     */
    private $quizQuestions;

    /**
     * @ORM\OneToMany(targetEntity=QuizUser::class, mappedBy="quiz", orphanRemoval=true)
     */
    private $quizUsers;

    public function __construct()
    {
        $this->quizQuestions = new ArrayCollection();
        $this->quizUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|QuizQuestion[]
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if (!$this->quizQuestions->contains($quizQuestion)) {
            $this->quizQuestions[] = $quizQuestion;
            $quizQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizQuestion): self
    {
        if ($this->quizQuestions->removeElement($quizQuestion)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestion->getQuiz() === $this) {
                $quizQuestion->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuizUser[]
     */
    public function getQuizUsers(): Collection
    {
        return $this->quizUsers;
    }

    public function addQuizUser(QuizUser $quizUser): self
    {
        if (!$this->quizUsers->contains($quizUser)) {
            $this->quizUsers[] = $quizUser;
            $quizUser->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizUser(QuizUser $quizUser): self
    {
        if ($this->quizUsers->removeElement($quizUser)) {
            // set the owning side to null (unless already changed)
            if ($quizUser->getQuiz() === $this) {
                $quizUser->setQuiz(null);
            }
        }

        return $this;
    }
}
