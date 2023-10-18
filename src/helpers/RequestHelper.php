<?php

namespace src\helpers;

class RequestHelper
{
    private array $queryParams;

    public function __construct(array $queryParams = [])
    {
        $this->queryParams = $queryParams;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function hasQueryParam($param): bool
    {
        return array_key_exists($param, $this->queryParams);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public function get($index): mixed
    {
        return $_REQUEST[$index] ?? null;
    }

    /**
     * Validate params to be exists and not empty
     * @param array $items
     * @return true
     * @throws \Exception
     */
    public function checkNotEmpty(array $params): bool
    {
        foreach ($params as $item) {
            if (empty($this->get($item))) {
                throw new \Exception(sprintf('فیلد %s به درستی وارد نشده است', $item));
            }
        }
        return true;
    }

    /**
     * Get header Authorization
     * */
    public function getAuthorizationHeader(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { // Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(
                array_map('ucwords', array_keys($requestHeaders)),
                array_values($requestHeaders)
            );
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     * */
    public function getBearerToken(): ?string
    {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}