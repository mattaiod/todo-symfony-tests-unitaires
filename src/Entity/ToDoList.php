<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
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

    public function addItemToDo(ItemToDo $itemToDo): self
    {
        if (!$this->itemToDos->contains($itemToDo)) {
            $this->itemToDos[] = $itemToDo;
            $itemToDo->setToDoList($this);
        }

        return $this;
    }

    public function removeItemToDo(ItemToDo $itemToDo): self
    {
        if ($this->itemToDos->removeElement($itemToDo)) {
            // set the owning side to null (unless already changed)
            if ($itemToDo->getToDoList() === $this) {
                $itemToDo->setToDoList(null);
            }
        }

        return $this;
    }

    public function validateNbItemEqual10()
    {
        if (count($this->getItemToDos()) <= 10) {
            return true;
        }
        return false;
    }

    public function validateNbItemEqual8()
    {
        if (count($this->getItemToDos()) == 8) {
            return true;
        }
        return false;
    }

    public function canAddNewItemCausedBy30MinutesMinimumLimit($dateTimeLastItem): bool
    {
        if ((date_timestamp_get(new \DateTime()) - $dateTimeLastItem) < 30 * 60) {
            return true;
        } else {
            return false;
        }
    }


    public function getDateTimeLastItem(){
//        $items = $this->getItemToDos();
//        foreach ($items as $item) {
//            $item->getCreatedAt()
    }

}
