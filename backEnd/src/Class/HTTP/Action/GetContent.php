<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\ContentsRepository;
use Exception;

class GetContent {

    public function __construct(
        private ContentsRepository $repository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $contents = $this->repository->getContent();
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse(['contents' => $contents]);
    }
}