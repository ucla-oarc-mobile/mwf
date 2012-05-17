<?php

class URL
{
    private static $_root = false;
    
    public static function root()
    {
        if(!self::$_root)
        {
            $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
            $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
            $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
            self::$_root = $protocol."://".$_SERVER['SERVER_NAME'].$port.substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
        }
        
        return self::$_root;
    }
    
    public static function asset($path)
    {
        return self::root().'/assets/'.$path;
    }
    
    public static function path($path = false)
    {
        return self::root().'/index.php' . ($path ? ('?p='.$path) : '');
    }
}