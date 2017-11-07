<?php

namespace SERPer\Services\SERP;


use GuzzleHttp\Client;


abstract class SERPService implements ISERPService
{

    protected static $searchUrl;
    
    protected static $numberOfResults = 100;
    
    private static $userAgents = [
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)',
        'Googlebot/2.1 (+http://www.google.com/bot.html)'
    ];

    public static function get(string $term, string $location = null):array
    {
        if (!is_null($location))
            $location = static::parseLocation($location);

        $googleHtmlContent = self::makeRequest($term, $location);
        if (is_null($googleHtmlContent))
            return [];

        $results = static::parseResults($googleHtmlContent);
        
        return $results;
    }

    protected static function makeRequest($term, $location)
    {
        $url = str_replace(
            [ '_TERM_', '_NUM_', '_LOC_' ], 
            [ $term, static::$numberOfResults, $location ], 
            static::$searchUrl
        );
        
        $client = new Client();
        $response = $client->request('GET', $url, [
            'Accept-Encoding' => 'gzip, deflate, br',
            'User-Agent' => self::getRandomUserAgent(),
            'timeout' => 5000
        ]);

        if ($response->getStatusCode() !== 200)
            return null;

        return (string) $response->getBody();
    }

    protected static function getRandomUserAgent()
    {
        $max = count(self::$userAgents) - 1;
        return self::$userAgents[rand(0, $max)];
    }

}