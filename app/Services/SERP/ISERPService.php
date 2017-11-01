<?php

namespace SERPer\Services\SERP;


interface ISERPService
{

    public static function get(string $term):array;

    public static function parseResults(string $serpHtmlContent):array;

}