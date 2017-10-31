<?php

namespace SERPer\Test\Unit\Services;


use PHPUnit\Framework\TestCase;
use SERPer\Services\SERPGoogle;


class SERPGoogleTest extends TestCase
{

    public function testGettingResultsFromGoogle()
    {
        $results = SERPGoogle::get('aluguel de veiculos em são paulo');

        $this->assertArrayHasKey('title', $results[0]);
        $this->assertArrayHasKey('url', $results[0]);
        $this->assertArrayHasKey('description', $results[0]);
    }

}