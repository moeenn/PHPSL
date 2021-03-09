<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \Exception;
use \min;
use \max;
use \pi;

class Number
{
  /**
   *  cast number to integer
   * 
   */
  public static function int($number): int
  {
    $allowedTypes = ['string', 'double', 'integer'];
    $type = gettype($number);

    if (!in_array($type, $allowedTypes)) {
      throw new Exception(
        'Invalid argument type: please provide ' .
          implode(', ', $allowedTypes)
      );
    };

    return (int) $number;
  }

  /**
   *  cast number to float
   * 
   */
  public static function float($number): float
  {
    $allowedTypes = ['string', 'double', 'integer'];
    $type = gettype($number);

    if (!in_array($type, $allowedTypes)) {
      throw new Exception(
        'Invalid argument type: please provide ' .
          implode(', ', $allowedTypes)
      );
    };

    return (float) $number;
  }

  /**
   *  find minimum value in an array
   * 
   */
  public static function min(array $array)
  {
    return min($array);
  }

  /**
   *  find minimum value in an array
   * 
   */
  public static function max(array $array)
  {
    return max($array);
  }

  /**
   *  calculate PI
   * 
   */
  public static function pi(): float
  {
    return pi();
  }

  /**
   *  round number to nearest integer
   * 
   */
  public static function round(float $number): int
  {
    return (int) \round($number);
  }

  /**
   *  round down number to nearest integer
   * 
   */
  public static function floor(float $number): int
  {
    return (int) \floor($number);
  }

  /**
   *  round up number to nearest integer
   * 
   */
  public static function ceiling(float $number): int
  {
    return (int) \ceil($number);
  }

  /**
   *  convert degrees to radians
   * 
   */
  public static function radians(float $degrees): float
  {
    return ($degrees * \pi()) / 180;
  }

  /**
   *  convert radians to degrees
   * 
   */
  public static function degrees(float $radians): float
  {
    return ($radians * 180) / \pi();;
  }
}
