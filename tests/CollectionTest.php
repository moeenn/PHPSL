<?php

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use OSO\PHPSL\Collection;

class CollectionTest extends TestCase
{
  public function testMap()
  {
    $input = [1, 2, 3, 4, 5];
    $expected = [2, 4, 6, 8, 10];

    $got = Collection::map($input, function ($number) {
      return $number * 2;
    });

    $this->assertTrue($expected === $got);
  }

  public function testFilter()
  {
    $input = [1, 2, 3, 4, 5];
    $expected = [4, 5];

    $got = Collection::filter($input, function ($number) {
      return $number > 3;
    });

    $this->assertTrue(count($expected) === count($got));

    $flag = true;
    for ($i = 0; $i < count($expected); $i++) {
      if ($expected[$i] !== $got[$i]) $flag = false;
    }

    $this->assertTrue($flag);
  }

  public function testSortAscending()
  {
    $cases = [
      [
        'input'     => [5, 3, 4, 1, 2],
        'expected'  => [1, 2, 3, 4, 5],
      ],
      [
        'input'     => ['d', 'b', 'a', 'c', 'e'],
        'expected'  => ['a', 'b', 'c', 'd', 'e'],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testSortDescending()
  {
    $cases = [
      [
        'input'     => [5, 3, 4, 1, 2],
        'expected'  => [5, 4, 3, 2, 1],
      ],
      [
        'input'     => ['d', 'b', 'a', 'c', 'e'],
        'expected'  => ['e', 'd', 'c', 'b', 'a'],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input'], [
        'order' => 'DESC'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testSortAssocAscending()
  {
    $cases = [
      [
        'input'     => [
          'a' => 'Lahore',
          'b' => 'Abbottabad',
          'c' => 'Karachi',
          'd' => 'Beijing',
        ],
        'expected'  => [
          'b' => 'Abbottabad',
          'd' => 'Beijing',          
          'c' => 'Karachi',
          'a' => 'Lahore',
        ],
      ],
      [
        'input'     => [
          'a' => 5000,
          'b' => 2000,
          'c' => 10,
          'd' => 600,
        ],
        'expected'  => [
          'c' => 10,
          'd' => 600,
          'b' => 2000,
          'a' => 5000,
        ],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input']);
      $this->assertTrue($case['expected'] === $got);
    }
  }  
}
