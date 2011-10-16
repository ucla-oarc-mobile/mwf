<?php

/**
 * Static loader that manages Javascript assets. For local assets, it provides
 * ways to both include a script directly and to write it into the DOM via a
 * script tag. For remote assets, it only provides the latter, requiring such
 * assets to be loaded into the DOM and not included directly. This promotes
 * better caching properties among externally-hosted files that may be cached.
 * This loader also includes several key functions that load assets either
 * externally based on $_external[$key] or else from within the Javascript
 * asset folder.
 *
 * @package core
 * @subpackage handler
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110827
 * 
 * @uses HTTPS
 */

require_once(dirname(__FILE__).'/https.class.php');

class JS
{
    /**
     * Boolean that denotes if init() has been invoked.
     * 
     * @var bool
     */
    private static $_init = false;
    
    /**
     * A mapping defined in init() of keys to external script files.
     * 
     * @var array
     */
    private static $_external;
    
    /**
     * Stores a set of loaded external scripts to prevent multiple imports.
     * 
     * @var array 
     */
    private static $_external_loaded = array();
    
    /**
     * An array by key that contains arrays of libraries that they library
     * by key name depends on.
     * 
     * @var array
     */
    private static $_dependencies;
    
    /**
     * Extensions that import_key() will try to use for script inclusion.
     * 
     * @var type 
     */
    private static $_exts = array('.php', '.js');
    
    /**
     * Static, one-time firing initializer that defines the mappings for
     * external libraries and for dependencies.
     * 
     * @return type 
     */
    public static function init()
    {
        if(self::$_init)
            return;
        
        /**
         * External libraries by key
         */
        self::$_external['jquery'] = 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js';
        self::$_external['jquery_ui'] = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js';
    
        /**
         * Dependencies by key
         */
        self::$_dependencies['jquery_ui'] = array('jquery');
        self::$_dependencies['transitions'] = array('jquery');
        self::$_dependencies['touch_transitions'] = array('transitions', 'jquery.swipe');
    }
    
    /**
     * Loads a file under assets/js and returns true or else it returns false.
     * Unless $allow_multiple is set true, it will otherwise only include the
     * file once.
     * 
     * @param string $filename
     * @param bool $allow_multiple
     * @return bool 
     */
    public static function load($filename, $allow_multiple = false)
    {
        /**
         * $filename is under assets/js
         */
        $filename = dirname(dirname(__FILE__)).'/js/'.$filename;
        
        /**
         * File must exist or else return false.
         */
        if(!file_exists($filename))
            return false;
        
        /**
         * Use include() if multiple allowed, or include_once() otherwise.
         */
        if($allow_multiple)
            include($filename);
        else
            include_once($filename);
        
        return true;
        
    }
    
    /**
     * Load a Javascript file for a given $key based on device classification.
     * If full, then $key may be assets/js/full/{$key}{$ext} for any extension
     * $ext defined in the array $_exts. If standard, or if full and not in 
     * assets/js/full, then it may be assets/js/standard/{$key}{$ext} for any
     * extension $ext in $_exts. This returns false if no matching file found.
     * 
     * @param string $key
     * @return bool 
     */
    public static function load_key($key)
    {
        /**
         * If full device, check each $_exts as assets/js/full/{$key}{$ext}.
         * If found, use load() to include the file.
         */
        if(Classification::is_full())
            foreach(self::$_exts as $ext)
                if(self::load('full/'.$key.$ext))
                    return true;
                
        /**
         * If standard device, or if full device and not already returned, check
         * each $_exts as assets/js/full/{$key}{$ext}. If found, then use load()
         * to include the file.
         */
        if(Classification::is_standard())
            foreach(self::$_exts as $ext)
                if(self::load('standard/'.$key.$ext))
                    return true;
                
       return false;
    }
    
    /**
     * Imports a Javascript file (live DOM write of a new script tag) for a
     * given $key based on device classification. If full, then $key may be 
     * assets/js/full/{$key}{$ext} for any extension $ext in the array $_exts.
     * If standard, or if full and not in assets/js/full, this it may under
     * assets/js/standard/{$key}{$ext} for any extension $ext in $_exts. This
     * returns false if no matching file found.
     * 
     * 
     * @param string $key
     * @return bool 
     */
    public static function import_key($key)
    {
        /**
         * If full device, check each $_exts as assets/js/full/{$key}{$ext}.
         * If found, then use import_file() to write a script tag via a live
         * DOM write.
         */
        if(Classification::is_full())
            foreach(self::$_exts as $ext)
                if(self::import_file('full/'.$key.$ext))
                    return true;
                
        /**
         * If standard device, or if full device and not already returned, check
         * each $_exts as assets/js/full/{$key}{$ext}. If found, then use
         * import_file() to write a script tag via a live DOM write.
         */
        if(Classification::is_standard())
            foreach(self::$_exts as $ext)
                if(self::import_file('standard/'.$key.$ext))
                    return true;
                
       return false;
    }
    
    /**
     * Imports a file under assets/js and returns true or else it returns false.
     * Unless $allow_multiple is set true, it will otherwise only include the
     * file once.
     * 
     * @param string $filename
     * @return bool 
     */
    public static function import_file($filename)
    {
        /**
         * $filename is under assets/js
         */
        $filepath = dirname(dirname(__FILE__)).'/js/'.$filename;
        
        if(!file_exists($filepath))
            return false;
        
        self::import_external(Config::get('global', 'site_assets_url').'/js/'.$filename);
        return true;
    }
    
    /**
     * Echo a call to mwf.util.importJS such that a new script tag is added to
     * the DOM for $url. Returns true if the import is successful, or false
     * if the file has already been loaded. The $allow_multiple boolean, if
     * set true, allows one to make the same call multiple times.
     * 
     * @param string $url
     * @param bool $allow_multiple
     * @return bool 
     */
    public static function import_external($url, $allow_multiple = false)
    {
        /**
         * Return false if $url has already been loaded and $allow_multiple
         * is false, thus not allowing for multiple loads of the same file.
         */
        if(in_array($url, self::$_external_loaded) && !$allow_multiple)
            return false;
        
        /**
         * Output a call to mwf.util.importJS and return true after storing
         * the $url under $_external_loaded to prevent multiple inclusion.
         */
        echo 'mwf.util.importJS(\''.(HTTPS::is_https() ? HTTPS::convert_path($url) : $url).'\');';
        self::$_external_loaded[] = $url;
        return true;
    }
    
    /**
     * Load a library based on key (such as passed as a get parameter to
     * assets/js.php). This uses import_external() if the file is mapped to
     * an external file under $_external or else it uses import_key() to 
     * import the file from under assets/js if the file exists. This function
     * is also aware of dependencies and consults $_dependencies to load
     * necessary files first. All inclusion from this call is done via live
     * DOM writes of additional script tags.
     * 
     * @param string $key 
     */
    public static function load_from_key($key)
    {
        self::init();
        
        /**
         * Recursively call load_from_key() to import all dependencies as 
         * defined under $_dependencies.
         */
        if(array_key_exists($key, self::$_dependencies))
            foreach(self::$_dependencies[$key] as $dependency_key)
                self::load_from_key($dependency_key);
        
        /**
         * If an external mapping exists, load externally. Otherwise, load from
         * under assets/js.
         */
        if(array_key_exists($key, self::$_external))
            self::import_external(self::$_external[$key]);
        else
            self::import_key($key);
    }
}