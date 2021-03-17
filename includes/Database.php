<?php

declare(strict_types=1);

namespace SOL5\PHPSL;

use \PDO;
use \Exception;
use \PDOException;
use Generator;

class Database
{
  private string $dsn;
  private $connection = null;
  private array $migrations = [];

  function __construct(string $host, string $db_name)
  {
    $this->dsn = "mysql:host={$host};dbname={$db_name}";
  }

  /**
   *  connect to a database using username and password
   * 
  */
  public function connect(string $username, string $password): void
  {
    try {
      $this->connection = new PDO($this->dsn, $username, $password);    
    } catch (PDOException $e) {
      throw new Exception('Failed to connect to the Database: ' . $e->getMessage());
    }

    $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  }

  /**
   *  check if a connection is open with the Database
   * 
  */
  public function isConnected(): bool
  {
    return $this->connection !== null;
  }

  /**
   *  execute query not returning any records
   * 
  */
  public function execute(string $statement, array $args = []): void
  {
    $query = $this->connection->prepare($statement, [
      PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY
    ]);
    
    if ($query->rowCount() > 0) {
      throw new Exception("This query returns results. Please use 'fetch()' method instead");
    }

    $query->execute($args);
  }

  /**
   *  execute queries that return results
   * 
  */
  public function fetch(string $statement, array $args = []): Generator
  {
    $query = $this->connection->prepare($statement);
    $query->execute($args);

    $results = $query->fetchAll();
    yield from $results;
  }

  /**
   *  register a migration
   * 
  */
  public function addMigration(string $query): void
  {
    array_push($this->migrations, $query);
  }

  /**
   *  run all migrations as a single transaction
   * 
  */
  public function runMigrations(): void
  {
    $query = "START TRANSACTION;";

    foreach ($this->migrations as &$migration) {
      $query .= $migration;
    }

    $query .= "COMMIT;";
    echo PHP_EOL . $query . PHP_EOL;
    $this->execute($query);
  }

  /**
   *  close connection to the database
   * 
  */
  public function disconnect(): void
  {
    $this->connection = null;
  }

  /**
   *  remove connection from the database
   * 
  */
  function __destruct()
  {
    $this->disconnect();
  }
}