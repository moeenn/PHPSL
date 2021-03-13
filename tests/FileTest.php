<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\File;

class FileTest extends TestCase
{
  private string $filePath = __DIR__ . '/file_tests/example.txt';
  private string $newfilePath = __DIR__ . '/file_tests/example_2.txt';
  private string $content = "lorem ipsum !@#!@#!@##RWR";
  private int $contentSize = 0;

  protected function setUp(): void
  {
    File::create($this->filePath);
    $this->contentSize = mb_strlen($this->content, '8bit');
  }

  public function testExists(): void
  {    
    $this->assertTrue(File::exists($this->filePath));
  }

  public function testRename(): void
  {
    File::rename($this->filePath, $this->newfilePath);
    $this->assertTrue(File::exists($this->newfilePath));
    File::rename($this->newfilePath, $this->filePath);
  }
  
  public function testSize(): void
  {
    $file = new File($this->filePath);
    $size = $file->size();

    // file is empty at this point
    $this->assertTrue($size === 0);
  }

  public function testWrite(): void
  {
    $file = new File($this->filePath, File::WRITE);
    $file->write($this->content);

    $size = $file->size();
    $this->assertTrue($size === $this->contentSize);
  }

  // public function testDump(): void
  // {
  //   $file = new File($this->filePath);
  //   $content = $file->dump();

  //   $this->assertEquals($this->content, $content);
  // }

  public function testDelete(): void
  {
    File::delete($this->filePath);
    $this->assertFalse(File::exists($this->filePath));
  }
}
