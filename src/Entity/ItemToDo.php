<?php

namespace App\Entity;

use App\Repository\ItemToDoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemToDoRepository::class)
 */
class ItemToDo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ToDoList::class, inversedBy="itemToDos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $toDoList;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToDoList(): ?ToDoList
    {
        return $this->toDoList;
    }

    public function setToDoList(?ToDoList $toDoList): self
    {
        $this->toDoList = $toDoList;

        return $this;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isValidContentUnder1000Chars () {
        $strlen = strlen($this->getContent());
        if ( $strlen <= 1000) {
            return true;
        }
        else {
            return false;
        }
    }

}
