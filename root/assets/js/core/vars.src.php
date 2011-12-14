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
 * @version 20111108
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
foreach ($cookies as $key => $value)
    if (isset($value))
        $cookies_arr[] = $prefix . $key;
$existing_cookies_var = '["' . implode('","', $cookies_arr) . '"]';

if (isset($cookies['override']))
    $override_cookie_var = '"' . addslashes($cookies['override']) . '"';
else
    $override_cookie_var = 'false';

if (isset($cookies['classification']))
    $classification_cookie_var = '"' . addslashes($cookies['classification']) . '"';
else
    $classification_cookie_var = 'false';

$domain_var = Config::get('global', 'site_assets_url');
if (($pos = strpos($domain_var, '//')) !== false)
    $domain_var = substr($domain_var, $pos + 2);
if (($pos = strpos($domain_var, '/')) !== false)
    $domain_var = substr($domain_var, 0, $pos);
if (($pos = strpos($domain_var, ':')) !== false)
    $domain_var = substr($domain_var, 0, $pos);
?>

var mwf=new function(){};

mwf.site=new function(){

    this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_url')) : Config::get('global', 'site_url'); ?>';

    this.asset = new function(){

        this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_assets_url')) : Config::get('global', 'site_assets_url'); ?>';

    };

    this.cookie = new function(){

        this.prefix = '<?php echo Config::get('global', 'cookie_prefix'); ?>';

        this.domain = <?php echo '\'' . $domain_var . '\''; ?>;

        this.exists = function(e){

            var cookies = <?php echo $existing_cookies_var; ?>;

            for(var i=0; i<cookies.length; i++)
                if(cookies[i] == e) return true;

            return false;
        };

        this.override = <?php echo $override_cookie_var; ?>;

        this.classification = <?php echo $classification_cookie_var; ?>;

    };

    this.analytics = new function(){

        this.key = <?php echo (Config::get('analytics', 'account') ? ('\'' . Config::get('analytics', 'account') . '\'') : 'null') ?>;

    };

    this.mobile = new function(){

        this.maxWidth = <?php echo (Config::get('mobile', 'max_width') ? Config::get('mobile', 'max_width') : 799) ?>;
        this.maxHeight = <?php echo (Config::get('mobile', 'max_height') ? Config::get('mobile', 'max_height') : 599) ?>;

    };

    this.local = new function(){

        this.domain = (function(){

            var p = document.URL, i;

            if((i = p.indexOf('://')) !== false)
                p = p.substring(i+3);
            else if((i = p.indexOf('//')) === 0)
                p = p.substring(2);

            if((i = p.indexOf('/')) > -1)
                p = p.substring(0, i);

            if((i = p.indexOf(':')) > -1)
                p = p.substring(0, i);

            if((i = p.indexOf('.')) == 0)
                p = p.substring(1);

            return p;

        })();

        var _isSameOrigin = null;

        this.isSameOrigin = function(){

            if(_isSameOrigin === null) {

                if(!this.domain || !mwf.site.cookie.domain) {

                    _isSameOrigin = true;

                } else{

                    var serviceProvider = "."+mwf.site.cookie.domain.toLowerCase();
                    var contentProvider = "."+this.domain.toLowerCase();

                    _isSameOrigin = contentProvider.substring(contentProvider.length - serviceProvider.length, serviceProvider.length) == serviceProvider;

                }
            }

            return _isSameOrigin;

        };

        this.cookie = new function(){

            var cookies = document.cookie.split(';');

            this.exists = function(e){

                return this.value(e) !== false;

            };

            this.value = function(e){

                for(var i = 0; i < cookies.length; i++)
                    if(cookies[i].substr(0,cookies[i].indexOf("=")).replace(/^\s+|\s+$/g,"") == e)
                        return cookies[i].substr(cookies[i].indexOf("=")+1).replace(/^\s+|\s+$/g,"");

                return false;

            };

        };

    };

    // Deprecated

    this.domain=function(){
        return this.local.domain;
    };

    this.webroot=function(){
        return this.root;
    };

    this.frontpage=function(){
        return this.root+'/index.php';
    };

    this.webassetroot=function(){
        return this.asset.root;
    };
};
