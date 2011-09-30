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
        return $pos === false ? ('https://'.$path) : substr_replace($path, 'https', 0, $pos);
    }
}
