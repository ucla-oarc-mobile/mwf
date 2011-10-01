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
 * @version 20110921
 *
 * @uses Config
 * @link /assets/js/core/browser.js
 */

/**
 * Require necessary libraries.
 */

require_once(dirname(dirname(__FILE__)).'/config.php');

class Screen
{
    /**
     * Default height if Javascript cannot determine it.
     *
     * @var int
     */
    private static $_default_height = 480;

    /**
     * Default width if Javascript cannot determine it.
     *
     * @var int
     */
    private static $_default_width = 320;
    
    private static $_init = null;
    
    private static $_name;
    
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
        self::$_name = Config::get('global', 'cookie_prefix').'screen';
        
        /**
         * If cookie is set, extract contents and parse the JSON into a PHP
         * object, then setting initialized value to true. Otherwise, set it
         * false, as initialization has failed since no cookie is defined.
         */
        if(isset($_COOKIE) && isset($_COOKIE[self::$_name]))
        {
            $browser = $_COOKIE[self::$_name];
            self::$_screen = self::parse($browser);
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
        return json_decode(str_replace(array('\\x3B', '\\x2C'), array(';', ','), stripslashes($dimensions)));
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
     * Returns the width of the browser in the following order: (1) from a
     * cookie set by mwf.browser or (2) the default width.
     * 
     * @return int
     */
    public static function get_width(){
        return ($width = self::get('w')) ? $width : self::$_default_width;
    }

    /**
     * Returns the height of the screen in the following order: (1) from a
     * cookie set by mwf.browser or (2) the default height.
     *
     * @return int
     */
    public static function get_height(){
        return ($height = self::get('h')) ? $height : self::$_default_height;
    }

    /**
     * Returns the height of the screen in the following order: (1) from a
     * cookie set by mwf.browser or (2) the default height.
     *
     * @return int
     */
    public static function get_pixel_ratio(){
        return ($ratio = self::get('r')) ? $ratio : 1;
    }
}
