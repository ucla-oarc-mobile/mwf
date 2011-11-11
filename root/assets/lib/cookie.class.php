<?php

/**
 * @package core
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111108
 * 
 * @uses Config
 */
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

    public static function set($name, $value, $expire=0, $path='/') {
        return setcookie(self::$_prefix . $name, $value, $expire, $path);
    }

    public static function get_all_names() {
        $rv = array();
        foreach (array_keys($_COOKIE) as $name) {
            if (strpos($name,self::$_prefix)===0) {
                $rv[] = substr($name, strlen(self::$_prefix), strlen($name));
            }
        }
        return $rv;
    }
}

Cookie::init();