<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Num;

class NumberTest extends TestCase
{
  /**
   * @covers Num::Int
   * 
   */
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
      $got = Num\int($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::float
   * 
   */
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
      $got = Num\float($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::min
   * 
   */
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
      $got = Num\min($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::max
   * 
   */
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
      $got = Num\max($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::pi
   * 
   */
  public function testPi(): void
  {
    $expected = 3.1415926535898;
    $got = Num\pi();
    $this->assertEquals($expected, $got);
  }

  /**
   * @covers Num::round
   * 
   */
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
      $got = Num\round($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::floor
   * 
   */
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
      $got = Num\floor($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::ceiling
   * 
   */
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
      $got = Num\ceiling($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::radians
   * 
   */
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
      $got = Num\radians($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::degrees
   * 
   */
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
      $got = Num\degrees($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Num::randomInt
   * 
   */
  public function testRandomInt(): void
  {
    $bounds = [
      'min' => 10,
      'max' => 100,
    ];

    for ($i = 0; $i < 500; $i++) {
      $num = Num\randomInt($bounds['min'], $bounds['max']);
      $this->assertTrue($num >= $bounds['min'] && $num < $bounds['max']);
    }
  }
}
