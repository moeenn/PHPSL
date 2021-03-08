<?php

declare(strict_types=1);

namespace OSO\PHPSL;

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
}
