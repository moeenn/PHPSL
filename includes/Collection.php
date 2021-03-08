<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

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

    $is_associative = array_keys($array) !== range(0, count($array) - 1);
    $is_descending =  isset($options['order']) && $options['order'] === 'DESC';
    $is_key_sort = isset($options['by']) && $options['by'] === 'key';

    if (!$is_associative && isset($options['by'])) {
      throw new \Exception('Cannot sort ordinary arrays by key or value');
    }

    if ($is_associative) {
      if ($is_descending) {
        ($is_key_sort) ? krsort($result) : arsort($result);
        return $result;
      }

      if (!$is_descending) {
        ($is_key_sort) ? ksort($result) : asort($result);
        return $result;
      }

      asort($result);
      return $result;
    }

    if (!$is_associative) {
      ($is_descending) ? rsort($result) : sort($result);
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
    for ($index = 0; $index < count($array); $index++) {
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
      $is_found = $callback($item);

      if ($is_found) return $item;
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
      $is_found = $callback($item);
      if ($is_found) array_push($results, $item);
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
