<?php

declare(strict_types=1);

namespace UnitTestFiles\Test;

require __DIR__ . '/../phpsl.php';

use PHPUnit\Framework\TestCase;
use SOL5\PHPSL\Database;
use \Exception;
use stdClass;

class DatabaseTest extends TestCase
{
	private Database $db;
	private string $host = 'localhost:6033';
	private string $db_name = 'global_db';
	private string $username = 'devuser';
	private string $password = 'devpass';
	private string $table = 'posts';

	private string $schema = <<<EOQ
	CREATE TABLE posts (
		id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
		title VARCHAR (100),
		content TEXT
	);
	EOQ;

	protected function setUp(): void
	{
		$this->db = new Database($this->host, $this->db_name);
		$this->db->connect($this->username, $this->password);
		$this->db->execute($this->schema);
	}

	public function testConnect(): void
	{
		$this->assertTrue($this->db->isConnected());
	}

	public function testExecute(): void
	{
		$statement = <<<EOQ
		ALTER TABLE {$this->table}
		ADD published INTEGER DEFAULT 1;
		EOQ;

		try {
			$this->db->execute($statement);
		} catch (Exception $e) {
			$this->assertEquals(
				"This query returns results. Please use 'fetch()' method instead",
				$e->getMessage()
			);
		}

		$this->assertTrue(true);
	}

	public function testFetch(): void
	{
	  $queries = [
	    [
	      'statement'   => 'INSERT INTO posts (title, content) VALUES (?, ?)',
	      'args'        => ['Example Title', 'Example Content'],
				'result'			=> (object) [
					'title'			=> 'Example Title',
					'content'		=> 'Example Content',
				],
	    ],
	    [
	      'statement'   => 'INSERT INTO posts (title, content) VALUES (:title, :content)',
	      'args'        => [
	        'title'     => 'Example Title 1',
	        'content'   => 'Example Content 1'
				],
				'result'			=> (object) [
					'title'			=> 'Example Title 1',
					'content'		=> 'Example Content 1',
				],
	    ],
	  ];

	  foreach ($queries as &$query) {
	    $this->db->execute($query['statement'], $query['args']);
	  }

		$allQuery = "SELECT * FROM {$this->table}";
		$results = $this->db->fetch($allQuery);

		$index = 0;
		foreach ($results as &$result) {
			$expected = $queries[$index]['result'];

			$this->assertEquals($expected->title, $result->title);
			$this->assertEquals($expected->content, $result->content);

			$index++;
		}
	}

	protected function tearDown(): void
	{
		$this->db->execute("DROP TABLE {$this->table};");
		$this->db->disconnect();
	}
}
