<?php

declare(strict_types=1);

namespace Middleware;
require_once __DIR__ . '/../lib/Interfaces.php';

class Process implements MiddlewareInterface
{
  public static function process($data)
  {
    return [
      'type'  => 'modified',
      'data'  => $data,
    ];
  } 
}