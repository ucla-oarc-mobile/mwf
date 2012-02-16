<?php

/**
 * Helper methods for vars.php.  Mostly it makes Config stuff from PHP accessible
 *     via JavaScript.
 *
 * @package core
 * 
 * @author ebollens
 * @author trott
 * @copyright Copyright (c) 2010-2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120208
 *
 * @uses Config
 * @uses HTTPS
 * @uses Cookie
 */
require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once(dirname(__FILE__) . '/https.class.php');
require_once(dirname(__FILE__) . '/cookie.class.php');

/**
 * Class that generates JS data from PHP data.
 */
class JS_Vars_Helper {

    private static $_cookie_domain;
    private static $_cookies;

    private static function init_cookies() {
        $all_cookie_names = array('classification', 'user_agent', 'screen', 'override');
        if (!isset(self::$_cookies)) {
            self::$_cookies = array();
            foreach ($all_cookie_names as $cookie_name)
                self::$_cookies[$cookie_name] = Cookie::get($cookie_name);
        }
    }

    /**
     *
     * @return string
     */
    public static function get_existing_cookie_names() {
        if (!isset(self::$_cookies))
            self::init_cookies();

        $prefix = Cookie::get_prefix();
        $cookies_arr = array();
        foreach (self::$_cookies as $key => $value)
            if (isset($value))
                $cookies_arr[] = $prefix . $key;
        return(json_encode($cookies_arr));
    }

    /**
     *
     * @param string $cookie_name
     * @return string 
     */
    public static function get_cookie($cookie_name) {
        if (!isset(self::$_cookies))
            self::init_cookies();

        if (!isset(self::$_cookies[$cookie_name]))
            return json_encode(false);

        return json_encode(self::$_cookies[$cookie_name]);
    }

    /**
     *
     * @return string 
     */
    private static function get_raw_cookie_domain() {
        /** @todo determine if we should first check HTTP_X_FORWARDED_SERVER */
        if (isset(self::$_cookie_domain)) {
            return self::$_cookie_domain;
        }

        if (isset($_SERVER['HTTP_HOST'])) { // actual host for multi-host requests
            self::$_cookie_domain = $_SERVER['HTTP_HOST'];
        } else { // fallthru that will not support successful multi-host requests
            self::$_cookie_domain = Config::get('global', 'site_assets_url');
            if (($pos = strpos(self::$_cookie_domain, '//')) !== false)
                self::$_cookie_domain = substr(self::$_cookie_domain, $pos + 2);
            if (($pos = strpos(self::$_cookie_domain, '/')) !== false)
                self::$_cookie_domain = substr(self::$_cookie_domain, 0, $pos);
        }

        if (($pos = strpos(self::$_cookie_domain, ':')) !== false)
            self::$_cookie_domain = substr(self::$_cookie_domain, 0, $pos);

        return self::$_cookie_domain;
    }

    /**
     *
     * @return string 
     */
    public static function get_cookie_domain() {
        return json_encode(self::get_raw_cookie_domain());
    }

    /**
     *
     * @return string 
     */
    public static function get_cookie_prefix() {
        return json_encode(Cookie::get_prefix());
    }

    /**
     *
     * @return string 
     */
    public static function get_site_url() {
        $site_url = Config::get('global', 'site_url');
        if (strpos($site_url, '://') !== false || substr($site_url, 0, 2) == '//') {
            if (HTTPS::is_https()) {
                $site_url = HTTPS::convert_path($site_url);
            }
        } else {
            $site_url = '//' . self::get_raw_cookie_domain() . (substr($site_url, 0, 1) != '/' ? '/' : '') . $site_url;
        }
        return json_encode($site_url);
    }

    /**
     *
     * @return string 
     */
    public static function get_site_asset_url() {
        $site_asset_url = Config::get('global', 'site_assets_url');
        if (strpos($site_asset_url, '://') !== false || substr($site_asset_url, 0, 2) == '//') {
            if (HTTPS::is_https()) {
                $site_asset_url = HTTPS::convert_path($site_asset_url);
            }
        }
        else
            $site_asset_url = '//' . self::get_raw_cookie_domain() . (substr($site_asset_url, 0, 1) != '/' ? '/' : '') . $site_asset_url;
        return json_encode($site_asset_url);
    }

    /**
     *
     * @return string 
     */
    public static function get_local_site_url() {
        $local_site_url = Config::get('global', 'site_url');
        if (strpos($local_site_url, '://') !== false || substr($local_site_url, 0, 2) == '//') {
            if (($scheme_pos = strpos($local_site_url, '//')) !== false) {
                if (($pos = strpos($local_site_url, '/', $scheme_pos + 2)) !== false && strlen($local_site_url) > ++$pos)
                    $local_site_url = substr($local_site_url, $pos);
                else
                    $local_site_url = '';
            }
        }
        return json_encode($local_site_url);
    }

    /**
     *
     * @return string 
     */
    public static function get_local_site_asset_url() {
        $local_site_asset_url = Config::get('global', 'site_assets_url');
        if (strpos($local_site_asset_url, '://') !== false || substr($local_site_asset_url, 0, 2) == '//') {
            if (($scheme_pos = strpos($local_site_asset_url, '//')) !== false) {
                if (($pos = strpos($local_site_asset_url, '/', $scheme_pos + 2)) !== false && strlen($local_site_asset_url) > ++$pos)
                    $local_site_asset_url = substr($local_site_asset_url, $pos);
                else
                    $local_site_asset_url = '';
            }
        }
        return json_encode($local_site_asset_url);
    }

    /**
     *
     * @return string 
     */
    public static function get_localstorage_prefix() {
        return json_encode(Config::get('global', 'local_storage_prefix'));
    }

    
    /**
     *
     * @return string
     */
    public static function get_analytics_key() {
        if (Config::get('analytics', 'account')) {
            return json_encode(Config::get('analytics', 'account'));
        } else {
            return 'null';
        }
    }

    /**
     * Return JSON object representing analytics.pathKeys from config file.
     * 
     * @return string 
     */
    public static function get_path_keys() {
        $pathAccounts = Config::get('analytics', 'path_account');
        $pathStarts = Config::get('analytics', 'path_start');
        if ($pathAccounts && $pathStarts)
            $indexes = array_intersect(array_keys($pathAccounts), array_keys($pathStarts));
        else
            $indexes = array();
        $pathKeys = array();
        foreach ($indexes as $index) {
            // a = account, s = start path
            $pathKeys[] = array('a' => $pathAccounts[$index], 's' => $pathStarts[$index]);
        }
        return json_encode($pathKeys);
    }
    
    
    /**
     * 
     * @return string
     */
    public static function get_mobile_max_width() {
        return Config::get('mobile', 'max_width') ? Config::get('mobile', 'max_width') : '799';
    }
    
    
    /**
     * 
     * @return string
     */
    public static function get_mobile_max_height() {
        return Config::get('mobile', 'max_height') ? Config::get('mobile', 'max_height') : '599';
    }
}