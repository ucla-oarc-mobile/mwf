/**
 * A anonymous encapsulated routine that will set a cookie with classification
 * information, if it is not already defined, using mwf.classification methods,
 * and a cookie with user agent data, if it not already defined, using 
 * mwf.userAgent methods.
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
 * @requires mwf.capability
 * @requires mwf.classification
 * @requires mwf.userAgent
 * 
 * @requires /root/assets/js/core/vars.php
 * @requires /root/assets/js/core/capability.js
 * @requires /root/assets/js/core/classification.js
 * @requires /root/assets/js/core/userAgent.js
 */

(function(){

    /**
     * If the device does not support cookies, then exit the routine early.
     */
    if(!mwf.capability.cookie())
        return false;
    
    /**
     * If set true later, then the window will be reloaded at end of routine.
     */
    var reload = false;
    
    /**
     * Anonymous routine for the classification cookie that will return true
     * if it needs a page reload to pass the cookie to server.
     */
    reload = (function(){

        /**
         * Exit routine early with false if matching classification cookie.
         */
        var i, cookies = document.cookie.split(';');
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == mwf.classification.cookieName)
                return false;
        }

        /**
         * If cookie is not set, set the cookie and reload the page.
         */
        var cookie = mwf.classification.cookieName+'={';
        cookie += '"mobile":'+mwf.classification.isMobile();
        cookie += ',"basic":'+mwf.classification.isBasic();
        cookie += ',"standard":'+mwf.classification.isStandard();
        cookie += ',"full":'+mwf.classification.isFull();
        if(mwf.classification.isOverride()){
            cookie += ',"actual":{';
            cookie += '"mobile":'+mwf.classification.wasMobile();
            cookie += ',"basic":'+mwf.classification.wasBasic();
            cookie += ',"standard":'+mwf.classification.wasStandard();
            cookie += ',"full":'+mwf.classification.wasFull();
            cookie += '}';
        }
        cookie += '};path=/';
        document.cookie = cookie;
        return true;

    })() || reload;
    
    /**
     * Anonymous routine for the classification cookie that will return true
     * if it needs a page reload to pass the cookie to server.
     */
    reload = (function(){
        
        /**
         * Exit routine early with false if matching classification cookie.
         */
        var i, cookies = document.cookie.split(';');
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == mwf.userAgent.cookieName)
                return false;
        }

        /**
         * If cookie is not set, set the cookie and reload the page.
         */
        var t;
        var cookie = mwf.userAgent.cookieName+'={';
        cookie += '"s":"'+navigator.userAgent.replace(/\;/g, '\\x3B').replace(/\,/g, '\\x2C')+'"';
        if(t = mwf.userAgent.getOS())
            cookie += ',"os":"'+t+'"';
        if(t = mwf.userAgent.getOSVersion())
            cookie += ',"osv":"'+t+'"';
        if(t = mwf.userAgent.getBrowser())
            cookie += ',"b":"'+t+'"';
        if(t = mwf.userAgent.getBrowserEngine())
            cookie += ',"be":"'+t+'"';
        cookie += '};path=/';
        document.cookie = cookie;
        return true;

    })() || reload;

    /**
     * Reload the page if any new cookies were set, passing data back to server.
     */
    if(reload)
        document.location.reload();
     
})();
