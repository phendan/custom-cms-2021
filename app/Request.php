<?php

namespace App;

class Request {
    private $getParams;
    private $postParams;
    private $headers;

    public function __construct(array $getParams)
    {
        $this->getParams = $getParams;
        $this->postParams = $_POST;
        $this->headers = $this->parseHeaders();
    }

    public function hasInput()
    {
        return !empty($this->postParams) || !empty($this->getParams);
    }

    public function getInput()
    {
        return $this->sanitize(array_merge($this->getParams, $this->postParams));
    }

    public function hasFile(?string $fileName)
    {
        if (isset($fileName)) {
            return isset($_FILES[$fileName]);
        }

        return isset($_FILES);
    }

    public function getFiles()
    {
        return $_FILES;
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

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    private function parseHeaders()
    {
        $rawHeaders = array_filter($_SERVER, fn($element) => str_starts_with($element, 'HTTP_'));
        $headers = [];

        foreach ($rawHeaders as $key => $header) {
            $keyFragments = explode('_', str_replace('HTTP_', '', $key));
            $keyFragments = array_map(fn($fragment) => ucfirst(strtolower($fragment)), $keyFragments);
            $key = implode('-', $keyFragments);
            $output[$key] = $header;
        }

        return $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function expectsJson()
    {
        $headers = $this->getHeaders();
        return in_array('Accept', $headers) && $headers['Accept'] === 'application/json';
    }

    public function sanitize($input)
    {
        return array_map(function ($element) {
            return trim($element);
        }, $input);
    }
}
