<?php

/**
 * Redirection file for non-mobile pages that redirects mobile devices to the
 * mobile site and generates an empty file for desktop browsers. This page
 * ignores classification overrides.
 *
 * This script file should NOT be included on the same page as /assets/js.php,
 * as /assets/js.php unsets the redirection override preference.
 *
 * @package core
 * @subpackage redirect
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111108
 *
 * @uses Cookie
 */

header('Content-Type: text/javascript');
header('Cache-Control: max-age=0');

require_once(dirname(dirname(__FILE__)).'/lib/cookie.class.php');

/**
 * If GET 'm' isn't set, then this page has no content
 */
if(!isset($_GET['m']))
    die();

/** 
 * The page to redirect to is GET 'm' 
 */
$mobile_page = $_GET['m'];

/**
 * The domain specifies a suffix that is optionally appended to the cookie name
 * to create an override setting for only particular pages.
 */
$domain_key = isset($_GET['d']) ? '_' . substr(md5($_GET['d']), 0, 8) : '';

/** 
 * Check to see if an override cookie exists. 
 */
$cookie = Cookie::get('ovrrdr'.$domain_key);
$cookie_override = isset($cookie) && $cookie == 1 ? 1 : 0;

/**
 * Determine if an override request has been made of the referrer
 */
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$referer_uri = strpos($referer, '?') !== false ? substr($referer, strpos($referer, '?')+1, strlen($referer)-strpos($referer, '?')-1) : '' ;
$uri_override = false;
foreach(explode('&', $referer_uri) as $row){
    if(strpos($row, '=') !== false && (substr($row, 0, strpos($row, '=')) == 'ovrrdr' || substr($row, 0, strpos($row, '=')) == 'override_redirect'))
        $uri_override = substr($row, strpos($row, '=')+1, strlen($row)-strpos($row, '=')-1) == 0 ? 0 : 1;
}

/** 
 * Set an expiry time for cookie (using GET 'e' if it and a GET 'd' are specified). 
 */
$expiry_time = 300;
if(strlen($domain_key) > 0 && isset($_GET['e']) && is_numeric($_GET['e']))
    $expiry_time = $_GET['e'];

/** 
 * Set cookie if a URI GET 'ovrrdr' exists or else refresh cookie if it is set.
 */
if($uri_override !== false)
    Cookie::set('ovrrdr'.$domain_key, $uri_override, ($expiry_time != 0 ? time()+$expiry_time*$uri_override : 0), '/');
elseif($cookie_override == 1)
    Cookie::set('ovrrdr'.$domain_key, $cookie_override, ($expiry_time != 0 ? time()+$expiry_time : 0), '/');

/** 
 * Determine if an override has occurred based on $uri_override. 
 */
$override = $uri_override !== false ? $uri_override : $cookie_override;

/** 
 * Script ends on a blank page if no redirect needs to occur. 
 */
if($override)
    die();

/**
 * Include core libraries to perform redirect iff mobile
 */
$core_dir = dirname(dirname(__FILE__)).'/js/core/';
$core_filenames = array('vars.php', 
                        'useragent.js',
                        'screen.js');
foreach($core_filenames as $core_filename)
    include_once($core_dir.$core_filename);

/**
 * Include the redirection routine itself
 */
include(dirname(__FILE__).'/redirect.js');

echo 'mwf.redirect("'.$_GET['m'].'");';
