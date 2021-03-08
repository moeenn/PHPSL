<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

class Hash
{
  /**
   *  generate secure password hash
   * 
  */
  public static function encode(string $string): string
  {
    $hash = password_hash(
      $string,
      PASSWORD_ARGON2I,
      [
        'memory_cost' => 2048,
        'time_cost' => 4,
        'threads' => 3
      ]
    );
    return $hash;
  }

  /**
   *  verify a password hash
   * 
  */
  public static function verify(string $cleartext, string $hash)
  {
    return password_verify($cleartext, $hash);
  }

  /**
   *  calculate MD5sum for integrity checking
   * 
  */
  public static function md5(string $string): string
  {
    return md5($string);
  }
}
