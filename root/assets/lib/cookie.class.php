<?php

require_once(dirname(__FILE__) . '/config.class.php');

class Cookie {

    private static $_prefix;

    /**
     * Static-only object cannot be instantiated via construction.
     */
    private function __construct() {
        
    }

    /**
     * Static-only object cannot be instantiated via cloning.
     */
    private function __clone() {
        
    }

    public static function init() {
        self::$_prefix = Config::get('global', 'cookie_prefix') ?
            Config::get('global', 'cookie_prefix') : 'mwf_';
    }

    protected static function stripslashes_deep($value) {
        $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

        return $value;
    }

    public static function get($name) {
        $name = get_magic_quotes_gpc() ?
                addslashes(self::$_prefix . $name) : self::$_prefix . $name;

        if (!isset($_COOKIE[$name]))
            return null;

        return get_magic_quotes_gpc() ?
                self::stripslashes_deep($_COOKIE[$name]) : $_COOKIE[$name];
    }
}

Cookie::init();