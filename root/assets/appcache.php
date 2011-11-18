<?php 

/**
 * This file is responsible for dynamically specifying HTML5 Offline Application
 * Cache manifest.
 *
 * @package core
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111113
 *
 * @uses Classification
 */

require_once(dirname(__FILE__).'/lib/classification.class.php');

/**
 * If device telemetry is not yet complete, send 404 so we don't cache 
 * incomplete JS and CSS.
 */

if(!Classification::init())
{
    header('HTTP/1.0 404 Not Found');
    exit();
}

/**
 * Sets output to be parsed as an appcache manifest and to not itself be cached.
 */

header("Cache-Control: max-age=0, no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: Wed, 11 Jan 1984 05:00:00 GMT");
header('Content-type: text/cache-manifest'); 

require_once(dirname(__FILE__).'/appcache/manifest.appcache');