<?php

class HTTPS
{
    public static function is_https()
    {
        return isset($_SERVER['HTTPS']);
    }
    
    public static function convert_path($path)
    {
        $pos = strpos($path, '://');
        return $pos === false
            ? (substr($path, 0, 2) != '//' ? 'https://'.$path : $path) 
            : substr_replace($path, 'https', 0, $pos);
    }
}
