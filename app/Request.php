<?php

namespace App;

class Request {
    private $getParams;
    private $postParams;
    private $fileParams;
    private $headers;

    public function __construct(array $getParams)
    {
        $this->getParams = $getParams;
        $this->postParams = $_POST;
        $this->fileParams = $_FILES;
    }

    public function hasInput()
    {
        return !empty($this->postParams) || !empty($this->getParams);
    }

    public function hasFile($file = null)
    {
        if (isset($file)) {
            return isset($this->fileParams[$file]);
        }

        return !empty($this->fileParams);
    }

    public function getInput()
    {
        return array_merge(
            $this->sanitize(array_merge(
                $this->getParams,
                $this->postParams,
            )),
            $this->fileParams
        );
    }

    public function only(array|string ...$params)
    {
        if (is_array($params[0])) {
            $params = $params[0];
        }

        return array_filter($this->getInput(), function($value, $param) use($params) {
            return in_array($param, $params);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function sanitize($input)
    {
        return array_map(function ($element) {
            return trim($element);
        }, $input);
    }
}
