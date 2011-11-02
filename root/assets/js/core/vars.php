<?php

/**
 * First script file that should be loaded by any mwf composite, as it defines
 * the mwf namespace and exposes server-side configuration variables into the
 * Javascript.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
 *
 * @uses Config
 * @uses HTTPS
 * 
 * @uses document.URL
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/lib/https.class.php');

$prefix = Config::get('global', 'cookie_prefix');

$cookies = array('classification', 'user_agent', 'screen');

$cookies_arr = array();
foreach($cookies as $cookie)
    if(isset($_COOKIE[$prefix.$cookie]))
        $cookies_arr[] = $prefix.$cookie;
    
$existing_cookies_var = '["'.implode('","', $cookies_arr).'"]';

$domain_var = Config::get('global', 'cookie_domain');
if($domain_var && substr($domain_var, 0, 1) == '.')
    $domain_var = substr($domain_var, 1);

?>var mwf=new function(){}; mwf.site=new function(){this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_url')) : Config::get('global', 'site_url'); ?>';this.asset = new function(){this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_assets_url')) : Config::get('global', 'site_assets_url'); ?>';};this.cookie = new function(){this.prefix = '<?php echo Config::get('global', 'cookie_prefix'); ?>'; this.domain = <?php if($domain_var) echo '\''.$domain_var.'\''; else echo 'false';  ?>; this.exists = function(e){var cookies = <?php echo $existing_cookies_var; ?>; for(var i=0; i<cookies.length; i++) if(cookies[i] == e) return true; return false;}};this.analytics = new function(){this.key = <?php echo (Config::get('analytics', 'account') ? ('\''.Config::get('analytics', 'account').'\'') : 'null') ?>; }; this.mobile = new function(){ this.maxWidth = <?php echo (Config::get('mobile', 'max_width') ? Config::get('mobile', 'max_width') : 799) ?>; this.maxHeight = <?php echo (Config::get('mobile', 'max_height') ? Config::get('mobile', 'max_height') : 599) ?>;}; this.local = new function(){ this.domain = (function(){ var p = document.URL, i; if((i = p.indexOf('://')) !== false) p = p.substring(i+3); else if((i = p.indexOf('//')) === 0) p = p.substring(2); if((i = p.indexOf('/')) > -1) p = p.substring(0, i); if((i = p.indexOf(':')) > -1) p = p.substring(0, i); if((i = p.indexOf('.')) == 0) p = p.substring(1); return p; })(); this.cookie = new function(){ var cookies = document.cookie.split(';'); this.exists = function(e){ return this.value(e) !== false; }; this.value = function(e){ for(var i = 0; i < cookies.length; i++) if(cookies[i].substr(0,cookies[i].indexOf("=")).replace(/^\s+|\s+$/g,"") == e) return cookies[i].substr(cookies[i].indexOf("=")+1).replace(/^\s+|\s+$/g,""); return false; } } }; this.domain=function(){ return this.local.domain; }; this.webroot=function(){ return this.root; }; this.frontpage=function(){ return this.root+'/index.php'; }; this.webassetroot=function(){ return this.asset.root;};};