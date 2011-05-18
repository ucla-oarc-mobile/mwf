<?php 

/**
 * This file is responsible for dynamically loading CSS for the client based on
 * user agent. This script outputs CSS and thus can be directly included via
 * <link>.
 *
 * This file should be included on all pages that use the mobile framework.
 *
 * To avoid CSS collisions with @import rules versus direct definitions, this
 * script should only use @import, and should use as minimally a subset of
 * stylesheets as possible.
 *
 * @author ebollens
 * @version 20101021
 *
 * @uses User_Agent
 */

/** Defines the file to be parsed as a CSS file. */
header("Content-Type: text/css");

/** Include necessary library. */
include_once(dirname(__FILE__).'/lib/user_agent.class.php');
include_once(dirname(__FILE__).'/lib/config.class.php');
require_once(dirname(__FILE__).'/lib/cssmin.class.php');
require_once(dirname(__FILE__).'/lib/path.class.php');

$custom = Config::get('css', 'custom');

if(!$custom)
    $custom = array();
elseif(!is_array($custom))
    $custom = array($custom);

require_once(dirname(__FILE__).'/css/default/basic.css');
foreach($custom as $dir)
    if(file_exists(dirname(__FILE__).'/css/'.$dir.'/basic.css'))
        include_once(dirname(__FILE__).'/css/'.$dir.'/basic.css');

if(User_Agent::is_standard())
{
    require_once(dirname(__FILE__).'/css/default/standard.css');
    foreach($custom as $dir)
        if(file_exists(dirname(__FILE__).'/css/'.$dir.'/standard.css'))
            include_once(dirname(__FILE__).'/css/'.$dir.'/standard.css');
}

if(User_Agent::is_full())
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

if(User_Agent::is_standard() && isset($_GET['standard']))
    foreach(explode(' ', $_GET['standard']) as $file)
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo ' ' . CSSMin::minify($contents);

if(User_Agent::is_full() && isset($_GET['full']))
    foreach(explode(' ', $_GET['full']) as $file)
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo ' ' . CSSMin::minify($contents);
        

?>