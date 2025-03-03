<?php

namespace App\Controllers;

use App\Support\File;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class UserController
 * 
 * @package App\Controllers
 * 
 * 
 * @return Response
 */
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
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
        
    }

    public function show(
        Request $request, 
        Response $response
    ) {
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    /**
     * Update
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function update(Request $request, Response $response): Response
    {
        $data = array('name' => 'Rob', 'age' => 40);
        $payload = json_encode($data);

        $response->getBody()->write($payload);
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * Insert
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function insert(
        Request $request, 
        Response $response
    ){
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * Delete
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function delete(
        Request $request, 
        Response $response
    ){ 
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);

    }

    /**
     * photo
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function photo(Request $request, Response $response): Response
    {
        $file      = $request->getUploadedFiles();
        $classFile = new File($file);
       
        /**
         * validateFile
         */
        if(!$classFile->validate()){
            $payload = [
                "error" => [
                    'code'=> 422,
                    'message' => $classFile->getMessage()
                ]
            ];
           
            /**
             * @param int code
             * @param array $payload
             * @param Response $response
             */
            return responseJson(
                422, 
                $payload, 
                $response
            );
        }

        $classFile->save();
        
        /**
         * @var array $payload
         */
        $payload = [
            "success" => [
                'code'=> 201,
                'message' => $classFile->getMessage()
            ]
        ];

        /**
         * @param int code
         * @param array $payload
         * @param Response $response
         */
        return responseJson(
            201, 
            $payload, 
            $response
        );
    }
}