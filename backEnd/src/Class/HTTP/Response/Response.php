<?php

namespace Alco\Market\Class\HTTP\Response;

abstract class Response {

    protected const SUCCESS = true;

    public function send(): void 
    {
        $data = ['success' => static::SUCCESS] + $this->payload();

        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    abstract protected function payload(): array;
}