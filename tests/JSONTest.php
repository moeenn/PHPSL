<?php

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use OSO\PHPSL\JSON;

class JSONTest extends TestCase
{
  public function testEncode()
  {
    $cases = [
      [
        'input' => [
          [
            'name'        => 'Saad',
            'age'         => 24,
            'programmer'  => false
          ],
          [
            'name'        => 'Osama',
            'age'         => 22,
            'programmer'  => true
          ]
        ],
        'expected' => '[{"name":"Saad","age":24,"programmer":false},{"name":"Osama","age":22,"programmer":true}]',
      ],
    ];

    foreach ($cases as &$case) {
      $got = JSON::encode($case['input']);
      $this->assertEquals($case['expected'], $got);
    }
  }

  public function testDecode()
  {
    $cases = [
      [
        'input'     => '[{"name":"Saad","age":24,"programmer":false},{"name":"Osama","age":22,"programmer":true}]',
        'expected'  => [
          [
            'name'        => 'Saad',
            'age'         => 24,
            'programmer'  => false
          ],
          [
            'name'        => 'Osama',
            'age'         => 22,
            'programmer'  => true
          ]
        ],
      ],
    ];

    foreach ($cases as &$case) {
      $got = JSON::decode($case['input']);
      $this->assertTrue($case['expected'] === $got);
    }
  }
}
