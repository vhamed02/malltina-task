<?php

namespace src\helpers;

class RequestHelper
{
    /**
     * @return string
     */
    public function getType()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param $index
     * @return mixed|null
     */
    public function get($index)
    {
        return $_REQUEST[$index] ?? null;
    }

    /**
     * Validate params to be exists and not empty
     * @param array $items
     * @return true
     * @throws \Exception
     */
    public function validate(array $params)
    {
        foreach ($params as $item) {
            if (empty($this->get($item))) {
                throw new \Exception(sprintf('فیلد %s به درستی وارد نشده است', $item));
            }
        }
        return true;
    }
}