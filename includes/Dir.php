<?php

declare(strict_types=1);

namespace SOL5\PHPSL\Dir;

use \Exception;

/**
 *  check if a directory exists
 * 
 */
function exists(string $path): bool
{
  if (file_exists($path) && is_dir($path)) return true;
  return false;
}

/**
 *  check if a provided path is a directory
 * 
 */
function isDir(string $path): bool
{
  return is_dir($path);
}


/**
 *  create a new directory
 * 
 */
function create(string $path): void
{
  if (exists($path)) {
    throw new Exception("A directory at location '{$path}' already exists");
  }

  mkdir($path);
}

/**
 *  move / rename a directory 
 * 
 */
function move(string $oldPath, string $newPath): void
{
  if (!exists($oldPath)) {
    throw new Exception("Directory at location '{$oldPath}' not found");
  }

  if (exists($newPath)) {
    throw new Exception("Directory at location '{$newPath}' already exists");
  }

  try {
    rename($oldPath, $newPath);
  } catch (Exception $e) {
    throw new Exception("Failed to Move Directory: {$e->getMessage()}");
  }
}

/**
 *  remove a directory
 * 
 */
function remove(string $path): void
{
  $isDeleted = rmdir($path);

  if (!$isDeleted) {
    throw new Exception("Failed to delete directory at location '{$path}'");
  }
}
