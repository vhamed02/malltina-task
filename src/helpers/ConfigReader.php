<?php

namespace src\helpers;

class ConfigReader
{
    const PHP_EXTENSION = '.php';
    private array $config;

    public function open($fileName)
    {
        $this->config = include_once CONFIG_PATH . DIRECTORY_SEPARATOR . $fileName . self::PHP_EXTENSION;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}