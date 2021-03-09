<?php

declare(strict_types=1);

namespace SOL5\PHPSL\Collection;

use \Exception;

/**
 *  map function to all elements in array
 *  
 */
function map(array $array, $callback): array
{
  return array_map($callback, $array);
}

/**
 *  filter an array based on criteria
 * 
 */
function filter(array $array, $callback): array
{
  $results = array_filter($array, $callback);
  return [...$results];
}

/**
 *  sort arrays in different manners
 * 
 */
function sort(array $array, $options = []): array
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
      ($isKeySort) ? \krsort($result) : \arsort($result);
      return $result;
    }

    if (!$isDescending) {
      ($isKeySort) ? \ksort($result) : \asort($result);
      return $result;
    }

    \asort($result);
    return $result;
  }

  if (!$isAssociative) {
    ($isDescending) ? \rsort($result) : \sort($result);
    return $result;
  }

  \sort($result);
  return $result;
}

/**
 *  join array into a string
 * 
 */
function join(array $data, string $delimiter = ' '): string
{
  return \implode($delimiter, $data);
}

/**
 *  check is a value exists in an array
 * 
 */
function exists(array $array, $value): bool
{
  return \in_array($value, $array);
}

/**
 *  check all elements in array against a condition
 * 
 */
function check(array $array, $callback): bool
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
function length(array $array): int
{
  return \count($array);
}

/**
 *  reduce an array into a single value
 * 
 */
function reduce(array $array, $callback, $total = 0)
{
  $length = \count($array);

  for ($index = 0; $index < $length; $index++) {
    $total = $callback($total, $array[$index], $index, $array);
  }

  return $total;
}

/**
 *  find an element in array based on callback
 * 
 */
function find(array $array, $callback)
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
function findAll(array $array, $callback): array
{
  $results = [];

  foreach ($array as &$item) {
    $isFound = $callback($item);
    if ($isFound) \array_push($results, $item);
  }

  return $results;
}

/**
 *  check if array is an associative array
 * 
 */
function isAssociative(array $array): bool
{
  return \array_keys($array) !== \range(0, \count($array) - 1);
}

/**
 *  add elements to end of array
 * 
*/
function push(array $array, array $values): array
{
	$result = [];
	\array_push($result, ...$array, ...$values);

	return $result;
}

/**
 *  add elements to start of array
 * 
*/
function append(array $array, array $values): array
{
	$result = [];
	\array_push($result, ...$values, ...$array);

	return $result;
}

/**
 *  merge two arrays and return a new array
 * 
*/
function merge(array $array1, array $array2): array
{
  return \array_merge($array1, $array2);
}