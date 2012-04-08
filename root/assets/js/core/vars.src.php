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

?>var mwf=new function(){};

mwf.site=new function(){

    this.root = <?php echo JS_Vars_Helper::get_site_url(); ?>;

    this.asset = new function(){

        this.root = <?php echo JS_Vars_Helper::get_site_asset_url(); ?>;

    };

    this.cookie = new function(){

        this.prefix = <?php echo JS_Vars_Helper::get_cookie_prefix(); ?>;

        this.domain = <?php echo  JS_Vars_Helper::get_cookie_domain(); ?>;

        this.exists = function(e){

            var cookies = <?php echo JS_Vars_Helper::get_existing_cookie_names(); ?>;

            for(var i=0; i<cookies.length; i++)
                if(cookies[i] == e) return true;

            return false;
        };

        this.override = <?php echo JS_Vars_Helper::get_cookie('override'); ?>;

        this.classification = <?php echo JS_Vars_Helper::get_cookie('classification'); ?>;

    };

    this.localStorage = new function(){
        this.prefix = <?php echo JS_Vars_Helper::get_localstorage_prefix(); ?>;
    };

    this.analytics = new function(){
    this.key = <?php echo JS_Vars_Helper::get_analytics_key(); ?>;
        this.pathKeys =  <?php echo JS_Vars_Helper::get_path_keys(); ?>;
    };

    this.mobile = new function(){
        this.maxWidth = <?php echo JS_Vars_Helper::get_mobile_max_width(); ?>;
        this.maxHeight = <?php echo JS_Vars_Helper::get_mobile_max_height(); ?>;
    };

    this.local = new function(){
    
        this.root = <?php echo JS_Vars_Helper::get_local_site_url(); ?>;
    
        this.asset = new function(){ 
        
            this.root = <?php echo JS_Vars_Helper::get_local_site_asset_url(); ?>;
            
        };

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
    
    this.redirect=function(target){
        window.location=target;
    };
    
    this.reload=function(){
        document.location.reload();
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
