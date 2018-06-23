<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class FirstTest extends TestCase
{
    /**
     * @test
     */
    public function oneMustBeOne()
    {
        $first = 1;

        $this->assertEquals($first, 1);
    }
}