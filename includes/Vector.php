<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \Exception;
use Generator;

class Vector
{
  private array $array;

  function __construct(array $array)
  {
    $associative = $this->isAssociative($array);
    if ($associative) {
      throw new Exception('Provided array cannot be initialized as a Vector');
    }

    $this->array = $array;
  }

  /**
   *  check if array is normal array (vector) or associative array (map)
   * 
   */
  public static function isAssociative(array $array): bool
  {
    return \array_keys($array) !== \range(0, \count($array) - 1);
  }

  /**
   *  convert vector to raw array
   * 
   */
  public function toArray(): array
  {
    return $this->array;
  }

  /**
   *  get length of array
   * 
   */
  public function length(): int
  {
    return \count($this->array);
  }

  /**
   *  provide an iterator for the vector
   *  
   */
  public function &iter(): Generator
  {
    $length = \count($this->array);

    for ($i = 0; $i < $length; $i++) {
      yield $i => $this->array[$i];
    }
  }

  /**
   *  map function to all elements in array
   *  
   */
  public function map($callback): Vector
  {
    $this->array = array_map($callback, $this->array);
    return new Vector($this->array);
  }

  /**
   *  reduce an array into a single value
   * 
   */
  public function reduce($callback, $total = 0)
  {
    $length = \count($this->array);

    for ($index = 0; $index < $length; $index++) {
      $total = $callback($total, $this->array[$index], $index, $this->array);
    }

    return $total;
  }

  /**
   *  filter an array based on criteria
   * 
   */
  function filter($callback): Vector
  {
    $results = array_filter($this->array, $callback);
    return new Vector($results);
  }

  /**
   *  sort vector in arcending or descending order
   * 
   */
  public function sort(array $options = []): Vector
  {
    $validOrders = ['ASC', 'DESC'];

    $defaultOptions = [
      'order' => 'ASC'
    ];

    $options = array_merge($defaultOptions, $options);

    if (!in_array($options['order'], $validOrders)) {
      throw new Exception("Invalid sort order: {$options['order']}");
    }

    $array = [...$this->array];
    ($options['order'] === 'ASC') ? \sort($array) : \rsort($array);
    return new Vector($array);
  }

  /**
   *  join vector elements into a string
   * 
   */
  public function join(string $delimiter = ' '): string
  {
    $array = [...$this->array];
    return \implode($delimiter, $array);
  }

  /**
   *  check is a value exists in a vector
   * 
   */
  public function exists($value): bool
  {
    return \in_array($value, $this->array);
  }

  /**
   *  check all elements in array against a condition
   * 
   */
  public function check($callback): bool
  {
    foreach ($this->array as &$item) {
      $flag = $callback($item);
      if (!$flag) return false;
    }

    return true;
  }

  /**
   *  find an element in array based on callback
   * 
   */
  public function find($callback)
  {
    foreach ($this->array as &$item) {
      $isFound = $callback($item);

      if ($isFound) return $item;
    }

    return null;
  }

  /**
   *  find elements in array based on callback
   * 
   */
  public function findAll($callback): array
  {
    $results = [];

    foreach ($this->array as &$item) {
      $isFound = $callback($item);
      if ($isFound) \array_push($results, $item);
    }

    return $results;
  }

  /**
   *  add elements to end of array
   * 
   */
  public function push(array $values): array
  {
    $result = [];
    \array_push($result, ...$this->array, ...$values);

    return $result;
  }

  /**
   *  add elements to start of array
   * 
   */
  public function append(array $values): array
  {
    $result = [];
    \array_push($result, ...$values, ...$this->array);

    return $result;
  }
}