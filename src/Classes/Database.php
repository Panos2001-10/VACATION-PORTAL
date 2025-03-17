<?php

namespace App;

class Database
{
    private $connection = null;

    public function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            if ($this->connection->connect_error) {
                die("Database connection failed: " . $this->connection->connect_error);
            }
        }

        return $this->connection;
    }
}
