<?php

declare(strict_types=1);

namespace SOL5\PHPSL\Num;
use \Exception;

/**
 *  cast number to integer
 * 
 */
function int($number): int
{
  $allowedTypes = ['string', 'double', 'integer'];
  $type = \gettype($number);

  if (!\in_array($type, $allowedTypes)) {
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
function float($number): float
{
  $allowedTypes = ['string', 'double', 'integer'];
  $type = \gettype($number);

  if (!\in_array($type, $allowedTypes)) {
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
function min(array $array)
{
  return \min($array);
}

/**
 *  find minimum value in an array
 * 
 */
function max(array $array)
{
  return \max($array);
}

/**
 *  calculate PI
 * 
 */
function pi(): float
{
  return \pi();
}

/**
 *  round number to nearest integer
 * 
 */
function round(float $number): int
{
  return (int) \round($number);
}

/**
 *  round down number to nearest integer
 * 
 */
function floor(float $number): int
{
  return (int) \floor($number);
}

/**
 *  round up number to nearest integer
 * 
 */
function ceiling(float $number): int
{
  return (int) ceil($number);
}

/**
 *  convert degrees to radians
 * 
 */
function radians(float $degrees): float
{
  return ($degrees * \pi()) / 180;
}

/**
 *  convert radians to degrees
 * 
 */
function degrees(float $radians): float
{
  return ($radians * 180) / \pi();;
}

/**
 *  generate random floating point number in range (0,1)
 * 
*/
function randomFloat(): float
{
  return \mt_rand() / \mt_getrandmax();
}

/**
 *  generate random floating point number in range (0,1)
 * 
*/
function randomInt(int $min, int $max): float
{
  return \rand($min, $max - 1);
}