<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\TokensRepository;
use Exception;

class LogOut {

    public function __construct(
        private TokensRepository $tokensRepository 
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $token = $request->jsonBodyField('TokenSet');
        } catch (Exception $e) {
            return new ErrorResponse('Not fount TokenSet');
        }

        try {
            $this->tokensRepository->checkTokenByToken($token);
            setcookie('TokenSet', $token, [
                'expires' => time() - 3600 * 24 * 20,
                'path' => '/',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Strict'
            ]);
        } catch (Exception $e) {
            return new ErrorResponse('Error in respository');
        }

        return new SuccessfulResponse([
            'result' => 'ok'
        ]);
    }
}