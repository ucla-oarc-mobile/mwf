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
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120226
 *
 * @uses JS_Vars_Helper
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/lib/js_vars_helper.class.php'); 

?>var mwf=new function(){};mwf.site=new function(){this.root=<?php echo JS_Vars_Helper::get_site_url(); ?>;this.asset=new function(){this.root=<?php echo JS_Vars_Helper::get_site_asset_url(); ?>};this.cookie=new function(){this.prefix=<?php echo JS_Vars_Helper::get_cookie_prefix(); ?>;this.domain=<?php echo  JS_Vars_Helper::get_cookie_domain(); ?>;this.exists=function(c){var b=<?php echo JS_Vars_Helper::get_existing_cookie_names(); ?>;for(var a=0;a<b.length;a++){if(b[a]==c){return true}}return false};this.override=<?php echo JS_Vars_Helper::get_cookie('override'); ?>;this.classification=<?php echo JS_Vars_Helper::get_cookie('classification'); ?>};this.localStorage=new function(){this.prefix=<?php echo JS_Vars_Helper::get_localstorage_prefix(); ?>};this.analytics=new function(){this.key=<?php echo JS_Vars_Helper::get_analytics_key(); ?>;this.pathKeys=<?php echo JS_Vars_Helper::get_path_keys(); ?>};this.mobile=new function(){this.maxWidth=<?php echo JS_Vars_Helper::get_mobile_max_width(); ?>;this.maxHeight=<?php echo JS_Vars_Helper::get_mobile_max_height(); ?>};this.local=new function(){this.root=<?php echo JS_Vars_Helper::get_local_site_url(); ?>;this.asset=new function(){this.root=<?php echo JS_Vars_Helper::get_local_site_asset_url(); ?>};this.domain=(function(){var c=document.URL,b;if((b=c.indexOf("://"))!==false){c=c.substring(b+3)}else{if((b=c.indexOf("//"))===0){c=c.substring(2)}}if((b=c.indexOf("/"))>-1){c=c.substring(0,b)}if((b=c.indexOf(":"))>-1){c=c.substring(0,b)}if((b=c.indexOf("."))==0){c=c.substring(1)}return c})();var a=null;this.isSameOrigin=function(){if(a===null){if(!this.domain||!mwf.site.cookie.domain){a=true}else{var c="."+mwf.site.cookie.domain.toLowerCase();var b="."+this.domain.toLowerCase();a=b.substring(b.length-c.length,c.length)==c}}return a};this.cookie=new function(){var b=document.cookie.split(";");this.exists=function(c){return this.value(c)!==false};this.value=function(d){for(var c=0;c<b.length;c++){if(b[c].substr(0,b[c].indexOf("=")).replace(/^\s+|\s+$/g,"")==d){return b[c].substr(b[c].indexOf("=")+1).replace(/^\s+|\s+$/g,"")}}return false}}};this.redirect=function(a){window.location=a};this.reload=function(){document.location.reload()};this.domain=function(){return this.local.domain};this.webroot=function(){return this.root};this.frontpage=function(){return this.root+"/index.php"};this.webassetroot=function(){return this.asset.root}};