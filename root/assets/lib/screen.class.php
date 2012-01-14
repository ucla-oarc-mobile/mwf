<?php

/**
 * A class that provides information about the user's screen based on a cookie
 * set by the mwf.server based on mwf.screen cookieName and telemetry.
 *
 * @package core
 * @subpackage browser
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111108
 *
 * @uses Cookie
 * @link /assets/js/core/browser.js
 */

/**
 * Require necessary libraries.
 */

require_once(dirname(__FILE__).'/cookie.class.php');

class Screen
{   
    private static $_init = null;
    
    private static $_name;
    
    private static $_cookie;
    
    private static $_screen = null;
    
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
        self::$_name = 'screen';
        
        /**
         * Contents of cookie set by asets/js/core/server.js.
         */
        self::$_cookie = Cookie::get(self::$_name);
        
        /**
         * If cookie is set, extract contents and parse the JSON into a PHP
         * object, then setting initialized value to true. Otherwise, set it
         * false, as initialization has failed since no cookie is defined.
         */
        if(isset(self::$_cookie))
        {
            self::$_screen = self::parse(self::$_cookie);
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
     * @param string $dimensions
     * @return object 
     */
    public static function parse($dimensions)
    {
        include_once(dirname(__FILE__).'/json.php');
        return json_decode(str_replace(array('\\x3B', '\\x2C'), array(';', ','), $dimensions));
    }
    
    public static function get($name)
    {
        if(!self::init())
            return false;
        
        if(!isset(self::$_screen->$name))
            return false;
        
        return self::$_screen->$name;
    }

    /**
     * Returns true if Javascript has set a cookie containing the known DOM
     * height and width, or false otherwise.
     *
     * @return bool
     */
    public static function has_cookie()
    {
        return self::init();
    }

    /**
     * Returns the width of the browser from a
     * cookie set by mwf.browser or else false
     * 
     * @return int
     * @return bool
     */
    public static function get_width(){
        $width = self::get('w');
        return is_numeric($width) ? intval($width) : false;
    }

    /**
     * Returns the height of the screen from a
     * cookie set by mwf.browser or else false
     *
     * @return int
     * @return bool
     */
    public static function get_height(){
        $height = self::get('h');
        return is_numeric($height) ? intval($height) : false;
    }

    /**
     * Returns the pixel ratio of the screen from a
     * cookie set by mwf.browser or else false
     *
     * @return float
     * @return bool
     */
    public static function get_pixel_ratio(){
        $ratio = self::get('r');
        return is_numeric($ratio) ? floatval($ratio) : false;
    }
}
