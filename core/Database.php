<?php

namespace PHPFramework;

class Database
{
    protected \PDO $connection;
    protected \PDOStatement $stmt;
    protected array $queries = [];

    public function __construct()
    {
        $dsn = "mysql:host=" . DB['host'] . ";dbname=" . DB['dbname'] . ";charset=" . DB['charset'];
        try {
            $this->connection = new \PDO($dsn, DB['username'], DB['password'], DB['options']);
        } catch (\PDOException $e) {
            error_log("[" . date('Y-m-d H:i:s') . "] DB Error: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOG_FILE);
            abort($e->getMessage(), 505);
        }
        
        return $this;
    }

    public function query(string $query, array $params = [])
    {
        try {
            $this->stmt = $this->connection->prepare($query);
            $this->stmt->execute($params);

            if (DEBUG) {
                ob_start();
                $this->stmt->debugDumpParams();
                $this->queries[] = ob_get_clean();
            }
        } catch (\PDOException $e) {
            error_log("[" . date('Y-m-d H:i:s') . "] DB Error: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOG_FILE);
            abort($e->getMessage(), 505);
        }

        return $this;
    }

    public function get()
    {
        return $this->stmt->fetchAll();
    }

    public function getOne()
    {
        return $this->stmt->fetch();
    }

    public function findAll($tbl): array|false
    {
        $this->query("SELECT * FROM {$tbl}");
        return $this->stmt->fetchAll();
    }

    public function findOne($tbl, $id): mixed
    {
        $this->query("SELECT * FROM {$tbl} WHERE id = ? LIMIT 1", [$id]);
        return $this->stmt->fetch();
    }

    public function findOrFail($tbl, $id): mixed
    {
        $result = $this->findOne($tbl, $id);
        if (!$result) {
            abort();
        }
        return $result;
    }

    public function getInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function getColumn(): mixed
    {
        return $this->stmt->fetchColumn();
    }

    public function getCount($tbl): int
    {
        $this->query("SELECT COUNT(*) FROM {$tbl}");
        return $this->getColumn();
    }

    public function getQueries()
    {
        $result = [];
        foreach ($this->queries as $key => $value) {
            $line = strtok($value, PHP_EOL);
            while (false !== $line) {
                if (str_contains($line, "SQL:") || str_contains($line, "Sent SQL:")) {
                    $result[$key][] = $line;
                }
                $line = strtok(PHP_EOL);
            }
        }
        return $result; 
    }
}
