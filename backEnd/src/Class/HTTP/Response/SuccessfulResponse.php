<?php declare(strict_types=1);

namespace Alco\Market\Class\HTTP\Response;

use Alco\Market\Class\HTTP\Response\Response;

class SuccessfulResponse extends Response {

    protected const SUCCESS = true;

    function __construct(
        private array $data = []
    )
    {
        
    }

    protected function payload(): array
    {
        return ['data' => $this->data];
    }
}