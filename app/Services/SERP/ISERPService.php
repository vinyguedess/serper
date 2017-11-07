<?php

namespace SERPer\Services\SERP;


interface ISERPService
{

    public static function get(string $term, string $location = null):array;

    public static function parseResults(string $serpHtmlContent):array;

    public static function parseLocation(string $location):string;

}