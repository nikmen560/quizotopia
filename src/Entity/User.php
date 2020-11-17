<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(
     *     message="The email is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=QuizUser::class, mappedBy="user", orphanRemoval=true)
     */
    private $quizUsers;

    /**
     * @ORM\OneToMany(targetEntity=UserPosition::class, mappedBy="user", orphanRemoval=true)
     */
    private $userPostitions;

    public function __construct()
    {
        $this->quizUsers = new ArrayCollection();
        $this->userPostitions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getQuizUser(): ?QuizUser
    {
        return $this->quizUser;
    }

    public function setQuizUser(QuizUser $quizUser): self
    {
        $this->quizUser = $quizUser;

        // set the owning side of the relation if necessary
        if ($quizUser->getUser() !== $this) {
            $quizUser->setUser($this);
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
            $quizUser->setUser($this);
        }

        return $this;
    }

    public function removeQuizUser(QuizUser $quizUser): self
    {
        if ($this->quizUsers->removeElement($quizUser)) {
            // set the owning side to null (unless already changed)
            if ($quizUser->getUser() === $this) {
                $quizUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserPosition[]
     */
    public function getUserPostitions(): Collection
    {
        return $this->userPostitions;
    }

    public function addUserPostition(UserPosition $userPostition): self
    {
        if (!$this->userPostitions->contains($userPostition)) {
            $this->userPostitions[] = $userPostition;
            $userPostition->setUser($this);
        }

        return $this;
    }

    public function removeUserPostition(UserPosition $userPostition): self
    {
        if ($this->userPostitions->removeElement($userPostition)) {
            // set the owning side to null (unless already changed)
            if ($userPostition->getUser() === $this) {
                $userPostition->setUser(null);
            }
        }

        return $this;
    }
}
