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
 * @version 20110921
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
    
    if(!mwf.capability.cookie())
        return;
    
    var i, cookies = document.cookie.split(';');
    
    /**
     * Anonymous routine for the classification cookie that will return 
     * true if it needs a page reload to pass the cookie to server.
     */
    var reload = (function(){

        var classification = mwf.classification;

        /**
         * Exit routine early with false if matching classification cookie.
         */
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == classification.cookieName)
                return false;
        }

        /**
         * If cookie is not set, set the cookie and reload the page.
         */
        var cookie = classification.cookieName+'={';
        cookie += '"mobile":'+classification.isMobile();
        cookie += ',"basic":'+classification.isBasic();
        cookie += ',"standard":'+classification.isStandard();
        cookie += ',"full":'+classification.isFull();
        if(classification.isOverride()){
            cookie += ',"actual":{';
            cookie += '"mobile":'+classification.wasMobile();
            cookie += ',"basic":'+classification.wasBasic();
            cookie += ',"standard":'+classification.wasStandard();
            cookie += ',"full":'+classification.wasFull();
            cookie += '}';
        }
        cookie += '};path=/';
        document.cookie = cookie;
        
        /**
         * Return true for reload request if cookie has been written.
         */
        return document.cookie.indexOf(classification.cookieName) != -1;

    })();
            
    /**
     * Anonymous routine for the classification cookie that will return 
     * true if it needs a page reload to pass the cookie to server.
     */
     reload = (function(){
         
        var userAgent = mwf.userAgent;

        /**
         * Exit routine early with false if matching classification cookie.
         */
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == userAgent.cookieName)
                return false;
        }

        /**
         * If cookie is not set, set the cookie and reload the page.
         */
        var t;
        var cookie = userAgent.cookieName+'={';
        cookie += '"s":"'+navigator.userAgent.replace(/\;/g, '\\x3B').replace(/\,/g, '\\x2C')+'"';
        if(t = userAgent.getOS())
            cookie += ',"os":"'+t+'"';
        if(t = userAgent.getOSVersion())
            cookie += ',"osv":"'+t+'"';
        if(t = userAgent.getBrowser())
            cookie += ',"b":"'+t+'"';
        if(t = userAgent.getBrowserEngine())
            cookie += ',"be":"'+t+'"';
        if(t = userAgent.getBrowserEngineVersion())
            cookie += ',"bev":"'+t+'"';
        cookie += '};path=/';
        document.cookie = cookie;
        
        /**
         * Return true for reload request if cookie has been written.
         */
        return document.cookie.indexOf(userAgent.cookieName) != -1;

    })() || reload;
            
    /**
     * Anonymous routine for the browser dimensions cookie that will return 
     * true if it needs a page reload to pass the cookie to server.
     */
     reload = (function(){

        var browser = mwf.browser,
            cookieContents = browser.cookieName+'={"h":"'+browser.getHeight()+'","w":"'+browser.getWidth()+'"}';

        /**
         * Exit routine early with false if matching classification cookie.
         */
        for(i=0; i < cookies.length; i++){
            if(cookies[i].replace(/^\s+|\s+$/g,"") == cookieContents)
                return false;
        }
        
        document.cookie = cookieContents+';path=/';
        
        /**
         * Return true for reload request if cookie has been written.
         */
        return document.cookie.indexOf(browser.cookieName) != -1;

    })() || reload;
        
    /**
     * Reload the page if needed.
     */
    if(reload)
        document.location.reload();
     
})();
