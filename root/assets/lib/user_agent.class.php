<?php

/**
 * Static accessor for device classification based on the classification cookie 
 * set by js/core/server.js based on assets/js/core/user_agent.js.
 *
 * @package core
 * @subpackage device
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111108
 * 
 * @uses Cookie
 */

require_once(dirname(__FILE__).'/cookie.class.php');

class User_Agent
{   
    /**
     * Null until init() fires. True after init() fires if cookie exists, or
     * false otherwise.
     * 
     * @var null|bool
     */
    private static $_init = null;
    
    /**
     * Name of the user_agent cookie set by assets/js/core/server.js.
     * 
     * @var string
     */
    private static $_name = '';
    
    /**
     * NContents of the user_agent cookie set by assets/js/core/server.js.
     * 
     * @var string
     */
    private static $_cookie = '';
    
    /**
     * An array of capabilities if know, or false otherwise. Null until loaded
     * by invoking init().
     * 
     * @var array|false
     */
    private static $_user_agent = null;
    
    /**
     * Static-only object cannot be instantiated via construction.
     */
    private function __construct() {}

    /**
     * Static-only object cannot be instantiated via cloning.
     */
    private function __clone() {}

    /**
     * Static initializer for User_Agent that loads capabilities from the cookie
     * into a static object via self::parse_capabilities. If a cookie is not
     * set, this returns false.
     * 
     * @return bool
     */
    public static function init()
    {
        /**
         * If initialized, return initialized value without reprocessing.
         */
        if(self::$_init !== null)
            return self::$_init;
        
        /**
         * Define name of the cookie set by asets/js/core/server.js.
         */
        self::$_name = 'user_agent';
        
        /**
         * Contents of the cookie set by asets/js/core/server.js.
         */
        self::$_cookie = Cookie::get(self::$_name);
        
        /**
         * If cookie is set, extract contents and parse the JSON into a PHP
         * object, then setting initialized value to true. Otherwise, set it
         * false, as initialization has failed since no cookie is defined.
         */
        if(isset(self::$_cookie))
        {
            self::$_user_agent = self::parse(self::$_cookie);
            self::$_init = true;
        }
        else
        {
            self::$_init = false;
        }
        
        /**
         * Return whether initialization succeeded or failed.
         */
        return self::$_init;
    }
    
    /**
     * Parses the capabilities cookie by name self::$_name via JSON decode into
     * an object. 
     * 
     * @param string $useragent
     * @return object 
     */
    public static function parse($useragent)
    {
        include_once(dirname(__FILE__).'/json.php');
        return json_decode(str_replace(array('\\x3B', '\\x2C'), array(';', ','), $useragent));
    }
    
    /**
     * Returns a value from user agent information as determined by 
     * mwf.userAgent in js/useragent.js and passed via JSON in a cookie by name 
     * self::$_name.
     * 
     * @param bool $val
     * @return object|false 
     */
    public static function get($val)
    {
        /**
         * Initialize if not already initialized.
         */
        if(!self::$_init)
        {
            self::init();
        }
        
        /**
         * Return $val by property name or else false if not set.
         */
        if(self::$_user_agent && isset(self::$_user_agent->$val))
        {
            return self::$_user_agent->$val;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Returns the user agent string as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_user_agent()
    {
        return self::get('s');
    }
	
    /**
     * Returns the operating system as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_os()
    {
        return self::get('os');
    }
	
    /**
     * Returns the operating system version as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_os_version()
    {
        return self::get('osv');
    }
	
    /**
     * Returns the browser as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_browser()
    {
        return self::get('b');
    }
	
    /**
     * Returns the browser engine as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_browser_engine()
    {
        return self::get('be');
    }
	
    /**
     * Returns the browser engine version as determined by mwf.userAgent.
     * 
     * @return string 
     */
    public static function get_browser_engine_version()
    {
        return self::get('bev');
    }
}

/**
 * Initialize the User_Agent static object.
 */
User_Agent::init();
