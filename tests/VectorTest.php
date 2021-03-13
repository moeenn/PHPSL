<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Vector;
use \Exception;

class VectorTest extends TestCase
{
  public function testConstruct(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 6],
        'expected'  => [1, 2, 3, 4, 5, 6],
      ],
      [
        'input'     => ['a', 'b', 'c', 'xyz'],
        'expected'  => ['a', 'b', 'c', 'xyz'],
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $this->assertTrue($case['expected'] === $vec->toArray());
    }
  }

  public function testException(): void
  {
    $input = [
      'name'  => 'someone',
      'age'   => 100
    ];

    try {
      $vec = new Vector($input);
    } catch (Exception $e) {
      $this->assertTrue('Provided array cannot be initialized as a Vector' === $e->getMessage());
      return;
    }

    $this->fail('Exception was not thrown on invalid constructor argument');
  }

  public function testIsAssociative(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5],
        'expected'  => false,
      ],
      [
        'input'     => [
          'name'    => 'someone',
          'age'     => 100
        ],
        'expected'  => true,
      ]
    ];

    foreach ($cases as &$case) {
      $got = Vector::isAssociative($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testLength(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'expected'  => 6
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->length();
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testMap(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 6],
        'callback'  => function ($num) {
          return $num * 2;
        },
        'expected'  => [2, 4, 6, 8, 10, 12]
      ],
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($num) {
          return $num ** 2;
        },
        'expected'  => [100, 400, 900, 1600, 2500]
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $vec->map($case['callback']);
      $this->assertTrue($case['expected'] === $vec->toArray());
    }
  }

  public function testReduce(): void
  {
    $cases = [
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($total, $item) {
          return $total + $item;
        },
        'expected'  => 150
      ],
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($total, $item, $index, $array) {
          $total += $item;

          if ($index === count($array) - 1) {
            return $total / count($array);
          }

          return  $total;
        },
        'expected'  => 30,
      ],
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->reduce($case['callback']);

      $this->assertEquals($case['expected'], $got);
    }
  }

  // public function testFilter(): void
  // {
  //   $input = [1, 2, 3, 4, 5, 6];
  //   $expected = [4, 5, 6];

  //   $vec = new Vector($input);

  //   $got = $vec->filter(function ($number) {
  //     return $number > 30;
  //   });

  //   $this->assertTrue(count($expected) === count($got->toArray()));

  //   // $flag = true;
  //   // for ($i = 0; $i < count($expected); $i++) {
  //   //   if ($expected[$i] !== $got->toArray()[$i]) $flag = false;
  //   // }

  //   // $this->assertTrue($flag);
  // }

  public function testIter(): void
  {
    $input = [1, 2, 3, 4, 5, 6];
    $expected = [...$input];

    $vec = new Vector($input);

    foreach ($vec->iter() as $index => &$element) {
      $this->assertEquals($expected[$index], $element);
    }
  }

  public function testSort(): void
  {
    $cases = [
      [
        'input'     => [5, 3, 4, 1, 2],
        'order'     => 'ASC',
        'expected'  => [1, 2, 3, 4, 5],
      ],
      [
        'input'     => ['d', 'b', 'a', 'c', 'e'],
        'order'     => 'ASC',
        'expected'  => ['a', 'b', 'c', 'd', 'e'],
      ],
      [
        'input'     => [5, 3, 4, 1, 2],
        'order'     => 'DESC',
        'expected'  => [5, 4, 3, 2, 1],
      ],
      [
        'input'     => ['d', 'b', 'a', 'c', 'e'],
        'order'     => 'DESC',
        'expected'  => ['e', 'd', 'c', 'b', 'a'],
      ],
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->sort(['order' => $case['order']]);

      $this->assertTrue($case['expected'] === $got->toArray());
    }
  }

  public function testSortException(): void
  {
    $vec = new Vector([1, 2, 3, 4, 5]);
    try {
      $vec->sort(['order' => 'alpha']);
    } catch (Exception $e) {
      $this->assertEquals('Invalid sort order: alpha', $e->getMessage());
      return;
    }

    $this->fail('Exception not thrown on invalid sort order argument');
  }


  public function testMethodChaining(): void
  {
    $input = [10, 5, 3, 2, 6];
    $expected = [100, 36, 25, 9, 4];

    $vec = new Vector($input);
    $got = $vec->map(function ($number) {
      return $number ** 2;
    })
      ->sort(['order' => 'DESC']);

    $this->assertTrue($expected === $got->toArray());
  }

  public function testJoin(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'expected'  => '1-2-3-4-5-abc'
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->join('-');
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testExists(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'needle'    => 4,
        'expected'  => true
      ],
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'needle'    => 'something',
        'expected'  => false
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->exists($case['needle']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testCheck(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 10, 20],
        'callback'  => function ($item) {
          return $item < 100;
        },
        'expected'  => true,
      ],
      [
        'input'     => ['some', 'random', 'words', 'here'],
        'callback'  => function ($item) {
          return gettype($item) === 'string';
        },
        'expected'  => true,
      ],
      [
        'input'     => ['some', 'random', 'words', 'here'],
        'callback'  => function ($item) {
          return strlen($item) > 4;
        },
        'expected'  => false,
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->check($case['callback']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testFind(): void
  {
    $cases = [
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($item) {
          return $item > 30;
        },
        'expected'  => 40
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->find($case['callback']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testFindAll(): void
  {
    $cases = [
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($item) {
          return $item > 30;
        },
        'expected'  => [40, 50]
      ],
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input']);
      $got = $vec->findAll($case['callback']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testPush(): void
  {
    $cases = [
      [
        'input_1'   => [1, 2, 3, 4, 5],
        'input_2'   => [10, 20, 30],
        'expected'  => [1, 2, 3, 4, 5, 10, 20, 30],
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input_1']);
      $got = $vec->push($case['input_2']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  public function testAppend(): void
  {
    $cases = [
      [
        'input_1'   => [1, 2, 3, 4, 5],
        'input_2'   => [10, 20, 30],
        'expected'  => [10, 20, 30, 1, 2, 3, 4, 5],
      ]
    ];

    foreach ($cases as &$case) {
      $vec = new Vector($case['input_1']);
      $got = $vec->append($case['input_2']);
      $this->assertTrue($case['expected'] === $got);
    }
  }
}
