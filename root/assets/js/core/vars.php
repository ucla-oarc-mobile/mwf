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
 * @version 20120130
 *
 * @uses Config
 * @uses HTTPS
 * 
 * @uses document.URL
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/lib/https.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/lib/cookie.class.php');

$prefix = Config::get('global', 'cookie_prefix');

$cookies = array('classification' => Cookie::get('classification'),
    'user_agent' => Cookie::get('user_agent'),
    'screen' => Cookie::get('screen'),
    'override' => Cookie::get('override')
);

$cookies_arr = array();
foreach ($cookies as $key=>$value)
    if (isset($value))
        $cookies_arr[] = $prefix.$key;
$existing_cookies_var = '["' . implode('","', $cookies_arr) . '"]';

if (isset($cookies['override']))
    $override_cookie_var = '"' . addslashes($cookies['override']) . '"';
else
    $override_cookie_var = 'false';

if (isset($cookies['classification']))
    $classification_cookie_var = '"' . addslashes($cookies['classification']) . '"';
else
    $classification_cookie_var = 'false';

/** @todo determine if we should first check HTTP_X_FORWARDED_SERVER */
if(isset($_SERVER['HTTP_HOST'])) // actual host for multi-host requests
{
    $domain_var = $_SERVER['HTTP_HOST'];
}
else // fallthru that will not support successful multi-host requests
{
    $domain_var = Config::get('global', 'site_assets_url');
    if (($pos = strpos($domain_var, '//')) !== false)
        $domain_var = substr($domain_var, $pos + 2);
    if (($pos = strpos($domain_var, '/')) !== false)
        $domain_var = substr($domain_var, 0, $pos);
}

$site_url = $local_site_url = Config::get('global', 'site_url');
if(strpos($local_site_url, '://') !== false || substr($local_site_url, 0, 2) == '//')
{
    if(($scheme_pos = strpos($local_site_url, '//')) !== false)
    {
        if(($pos = strpos($local_site_url, '/', $scheme_pos+2)) !== false && strlen($local_site_url) > ++$pos)
            $local_site_url = substr($local_site_url, $pos);
        else
            $local_site_url = '';
    }
    
    if(HTTPS::is_https())
    {
        $site_url = HTTPS::convert_path($site_url);
    }
}
else
{
    $site_url = '//'.$domain_var.(substr($site_url,0,1) != '/' ? '/':'').$site_url;
}

$site_asset_url = $local_site_asset_url = Config::get('global', 'site_assets_url');
if(strpos($local_site_asset_url, '://') !== false || substr($local_site_asset_url, 0, 2) == '//')
{
    if(($scheme_pos = strpos($local_site_asset_url, '//')) !== false)
    {
        if(($pos = strpos($local_site_asset_url, '/', $scheme_pos+2)) !== false && strlen($local_site_asset_url) > ++$pos)
            $local_site_asset_url = substr($local_site_asset_url, $pos);
        else
            $local_site_asset_url = '';
    }
    
    if(HTTPS::is_https())
    {
        $site_asset_url = HTTPS::convert_path($site_asset_url);
    }
}
else
    $site_asset_url = '//'.$domain_var.(substr($site_asset_url,0,1) != '/' ? '/':'').$site_asset_url;

if (($pos = strpos($domain_var, ':')) !== false)
    $domain_var = substr($domain_var, 0, $pos);

?>var mwf=new function(){};mwf.site=new function(){this.root = '<?php echo $site_url; ?>';this.asset = new function(){this.root = '<?php echo $site_asset_url; ?>';};this.cookie = new function(){this.prefix = '<?php echo Config::get('global', 'cookie_prefix'); ?>';this.domain = <?php echo '\'' . $domain_var . '\''; ?>;this.exists = function(e){var cookies = <?php echo $existing_cookies_var; ?>;for(var i=0; i<cookies.length; i++)if(cookies[i] == e)return true;return false;};this.override = <?php echo $override_cookie_var; ?>;this.classification=<?php echo $classification_cookie_var; ?>;};this.localStorage=new function(){this.prefix='<?php echo Config::get('global','local_storage_prefix');?>'};this.analytics=new function(){this.key = <?php echo (Config::get('analytics', 'account') ? ('\'' . Config::get('analytics', 'account') . '\'') : 'null') ?>;};this.mobile = new function(){this.maxWidth = <?php echo (Config::get('mobile', 'max_width') ? Config::get('mobile', 'max_width') : 799) ?>;this.maxHeight = <?php echo (Config::get('mobile', 'max_height') ? Config::get('mobile', 'max_height') : 599) ?>;};this.local = new function(){this.root = "<?php echo $local_site_url; ?>"; this.asset = new function(){ this.root = "<?php echo $local_site_asset_url; ?>"; };this.domain = (function(){var p = document.URL, i;if((i = p.indexOf('://')) !== false)p = p.substring(i+3);else if((i = p.indexOf('//')) === 0)p = p.substring(2);if((i = p.indexOf('/')) > -1)p = p.substring(0, i);if((i = p.indexOf(':')) > -1)p = p.substring(0, i);if((i = p.indexOf('.')) == 0)p = p.substring(1);return p;})();var _isSameOrigin = null;this.isSameOrigin = function(){if(_isSameOrigin === null){if(!this.domain || !mwf.site.cookie.domain){_isSameOrigin = true;}else{var serviceProvider = "."+mwf.site.cookie.domain.toLowerCase();var contentProvider = "."+this.domain.toLowerCase();_isSameOrigin = contentProvider.substring(contentProvider.length - serviceProvider.length, serviceProvider.length) == serviceProvider;}}return _isSameOrigin;};this.cookie = new function(){var cookies = document.cookie.split(';');this.exists = function(e){return this.value(e) !== false;};this.value = function(e){for(var i = 0; i < cookies.length; i++)if(cookies[i].substr(0,cookies[i].indexOf("=")).replace(/^\s+|\s+$/g,"") == e)return cookies[i].substr(cookies[i].indexOf("=")+1).replace(/^\s+|\s+$/g,"");return false;};};};this.domain=function(){return this.local.domain;};this.webroot=function(){return this.root;};this.frontpage=function(){return this.root+'/index.php';};this.webassetroot=function(){return this.asset.root;};};
