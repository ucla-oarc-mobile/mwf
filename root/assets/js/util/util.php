<?php

/**
 * Javascript file that defines the basic mwf object and libraries. This should
 * be included before any other JS scripts.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110331
 *
 * @uses Config
 */

include_once(dirname(dirname(dirname(__FILE__))).'/config.php');

/** Defines the file to be parsed as a Javascript file and sets a max cache life. */
if(!headers_sent()){
    header('Content-Type: text/javascript');
    header("Cache-Control: max-age=3600");
}

?>
var mwf=new function(){};

mwf.desktop=new function(){};
mwf.standard=new function(){};
mwf.full=new function(){};
mwf.touch=mwf.standard;
mwf.webkit=mwf.full;
mwf.iphone=new function(){};

mwf.ext=new function(){};
mwf.ext.desktop=new function(){};
mwf.ext.standard=new function(){};
mwf.ext.full=new function(){};
mwf.ext.touch=mwf.ext.standard;
mwf.ext.webkit=mwf.ext.full;
mwf.ext.iphone=new function(){};

mwf.util=new function(){
    this.importJS=function(jsFile){document.write('<script type="text/javascript" src="'+jsFile+'"></scr'+'ipt>');}
    this.importCSS=function(cssFile){document.write('<link rel="stylesheet" type="text/css" href="'+cssFile+'" media="screen">');}
};
mwf.site=new function(){
    this.webroot=function(){return '<?php echo Config::get('global', 'site_url'); ?>';}
    this.frontpage=function(){return '<?php echo Config::get('global', 'site_url'); ?>/index.php';}
    this.webassetroot=function(){return '<?php echo Config::get('global', 'site_assets_url'); ?>';}
    this.domain=function(){
        var temppath = document.URL;
        if(temppath.search('http://') == 0)
            temppath = temppath.substring(7, temppath.length);
        if(temppath.search('/') > -1)
            temppath = temppath.substring(0, temppath.search('/'));
        return temppath;
    }
};
document.write('<script type="text/javascript" src="<?php echo Config::get('global', 'site_assets_url'); ?>/redirect/js_unset_override.php"></scr'+'ipt>');