<?php 

namespace SERPer\Services;


use GuzzleHttp\Client;


class SERPGoogle
{

    private static $googleSearchUrl = 'https://www.google.com/search?q=_TERM_&num=_NUM_&gws_rd=cr&dcr=0';
    private static $numberOfResults = 100;
    private static $userAgents = [
        'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0',
        'Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0',
        'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1',
        'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)',
        'Googlebot/2.1 (+http://www.google.com/bot.html)'
    ];

    public static function get($term)
    {
        $googleHtmlContent = self::makeRequest($term);
        if (is_null($googleHtmlContent))
            return [];

        $results = self::parseResults($googleHtmlContent);
        
        return $results;
    }

    public static function parseResults($googleHtmlContent)
    {
        preg_match_all('/\<div\sclass\=\"g\"(.*)/', $googleHtmlContent, $googleResultsMatched);

        $results = [];
        foreach ($googleResultsMatched[1] as $index => $matchedResult) {
            preg_match('/\<h3\sclass\=\"r\"\>\<a\shref\=\"(.*?)\>(.*)\<\/a\>\<\/h3\>/', $matchedResult, $matchedTitle);
            preg_match('/\<cite\>(.*)\<\/cite\>/', $matchedResult, $matchedUrl);
            preg_match('/\<span\sclass\=\"st\"\>(.*)/', $matchedResult, $matchedDescription);

            $results[] = [
                'url' => !empty($matchedUrl) ? strip_tags(utf8_encode($matchedUrl[1])) : null,
                'title' => !empty($matchedTitle) ? strip_tags(utf8_encode($matchedTitle[2])) : null,
                'description' => !empty($matchedDescription) ? strip_tags(utf8_encode($matchedDescription[1])) : null,
                'position' => [
                    'page' => floor(($index) / 10) + 1,
                    'position' => substr((string) $index, -1) + 1,
                    'general' => $index
                ]
            ];
        }

        return $results;
    }

    public static function makeRequest($term)
    {
        $client = new Client();
        $response = $client->request('GET', str_replace([
            '_TERM_', '_NUM_'
        ], [ $term, self::$numberOfResults ], self::$googleSearchUrl), [
            'Accept-Encoding' => 'gzip, deflate, br',
            'User-Agent' => self::getRandomUserAgent(),
            'timeout' => 5000
        ]);

        if ($response->getStatusCode() !== 200)
            return null;

        return (string) $response->getBody();
    }

    public static function getRandomUserAgent()
    {
        $max = count(self::$userAgents) - 1;
        return self::$userAgents[rand(0, $max)];
    }

}