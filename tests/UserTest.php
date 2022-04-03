<?php

namespace App\Tests;

use App\Entity\ToDoList;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function validateUserWithGoodData(): void
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
    public function validateUserWithBadFirstName(): void
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
    public function validateUserWithBadLastName(): void
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
    public function validateUserWithBadEmail(): void
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
    public function validateUserWithBadPassword(): void
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
    public function validateUserWithBadBirthday(): void
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
        $todoList = new ToDoList();
        $todoList = new ToDoList();
        $user->setFirstName("John");
        $user->setLastName("Doe");
        $user->setEmail("johndoe@test.com");
        $user->setPassword("mdp");
        $user->setBirthday(new \DateTime("06-06-2015"));
        $this->assertFalse($user->isValid());
    }
}
