<?php

namespace src\database\adapters;

interface DBAdapter
{
    public function fetchAll(string $query);

    public function fetchRow(string $query);

    public function exec(string $query);
}