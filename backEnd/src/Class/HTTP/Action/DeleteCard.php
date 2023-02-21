<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\ContentsRepository;
use Exception;

class DeleteCard {

    public function __construct(
        private ContentsRepository $repository
    )
    {  
    }

    public function handle(Request $request): Response
    {
        try {
            $id = $request->jsonBodyField('id_post');
        } catch (\Throwable $th) {
            return new ErrorResponse('Not found id_post');
        }

        try {
            $this->repository->delete($id);
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

        return new SuccessfulResponse([]);
    }
}