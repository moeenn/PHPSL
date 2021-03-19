<?php

declare(strict_types=1);

namespace SOL5\PHPSL\File;

use \Exception;
use \Generator;

class FileObject
{
  private string $filepath;
  private $file;
  private string $mode;
  private bool $isOpen;

  const READ = 'r';
  const WRITE = 'w';
  const APPEND = 'a';

  function __construct(string $filepath, string $mode = self::READ)
  {
    if (!\file_exists($filepath)) {
      throw new Exception("File '{$filepath}' not found");
    }

    $allowedModes = [self::READ, self::WRITE, self::APPEND];
    if (!in_array($mode, $allowedModes)) {
      throw new Exception("File can only be opened in READ, WRITE or APPEND mode");
    }

    $this->filepath = $filepath;
    $this->mode = $mode;
    $this->isOpen = false;
  }

  /**
   *  lazy open a file
   * 
   */
  private function open(): void
  {
    try {
      $this->file = \fopen($this->filepath, $this->mode);
    } catch (\Exception $_) {
      throw new Exception("Failed to open file '{$this->filepath}', please check file permissions");
    }
    $this->isOpen = true;
  }

  /**
   *  iterate through file content line-by-line
   *  also allow iteration by-reference
   * 
   */
  public function &iter(): Generator
  {
    if (!$this->isOpen) $this->open();

    while (($line = fgets($this->file)) !== false) {
      yield $line;
    }
  }

  /**
   *  dump entire content of the file
   * 
   */
  public function dump(): string
  {
    if (!$this->isOpen) $this->open();
    if ($this->size() === 0) {
      throw new Exception("File '{$this->filepath}' is empty");
    }

    return \fread($this->file, $this->size());
  }

  /**
   *  get filesize of currently open file
   * 
   */
  public function size(): int
  {
    $size = \filesize($this->filepath);
    \clearstatcache();
    return ($size) ? $size : 0;
  }

  /**
   *  write content to a file
   * 
   */
  public function write(string $content): void
  {
    if (!$this->isOpen) $this->open();

    $writeModes = [self::WRITE, self::APPEND];
    if (!in_array($this->mode, $writeModes)) {
      throw new Exception("File is currently open in read-only mode. Please open the file in write mode to continue");
    }

    \fwrite($this->file, $content);
  }


  /**
   *  clear out current content of a file
   * 
   */
  public function clear(): void
  {
    \file_put_contents($this->filepath, '');
  }

  /**
   *  close a file
   * 
   */
  public function close(): void
  {
    if ($this->file !== null) {
      \fclose($this->file);
    }
    $this->isOpen = false;
  }

  /**
   *  close the file
   * 
   */
  public function __destruct()
  {
    $this->close();
  }
}


/**
 *  file related utilities
 * 
 */
function exists(string $filepath): bool
{
  return \file_exists($filepath);
}

/**
 *  check if path is actually a file
 * 
 */
function isFile(string $filepath): bool
{
  return \is_file($filepath);
}

/**
 *  delete a file
 * 
 */
function delete(string $filepath): void
{
  if (!exists($filepath)) {
    throw new Exception("File '{$filepath}' cannot be deleted because it was not found");
  }

  $isDeleted = \unlink($filepath);
  if (!$isDeleted) {
    throw new Exception("Failed to delete file '{$filepath}'");
  }
}

/**
 *  move / rename a file
 * 
 */
function move(string $oldPath, string $newPath): void
{
  if ($oldPath === $newPath) {
    throw new Exception("File '{$oldPath}' must be given a new name in order to be renamed");
  }

  if (!exists($oldPath)) {
    throw new Exception("File '{$oldPath}' cannot be renamed because it was not found");
  }

  if (!isFile($oldPath)) {
    throw new Exception("File '{$oldPath}' cannot be renamed because it is not a file");
  }

  if (exists($newPath)) {
    throw new Exception("File '{$oldPath}' cannot be renamed as '{$newPath}' because the latter already exists");
  }

  \rename($oldPath, $newPath);
}

/**
 *  create an empty file
 * 
 */
function create(string $filepath): void
{
  $file = \fopen($filepath, FileObject::WRITE);
  \fclose($file);
}