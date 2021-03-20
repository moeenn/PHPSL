<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Collection;

class ArrTest extends TestCase
{
  /**
   *  @covers OSO\PHPSL\Collection\map
   * 
   */
  public function testMap(): void
  {
    $input = [1, 2, 3, 4, 5];
    $expected = [2, 4, 6, 8, 10];

    $got = Collection\map($input, function ($number) {
      return $number * 2;
    });

    $this->assertTrue($expected === $got);
  }

  /**
   *  @covers OSO\PHPSL\Collection\filter
   * 
   */
  public function testFilter(): void
  {
    $input = [1, 2, 3, 4, 5];
    $expected = [4, 5];

    $got = Collection\filter($input, function ($number) {
      return $number > 3;
    });

    $this->assertTrue(count($expected) === count($got));

    $flag = true;
    for ($i = 0; $i < count($expected); $i++) {
      if ($expected[$i] !== $got[$i]) $flag = false;
    }

    $this->assertTrue($flag);
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortAscending(): void
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
      $got = Collection\sort($case['input']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortDescending(): void
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
      $got = Collection\sort($case['input'], [
        'order' => 'DESC'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortAssocAscending(): void
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
      $got = Collection\sort($case['input']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortAssocKeyAscending(): void
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
      $got = Collection\sort($case['input'], [
        'by'  => 'key'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortAssocDescending(): void
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
      $got = Collection\sort($case['input'], [
        'order' => 'DESC'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\sort
   * 
   */
  public function testSortAssocKeyDescending(): void
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
      $got = Collection\sort($case['input'], [
        'order' => 'DESC',
        'by'    => 'key'
      ]);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\join
   * 
   */
  public function testJoin(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'expected'  => '1-2-3-4-5-abc'
      ]
    ];

    foreach ($cases as &$case) {
      $got = Collection\join($case['input'], '-');
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers OSO\PHPSL\Collection\exists
   * 
   */
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
      $got = Collection\exists($case['input'], $case['needle']);

      if ($case['expected']) {
        $this->assertTrue($case['expected']);
      } else {
        $this->assertNotTrue($case['expected']);
      }
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\check
   * 
   */
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
      $got = Collection\check($case['input'], $case['callback']);

      if ($case['expected']) {
        $this->assertTrue($got);
      } else {
        $this->assertNotTrue($got);
      }
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\length
   * 
   */
  public function testLength(): void
  {
    $cases = [
      [
        'input'     => [1, 2, 3, 4, 5, 'abc'],
        'expected'  => 6
      ],
      [
        'input'     => [
          'name'      => 'someone',
          'age'       => 30,
          'employed'  => true
        ],
        'expected'  => 3
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection\length($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\reduce
   * 
   */
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
      $got = Collection\reduce($case['input'], $case['callback']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\find
   * 
   */
  public function testFind(): void
  {
    $cases = [
      [
        'input'     => [10, 20, 30, 40, 50],
        'callback'  => function ($item) {
          return $item > 30;
        },
        'expected'  => 40
      ],
      [
        'input'     => [
          [
            'name'  => 'someone',
            'age'   => 30
          ],
          [
            'name'  => 'other',
            'age'   => 40
          ],
          [
            'name'  => 'than',
            'age'   => 15
          ],
          [
            'name'  => 'him',
            'age'   => 25
          ]
        ],
        'callback'  => function ($item) {
          return $item['age'] > 25;
        },
        'expected'  => [
          'name'  => 'someone',
          'age'   => 30
        ]
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection\find($case['input'], $case['callback']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\findAll
   * 
   */
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
      [
        'input'     => [
          [
            'name'  => 'someone',
            'age'   => 30
          ],
          [
            'name'  => 'other',
            'age'   => 40
          ],
          [
            'name'  => 'than',
            'age'   => 15
          ],
          [
            'name'  => 'him',
            'age'   => 25
          ]
        ],
        'callback'  => function ($item) {
          return $item['age'] > 25;
        },
        'expected'  => [
          [
            'name'  => 'someone',
            'age'   => 30
          ],
          [
            'name'  => 'other',
            'age'   => 40
          ],
        ]
      ],
    ];

    foreach ($cases as &$case) {
      $got = Collection\findAll($case['input'], $case['callback']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\push
   * 
   */
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
      $got = Collection\push($case['input_1'], $case['input_2']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\append
   * 
   */
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
      $got = Collection\append($case['input_1'], $case['input_2']);
      $this->assertTrue($case['expected'] === $got);
    }
  }

  /**
   *  @covers OSO\PHPSL\Collection\merge
   * 
   */
  public function testMerge(): void
  {
    $cases = [
      [
        'input_1'   => [1, 2, 3, 4, 5],
        'input_2'   => [10, 20, 30],
        'expected'  => [1, 2, 3, 4, 5, 10, 20, 30],
      ]
    ];

    foreach ($cases as &$case) {
      $got = Collection\merge($case['input_1'], $case['input_2']);

      $length = count($case['input_1']) + count($case['input_2']);
      $this->assertEquals($length, count($got));

      for ($i = 0; $i < $length; $i++) {
        $this->assertEquals($case['expected'][$i], $got[$i]);
      }
    }
  }
}
