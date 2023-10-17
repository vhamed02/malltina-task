<?php

require_once 'vendor/autoload.php';

use src\helpers\ConfigReader;
use src\helpers\RequestHelper;
use src\helpers\UrlHelper;
use src\services\AuthService;
use src\services\RouterService;

$urlHelper = new UrlHelper();
$requestHelper = new RequestHelper();
$configReader = new ConfigReader();

$auth = new AuthService($requestHelper, $configReader);
$auth->authenticate();

$router = new RouterService($urlHelper, $requestHelper);
$router->resolve();