<?php

namespace App\Tests;

use App\Entity\ToDoList;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function testUserWithAccurateData(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("password");
        $user->setBirthday(new \DateTime("06-06-1970"));
        $this->assertTrue($user->isValid());
    }

    /** @test */
    public function testUserWithNonAccurateFirstName(): void
    {
        $user = new User();
        $user->setFirstName("");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("password");
        $user->setBirthday(new \DateTime("06-06-1970"));
        $this->assertFalse($user->isValid());
    }

    /** @test */
    public function testUserWithNonAccurateLastName(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("password");
        $user->setBirthday(new \DateTime("06-06-1970"));
        $this->assertFalse($user->isValid());
    }

    /** @test */
    public function testUserWithNonAccurateEmail(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoetestcom");
        $user->setPassword("password");
        $user->setBirthday(new \DateTime("06-06-1970"));
        $this->assertFalse($user->isValid());
    }

    /** @test */
    public function testUserWithNonAccuratePassword(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("mdp");
        $user->setBirthday(new \DateTime("06-06-1970"));
        $this->assertFalse($user->isValid());
    }

    /** @test */
    public function testUserWithBadBirthday(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("mdp");
        $user->setBirthday(new \DateTime("06-06-2015"));
        $this->assertFalse($user->isValid());
    }

    public function testMultipleToDoListCreation(): void
    {
        $user = new User();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("mdp");
        $user->setBirthday(new \DateTime("06-06-2015"));

        $todoList1 = new ToDoList();
        $todoList2 = new ToDoList();
        $user->setToDoList($todoList1);
        $user->setToDoList($todoList2);
        $this->assertEquals($todoList2, $user->getToDoList());
        $this->assertFalse($user->isValid());
    }
}
