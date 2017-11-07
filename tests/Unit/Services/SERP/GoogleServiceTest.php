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

}