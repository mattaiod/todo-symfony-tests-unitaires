<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use App\Service\EmailSenderService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="toDoList", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userApp;

    /**
     * @ORM\OneToMany(targetEntity=ItemToDo::class, mappedBy="toDoList", orphanRemoval=true)
     */
    private $itemToDos;

    public function __construct()
    {
        $this->itemToDos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserApp(): ?User
    {
        return $this->userApp;
    }

    public function setUserApp(User $userApp): self
    {
        $this->userApp = $userApp;

        return $this;
    }

    /**
     * @return Collection<int, ItemToDo>
     */
    public function getItemToDos(): Collection
    {
        return $this->itemToDos;
    }

    public function canAddItemToDo($itemTodo): bool
    {
        if (!$this->isNbItemLess10()) {
            return false;
        }
        if (!$this->isUniqueNameAmongTodo($itemTodo)) {
            return false;
        }
        if (!$this->canAddNewItemCausedBy30MinutesMinimumLimit()) {
            return false;
        }
        return true;
    }


    public function addItemToDo(ItemToDo $itemToDo): bool
    {
        if ($this->canAddItemToDo($itemToDo)) {
            return false;
        }

        if ($this->isCurrentItem8th()) {
            EmailSenderService::sendEmail();
        }

        $this->itemToDos[] = $itemToDo;
        $itemToDo->setToDoList($this);

        return true;
    }

    public function isCurrentItem8th(): bool
    {
        if (count($this->itemToDos) == 7) {
            return true;
        }
        return false;
    }


    public function isUniqueNameAmongTodo($currentItem): bool
    {
        foreach ($this->getItemToDos() as $item) {
            if ($item->getName() == $currentItem->getName())
                return false;
        }
        return true;
    }


    public
    function removeItemToDo(ItemToDo $itemToDo): self
    {
        if ($this->itemToDos->removeElement($itemToDo)) {
            // set the owning side to null (unless already changed)
            if ($itemToDo->getToDoList() === $this) {
                $itemToDo->setToDoList(null);
            }
        }

        return $this;
    }

    public
    function isNbItemLess10()
    {
        if (count($this->getItemToDos()) < 10) {
            return true;
        }
        return false;
    }

    public
    function isNbItemEqual7()
    {
        if (count($this->getItemToDos()) <= 8) {
            return true;
        }
        return false;
    }

    public function canAddNewItemCausedBy30MinutesMinimumLimit(): bool
    {
        if ((date_timestamp_get(new \DateTime()) - $this->getDateTimeLastItem()) <= 30 * 60) {
            return true;
        } else {
            return false;
        }
    }


    public function getDateTimeLastItem()
    {
        $itemToDos = $this->getItemToDos()->toArray();

        usort($itemToDos, function ($a, $b) {
            return $a->getCreatedAt() <=> $b->getCreatedAt();
        });
        return end($itemToDos);
    }
    }
