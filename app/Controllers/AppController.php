<?php

namespace SERPer\Controllers;


use SERPer\Services\CacheService;
use SERPer\Services\SERPGoogleService;
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
            
        $term = strtolower($request->get('term'));

        $listOfDomains = CacheService::get($term);
        if (is_null($listOfDomains)) {
            $listOfDomains = SERPGoogleService::get($term);
            CacheService::set($term, json_encode($listOfDomains));
        } else
            $listOfDomains = json_decode($listOfDomains, true);

        $results = ['status' => true, 'results' => $listOfDomains];

        $domain = $request->get('domain');
        if (!is_null($domain)) {
            foreach ($results['results'] as $result) {
                if (!isset($result['info']) && strpos($result['url'], $domain)) {
                    $results['info'] = [
                        'domain' => $domain,
                        'position' => $result['position']
                    ];
                }
            }
        }

        return new JsonResponse($results, Response::HTTP_OK);
    }

}
