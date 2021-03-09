<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \Exception;
use phpDocumentor\Reflection\Types\Boolean;

class Collection
{
  /**
   *  map function to all elements in array
   *  
   */
  public static function map(array $array, $callback): array
  {
    return array_map($callback, $array);
  }

  /**
   *  filter an array based on criteria
   * 
   */
  public static function filter(array $array, $callback): array
  {
    $results = array_filter($array, $callback);
    return [...$results];
  }

  /**
   *  sort arrays in different manners
   */
  public static function sort(array $array, $options = []): array
  {

    $result = $array;

    $isAssociative = array_keys($array) !== range(0, count($array) - 1);
    $isDescending =  isset($options['order']) && $options['order'] === 'DESC';
    $isKeySort = isset($options['by']) && $options['by'] === 'key';

    if (!$isAssociative && isset($options['by'])) {
      throw new Exception('Cannot sort ordinary arrays by key or value');
    }

    if ($isAssociative) {
      if ($isDescending) {
        ($isKeySort) ? krsort($result) : arsort($result);
        return $result;
      }

      if (!$isDescending) {
        ($isKeySort) ? ksort($result) : asort($result);
        return $result;
      }

      asort($result);
      return $result;
    }

    if (!$isAssociative) {
      ($isDescending) ? rsort($result) : sort($result);
      return $result;
    }

    sort($result);
    return $result;
  }

  /**
   *  join array into a string
   * 
   */
  public static function join(array $data, string $delimiter = ' '): string
  {
    return implode($delimiter, $data);
  }

  /**
   *  check is a value exists in an array
   * 
   */
  public static function exists(array $array, $value): bool
  {
    return in_array($value, $array);
  }

  /**
   *  check all elements in array against a condition
   * 
   */
  public static function check(array $array, $callback): bool
  {
    foreach ($array as &$item) {
      $flag = $callback($item);
      if (!$flag) return false;
    }

    return true;
  }

  /**
   *  get length of array
   * 
   */
  public static function length(array $array): int
  {
    return count($array);
  }

  /**
   *  reduce an array into a single value
   * 
   */
  public static function reduce(array $array, $callback, $total = 0)
  {
    $length = count($array);

    for ($index = 0; $index < $length; $index++) {
      $total = $callback($total, $array[$index], $index, $array);
    }

    return $total;
  }

  /**
   *  find an element in array based on callback
   * 
   */
  public static function find(array $array, $callback)
  {
    foreach ($array as &$item) {
      $isFound = $callback($item);

      if ($isFound) return $item;
    }

    return null;
  }

  /**
   *  find elements in array based on callback
   * 
   */
  public static function findAll(array $array, $callback): array
  {
    $results = [];

    foreach ($array as &$item) {
      $isFound = $callback($item);
      if ($isFound) array_push($results, $item);
    }

    return $results;
  }

  /**
   *  check if array is an associative array
   * 
  */
  public static function isAssociative(array $array): bool
  {
    return array_keys($array) !== range(0, count($array) - 1);
  }
}
