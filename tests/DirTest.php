<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use Exception;
use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Dir;

class DirTest extends TestCase
{
  public function testIntegration(): void
  {
    $path = __DIR__ . '/file_tests/example';
    $newPath = __DIR__ . '/file_tests/example2';

    Dir\create($path);
    $exists = Dir\exists($path);
    $isDir = Dir\isDir($path);

    $this->assertTrue($exists);
    $this->assertTrue($isDir);

    Dir\move($path, $newPath);
    $exists = Dir\exists($newPath);

    $this->assertTrue($exists);

    Dir\remove($newPath);
    $exists = Dir\exists($newPath);

    $this->assertFalse($exists);
  }

  public function testCreateException(): void
  {
    $path = __DIR__ . '/file_tests/sample';

    Dir\create($path);

    try {
      Dir\create($path);
    } catch (Exception $e) {
      $this->assertEquals("A directory at location '{$path}' already exists", $e->getMessage());
      Dir\remove($path);
      return;
    }

    $this->fail('Exception not thrown on diplicate directory creation');
  }

  public function testMoveExceptionDirNotFound(): void
  {
    $oldPath = __DIR__ . '/file_tests/sample2';
    $newPath = __DIR__ . '/file_tests/sample3';

    try {
      Dir\move($oldPath, $newPath);
    } catch (Exception $e) {
      $this->assertEquals("Directory at location '{$oldPath}' not found", $e->getMessage());
      return;
    }

    $this->fail('Exception not thrown on move of non-existing directory');
  }

  public function testMoveExceptionTargetExists(): void
  {
    $oldPath = __DIR__ . '/file_tests/sample2';
    $newPath = __DIR__ . '/file_tests/sample3';

    Dir\create($oldPath);
    Dir\create($newPath);

    try {
      Dir\move($oldPath, $newPath);
    } catch (Exception $e) {
      $this->assertEquals("Directory at location '{$newPath}' already exists", $e->getMessage());

      Dir\remove($oldPath);
      Dir\remove($newPath);

      return;
    }

    $this->fail('Exception not thrown on move when a directory at target location already exists');
  }
}