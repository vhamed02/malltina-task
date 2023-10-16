<?php

require_once 'vendor/autoload.php';

// better to having a service container
$router = new \kernel\src\services\RouterService(
    new \kernel\src\helpers\UrlHelper(),
    new \kernel\src\helpers\RequestHelper()
);
$router->resolveController();