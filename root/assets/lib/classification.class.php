<?php

/**
 * Static accessor for device classification based on the classification cookie 
 * set by js/core/server.js based on assets/js/core/classification.js and
 * and assets/js/core/override.js.
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

class Classification
{   
    /**
     * Null until init() fires. True after init() fires if cookie exists, or
     * false otherwise.
     * 
     * @var null|bool
     */
    private static $_init = null;
    
    /**
     * Name of the capabilities cookie set by assets/js/core/server.js.
     * 
     * @var string
     */
    private static $_name = '';
    
    /**
     * Contents of cookie set by assets/js/core/server.js.
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
    private static $_capabilities = null;
    
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
        self::$_name = 'classification';
        
        /**
         * If cookie is set, extract contents and parse the JSON into a PHP
         * object, then setting initialized value to true. Otherwise, set it
         * false, as initialization has failed since no cookie is defined.
         */
        self::$_cookie = Cookie::get(self::$_name);
        if(isset(self::$_cookie))
        {
            $capabilities = self::$_cookie;
            self::$_capabilities = self::parse($capabilities);
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
     * @param string $capabilities
     * @return object 
     */
    public static function parse($capabilities)
    {
        include_once(dirname(__FILE__).'/json.php');
        return json_decode($capabilities);
    }
    
    /**
     * Returns an array of capabilities determined by mwf.device in js/device.js
     * and passed via JSON in a cookie by name self::$_name.
     * 
     * @param bool $consider_override
     * @return object|false 
     */
    public static function get($consider_override = true)
    {
        /**
         * Initialize if not already initialized.
         */
        if(!self::$_init)
        {
            self::init();
        }
        
        /**
         * If not considering override and "actual" property is set, then the 
         * device is overridden and to not consider it, must take the object
         * keyed as "actual" rather than the whole capabilities object. 
         * Otherwise, if capabilities are known, then return them or else false.
         */
        if(!$consider_override && isset(self::$_capabilities->actual))
        {
            return self::$_capabilities->actual;
        }
        elseif(self::$_capabilities)
        {
            return self::$_capabilities;
        }
        else
        {
            return false;
        }
    }
	
    /**
     * Return true if classified as a full device by mwf.device in js/device.js.
     * This information is passed server-side by mwf.server in js/server.js via 
     * a cookie with name self::$_name.
     * 
     * @param bool $consider_override
     * @return bool 
     */
    public static function is_full($consider_override = true)
    {
        $capabilities = self::get($consider_override);
        return $capabilities && $capabilities->full;
    }

    /**
     * Return true if classified as at least a standard device by mwf.device in 
     * js/device.js. This information is passed server-side by mwf.server in
     * js/server.js via a cookie with name self::$_name.
     * 
     * @param bool $consider_override
     * @return bool 
     */
    public static function is_standard($consider_override = true)
    {
        $capabilities = self::get($consider_override);
        return $capabilities && $capabilities->standard;
    }

    /**
     * All devices are regarded as basic.
     * 
     * @param bool $consider_override
     * @return true 
     */
    public static function is_basic($consider_override = true)
    {
        return true;
    }

    /**
     * A device is regarded as mobile under one of two conditions: mwf.device
     * in js/device.js classifies it as mobile in the cookie, or the device does
     * not support cookies. The former is more common, but the latter derives
     * its logic by the fact that all major desktop browsers support cookies,
     * whereas support for cookies for mobile browsers is shaky. If cookies 
     * are disregarded, then the user will get a minimal user experience and
     * be classified as basic.
     * 
     * @param bool $consider_override
     * @return bool 
     */
    public static function is_mobile($consider_override = true)
    {
        $capabilities = self::get($consider_override);
        return $capabilities && $capabilities->mobile || !isset(self::$_cookie);
    }
    
    /**
     * Determin if the device is overridden based on the override cookie.
     * 
     * @return bool
     */
    public static function is_override()
    {
        $override = Cookie::get('override');
        return isset($override);
    }
    
    /**
     * Determine if the device is overridden as the $classification provided,
     * namely 'full', 'standard', and 'basic'. If $absolute_only is set to true,
     * then this does not return true if comparing the standard classification
     * to a full device, whereas otherwise it does, as a full device has the
     * capabilities of a standard device as well.
     * 
     * @param string $classification
     * @param bool $absolute_only
     * @return bool
     */
    public static function is_override_as($classification, $absolute_only = false)
    {
        /**
         * Return false if not overridden.
         */
        if(!self::is_override())
            return false;
        
        /**
         * Switch on the $classification name to determine if the device is of
         * the $classification. If $absolute_only, then make sure it is not also
         * the classification above, as, if so, it is inheriting lesser
         * classifications.
         */
        switch($classification)
        {
            case 'full':
                return self::is_full();
            case 'standard':
                return self::is_standard() && (!$absolute_only || !self::is_full());
            case 'basic':
                return self::is_basic() && (!$absolute_only || !self::is_standard());
        }
        
        /**
         * Return false if not a valid classification, as all valid 
         * classifications have been checked and then returned by switch.
         */
        return false;
    }
    
    /**
     * Determine if the device is in preview mode, as in it is not itself
     * mobile (when not considering override) but that it has indeed been
     * overridden.
     * 
     * @return bool
     */
    public static function is_preview()
    {
        return self::is_override() && !self::is_mobile(false);
    }
}

/**
 * Initialize the Device static object.
 */
Classification::init();
