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
 * @version 20111003
 *
 * @uses Config
 * @uses HTTPS
 * 
 * @uses document.URL
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/lib/https.class.php');

?>

var mwf=new function(){};

mwf.site=new function(){
    
this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_url')) : Config::get('global', 'site_url'); ?>';
    
    this.asset = new function(){
        
        this.root = '<?php echo HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_assets_url')) : Config::get('global', 'site_assets_url'); ?>';
        
    };
    
    this.cookie = new function(){
        
        this.prefix = '<?php echo Config::get('global', 'cookie_prefix'); ?>';
        
    };
    
    this.localStorage = new function(){
        this.prefix = '<?php echo Config::get('global', 'local_storage_prefix'); ?>';
    };
    
    this.analytics = new function(){
    
        this.key = <?php echo (Config::get('analytics', 'account') ? ('\''.Config::get('analytics', 'account').'\'') : 'null') ?>;
    
    };
    
    this.mobile = new function(){
    
        this.maxWidth = <?php echo (Config::get('mobile', 'max_width') ? Config::get('mobile', 'max_width') : 799) ?>;
        this.maxHeight = <?php echo (Config::get('mobile', 'max_height') ? Config::get('mobile', 'max_height') : 599) ?>;
    
    };
    
    this.domain=function(){
    
        var temppath = document.URL;
        
        if(temppath.search('http://') == 0)
            temppath = temppath.substring(7, temppath.length);
        else if(temppath.search('https://') == 0)
            temppath = temppath.substring(8, temppath.length);
            
        if(temppath.search('/') > -1)
            temppath = temppath.substring(0, temppath.search('/'));
            
        return temppath;
    };
    
    // Deprecated
    
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
