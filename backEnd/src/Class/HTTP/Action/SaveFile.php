<?php

namespace Alco\Market\Class\HTTP\Action;

use Alco\Market\Class\HTTP\Request\Request;
use Alco\Market\Class\HTTP\Response\ErrorResponse;
use Alco\Market\Class\HTTP\Response\Response;
use Alco\Market\Class\HTTP\Response\SuccessfulResponse;
use Alco\Market\Class\Repository\TokensRepository;
use DateTimeImmutable;

class SaveFile {

    public function __construct(
        private TokensRepository $repository
    )
    {
        
    }

    public function handle(Request $request): Response
    {
    
        if($token = $this->repository->getTokenByToken($request->getCoockie('TokenSet'))) {
            if($token->expires_on() >= new DateTimeImmutable()) {
                $upLoadingDir = '../imgs/';
            $file = $request->getFile('img_file');
            $uploadFile = $upLoadingDir . basename($file['name']);
   
            if($file['size'] > 500000) {
                return new ErrorResponse('Over file size!');
            }

            $splitFileName = explode('.', $uploadFile);
            $extension = end($splitFileName);

            $array_ext_access = array('', 'jpg', 'img', 'imgs', 'png', 'bmp');

            $is_check = array_search($extension, $array_ext_access);

            if($is_check) {
                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    return new SuccessfulResponse();
                } 
            }
        }
            }
            
        return new ErrorResponse('No access rights');
    }

}