<?php

namespace SERPer\Test\Functional;


use SERPer\Services\CacheService;
use Silex\WebTestCase;


class SERPGoogleTest extends WebTestCase
{

    public static function setUpBeforeClass()
    {
        CacheService::delete('Aluguel de carros');
    }

    public function createApplication()
    {
        $app = require __DIR__ . '/../../app/bootstrap.php';
        $app['debug'] = false;
        unset($app['exception_handler']);

        return $app;
    }

    public function testAccessingHomeInformation()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('description', $response);
        $this->assertArrayHasKey('version', $response);
    }   

    public function testTermsSearch()
    {
        $client = $this->createClient();
        $client->request('GET', '/search?term=Aluguel de salão para casamento');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('results', $response);
    }

    public function testTermsSearchWithDomainInformation()
    {
        $client = $this->createClient();
        $client->request('GET', '/search?term=Aluguel de carros&domain=localiza.com');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('results', $response);
        $this->assertArrayHasKey('info', $response);
    }

    public function testGettingResultAlreadyCached()
    {
        $client = $this->createClient();
        $client->request('GET', '/search?term=Aluguel de carros&domain=localiza.com');

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), 200);
        $this->assertArrayHasKey('status', $response);
    }

    public function testPresentingErrorWhenTermNotInformed()
    {
        $client = $this->createClient();
        $client->request('GET', '/search');

        $this->assertEquals($client->getResponse()->getStatusCode(), 400);
    }

}
