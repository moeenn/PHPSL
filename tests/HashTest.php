<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Hash;

class HashTest extends TestCase
{
  /**
   * @covers Hash::encode
   * 
   */
  public function testEncode(): void
  {
    $message = 'Hello World';
    $limit = 100;
    $hashes = [];

    for ($i = 0; $i < $limit; $i++) {
      $hash = Hash\encode($message);
      array_push($hashes, $hash);
    }

    $has_duplicates = count(array_unique($hashes)) < count($hashes);
    $this->assertFalse($has_duplicates);
  }

  /**
   * @covers Hash::verify
   * 
   */
  public function testVerify(): void
  {
    $input = 'Hello World';
    $hash = Hash\encode($input);
    $is_match = Hash\verify($input, $hash);
    $this->assertTrue($is_match);
  }

  /**
   * @covers Hash::md5
   * 
   */
  public function testMD5(): void
  { 
    $input = 'Hello World';
    $limit = 20;
    $hashes = [];

    for ($i = 0; $i < $limit; $i++)
    {
      $hash = Hash\md5($input);
      array_push($hashes, $hash);
    }

    $is_same = count(array_unique($hashes)) === 1;
    $this->assertTrue($is_same);
  }

  /**
   * @covers Hash::salt
   * 
   */
  public function testSalt(): void
  {
    $results = [];

    foreach (range(1,500) as &$i) {
      $salt = Hash\salt();
      $this->assertTrue(!in_array($salt, $results));
      array_push($results, $salt);
    }
  }
}
