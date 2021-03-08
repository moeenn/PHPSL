<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Number;

class NumberTest extends TestCase
{
  public function testInt(): void
  {
    $cases = [
      [
        'input'     => 300,
        'expected'  => 300,
      ],
      [
        'input'     => 300.5,
        'expected'  => 300
      ],
      [
        'input'     => '500.2',
        'expected'  => 500
      ]
    ];

    foreach ($cases as &$case) {
      $got = Number::int($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testFloat(): void
  {
    $cases = [
      [
        'input'     => 300.7,
        'expected'  => 300.7,
      ],
      [
        'input'     => 300,
        'expected'  => 300.0
      ],
      [
        'input'     => '500',
        'expected'  => 500.0
      ]
    ];

    foreach ($cases as &$case) {
      $got = Number::float($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testMin(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 6, -100],
        'expected'  => -100,
      ],
      [
        'input'     => [-20.5, 0, -10, 100],
        'expected'  => -20.5
      ]
    ];

    foreach ($cases as &$case) {
      $got = Number::min($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testMax(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 6, -100],
        'expected'  => 6,
      ],
      [
        'input'     => [-20.5, 0, -10, 100.7],
        'expected'  => 100.7
      ]
    ];

    foreach ($cases as &$case) {
      $got = Number::max($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testPi(): void
  {
    $expected = 3.1415926535898;
    $got = Number::pi();
    $this->assertEquals($expected, $got);
  }

  public function testRound(): void
  {
    $cases = [
      [
        'input'     => 100.6,
        'expected'  => 101,
      ],
      [
        'input'     => 100.2,
        'expected'  => 100,
      ],
      [
        'input'     => 100.5,
        'expected'  => 101,
      ],
    ];

    foreach ($cases as &$case) {
      $got = Number::round($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testFloor(): void
  {
    $cases = [
      [
        'input'     => 100.6,
        'expected'  => 100,
      ],
      [
        'input'     => 200.2,
        'expected'  => 200,
      ],
      [
        'input'     => 105.5,
        'expected'  => 105,
      ],
    ];

    foreach ($cases as &$case) {
      $got = Number::floor($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testCeiling(): void
  {
    $cases = [
      [
        'input'     => 100.6,
        'expected'  => 101,
      ],
      [
        'input'     => 200.2,
        'expected'  => 201,
      ],
      [
        'input'     => 105.5,
        'expected'  => 106,
      ],
    ];

    foreach ($cases as &$case) {
      $got = Number::ceiling($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testRadians(): void
  {
    $cases = [
      [
        'input'     => 30,
        'expected'  => 0.5235987755983,
      ],
      [
        'input'     => 0,
        'expected'  => 0,
      ],
      [
        'input'     => 360,
        'expected'  => 6.2831853072,
      ],
    ];

    foreach ($cases as &$case) {
      $got = Number::radians($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }  

  public function testDegrees(): void
  {
    $cases = [
      [
        'input'     => 1,
        'expected'  => 57.295779513082,
      ],
      [
        'input'     => 3.5,
        'expected'  => 200.53522829579,
      ]
    ];

    foreach ($cases as &$case) {
      $got = Number::degrees($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }    
}
