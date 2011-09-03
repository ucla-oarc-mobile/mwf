/**
 * Defines methods under mwf.override that process a query string specifying
 * override with a classification qualifier to mutate the mwf.classification 
 * object and change the cookie values passed to the server related to device 
 * classification.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110902
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.capability
 * @requires mwf.classification
 * 
 * @requires /root/assets/js/core/vars.php
 * @requires /root/assets/js/core/screen.js
 * @requires /root/assets/js/core/capability.js
 * @requires /root/assets/js/core/classification.js
 * 
 * @see /root/assets/js/core/server.js
 */

mwf.override = new function(){
    
    /**
     * If no support for cookies, then set isOverride false, since override
     * requires a cookie, and then return early from this initialization.
     */
    if(!mwf.capability.cookie()){
        mwf.classification.isOverride = function(){ return false; }
        return;
    }
    
    /**
     * Name of the override cookie.
     *
     * @var string
     */
    this.cookieName = mwf.site.cookie.prefix+'override';
    
    /**
     * Match either the query string parameter override and designate this as 
     * the variable override for further processing.
     */
    var regexS = "[\\?&]override=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if(results == null){
        mwf.classification.isOverride = function(){ return false; }
        return;
    }
    var override = results[1];
    
    /**
     * If the override variable determined from the query string is "no", then
     * the classification cookie should be expired, the override value cookie
     * should be expired, and the window location should be recomposed with
     * all of the query string except the override parameter,  
     */
    if(override == 'no'){
        document.cookie = mwf.classification.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
        document.cookie = this.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
        
        url = document.location.href;
        var urlparts= url.split('?');
        if (urlparts.length>=2)
        {
            var urlBase=urlparts.shift(); 
            var queryString=urlparts.join("?");

            var prefix = 'override=';
            var pars = queryString.split(/[&;]/g);
            for (var i= pars.length; i-->0;) 
              if (pars[i].lastIndexOf(prefix, 0)!==-1)
                  pars.splice(i, 1);
            window.location = urlBase+'?'+pars.join('&');
            return;
        }
    }
    
    /**
     * Return if the override cookie is equivalent to the override specified in
     * the query string.
     */
    var cookies = document.cookie.split(';');
    for(i=0; i < cookies.length; i++){
        x = cookies[i].substr(0,cookies[i].indexOf("="));
        x = x.replace(/^\s+|\s+$/g,"");
        if(x == this.cookieName){
            var pos = cookies[i].indexOf("=")+1;
            if(override == cookies[i].substr(pos, cookies[i].length-pos)){
                return;
            }
        }
    }
    
    /**
     * Store the old primitives for the mwf.classification.wasX methods.
     */
    var _full = mwf.classification.isFull();
    var _standard = mwf.classification.isStandard();
    var _basic = mwf.classification.isBasic();
    var _mobile = mwf.classification.isMobile();
    
    /**
     * Define a set of mwf.classification.wasX methods.
     */
    mwf.classification.wasFull = function(){ return _full; }
    mwf.classification.wasStandard = function(){ return _standard; }
    mwf.classification.wasBasic = function(){ return _basic; }
    mwf.classification.wasMobile = function(){ return _mobile; }
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades downward from full for true values.
     */
    switch(override){
        case 'full':
            mwf.classification.isFull = function(){ return true; }
        case 'standard':
            mwf.classification.isStandard = function(){ return true; }
        case 'basic':
            mwf.classification.isBasic = function(){ return true; }
            mwf.classification.isMobile = function(){ return true; }
    }
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades upward from basic for false values.
     */
    switch(override){
        case 'basic':
            mwf.classification.isStandard = function(){ return false; }
        case 'standard':
            mwf.classification.isFull = function(){ return false; }
    }
    
    /**
     * Define the mwf.classification.isOverride() method as true.
     */
    mwf.classification.isOverride = function(){ return true; }
    
    /**
     * Expire the existing classification cookie. This will cause server.js
     * to redefine this cookie based on the modified mwf.classification methods.
     */
    document.cookie = mwf.classification.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
    
    /**
     * Define the override cookie.
     */
    document.cookie = this.cookieName+'='+override+';path=/';
    
};
