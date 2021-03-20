<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Map;
use \Exception;

class MapTest extends TestCase
{
  /**
   * @covers Map::__construct
   * 
   */
  public function testConstruct(): void
  {
    $cases = [
      [
        'name'  => 'Someone',
        'age'   => 30,
        'sharp' => true,
      ],
      [
        'request'   => 31231231,
        'callback'  => function () {
          echo 'test';
        },
      ]
    ];

    foreach ($cases as &$case) {
      $map = new Map($case);
      $this->assertEquals($case, $map->toArray());
    }
  }

  /**
   * @covers Map::__construct
   * 
   */
  public function testException(): void
  {
    $input = [1, 2, 3, 4, 5, 6];

    try {
      $map = new Map($input);
    } catch (Exception $e) {
      $this->assertTrue('Provided array cannot be initialized as a Map' === $e->getMessage());
      return;
    }

    $this->fail('Exception was not thrown on invalid constructor argument');
  }

  /**
   * @covers Map::length
   * 
   */
  public function testLength(): void
  {
    $cases = [
      [
        'input'     => [
          'name'    => 'Someone',
          'age'     => 30,
          'sharp'   => true,
        ],
        'expected'  => 3
      ]
    ];

    foreach ($cases as &$case) {
      $map = new Map($case['input']);
      $got = $map->length();
      $this->assertEquals($case['expected'], $got);
    }
  }

  /**
   * @covers Map::&iter
   * 
   */
  public function testIter(): void
  {
    $input = [
      'name'    => 'Someone',
      'age'     => 30,
      'hobbies' => ['Sports', 'TV', 'Diving']
    ];
    $expected = $input;

    $map = new Map($input);

    foreach ($map->iter() as $key => &$value) {
      $this->assertEquals($expected[$key], $value);
    }
  }

  /**
   * @covers Map::filter
   * 
   */
  public function testFilter(): void
  {
    $cases = [
      [
        'input'     => [
          'name'    => 'someone',
          'age'     => 30,
          'color'   => 'blue',
          'country' => 'Mars',
          'car'     => 'Sedan'
        ],
        'callback'  => function ($key, $value) {
          $requiredKeys = ['name', 'color', 'car'];
          if (in_array($key, $requiredKeys)) {
            return [$key => $value];
          }
        },
        'expected'  => [
          'name'    => 'someone',
          'color'   => 'blue',
          'car'     => 'Sedan'
        ],
      ]
    ];

    foreach ($cases as &$case) {
      $map = new Map($case['input']);
      $got = $map->filter($case['callback']);
      $this->assertEquals($case['expected'], $got->toArray());
    }
  }

  /**
   * @covers Map::get
   * 
   */
  public function testGet(): void
  {
    $input = [
      'name'    => 'someone',
      'age'     => 30,
      'color'   => 'blue',
      'country' => 'Mars',
      'car'     => 'Sedan'
    ];

    $expected = 'blue';

    $map = new Map($input);
    $got = $map->get('color');

    $this->assertEquals($expected, $got);
  }

  /**
   * @covers Map::get
   * 
   */
  public function testGetException(): void
  {
    $input = [
      'name'    => 'someone',
      'age'     => 30,
      'color'   => 'blue',
      'country' => 'Mars',
      'car'     => 'Sedan'
    ];

    $expectedError = "Key 'city' not found within the Map";
    $map = new Map($input);

    try {
      $result = $map->get('city');
    } catch (Exception $e) {
      $this->assertTrue($expectedError === $e->getMessage());
      return;
    }

    $this->fail('Exception was not thrown on invalid get() argument');
  }
}
