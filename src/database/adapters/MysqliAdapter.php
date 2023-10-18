<?php

namespace src\database\adapters;

use src\database\Connections\MysqliConnection;

class MysqliAdapter implements DBAdapter
{
    private \mysqli $connection;

    public function __construct(MysqliConnection $connection)
    {
        $this->connection = $connection->build();
    }

    public function fetchAll(string $query)
    {
        return $this->connection->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchRow(string $query)
    {
        return $this->connection->query($query)->fetch_assoc();
    }

    public function exec(string $query)
    {
        return $this->connection->query($query);
    }
}