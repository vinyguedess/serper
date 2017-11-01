<?php

namespace SERPer\Test\Unit\Services;


use PHPUnit\Framework\TestCase;
use SERPer\Services\CacheService;


class CacheServiceTest extends TestCase
{

    public function testSavingCache()
    {
        CacheService::set('cache.test', 'hello world');
        $this->assertTrue(true);
    }

    public function testGettingCache()
    {
        $value = CacheService::get('cache.test');
        $this->assertEquals($value, 'hello world');
    }

    public function testGettingDefaultValueWhenCacheDoesNotExists()
    {
        $value = CacheService::get('cache.non-existent', 'default-value');
        $this->assertEquals($value, 'default-value');
    }

    public function testGettingDefaultValueWhenCacheIsExpired()
    {
        CacheService::set('cache.expired_cache', 'something expired', '-10 seconds');
        
        $value = CacheService::get('cache.expired_cache', 'expired');
        $this->assertEquals($value, 'expired');
    }
    
}