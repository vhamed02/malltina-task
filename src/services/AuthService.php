<?php

namespace src\services;

use src\helpers\ConfigReader;
use src\helpers\JsonResponse;
use src\helpers\RequestHelper;

class AuthService
{
    private RequestHelper $requestHelper;

    public function __construct(RequestHelper $requestHelper, ConfigReader $configReader)
    {
        $this->requestHelper = $requestHelper;
        $this->configReader = $configReader;
    }

    public function authenticate()
    {
        $authConfig = $this->configReader->open('auth')->getConfig();
        if ($this->requestHelper->getBearerToken() === $authConfig['bearer']) {
            return true;
        }
        return JsonResponse::create([
            'status' => 403,
            'message' => 'not authorized'
        ]);
    }
}