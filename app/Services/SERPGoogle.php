<?php 

namespace SERPer\Services;


use GuzzleHttp\Client;


class SERPGoogle
{

    private static $googleSearchUrl = 'http://google.com/search';

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
        foreach ($googleResultsMatched[1] as $matchedResult) {
            preg_match('/\<h3\sclass\=\"r\"\>\<a\shref\=\"(.*?)\>(.*)\<\/a\>\<\/h3\>/', $matchedResult, $matchedTitle);
            preg_match('/\<cite\>(.*)\<\/cite\>/', $matchedResult, $matchedUrl);
            preg_match('/\<span\sclass\=\"st\"\>(.*)/', $matchedResult, $matchedDescription);

            $results[] = [
                'url' => !empty($matchedUrl) ? strip_tags($matchedUrl[1]) : null,
                'title' => !empty($matchedTitle) ? strip_tags(utf8_encode($matchedTitle[2])) : null,
                'description' => !empty($matchedDescription) ? strip_tags(utf8_encode($matchedDescription[1])) : null
            ];
        }

        return $results;
    }

    public static function makeRequest($term)
    {
        $client = new Client();
        $response = $client->request('GET', self::$googleSearchUrl . "?q={$term}", [
            'User-Agent' => 'testing/1.0',
            'timeout' => 2000
        ]);

        if ($response->getStatusCode() !== 200)
            return null;

        return (string) $response->getBody();
    }

}