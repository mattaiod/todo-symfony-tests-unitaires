<?php

namespace App\Tests;

use App\Entity\ItemToDo;
use PHPUnit\Framework\TestCase;

class ItemToDoListTest extends TestCase
{
    /** @test */
    public function testContentItemToDoCantExceed1000Chars(): void
    {
        $item = new ItemToDo();

        $nbChars = 999;
        $item->setContent(str_repeat("0", $nbChars ));
        $this->assertTrue($item->isValidContentUnder1000Chars(), "The content $nbChars exceed the limit of 1000 chars");

        $nbChars = 1000;
        $item->setContent(str_repeat("0", $nbChars ));
        $this->assertTrue($item->isValidContentUnder1000Chars(), "The content $nbChars exceed the limit of 1000 chars");

        $nbChars = 1001;
        $item->setContent(str_repeat("0", $nbChars ));
        $this->assertFalse($item->isValidContentUnder1000Chars(), "The content $nbChars exceed the limit of 1000 chars");
    }
}


