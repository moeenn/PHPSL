<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \Exception;

class Map
{
  private array $map;

  function __construct(array $array)
  {
    $associative = $this->isAssociative($array);
    if (!$associative) {
      throw new Exception('Provided array cannot be initialized as a Map');
    }

    $this->array = $array;
  }

  /**
   *  check if array is normal array (vector) or associative array (map)
   * 
  */
  private static function isAssociative(array $array): bool
  {
    return \array_keys($array) !== \range(0, \count($array) - 1);
  }
}
