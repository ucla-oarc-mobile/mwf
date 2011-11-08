<?php 

/**
 * This file is responsible for dynamically loading CSS for the client based on
 * user agent. This script outputs CSS and thus can be directly included via
 * <link>.
 *
 * This file should be included on all pages that use the mobile framework.
 *
 * @package core
 * @subpackage css
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110901
 *
 * @uses Classification
 * @uses CSS
 * @uses CSSMin
 * @uses Path
 * @uses Path_Validator
 */

/**
 * Include necessary libraries.
 */

require_once(dirname(__FILE__).'/lib/classification.class.php');
require_once(dirname(__FILE__).'/lib/config.class.php');
require_once(dirname(__FILE__).'/lib/cssmin.class.php');
require_once(dirname(__FILE__).'/lib/path.class.php');
require_once(dirname(__FILE__).'/lib/path_validator.class.php');

/**
 * Defines the file to be parsed as a CSS file.
 */

header('Content-Type: text/css');

if(!Classification::init())
{
    header("Cache-Control: max-age=0");
}
else
{
    /**
     * @todo what do we do with caching here?
     */
}

?>/** Mobile Web Framework | http://mwf.ucla.edu */

<?php

/**
 * Get custom CSS classes from {'css':'custom'} config variable.
 *
 * @link /config/css.php
 */

$custom = Config::get('css', 'custom');

if(!$custom)
    $custom = array();
elseif(!is_array($custom))
    $custom = array($custom);

/**
 * Load all basic.css stylesheets under the default and custom directories.
 */

require_once(dirname(__FILE__).'/css/default/basic.css');
foreach($custom as $dir)
    if(file_exists(dirname(__FILE__).'/css/'.$dir.'/basic.css'))
        include_once(dirname(__FILE__).'/css/'.$dir.'/basic.css');

/**
 * Load all standard.css stylesheets under the default and custom directories.
 */

if(Classification::is_standard())
{
    require_once(dirname(__FILE__).'/css/default/standard.css');
    foreach($custom as $dir)
        if(file_exists(dirname(__FILE__).'/css/'.$dir.'/standard.css'))
            include_once(dirname(__FILE__).'/css/'.$dir.'/standard.css');
}

/**
 * Load all full.css stylesheets under the default and custom directories.
 */

if(Classification::is_full())
{
    require_once(dirname(__FILE__).'/css/default/full.css');
    foreach($custom as $dir)
        if(file_exists(dirname(__FILE__).'/css/'.$dir.'/full.css'))
            include_once(dirname(__FILE__).'/css/'.$dir.'/full.css');
}

/**
 * Load custom CSS files (minified) based on user agent.
 */

if(isset($_GET['basic']))
    foreach(explode(' ', $_GET['basic']) as $file)
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo ' ' . CSSMin::minify($contents);

if(Classification::is_standard() && isset($_GET['standard']))
    foreach(explode(' ', $_GET['standard']) as $file)
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo ' ' . CSSMin::minify($contents);

if(Classification::is_full() && isset($_GET['full']))
    foreach(explode(' ', $_GET['full']) as $file)
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo ' ' . CSSMin::minify($contents);
