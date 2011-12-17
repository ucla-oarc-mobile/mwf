<?php 

/**
 * This file is responsible for dynamically loading Javascript for the client
 * based on user agent. This script outputs Javascript and thus can be directly
 * included via <script>.
 *
 * This file should be included on all pages that use the mobile framework.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111101
 *
 * @uses Classification
 * @uses JS
 * @uses JSMin
 * @uses Path
 * @uses Path_Validator
 * @uses User_Agent
 */

/**
 * Include necessary libraries. 
 */

require_once(dirname(__FILE__).'/lib/classification.class.php');
require_once(dirname(__FILE__).'/lib/js.class.php');
require_once(dirname(__FILE__).'/lib/jsmin.class.php');
require_once(dirname(__FILE__).'/lib/path.class.php');
require_once(dirname(__FILE__).'/lib/path_validator.class.php');
require_once(dirname(__FILE__).'/lib/user_agent.class.php');
$ext = '.js';

/**
 * Defines the file to be parsed as a Javascript file and restricts online caching.
 */

header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: Wed, 11 Jan 1984 05:00:00 GMT");
header('Content-Type: text/javascript');

?>/** Mobile Web Framework | http://mwf.ucla.edu */

<?php

/**
 * Core Javascript libraries always included.
 */

$core_filenames = array('vars.php', 
              'base.js',
              'modernizr.js', 
              'capability.js', 
              'browser.js',
              'useragent.js',
              'screen.js',
              'classification.js', 
              'util.js',
              'override.js',
              'server.js',
              'telemetry.js');

/**
 * Include each core Javascript library.
 */

foreach($core_filenames as $filename)
    JS::load('core/'.$filename);

/**
 * End JS definitions early if Device is not initialized, as server.js is going
 * to cause a redirect to return to this page after passing device info.
 */

if(!Classification::init())
    die();

JS::load('core/user_agent.js');

/**
 * Include utility libraries.
 */

if(!isset($_GET['no_ga']))
    JS::load('utility/analytics.js');

if(!isset($_GET['no_favicon']) && !isset($_GET['no_icon']))
    JS::load('utility/favicon.js');

/**
 * Writes apple-touch-icon[-precomposed] to the DOM.
 */

if(Classification::is_full() && (!Config::get('global', 'appicon_allow_disable_flag') || (!isset($_GET['no_appicon']) && !isset($_GET['no_icon']))))
    JS::load('full/appicon.php');

/**
 * Moves the window below the URL bar and fixes Safari viewport on orientation change.
 */
if(User_Agent::get_os() == 'iphone_os')
{
    JS::load('iphone/safariurlbar.js');
    JS::load('iphone/orientation.js');
}

/**
 * Include preview_util as part of js.php and import the desktop preview.
 *
 * @uses /assets/js/desktop/preview_util.php
 * @uses /assets/js/desktop/preview.js [import]
 */

if(Classification::is_preview())
{
    JS::load_from_key('jquery');
    JS::load('desktop/preview_util.php');
    JS::load('desktop/preview_menu.js');
}

/**
 * Load all standard (and touch_lib for compat) libraries specified in the URI.
 */

if(Classification::is_standard() && (isset($_GET['standard_libs']) || isset($_GET['touch_libs'])) )
{
    $loadarr = isset($_GET['standard_libs']) ? explode(' ', $_GET['standard_libs']) : array();

    if(isset($_GET['touch_libs']))
        $loadarr = array_merge(explode(' ', $_GET['touch_libs']), $loadarr);
    
    foreach($loadarr as $load)
        JS::load_from_key($load);
}

/**
 * Load all full (and webkit_lib for compat) libraries specified in the URI.
 */

if(Classification::is_full() && (isset($_GET['full_libs']) || isset($_GET['webkit_libs'])) )
{
    $loadarr = isset($_GET['full_libs']) ? explode(' ', $_GET['full_libs']) : array();

    if(isset($_GET['webkit_libs']))
        $loadarr = array_merge(explode(' ', $_GET['webkit_libs']), $loadarr);
    
    foreach($loadarr as $load)
        JS::load_from_key($load);
}

/**
 * Load custom JS files (minified) based on user agent.
 */

if(isset($_GET['basic']))
    foreach(explode(' ', $_GET['basic']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);

if(Classification::is_standard() && isset($_GET['standard']))
    foreach(explode(' ', $_GET['standard']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);

if(Classification::is_full() && isset($_GET['full']))
    foreach(explode(' ', $_GET['full']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);
