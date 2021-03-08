<?php

declare(strict_types=1);

namespace OSO\PHPSL;

class Str
{
  /**
   *  convert string to uppercase
   * 
  */
  static public function upper(string $string): string
  {
    return strtoupper($string);
  }

  /**
   *  convert string to lowercase
   * 
  */
  static public function lower(string $string): string
  {
    return strtolower($string);
  }

  /**
   *  convert string to title case
   * 
  */
  static public function title(string $string): string
  {
    return ucwords($string);
  }

  /**
   *  convert string to slug
  */
  static public function slug(string $string): string
  {
    $lower = strtolower($string);
    return str_replace(' ', '-', $lower);
  } 

  /**
   *  convert string to slug
  */
  static public function currency(int $number, string $locale = 'US'): string
  {
    setlocale(LC_MONETARY, $locale);
    return \money_format("%i", $number);
  }  
} 
