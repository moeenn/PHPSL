<?php

declare(strict_types=1);

namespace SOL5\PHPSL\Str;


/**
 *  convert string to uppercase
 * 
 */
function upper(string $string): string
{
  return \strtoupper($string);
}

/**
 *  convert string to lowercase
 * 
 */
function lower(string $string): string
{
  return \strtolower($string);
}

/**
 *  convert string to title case
 * 
 */
function title(string $string): string
{
  return \ucwords($string);
}

/**
 *  convert string to slug
 */
function slug(string $string): string
{
  $lower = \strtolower($string);
  return \str_replace(' ', '-', $lower);
}

/**
 *  create random string
 *  not suitable for crypto purposes
 * 
 */
function random(array $options = []): string
{
  $defaultOptions = [
    'length'  => 10,
    'numbers' => false,
  ];

  $options = \array_merge($defaultOptions, $options);
  $keyspace = ($options['numbers'])
    ? '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

  $pieces = [];
  $max = \mb_strlen($keyspace, '8bit') - 1;

  for ($i = 0; $i < $options['length']; ++$i) {
    $pieces[] = $keyspace[\random_int(0, $max)];
  }

  return \implode('', $pieces);
}

/**
 *  convert a string into an array based on a delimiter value
 * 
 */
function split(string $string, string $delimiter): array
{
  return \explode($delimiter, $string);
}

/**
 *  get string length
 * 
 */
function length(string $string): int
{
  return \strlen($string);
}

/**
 *  format and return string
 * 
 */
function sprintf(string $format, array $args): string
{
  return \sprintf($format, ...$args);
}

/**
 *  format and print string
 * 
 */
function printf(string $format, array $args): void
{
  echo \sprintf($format, ...$args);
}
