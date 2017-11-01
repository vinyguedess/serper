<?php 

namespace SERPer\Services\SERP;


class GoogleService extends SERPService
{
    
    protected static $searchUrl = 'https://www.google.com/search?q=_TERM_&num=_NUM_&gws_rd=cr&dcr=0';

    protected static $numberOfResults = 5;

    public static function parseResults(string $googleHtmlContent):array
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

}