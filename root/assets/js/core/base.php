<?php

/**
 * Defines mwf object and mwf.site, including variables derived from Config.
 * This file should be defined before any other JS scripts.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110826
 *
 * @uses Config
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');

?>

var mwf=new function(){};

mwf.site=new function(){
    
    this.root = '<?php echo Config::get('global', 'site_url'); ?>';
    
    this.asset = new function(){
        
        this.root = '<?php echo Config::get('global', 'site_assets_url'); ?>';
        
    }
    
    this.cookie = new function(){
        
        this.prefix = '<?php echo Config::get('global', 'cookie_prefix'); ?>';
        
    }
    
    this.analytics = new function(){
    
        this.key = <?php echo (Config::get('analytics', 'account') ? ('\''.Config::get('analytics', 'account').'\'') : 'null') ?>;
    
    }
    
    this.domain=function(){
        var temppath = document.URL;
        if(temppath.search('http://') == 0)
            temppath = temppath.substring(7, temppath.length);
        if(temppath.search('/') > -1)
            temppath = temppath.substring(0, temppath.search('/'));
        return temppath;
    }
    
    // Deprecated
    
    this.webroot=function(){
        return this.root;
    }
    
    this.frontpage=function(){
        return this.root()+'/index.php';
    }
    
    this.webassetroot=function(){
        return this.asset.root;
    }
};

document.write('<script type="text/javascript" src="<?php echo Config::get('global', 'site_assets_url'); ?>/redirect/js_unset_override.php"></scr'+'ipt>');

// Classification namespaces [deprecated]
mwf.desktop=new function(){};
mwf.standard=new function(){};
mwf.full=new function(){};
mwf.touch=mwf.standard;
mwf.webkit=mwf.full;
mwf.iphone=new function(){};

// Classification extension namespaces [deprecated]
mwf.ext=new function(){};
mwf.ext.desktop=new function(){};
mwf.ext.standard=new function(){};
mwf.ext.full=new function(){};
mwf.ext.touch=mwf.ext.standard;
mwf.ext.webkit=mwf.ext.full;
mwf.ext.iphone=new function(){};
