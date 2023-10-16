<?php

require_once 'vendor/autoload.php';

// better to having a service container
$router = new \src\services\RouterService(
    new \src\helpers\UrlHelper(),
    new \src\helpers\RequestHelper()
);
$router->resolveController();