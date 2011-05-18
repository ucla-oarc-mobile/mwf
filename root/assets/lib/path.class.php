<?php

require_once('path_validator.class.php');

class Path extends Path_Validator
{
    private static $_curl_timeout_download = 1000;
    private static $_curl_timeout_exists = 500;

    public static function exists($path)
    {
        if(self::is_local($path))
            return file_exists($path);

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $path);
         curl_setopt($ch, CURLOPT_HEADER, TRUE);
         curl_setopt($ch, CURLOPT_NOBODY, TRUE);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::$_curl_timeout_exists);
         $result = curl_exec($ch);
         curl_close($ch);
         return substr($result, 0, strlen('HTTP/1.1 200')) == 'HTTP/1.1 200';
    }

    public static function get_contents($path)
    {
        if(self::is_local($path))
            return file_get_contents($path);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::$_curl_timeout_download);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

?>
