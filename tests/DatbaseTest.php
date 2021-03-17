<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Database;
use \Exception;

class DatabaseTest extends TestCase
{
	private Database $db;
	private string $host = 'localhost:6033';
	private string $db_name = 'global_db';
	private string $username = 'devuser';
	private string $password = 'devpass';

	protected function setUp(): void
	{
		$this->db = new Database($this->host, $this->db_name);
		$this->db->connect($this->username, $this->password);
	}

	// public function testMigrations(): void
	// {
	// 	$migrations = [
	// 		"CREATE TABLE posts (
	// 			id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	// 			title VARCHAR (100), 
	// 			content TEXT 
	// 		);",

	// 		"CREATE TABLE users (
	// 			id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	// 			username VARCHAR (100),
	// 			password VARCHAR (256)
	// 		);"
	// 	];

	// 	foreach ($migrations as &$migration) {
	// 		$this->db->addMigration($migration);
	// 	}

	// 	$this->db->runMigrations();
	// }

	public function testConnect(): void
	{
	  $this->assertTrue($this->db->isConnected());
	  $this->assertTrue($this->db !== null);
	}

	// public function testExecute(): void
	// {
	//   $statement = <<<EOQ
	//   CREATE TABLE IF NOT EXISTS posts (
	//     id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
	//     title VARCHAR (100),
	//     content TEXT
	//   );
	//   EOQ;

	//   try {
	//     $this->db->execute($statement);
	//   } catch (Exception $e) {
	//     $this->assertEquals(
	//       "This query returns results. Please use 'fetch()' method instead",
	//       $e->getMessage()
	//     );
	//   }

	//   $this->assertTrue(true);
	// }

	// public function testInsert(): void
	// {
	//   $cases = [
	//     [
	//       'statement'   => 'INSERT INTO posts (title, content) VALUES (?, ?)',
	//       'args'        => ['Example Title', 'Example Content']
	//     ],
	//     [
	//       'statement'   => 'INSERT INTO posts (title, content) VALUES (:title, :content)',
	//       'args'        => [
	//         'title'     => 'Example Title',
	//         'content'   => 'Example Content'
	//       ]
	//     ],
	//   ];

	//   foreach ($cases as &$case) {
	//     $this->db->execute($case['statement'], $case['args']);
	//   }

	//   $this->assertTrue(true);
	// }

	protected function tearDown(): void
	{
		// $this->db->execute('DROP TABLE posts;');
		$this->db->disconnect();
	}
}
