<?php

/**
 * This file is responsible for doing just-in-time minification of the
 * specified CSS file(s) and then outputting them as the content of this
 * file. Minified CSS can be targetted at specific classifications through $_GET
 * parameters. This script outputs CSS and thus can be directly included via
 * <link>.
 *
 * @package core
 * @subpackage min
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110901
 *
 * @uses Classification
 * @uses CSSMin
 * @uses Path
 * @uses Path_Validator
 */

/**
 * Defines the file to be parsed as a CSS file. 
 */

header("Content-Type: text/css");

/**
 * Require necessary libraries.
 */

require_once(dirname(dirname(__FILE__)).'/lib/'.'cssmin.class.php');
require_once(dirname(dirname(__FILE__)).'/lib/'.'classification.class.php');
require_once(dirname(dirname(__FILE__)).'/lib/'.'path.class.php');
require_once(dirname(dirname(__FILE__)).'/lib/'.'path_validator.class.php');

/**
 * Scripts that will be minified and included at the BASIC level and above.
 */

if(isset($_GET['basic']) || isset($_GET['paths']))
{
    $loadarr = isset($_GET['basic']) ? explode(' ', $_GET['basic']) : array();

    // Support for deprecated PATHS parameter.
    if(isset($_GET['paths']))
        $loadarr = array_merge(explode(' ', $_GET['paths']), $loadarr);

    foreach($loadarr as $file) {
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo CSSMin::minify($contents);
    }
}

/**
 * Scripts that will be minified and included at the STANDARD level and above.
 */

if(Classification::is_standard() && (isset($_GET['standard']) || isset($_GET['touch'])) )
{
    $loadarr = isset($_GET['standard']) ? explode(' ', $_GET['standard']) : array();

    // Support for deprecated TOUCH parameter.
    if(isset($_GET['touch']))
        $loadarr = array_merge(explode(' ', $_GET['touch']), $loadarr);

    foreach($loadarr as $file) {
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo CSSMin::minify($contents);
    }
}

/**
 * Scripts that will be minified and included at the FULL level only.
 */

if(Classification::is_full() && (isset($_GET['full']) || isset($_GET['webkit'])) )
{
    $loadarr = isset($_GET['full']) ? explode(' ', $_GET['full']) : array();

    // Support for deprecated WEBKIT parameter.
    if(isset($_GET['webkit']))
        $loadarr = array_merge(explode(' ', $_GET['webkit']), $loadarr);

    foreach($loadarr as $file) {
        if(Path_Validator::is_safe($file, 'css') && $contents = Path::get_contents($file))
            echo CSSMin::minify($contents);
    }
}
