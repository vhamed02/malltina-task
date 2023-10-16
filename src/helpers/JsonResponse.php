<?php

namespace src\helpers;

class JsonResponse
{
    private static function setJsonHeader(): void
    {
        header('Content-Type: application/json; charset=utf-8');
    }

    public static function create(array $data): string
    {
        self::setJsonHeader();
        return die(json_encode($data));
    }
}