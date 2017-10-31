<?php

namespace SERPer\Controllers;


use SERPer\Services\SERPGoogle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AppController
{

    public function indexAction()
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../../composer.json'), true);

        return new JsonResponse([
            'name' => 'SERPer',
            'description' => $composer['description'],
            'version' => $composer['version']
        ]);
    }

    public function searchAction(Request $request)
    {
        if (is_null($request->get('term')))
            return new JsonResponse([
                'status' => false,
                'message' => ['You must defined a term parameter']
            ], JsonResponse::HTTP_BAD_REQUEST);
    
        $results = SERPGoogle::get($request->get('term'));
    
        return new JsonResponse([
            'status' => true,
            'results' => $results
        ], Response::HTTP_OK);
    }

}