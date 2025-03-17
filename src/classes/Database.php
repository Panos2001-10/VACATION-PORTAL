<?php

namespace App;

class Database
{
    private ?\mysqli $connection = null;

    /**
     * Get a mysqli connection.
     *
     * @return \mysqli
     */
    public function getConnection(): \mysqli
    {
        if ($this->connection === null) {
            $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ($this->connection->connect_error) {
                die("Database connection failed: " . $this->connection->connect_error);
            }
        }

        return $this->connection;
    }

    /**
     * Build the parameter types string dynamically based on each parameter's type.
     *
     * @param array $params
     * @return string
     */
    private function buildParamTypes(array $params): string
    {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                // Fallback to string if type detection fails
                $types .= 's';
            }
        }
        return $types;
    }

    /**
     * Fetch a single row as an associative array, or null if not found.
     *
     * @param string $sql    The SQL statement with placeholders.
     * @param array  $params The parameters to bind to the SQL statement.
     *
     * @return array|null
     * @throws \Exception If statement preparation fails.
     */
    public function fetchRow(string $sql, array $params = []): ?array
    {
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->getConnection()->error);
        }

        if (!empty($params)) {
            $types = $this->buildParamTypes($params);
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ?: null;
    }

    /**
     * Fetch all rows as an array of associative arrays.
     *
     * @param string $sql    The SQL statement with placeholders.
     * @param array  $params The parameters to bind to the SQL statement.
     *
     * @return array
     * @throws \Exception If statement preparation fails.
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->getConnection()->error);
        }

        if (!empty($params)) {
            $types = $this->buildParamTypes($params);
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows;
    }
}
