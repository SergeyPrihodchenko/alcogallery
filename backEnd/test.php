<?php

// echo hash('sha3-256', 'admin' . 'Vinokurow');

// use Exception;

class Request {

    function __construct(
        private array $get,
        private array $server,
        private string $body,
        private array $cookie,
        private array $file
    )
    {
    }

    private function jsonBody(): array
    {
        try {
            $data = json_decode(
                $this->body,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
        } catch (Exception $e) {
            // throw new Exception($e);
        }

        if(!is_array($data)) {
            // throw new Exception('not valid json');
        }

        return $data;
    }

    public function jsonBodyField(string $field): mixed
    {
        $data = $this->jsonBody();

        if(!array_key_exists($field, $data)) {
            // throw new Exception("No suth field: $field");
        }

        if(empty($data[$field])) {
            // throw new Exception("Empty field: $field");
        }

        return $data[$field];
    }

    public function method(): string
    {
        if(!array_key_exists('REQUEST_METHOD', $this->server)) {
            // throw new Exception('Cannot get method from the request');
        }

        return $this->server['REQUEST_METHOD'];
    }

    public function path(): string
    {
        if(!array_key_exists('REQUEST_URI', $this->server)) {
            // throw new Exception('Cannot get path the request');
        }

        $components = parse_url($this->server['REQUEST_URI']);
            
        if(!is_array($components) || !array_key_exists('path', $components)) {
            // throw new Exception('Cannot get path the request');
        }

        return $components['path'];
    }

    public function query(string $param): string
    {
        if(!array_key_exists($param, $this->get)) {
            // throw new Exception("No such query param in the request $param");
        }

        $value = trim($this->get[$param]);

        if(empty($value)) {
            // throw new Exception("Empty query param in the request $param");
        }

        return $value;
    }

    public function header(string $header): string
    {
        $headerName =mb_strtoupper('http_' . str_replace('-', '_', $header));

        if(!array_key_exists($headerName, $this->server)) {
            // throw new Exception("No such header in the request: $header");
        }

        $value = trim($this->server[$headerName]);

        if(empty($value)) {
            // throw new Exception("Empty header in the request $header");
        }

        return $value;
    }

    public function getCoockie(string $name): string
    {
        return $this->cookie[$name];
    }

    public function getFile(string $name): array
    {
        return $this->file[$name];
    }
}

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'), $_COOKIE, $_FILES);

var_dump($request->getFile('img_file')); 