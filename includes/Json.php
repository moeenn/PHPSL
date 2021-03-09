<?php

declare(strict_types=1);

namespace SOL5\PHPSL\JSON;

/**
 *  convert data into JSON string
 * 
 */
function encode(array $data): string
{
  return json_encode($data);
}

/**
 *  convert JSON string into PHP associative array
 * 
 */
function decode(string $data): array
{
  return json_decode($data, true);
}
