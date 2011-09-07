<?php 

/**
 * This file is responsible for dynamically loading Javascript for the client
 * based on user agent. This script outputs Javascript and thus can be directly
 * included via <script>.
 *
 * This file should be included on all pages that use the mobile framework.
 *
 * @package core
 * @subpackage handler
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110512
 *
 * @uses User_Agent
 * @uses JS
 * @uses JSMin
 * @uses Path_Validator
 */

/**
 * Defines the file to be parsed as a Javascript file and sets a max cache life.
 */

header('Content-Type: text/javascript');
header("Cache-Control: max-age=3600");

/**
 * Include necessary libraries. 
 */

include_once(dirname(__FILE__).'/lib/user_agent.class.php');
include_once(dirname(__FILE__).'/lib/js.class.php');
require_once(dirname(__FILE__).'/lib/jsmin.class.php');
require_once(dirname(__FILE__).'/lib/path.class.php');
$ext = '.js';

/**
 * Always included base Javascript libraries.
 *
 * @uses /assets/js/util/util.php
 * @uses /assets/js/util/browser.php
 * @uses /assets/js/util/ua.php
 */
JS::include_library('util', 'util', 'php');
JS::include_library('browser', 'util', 'php');
JS::include_library('ua', 'util', 'php');

/**
 * Conditionally-disabled base Javascript libraries.
 *
 * @uses /assets/js/util/analytics.php
 * @uses /assets/js/util/favicon.php
 */

if(!isset($_GET['no_ga']))
    JS::include_library('analytics', 'util', 'php');
if(!isset($_GET['no_favicon']) && !isset($_GET['no_icon']))
    JS::include_library('favicon', 'util', 'php');

/**
 * Writes apple-touch-icon[-precomposed] to the DOM.
 *
 * @uses /assets/js/webkit/appicon.js
 */
if(User_Agent::is_full() && (!Config::get('global', 'appicon_allow_disable_flag') || (!isset($_GET['no_appicon']) && !isset($_GET['no_icon']))))
    JS::include_library('appicon', 'full', 'php');

/**
 * Moves the window below the URL bar.
 *
 * @uses /assets/js/iphone/safariurlbar.js
 * @uses /assets/js/iphone/orientation.js
 */
if(User_Agent::is_iphone_os())
{
    JS::include_library('safariurlbar', 'iphone');
    JS::include_library('orientation', 'iphone');
}

/**
 * Include preview_util as part of js.php and import the desktop preview.
 *
 * @uses /assets/js/desktop/preview_util.php
 * @uses /assets/js/desktop/preview.js [import]
 */

if(User_Agent::is_preview())
{
    JS::include_library('preview_util', 'desktop', 'php');
    JS::import_library('preview', 'desktop');
}

/**
 * Load all standard (and touch_lib for compat) libraries specified in the URI.
 */

if(User_Agent::is_standard() && (isset($_GET['standard_libs']) || isset($_GET['touch_libs'])) )
{
    $loadarr = isset($_GET['standard_libs']) ? explode(' ', $_GET['standard_libs']) : array();

    if(isset($_GET['touch_libs']))
        $loadarr = array_merge(explode(' ', $_GET['touch_libs']), $loadarr);
    
    foreach($loadarr as $load)
        JS::import_library($load, 'standard');
}

/**
 * Load all full (and webkit_lib for compat) libraries specified in the URI.
 */

if(User_Agent::is_full() && (isset($_GET['full_libs']) || isset($_GET['webkit_libs'])) )
{
    $loadarr = isset($_GET['full_libs']) ? explode(' ', $_GET['full_libs']) : array();

    if(isset($_GET['webkit_libs']))
        $loadarr = array_merge(explode(' ', $_GET['webkit_libs']), $loadarr);
    
    foreach($loadarr as $load)
        JS::import_library($load, 'full');
}

/**
 * Load custom JS files (minified) based on user agent.
 */

if(isset($_GET['basic']))
    foreach(explode(' ', $_GET['basic']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);

if(User_Agent::is_standard() && isset($_GET['standard']))
    foreach(explode(' ', $_GET['standard']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);

if(User_Agent::is_full() && isset($_GET['full']))
    foreach(explode(' ', $_GET['full']) as $file)
        if(Path_Validator::is_safe($file, 'js') && $contents = Path::get_contents($file))
            echo ' ' . JSMin::minify($contents);
