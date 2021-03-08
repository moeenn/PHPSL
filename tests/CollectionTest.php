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

  public function testSortAssocKeyAscending()
  {
    $cases = [
      [
        'input'     => [
          'c' => 'Lahore',
          'b' => 'Abbottabad',
          'd' => 'Karachi',
          'a' => 'Beijing',
        ],
        'expected'  => [
          'a' => 'Beijing',
          'b' => 'Abbottabad',
          'c' => 'Lahore',
          'd' => 'Karachi',
        ],
      ],
      [
        'input'     => [
          'd' => 5000,
          'a' => 2000,
          'b' => 10,
          'c' => 600,
        ],
        'expected'  => [
          'a' => 2000,
          'b' => 10,
          'c' => 600,
          'd' => 5000,
        ],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input'], [
        'by'  => 'key'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testSortAssocDescending()
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
          'a' => 'Lahore',
          'c' => 'Karachi',
          'd' => 'Beijing',
          'b' => 'Abbottabad',
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
          'a' => 5000,
          'b' => 2000,
          'd' => 600,
          'c' => 10,
        ],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input'], [
        'order' => 'DESC'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testSortAssocKeyDescending()
  {
    $cases = [
      [
        'input'     => [
          'c' => 'Lahore',
          'b' => 'Abbottabad',
          'd' => 'Karachi',
          'a' => 'Beijing',
        ],
        'expected'  => [
          'd' => 'Karachi',
          'c' => 'Lahore',
          'b' => 'Abbottabad',
          'a' => 'Beijing',
        ],
      ],
      [
        'input'     => [
          'd' => 5000,
          'a' => 2000,
          'b' => 10,
          'c' => 600,
        ],
        'expected'  => [
          'd' => 5000,
          'c' => 600,
          'b' => 10,
          'a' => 2000,
        ],
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection::sort($case['input'], [
        'order' => 'DESC',
        'by'    => 'key'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }
}
