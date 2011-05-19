<?php

/**
 * A class that provides information about the user's browser based on cookies
 * set by the mwf.user_browser.init() function that fires on all js.php-using
 * pages.
 *
 * @package core
 * @subpackage user_browser
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20101021
 *
 * @uses Config
 * @uses User_Agent
 * @link /assets/js/util/browser.php
 */

/**
 * Require necessary libraries.
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(dirname(__FILE__).'/user_agent.class.php');

class User_Browser
{
    /**
     * Default height if Javascript/WURFL cannot determine it.
     *
     * @var int
     */
    private static $_default_height = 480;

    /**
     * Default width if Javascript/WURFL cannot determine it.
     *
     * @var int
     */
    private static $_default_width = 320;

    /**
     * Returns true if Javascript has set a cookie containing the known DOM
     * height and width, or false otherwise.
     *
     * @return bool
     */
    public static function has_cookie()
    {
        return isset($_COOKIE[Config::get('global', 'cookie_prefix').'bw']);
    }

    /**
     * Returns the width of the browser in the following order: (1) from a
     * cookie set by mwf.browser, (2) from the width that WURFL knows of the
     * device, or (3) the default width.
     * 
     * @return int
     */
    public static function width(){
        if(self::has_cookie())
            return $_COOKIE[Config::get('global', 'cookie_prefix').'bw'];
        else if(($resolution_width = User_Agent::get_capability('resolution_width')) >= 120)
            return (int)$resolution_width;
        return self::$_default_width;
    }

    /**
     * Returns the height of the browser in the following order: (1) from a
     * cookie set by mwf.browser, (2) from the height that WURFL knows of the
     * device, or (3) the default height.
     *
     * @return int
     */
    public static function height(){
        if(self::has_cookie())
            return $_COOKIE[Config::get('global', 'cookie_prefix').'bh'];
        else if(($resolution_height = User_Agent::get_capability('resolution_height')) >= 120)
            return (int)$resolution_height;
        return self::$_default_height;
    }
}
