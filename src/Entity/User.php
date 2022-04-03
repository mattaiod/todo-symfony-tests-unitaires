<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;


    /**
     * @ORM\OneToOne(targetEntity=ToDoList::class, mappedBy="userApp", cascade={"persist", "remove"})
     */
    private $toDoList;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthday;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->toDoList;
    }

    public function setToDoList(ToDoList $toDoList): self
    {
        // set the owning side of the relation if necessary
        if ($toDoList->getUserApp() !== $this) {
            $toDoList->setUserApp($this);
        }

        $this->toDoList = $toDoList;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function validateEmail(): bool
    {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function validatePassword(): bool {
        $sizePassword = strlen($this->password);
        if ($sizePassword >= 8 && $sizePassword <= 40) {
            return true;
        }
        return false;
    }

    public function validateAge(): bool {
        $diff = date_diff($this->getBirthday(), date_create((new \DateTime("now"))->format("d-m-Y")));
        $age = $diff->format('%y');
        if ($age >= 13) {
            return true;
        }
        return false;
    }

    public function validateFirstname(): bool
    {
        return !empty($this->firstName);
    }

    public function validateLastname(): bool
    {
        return !empty($this->lastName);
    }

    public function isValid(): bool {
        if ($this->validateFirstname($this->firstName) === true
            && $this->validateLastName($this->lastName) === true
            && $this->validateEmail($this->email) === true
            && $this->validatePassword($this->password) === true
            && $this->validateAge($this->birthday)) {
            return true;
        }
        return false;
    }


}
