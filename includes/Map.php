<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \Exception;
use \Generator;

class Map
{
  private array $map;

  function __construct(array $array)
  {
    $associative = $this->isAssociative($array);
    if (!$associative) {
      throw new Exception('Provided array cannot be initialized as a Map');
    }

    $this->map = $array;
  }

  /**
   *  check if array is normal array (vector) or associative array (map)
   * 
   */
  private static function isAssociative(array $array): bool
  {
    return \array_keys($array) !== \range(0, \count($array) - 1);
  }

  /**
   *  convert vector to raw array
   * 
   */
  public function toArray(): array
  {
    return $this->map;
  }

  /**
   *  get length of vector
   * 
   */
  public function length(): int
  {
    return \count($this->map);
  }

  /**
   *  provide an iterator for the vector
   *  
   */
  public function &iter(): Generator
  {
    foreach ($this->map as $key => &$value) {
      yield $key => $value;
    }
  }

  /**
   *  filter map based on criteria
   * 
   */
  public function filter($callback): Map
  {
    $result = [];

    foreach ($this->map as $key => &$value) {
      $pass = $callback($key, $value);
      if (isset($pass)) {
        foreach ($pass as $key => &$value) {
          $result[$key] = $value;
        }
      }
    }
  
    return new Map($result);
  }

  /**
   *  get specific value from map
   * 
  */
  public function get($key)
  {
    try {      
      $result = $this->map[$key]; 
    } catch (Exception $e) {
      throw new Exception("Key '{$key}' not found within the Map");
    }

    return $result;
  }
}
