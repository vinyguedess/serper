<?php

namespace SERPer\Services;


class CacheService
{

    private static $chave = 'ch4v3d3bl0qu310';

    public static function set($key, $value, $expiresIn = '+4 hours')
    {
        $key = self::encode($key, self::$chave);

        $value = self::encode(json_encode([
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime($expiresIn)),
            'data' => $value
        ]), self::$chave);

        file_put_contents(__DIR__ . "/../../storage/{$key}.cache", $value);
    }

    public static function get($originalKey, $defaultValue = null)
    {
        if (!self::hasCache($originalKey))
            return $defaultValue;

        $key = self::encode($originalKey, self::$chave);    
        $cache = file_get_contents(__DIR__ . "/../../storage/{$key}.cache");
        $cache = json_decode(self::decode($cache, self::$chave), true);
        if (str_replace([':', ' ', '-'], '', $cache['expires_at']) < date('YmdHis')) {
            self::delete($originalKey);
            return $defaultValue;
        }

        return $cache['data'];
    }

    public static function delete($originalKey)
    {
        $key = self::encode($originalKey, self::$chave);
        if (self::hasCache($originalKey))
            unlink(__DIR__ . "/../../storage/{$key}.cache");
    }
    
    public static function hasCache($key)
    {
        $key = self::encode($key, self::$chave);
        return file_exists(__DIR__ . "/../../storage/{$key}.cache");
    }

    private static function encode($string, $key)
    {
        return base64_encode(strrev((base64_encode($string) . $key)));
    }

    private static function decode($string, $key)
    {
        return base64_decode(strrev(substr(base64_decode($string), strlen($key))));
    }

}