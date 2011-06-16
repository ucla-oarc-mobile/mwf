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
 * @version 20101220
 *
 * @uses Config
 * @uses User_Agent
 */

/** Set the header type and a cache of zero because this is very dynamic. */
header('Content-Type: text/javascript');
header("Cache-Control: max-age=0");

/** User_Agent is required to determine visitor device type. */
@require_once('../lib/user_agent.class.php');
@include_once(dirname(dirname(__FILE__)).'/config.php');

/**
 * Script does nothing if class can't load, user isn't mobile, or the GET 'm'
 * parameter isn't set (meaning the script wouldn't know where to redirect).
 * This also does nothing if the User_Agent fetch fails. This is a safety
 * fallback to leave the behavior on other sites as though they're already
 * on the other site.
 */
if(!class_exists('User_Agent') || User_Agent::get() === false || !User_Agent::is_mobile(false) || !isset($_GET['m']))
    die();

/** The page to redirect to is GET 'm' */
$mobile_page = $_GET['m'];

/**
 * The domain specifies a suffix that is optionally appended to the cookie name
 * to create an override setting for only particular pages.
 */
$domain_key = isset($_GET['d']) ? '_' . substr(md5($_GET['d']), 0, 8) : '';

/** Check to see if an override cookie exists. */
$cookie_override = isset($_COOKIE[Config::get('global', 'cookie_prefix').'ovrrdr'.$domain_key]) && $_COOKIE[Config::get('global', 'cookie_prefix').'ovrrdr'.$domain_key] == 1 ? 1 : 0;

/** The referrer is the page including this script - it may include GET 'ovrrdr'. */
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$referer_uri = strpos($referer, '?') !== false ? substr($referer, strpos($referer, '?')+1, strlen($referer)-strpos($referer, '?')-1) : '' ;

/** Find GET 'ovrrdr' if it exists in the referrer's URI. */
$uri_override = false;
foreach(explode('&', $referer_uri) as $row){
    if(strpos($row, '=') !== false && substr($row, 0, strpos($row, '=')) == 'ovrrdr')
        $uri_override = substr($row, strpos($row, '=')+1, strlen($row)-strpos($row, '=')-1) == 0 ? 0 : 1;
}

/** Set an expiry time for cookie (using GET 'e' if it and a GET 'd' are specified). */
$expiry_time = 300;
if(strlen($domain_key) > 0 && isset($_GET['e']) && is_numeric($_GET['e']))
    $expiry_time = $_GET['e'];

/** Set cookie if a URI GET 'ovrrdr' exists. */
if($uri_override !== false)
    setcookie(Config::get('global', 'cookie_prefix').'ovrrdr'.$domain_key, $uri_override, ($expiry_time != 0 ? time()+$expiry_time*$uri_override : 0), '/');
/** Refresh cookie if it is already set. */
elseif($cookie_override == 1)
    setcookie(Config::get('global', 'cookie_prefix').'ovrrdr'.$domain_key, $cookie_override, ($expiry_time != 0 ? time()+$expiry_time : 0), '/');

/** Determine if an override needs to occur based on $uri_override. */
$override = $uri_override !== false ? $uri_override : $cookie_override;

/** Script ends on a blank page if no redirect needs to occur. */
if($override)
    die();

if(isset($_GET['prompt']))
{
    $prompt = strlen($_GET['prompt']) > 0 ? strip_tags($_GET['prompt']) : 'Select a browsing mode:';
    $max = mt_getrandmax();
    $rand = 'prompt-'.mt_rand($max/2, $max);
    ?>if(typeof(window.addEventListener) == 'undefined' || typeof(document.createElement) == 'undefined'){
    window.location = '<?php echo $mobile_page; ?>';
}else{
    window.addEventListener('load', function(){

        var o = document.createElement('div');
        o.id = '<?php echo 'o-'.$rand; ?>';
        o.style.position = 'absolute';
        o.style.top = 0;
        o.style.bottom = 0;
        o.style.left = 0;
        o.style.right = 0;
        o.style.background = '#000';
        o.style.opacity = '.4';
        o.style.zIndex = 0;

        var w = document.createElement('div');
        w.id = '<?php echo $rand; ?>';
        w.style.position = 'absolute';
        w.style.background = '#fff';
        w.style.zIndex = 1;
        w.style.textAlign = 'center';
        w.style.width = '80%';
        w.style.margin = '20px 10%';
        w.style.padding = '12px 8px';
        w.style.WebkitBorderRadius = '8px';
        w.style.MozBorderRadius = '8px';
        w.style.OBorderRadius = '8px';
        w.style.borderRadius = '8px';
        w.innerHTML = '<div><?php echo $prompt; ?></div><div><a href="<?php echo $mobile_page; ?>">Mobile Site</a> | <a href="#" id="<?php echo 'c-'.$rand; ?>">Full Site</a></div>';

        var b = document.body;
        var fc = b.firstChild;
        b.insertBefore(w, fc);
        b.insertBefore(o, fc);

        document.getElementById('<?php echo 'c-'.$rand; ?>').addEventListener('click', function(){
            var c = '<?php echo Config::get('global', 'cookie_prefix').'ovrrdr'.$domain_key; ?>=1;path=/;';
            <?php if($expiry_time){ ?>
            var ex= new Date();
            ex.setTime(ex.getTime()+<?php echo $expiry_time*1000; ?>);
            c += 'expires='+ex.toUTCString()+';';
            <?php } ?>
            document.cookie = c;
            var w = document.getElementById('<?php echo 'o-'.$rand; ?>');
            var o = document.getElementById('<?php echo $rand; ?>');
            w.parentNode.removeChild(w);
            o.parentNode.removeChild(o);
        }, false);
    }, false);

}<?php
}
else
{
    /** Redirect code is the only code written to page if redirect is needed. */
    echo 'window.location = "' . $mobile_page , '";';
}
