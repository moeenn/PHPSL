<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

function debug($data, array $options = []): void
{
  $defaultOptions = [
    'detailed'  => false,
  ];

  $options = array_merge($defaultOptions, $options);

  echo "<style>
  pre {
    background: #fdf6e3; 
    color: #657b83; 
    padding: 1rem; 
    font-size: 0.9rem; 
    line-height: 1.3rem;
    font-family: monospace;
  }
  
  pre pre {
    padding: 0;
  }

  pre .xdebug-var-dump {
    font-size: 0.8rem;
  }
  </style>";

  echo "<pre>";
  ($options['detailed']) ? var_dump($data) : print_r($data);
  echo '</pre>';
}

/**
 *  get query parameters from current URL
 * 
*/
function query(string $param = null)
{
  if (!isset($param)) return $_GET;
  if (!isset($_GET[$param])) return [];
  return $_GET[$param];
}
