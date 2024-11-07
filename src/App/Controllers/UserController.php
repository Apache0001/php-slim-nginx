<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    /**
     * index
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $data = array('name' => 'Rob', 'age' => 40);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        
        $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
        return $response;
    }

    /**
     * photo
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function photo(Request $request, Response $response): Response
    {
        $file = $request->getUploadedFiles();
        
        if(!isset($file['photo']) || empty($file['photo']->getSize())){
        
            $payload = json_encode([
                "error" => [
                    'code'=> 422,
                    'message' => 'File not found.'
                ]
            ]);
            
            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(422);
        }

        var_dump('teste');exit;

        $fileTempFilename = pathinfo(
            $file['photo']->getClientFilename(), 
            PATHINFO_BASENAME
        );

    
        $payload = json_encode($data);

        $response->getBody()->write($payload);

        $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
        return $response;
    }
}