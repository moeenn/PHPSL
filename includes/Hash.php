<?php

declare(strict_types=1);

namespace SOL5\PHPSL\Hash;

/**
 *  generate secure password hash
 * 
 */
function encode(string $string): string
{
  $hash = \password_hash(
    $string,
    PASSWORD_ARGON2ID,
    [
      'memory_cost' => 2048,
      'time_cost'   => 4,
      'threads'     => 3,
      'cost'        => 3,
      'salt'        => salt(),
    ]
  );
  return $hash;
}

/**
 *  verify a password hash
 * 
 */
function verify(string $cleartext, string $hash)
{
  return \password_verify($cleartext, $hash);
}

/**
 *  calculate MD5sum for integrity checking
 * 
 */
function md5(string $string): string
{
  return \md5($string);
}

/**
 *  generate random salt value
 * 
*/
function salt(): string
{
  return \random_bytes(128);
}
