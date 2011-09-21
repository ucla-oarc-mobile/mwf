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
 * @version 20110921
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
     * Store reference as local variable as optimized for compression.
     * 
     * @var object
     */
    var classification = mwf.classification;
    
    /**
     * If no support for cookies, then set isOverride false, since override
     * requires a cookie, and then return early from this initialization.
     */
    if(!mwf.capability.cookie()){
        classification.isOverride = function(){return false;}
        return;
    }
    
    /**
     * Name of the override cookie, stored by reference as local variable as 
     * optimized for compression.
     * 
     * @var string
     */
    var cName = (this.cookieName = mwf.site.cookie.prefix+'override');
    
    /**
     * Return if the override cookie is equivalent to the override specified in
     * the query string.
     */
    var matchingCookie = false,
        cookies = document.cookie.split(';'),
        override = false;
    for(i=0; i < cookies.length && override == false; i++){
        x = (cookies[i].substr(0,cookies[i].indexOf("="))).replace(/^\s+|\s+$/g,"");
        if(x == cName){
            var pos = cookies[i].indexOf("=")+1;
            override = cookies[i].substr(pos, cookies[i].length-pos);
            classification.isOverride = function(){return true;}
            matchingCookie = cookies[i];
        }
    }
    
    /**
     * Match either the query string parameter override and designate this as 
     * the variable override for further processing. Otherwise, if there's not
     * a matching cookie already in existance for the override, return early
     * as no override of classification functions is necessary. In this latter
     * case, the wasX functions will be undefined.
     */
    var results = (new RegExp("[\\?&]override=([^&#]*)")).exec( window.location.href );
    if(results != null){
        override = results[1];
    }else if(!override){
        classification.isOverride = function(){return false;}
        return;
    }
    
    if(matchingCookie) {
        matchingCookie = matchingCookie.substr(matchingCookie.indexOf("=")+1) == override ? true : false;
    }
    
    /**
     * If the override variable determined from the query string is "no", then
     * the classification cookie should be expired, the override value cookie
     * should be expired, and the window location should be recomposed with
     * all of the query string except the override parameter,  
     */
    if(override == 'no'){
        document.cookie = mwf.classification.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
        document.cookie = cName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
        
        url = document.location.href;
        var urlparts= url.split('?');
        if (urlparts.length>=2)
        {
            var urlBase=urlparts.shift(), 
                queryString=urlparts.join("?"),
                prefix = 'override=',
                pars = queryString.split(/[&;]/g);
            for (var i= pars.length; i-->0;) 
              if (pars[i].lastIndexOf(prefix, 0)!==-1)
                  pars.splice(i, 1);
            window.location = urlBase+'?'+pars.join('&');
            return;
        }
    }
    
    /**
     * Store the old primitives for the mwf.classification.wasX methods.
     */
    var _full = classification.isFull(),
        _standard = classification.isStandard(),
        _basic = classification.isBasic(),
        _mobile = classification.isMobile();
    
    /**
     * Define a set of mwf.classification.wasX methods.
     */
    classification.wasFull = function(){return _full;}
    classification.wasStandard = function(){return _standard;}
    classification.wasBasic = function(){return _basic;}
    classification.wasMobile = function(){return _mobile;}
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades downward from full for true values.
     */
    switch(override){
        case 'full':
            classification.isFull = function(){return true;}
        case 'standard':
            classification.isStandard = function(){return true;}
        case 'basic':
            classification.isBasic = function(){return true;}
            classification.isMobile = function(){return true;}
    }
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades upward from basic for false values.
     */
    switch(override){
        case 'basic':
            classification.isStandard = function(){return false;}
        case 'standard':
            classification.isFull = function(){return false;}
    }
    
    /**
     * Define the mwf.classification.isOverride() method as true.
     */
    classification.isOverride = function(){return true;}
    
    /**
     * If there was a 
     */
    if(matchingCookie)
        return;
    
    /**
     * Expire the existing classification cookie. This will cause server.js
     * to redefine this cookie based on the modified mwf.classification methods.
     */
    document.cookie = classification.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT';
    
    /**
     * Define the override cookie.
     */
    document.cookie = cName+'='+override+';path=/';
    
};
