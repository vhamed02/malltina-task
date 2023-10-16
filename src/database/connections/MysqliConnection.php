<?php

namespace src\database\Connections;

use src\helpers\ConfigReader;

class MysqliConnection implements DBConnection
{
    private ConfigReader $configReader;

    public function __construct(ConfigReader $configReader)
    {
        $this->configReader = $configReader;
    }

    public function build()
    {
        $dbConfig = $this->configReader->open('database')->getConfig();
        return new \mysqli(
            $dbConfig['connection']['db_host'],
            $dbConfig['connection']['db_user'],
            $dbConfig['connection']['db_pass'],
            $dbConfig['connection']['db_name']
        );
    }
}