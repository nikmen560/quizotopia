<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserPositionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserPositionRepository::class)
 */
class UserPosition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userPostitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Quiz::class, inversedBy="userPositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quiz;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $result;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $spendedTime;
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

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

    public function getSpendedTime(): ?\DateInterval
    {
        return $this->spendedTime;
    }

    public function setSpendedTime(\DateInterval $spendedTime): self
    {
        $this->spendedTime = $spendedTime;

        return $this;
    }
}
