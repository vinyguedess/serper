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
        return "<h1>Bem findo ao SERPer</h1>";
    }

    public function searchAction(Request $request)
    {
        if (is_null($request->get('term')))
            return new JsonResponse([
                'status' => true,
                'message' => ['You must defined a term parameter']
            ], JsonResponse::HTTP_BAD_REQUEST);
    
        $results = SERPGoogle::get($request->get('term'));
    
        return new JsonResponse([
            'status' => true,
            'data' => $results
        ], Response::HTTP_OK);
    }

}