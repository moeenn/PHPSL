<?php declare(strict_types = 1);

class Collection {
  /**
   *  map function to all elements in array
   *  
  */
  public static function map(array $list, $callback): array 
  {
    return array_map($callback, $list);
  }
}