<?php

/**
 * Static container of configuration variables available throughout the system.
 * This static class (should not be instantiated) provides setters for config
 * files and getters for other files. It uses lazy instantiation to include
 * config files only when a user attempts to access a configuration variable
 * within the namespace of the particular file.
 *
 * @package core
 * @subpackage config
 *
 * @author ebollens
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111108
 * 
 * @uses HTTPS
 */
require_once(dirname(__FILE__).'/https.class.php');

class Config {

    /**
     * @var array Static container of configuration variables that have been
     *              loaded already through config file inclusion (lazy include).
     */
    private static $_vars = array();

    public static function init() {
        $scheme = HTTPS::is_https() ? 'https' : 'http';
        if (self::get('base', 'site_url')) {
            define('MWF_CONFIG_SITE_URL', self::get('base', 'site_url'));
        } else {
            define('MWF_CONFIG_SITE_URL', $scheme.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']);
        }
        
        if (self::get('base', 'site_assets_url')) {
            define('MWF_CONFIG_SITE_ASSETS_URL', self::get('base', 'site_assets_url'));
        } else {
            define('MWF_CONFIG_SITE_ASSETS_URL', $scheme.'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/assets');
        }
    }

    /**
     * Static method that returns a value as specified in the file defined as
     *      /assets/config/{$cat}.php, where it should have been set via
     *      Config::set($cat, $key, $value) in that config file.
     * 
     * @link /assets/config/
     *
     * @param string $cat namespace (name of the config file) where the $key resides
     * @param string $key key of the value within the $cat namespace
     * @return mixed|false mixed if $key exists for $cat or false otherwise
     */
    public static function get($cat, $key) {
        if (!isset(self::$_vars[$cat]) && file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/' . $cat . '.ini'))
            self::$_vars[$cat] = parse_ini_file(dirname(dirname(dirname(dirname(__FILE__)))) . '/config/' . $cat . '.ini');
        return isset(self::$_vars[$cat]) && isset(self::$_vars[$cat][$key]) ? self::$_vars[$cat][$key] : false;
    }

    /**
     * Static method that sets a value. This should be set in a file with the
     *      name /assets/config/{$cat}.php to enable corrent lazy loading
     *      through Config::get($cat, $key).
     *
     * @param string $cat namespace (name of the config file) where the $key resides
     * @param string $key key of the value within the $cat namespace
     * @param mixed $value the value that the ($cat, $key) pair encodes
     */
    public static function set($cat, $key, $value) {
        if (!isset($cat))
            self::$_vars[$cat] = array();

        self::$_vars[$cat][$key] = $value;
    }

}

Config::init();
?>