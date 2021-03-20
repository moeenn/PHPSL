<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\File\FileObject;
use SOL5\PHPSL\File;

class FileTest extends TestCase
{
  private string $filePath = __DIR__ . '/file_tests/example.txt';
  private string $newfilePath = __DIR__ . '/file_tests/example_2.txt';
  private string $content = "lorem ipsum !@#!@#!@##RWR";
  private int $contentSize = 0;

  protected function setUp(): void
  {
    File\create($this->filePath);
    $this->contentSize = mb_strlen($this->content, '8bit');
  }

  /**
   * @covers File::exists
   * 
   */
  public function testExists(): void
  {    
    $exists = File\exists($this->filePath);
    $this->assertTrue($exists);
  }

  /**
   * @covers File::move
   * 
   */
  public function testMove(): void
  {
    File\move($this->filePath, $this->newfilePath);
    $this->assertTrue(File\exists($this->newfilePath));
    File\move($this->newfilePath, $this->filePath);
  }
  
  /**
   * @covers File::size
   * 
   */
  public function testSize(): void
  {
    $file = new FileObject($this->filePath);
    $size = $file->size();

    // file is empty at this point
    $this->assertTrue($size === 0);
  }

  /**
   * @covers File::write
   * 
   */
  public function testWrite(): void
  {
    $file = new FileObject($this->filePath, FileObject::WRITE);
    $file->write($this->content);

    $size = $file->size();
    $this->assertTrue($size === $this->contentSize);
  }

  /**
   * @covers File::dump
   * 
   */
  public function testDump(): void
  {
    $file = new FileObject($this->filePath, FileObject::WRITE);
    $file->write($this->content);    

    $file = new FileObject($this->filePath);
    $content = $file->dump();

    $this->assertEquals($this->content, $content);
  }

  /**
   * @covers File::delete
   * 
   */
  public function testDelete(): void
  {
    File\delete($this->filePath);
    $this->assertFalse(File\exists($this->filePath));
  }

  public function tearDown(): void
  {
    if (File\exists($this->filePath)) {
      File\delete($this->filePath);
    }
  }
}
