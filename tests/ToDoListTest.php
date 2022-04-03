<?php

namespace App\Tests;

use App\Controller\ToDoListController;
use App\Entity\ItemToDo;
use App\Entity\ToDoList;
use App\Entity\User;
use App\Repository\ToDoListRepository;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
    /** @test */
    public function testUserOnlyHasOneTodolist(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("password");
        $user->setBirthday(new \DateTime("06-06-1970"));

        $toDoListMock = $this->createMock(User::class);
        $toDoListMock->method('setToDoList')->will($this->return());
        $this->assertTrue($item->isValidContentUnder1000Chars());


    }

    public function testValidRespectTimeCreateOf30min()
    {


        $currentTimeStamp  = date_timestamp_get(date_create());
        $dateOfMockup = $currentTimeStamp - 5*60;

        $toDoListMock = $this->createMock(ToDoList::class);
        $toDoListMock->method('getDateTimeLastItem')->will($this->return());

        $dateTimeLastItem = $toDoListMock->getDateTimeLastItem();

        $toDoListMock->canAddNewItemCausedBy30MinutesMinimumLimit();

    }

    //TODO:(T= A la 8ème item: send email à l’utilisateur pour lui dire il en reste que 2:     EmailSenderService)

    //TODO: (T= verif peut contenir 0 a 10 items uniquement dans la todo)

}