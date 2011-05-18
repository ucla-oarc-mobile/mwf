<?php

/**
 * A class that provides information about the user's browser based on cookies
 * set by the mwf.user_browser.init() function that fires on all js.php-using
 * pages.
 *
 * @author ebollens
 * @version 20101021
 *
 * @uses Config
 * @link /assets/js/util/browser.php
 *
 * @todo This file needs comments for methods and variables.
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(dirname(__FILE__).'/user_agent.class.php');

class User_Browser
{
	private static $_default_height = 480;
	private static $_default_width = 320;
	
	public static function has_cookie()
	{
		return isset($_COOKIE[Config::get('global', 'cookie_prefix').'bw']);
	}
	
	public static function width(){
		if(self::has_cookie())
			return $_COOKIE[Config::get('global', 'cookie_prefix').'bw'];
                else if(($resolution_width = User_Agent::get_capability('resolution_width')) >= 120)
                    return (int)$resolution_width;
		return self::$_default_width;
	}
	
	public static function height(){
		if(self::has_cookie())
			return $_COOKIE[Config::get('global', 'cookie_prefix').'bh'];
                else if(($resolution_height = User_Agent::get_capability('resolution_height')) >= 120)
                    return (int)$resolution_height;
		return self::$_default_height;
	}
}

?>