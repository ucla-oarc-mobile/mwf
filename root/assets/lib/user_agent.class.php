<?php

/**
 * A class that provides information about the user's device based on user agent,
 * employing the facade pattern for deriving capability information from an
 * adapter provided with the user agent string by this class.
 *
 * @package core
 * @subpackage user_agent
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110510
 *
 * @uses Config
 */

require_once(dirname(dirname(__FILE__)).'/config.php');

class User_Agent
{
    /**
     * Adapter object used by the facade to determine capability information
     * based on the user agent.
     *
     * @var <type> 
     */
    private static $_adapter = null;

    /**
     * User agent as derived from $_SERVER.
     * 
     * @var string
     */
    private static $_agent = null;

    private static $_uamap = array('desktop'=>0,
                                   'mobile'=>1,
                                   'basic'=>1,
                                   'standard'=>2,
                                   'full'=>3,
                                   'iphone_os'=>4);

    /**
     * Static-only object cannot be instantiated via construction.
     */
    private function __construct() {}

    /**
     * Static-only object cannot be instantiated via cloning.
     */
    private function __clone() {}

    /**
     * A reference accessor the static singleton instantiation of the adapter
     * for the user agent, constructing the adapter with the user agent string
     * if the adapter has not already been instantiated.
     *
     * @return User_Agent_Adapter_Interface
     */
    public static function &adapter()
    {
        if(self::$_adapter === null)
        {
            if(($ua = User_Agent::get()) !== false)
            {
                require_once(strtolower(Config::get('user_agent', 'adapter')).'.class.php');
                $adapter_class = Config::get('user_agent', 'adapter');
                self::$_adapter = new $adapter_class($ua);
            }
            else
            {
                require_once('user_agent_empty_adapter.class.php');
                self::$_adapter = new User_Agent_Empty_Adapter();
            }
        }

        return self::$_adapter;
    }

    /**
     * Accessor for the user agent string.
     *
     * @return string
    */
    public static function get()
    {
        if(self::$_agent === null)
            self::$_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;

        return self::$_agent;
    }

    /**
     * Accessor to determine if user agent denotes an iPhone OS / iOS device.
     * 
     * @return bool
     */
    public static function is_iphone_os($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('iphone_os'))
                return true;
            else
                return false;
        }
        return self::adapter()->is_iphone_os();
    }
	
    /**
     * Accessor to determine if user agent denotes a full capability browser.
     *
     * @return bool
     */
    public static function is_full($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('full'))
                return true;
            else
                return false;
        }
        return self::adapter()->is_full();
    }

    /**
     * Accessor to determine if user agent denotes a standard browser.
     *
     * @return bool
     */
    public static function is_standard($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('standard'))
                return true;
            else
                return false;
        }
        return self::adapter()->is_standard();
    }

    /**
     * Accessor to determine if user agent denotes a mobile device.
     *
     * @return bool
     */
    public static function is_mobile($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('mobile'))
                return true;
            else
                return false;
        }
        return self::adapter()->is_mobile();
    }

    /**
     * Accessor to determine if user agent denotes a mobile device.
     *
     * @return bool
     */
    public static function is_basic($consider_override = true)
    {
        return self::is_mobile($consider_override);
    }

    /**
     * Accessor to determine if user agent has the capability $capability.
     *
     * @param string $capability
     * @return bool
     */
    public static function has_capability($capability)
    {
        return self::adapter()->has_capability($capability);
    }

    /**
     * Accessor to determine capability $capability if the adapter provides it.
     *
     * @param string $capability
     * @return mixed
     */
    public static function get_capability($capability)
    {
        return self::adapter()->get_capability($capability);
    }

    /**
     * Accessor to get the operating system name if the adapter provides it.
     *
     * @return string
     */
    public static function get_os()
    {
        return self::get_capability('device_os');
    }

    /**
     * Accessor to get the operating system version if the adapter provides it.
     *
     * @return string
     */
    public static function get_os_version()
    {
        return self::get_capability('device_os_version');
    }

    /**
     * Accessor to get the browser name if the adapter provides it.
     *
     * @return string
     */
    public static function get_browser()
    {
        return self::get_capability('mobile_browser');
    }

    /**
     * Accessor to get the browser version if the adapter provides it.
     *
     * @return string
     */
    public static function get_browser_version()
    {
        return self::get_capability('mobile_browser_version');
    }

    /**
     * A setter to dictate that the device classification should be overridden,
     * and what it should be overridden as.
     *
     * @param string $classification The desired classification for the override
     * @return bool
     */
    public static function set_override($classification)
    {
        if(isset(self::$_uamap[$classification]))
            return setcookie(Config::get('global', 'cookie_prefix').'ovrcls', self::$_uamap[$classification], time()+86400, '/');
        else
            return false;
    }

    /**
     * Expires the override cookie by setting the value before current time.
     *
     * @return bool
     */
    public static function unset_override()
    {
        return setcookie(Config::get('global', 'cookie_prefix').'ovrcls', '', time()-86400, '/');
    }

    /**
     * Returns true if the user agent is overridden, or false otherwise.
     *
     * @return bool
     */
    public static function is_overridden()
    {
        return isset($_COOKIE[Config::get('global', 'cookie_prefix').'ovrcls'])
               && $_COOKIE[Config::get('global', 'cookie_prefix').'ovrcls'] != ''
               && $_COOKIE[Config::get('global', 'cookie_prefix').'ovrcls'] >= 0;
    }

    /**
     * Returns true if the user agent is overridden and the classification is
     * the same as $classification. The $absolute flag determines if it will
     * return true if the classification overridden is higher than the
     * classification $classfication with priority by $_uamap.
     *
     * @param string $classification
     * @param bool $absolute_only
     * @return bool
     */
    public static function overriden_as($classification, $absolute_only = false)
    {
        if(!self::is_overridden())
            return false;

        if($_COOKIE[Config::get('global', 'cookie_prefix').'ovrcls'] == self::$_uamap[$classification])
            return true;
        else if($absolute_only)
            return false;
        else if($_COOKIE[Config::get('global', 'cookie_prefix').'ovrcls'] > self::$_uamap[$classification])
            return true;
        else
            return false;
    }

    /**
     * Rturns true if the user agent not mobile by default but is overridden
     * to be a mobile user agent as in preview mode, or false otherwise.
     *
     * @return bool
     */
    public static function is_preview()
    {
        return !self::adapter()->is_mobile() && self::overriden_as('mobile');
    }

    /**
     * Returns true if the user agent is driven by the Webkit engine, or false
     * otherwise. This ignores overrides.
     *
     * @return bool
     */
    public static function is_webkit_engine()
    {
        return self::adapter()->is_webkit_engine();
    }

    /*******
     *
     * DEPRECTED
     */

    /**
     * Accessor to determine if user agent denotes a Webkit-based browser.
     *
     * @return bool
     */
    public static function is_webkit($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('webkit'))
                return true;
            else
                return false;
        }

        return self::adapter()->is_webkit();
    }

    /**
     * Accessor to determine if user agent denotes a rich interface device.
     *
     * @return bool
     */
    public static function is_touch($consider_override = true)
    {
        if($consider_override && self::is_overridden())
        {
            if(self::overriden_as('touch'))
                return true;
            else
                return false;
        }

        return self::adapter()->is_touch();
    }
}
