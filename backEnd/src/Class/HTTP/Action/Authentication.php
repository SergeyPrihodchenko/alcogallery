<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\TokensRepository;
use Alco\Market\Class\Repository\UsersRepository;
use Alco\Market\Class\Token\Token;
use DateTimeImmutable;
use Exception;

class Authentication {

    function __construct(
        private UsersRepository $usersRepo,
        private TokensRepository $tokensRepo
    )
    {
    }

    public function handle(Request $request): Response
    {

        try {
            $nickName = str_replace(';', '', strip_tags(trim($request->jsonBodyField('nickName'))));
            $password = str_replace(';', '', strip_tags(trim($request->jsonBodyField('pass'))));
        } catch (Exception $e) {
            return new ErrorResponse('Not fond user data');
        }

        try {
            $user = $this->usersRepo->getUser($nickName, $password);
        } catch (Exception $e) {
            return new ErrorResponse('Not found user');
        }

        if($token = $this->tokensRepo->getTokenById($user->id())) {

            $token->set_expires_on((new DateTimeImmutable())->modify('+5 day'));
            $this->tokensRepo->save($token);

            header("Content-Type: aplication/json");

            setcookie('TokenSet', $token->token(), [
                'expires' => time() + 3600 * 24 * 5,
                'path' => '/',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Strict'
            ]);
            return new SuccessfulResponse([
                'result' => 'ok',
                'token' => $token->token()
            ]);
        }

        $gen_token = bin2hex(random_bytes(40));
        $date = (new DateTimeImmutable())->modify('+5 day');

        $newToken = new Token($gen_token, $user->id(), $date);
        
        try {
            $this->tokensRepo->save($newToken);

            setcookie('TokenSet', $gen_token, [
                'expires' => time() + 3600 * 24 * 5,
                'path' => '/',
                'secure' => false,
                'httponly' => false,
                'samesite' => 'Strict'
            ]);

            return new SuccessfulResponse([
                'result' => 'ok',
                'token' => $newToken->token()
            ]);
        } catch (Exception $e) {
            return new ErrorResponse($e->getMessage());
        }
    }
}