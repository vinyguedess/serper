<?php

namespace SERPer\Test\Unit\Services\SERP;


use PHPUnit\Framework\TestCase;
use SERPer\Services\SERP\GoogleService;


class GoogleServiceTest extends TestCase
{

    public function testGettingResultsFromGoogle()
    {
        $results = GoogleService::get('aluguel de veiculos em são paulo');

        $this->assertArrayHasKey('title', $results[0]);
        $this->assertArrayHasKey('url', $results[0]);
        $this->assertArrayHasKey('description', $results[0]);
    }

    public function testGettingResultsForcingRegion()
    {
        $results = GoogleService::get('aluguel de veiculos', 'Brazil,São Paulo,São Paulo');
        
        file_put_contents('xxx.json', json_encode($results));

        $this->assertArrayHasKey('title', $results[0]);
        $this->assertArrayHasKey('url', $results[0]);
        $this->assertArrayHasKey('description', $results[0]);
    }

}