<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOStatement;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;
    private PDOStatement|false $stmt = false;

    public function __construct()
    {
        self::$pdo = Database::getConnection();
    }
    
    private static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $config = Config::DB;

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$pdo = new PDO(
                    $dsn,
                    $config['user'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                throw new \RuntimeException('DB connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
    
    private function query(string $sql, array $params = []): PDOStatement|false
    {
        $this->stmt = self::$pdo->prepare($sql);

        if (!empty($params)) {
            $this->stmt->execute($params);
        } else {
            $this->stmt->execute();
        }

        return $this->stmt;
    }
    
    public function fetch(string $sql, array $params = []): array|false
    {
        $stmt = $this->query($sql, $params);
        
        return $stmt? $stmt->fetch() : false;
    }
    
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    public function insert(string $table, array $data): int
    {
        // $data is ['column1' => 'value1', 'column2' => 'value2', ...].
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($data);

        return (int) self::$pdo->lastInsertId();
    }
    
    public function updateById(string $table, array $data, int $id): int
    {
        // Build "column1 = :column1, column2 = :column2, ...".
        $set = implode(', ', array_map(fn($col) => "$col = :$col", array_keys($data)));

        $sql = sprintf("UPDATE %s SET %s WHERE id = :id", $table, $set);

        $stmt = self::$pdo->prepare($sql);

        $data['id'] = $id;

        $stmt->execute($data);

        return $stmt->rowCount();
    }
    
    public function delete(string $table, int $id): int
    {
        $sql = sprintf("DELETE FROM %s WHERE id = :id", $table);
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }
}
