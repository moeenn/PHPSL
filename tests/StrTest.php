<?php

declare(strict_types = 1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Str;

class StrTest extends TestCase
{
  public function testUpper(): void
  {
    $cases = [
      [
        'input'     => 'Qwerty',
        'expected'  => 'QWERTY',
      ],
      [
        'input'     => 'q1w2e3R4',
        'expected'  => 'Q1W2E3R4',
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::upper($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testLower(): void
  {
    $cases = [
      [
        'input'     => 'QwerTy',
        'expected'  => 'qwerty',
      ],
      [
        'input'     => 'q1W2e3R4',
        'expected'  => 'q1w2e3r4',
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::lower($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testTitle(): void
  {
    $cases = [
      [
        'input'     => 'the song of the white wolf',
        'expected'  => 'The Song Of The White Wolf',
      ],
      [
        'input'     => 'is always sung alone',
        'expected'  => 'Is Always Sung Alone',
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::title($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testSlug(): void
  {
    $cases = [
      [
        'input'     => 'The Song Of The White Wolf 123',
        'expected'  => 'the-song-of-the-white-wolf-123',
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::slug($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testRandom(): void
  {
    $limit = 200;
    $strings = [];

    for ($i = 0; $i < $limit; $i++)
    {
      $string = Str::random([
        'length'  => 10,
        'numbers' => true,
      ]);

      array_push($strings, $string);

      $has_duplicates = count(array_unique($strings)) < count($strings);
      $this->assertFalse($has_duplicates);
    }
  }

  public function testSplit(): void
  {
    $cases = [
      [
        'input'     => 'a b c d e',
        'expected'  => ['a', 'b', 'c', 'd', 'e'],
        'delimiter' => ' '
      ],
      [
        'input'     => 'this-is-a-slug',
        'expected'  => ['this', 'is', 'a', 'slug'],
        'delimiter' => '-'
      ]
    ];

    foreach ($cases as &$case)
    {
      $got = Str::split($case['input'], $case['delimiter']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testLength(): void
  {
    $cases = [
      [
        'input'     => 'The Song Of The White Wolf 123',
        'expected'  => 30,
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::length($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testSprintf(): void
  {
    $cases = [
      [
        'input'     => 'The %s Of The %s %s',
        'args'      => ['Song', '#fff', 'Wolf'],
        'expected'  => 'The Song Of The #fff Wolf',
      ],
      [
        'input'     => 'Is %s At The %d',
        'args'      => ['Loudest', 500],
        'expected'  => 'Is Loudest At The 500',
      ],
    ];

    foreach ($cases as &$case) {
      $got = Str::sprintf($case['input'], $case['args']);
      $this->assertEquals($case['expected'], $got);
    }
  }
}
