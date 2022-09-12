<?php

namespace App\Tests\Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $class;

    public function setUp(): void
    {
        $this->class = new Calculator();
    }

    /**
     * @dataProvider numbers
     */
    public function testAdd(int $a, int $b, int $sum): void
    {
        $this->assertSame($sum, $this->class->add($a, $b));
    }

    public function numbers(): array
    {
        return [
            [
                1, 1, 2
            ],
            [
                2, 1, 3
            ]
        ];
    }
}
