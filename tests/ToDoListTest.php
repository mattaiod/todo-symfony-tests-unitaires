<?php

namespace App\Tests;

use App\Controller\ToDoListController;
use App\Entity\ItemToDo;
use App\Entity\ToDoList;
use App\Entity\User;
use App\Repository\ToDoListRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Date;

class ToDoListTest extends TestCase
{


    public function testMoreThanTenItems()
    {
        $todolist = new ToDoList();
        $item = new ItemToDo();
        for ($i = 0; $i < 5; $i++) {
            $todolist->addItemToDo($item);
        }
        $this->assertTrue($todolist->isNbItemLess10());
    }

    public function testImpossibilityToAddItemWithNonUniqueName(): void
    {
        $todolist = new ToDoList();
        $item = new ItemToDo();
        $item->setName("uniqueName");
        $item2 = new ItemToDo();
        $item2->setName("uniqueName");
        $todolist->addItemToDo($item);
        $this->assertFalse($todolist->isUniqueNameAmongTodo($item2));
    }

    public function testSendEmailAt8thElement(): void
    {
        $todolist = new ToDoList();
        $item = new ItemToDo();
        for ($i = 0; $i < 7; $i++) {
            $todolist->addItemToDo($item);
        }
        $this->assertTrue($todolist->isCurrentItem8th());
    }

    public function testCreateItemAfter40min()
    {
        $toDoList = new ToDoList();
        $item = new ItemToDo();
        $item2 = new ItemToDo();

        $currentTimeStamp = date_timestamp_get(date_create());
        $dateOfPreviousItem = $currentTimeStamp - 40 * 60;

        $item->setCreatedAt((new \DateTime())->setTimestamp($dateOfPreviousItem));
        $item2->setCreatedAt(new \DateTime());
        $toDoList->addItemToDo($item);
        $this->assertFalse($toDoList->canAddItemToDo($item2));
    }

}