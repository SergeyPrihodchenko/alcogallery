<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\Content\Content;
use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\ContentsRepository;
use Alco\Market\Class\Repository\TokensRepository;
use DateTimeImmutable;
use Exception;

class SaveContentData {

    public function __construct(
        private ContentsRepository $contentsRepo,
        private TokensRepository $tokensRepo
    )
    {
    }

    public function handle(Request $request): Response
    {
        if($token = $this->tokensRepo->getTokenByToken($request->getCoockie('TokenSet'))) {
            if($token->expires_on() >= new DateTimeImmutable()) {
                try {
                    $name = $request->jsonBodyField('name');
                    $description = $request->jsonBodyField('description');
                    $file_name = $request->jsonBodyField('img_name');
                } catch (Exception $e) {
                    return new ErrorResponse("Not found data name:$name; description:$description; img_name:$file_name");
                }
    
                $content = new Content(
                    Content::validator($name),
                    $description,
                    $file_name
                );
    
                try {
                    $this->contentsRepo->save($content);
                } catch (Exception $e) {
                    return new ErrorResponse($e->getMessage());
                }
    
                return new SuccessfulResponse();
            }
        }
            
        return new ErrorResponse('No access rights');
    }
}