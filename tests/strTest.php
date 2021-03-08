<?php

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use OSO\PHPSL\Str;

class StrTest extends TestCase
{
  public function testUpper()
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

  public function testLower()
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

  public function testTitle()
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

  public function testSlug()
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
}
