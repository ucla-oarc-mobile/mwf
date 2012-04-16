/**
 * Responsible for writing classification, user agent and screen cookies back
 * to the server and refreshing the page to propagate this if done as such.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120415
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.capability
 * @requires mwf.classification
 * @requires mwf.userAgent
 * @requires mwf.screen
 * 
 * @requires /root/assets/js/core/vars.php
 * @requires /root/assets/js/core/capability.js
 * @requires /root/assets/js/core/classification.js
 * @requires /root/assets/js/core/userAgent.js
 * @requires /root/assets/js/core/screen.js
 */

mwf.server = new function(){

    /**
     * Local variables to minimize payload size in compression.
     */
    
    var site = mwf.site,
    classification = mwf.classification,
    userAgent = mwf.userAgent,
    screen = mwf.screen,
    mustRedirect = false,
    mustReload = false;
    
    var setCookie = function(cookieName, cookieContent) {
    
        /**
         * Function to generate a cookie on the service provider, specifying a
         * domain if this is a cross
         */
        
        var isSameOrigin = site.local.isSameOrigin();
            
        /**
         * If not cross-domain or this is the first load and third party is
         * supported, then attempt to write the cookie to the SP directly.
         */
        
        if(isSameOrigin){
            
            /**
             * Write the cookie with the proper suffix for service provider.
             */
            
            document.cookie = cookieName + '=' + encodeURIComponent(cookieContent)+';path=/';
            
            /**
             * Must reload the page to propagate the cookie to SP.
             */
            
            mustReload = true;
            
        /**
         * If third-party cookies aren't supported and this is cross domain,
         * then redirect through the SP and then back to CP.
         */  
        
        } else {
            
            mustRedirect = true;
            
        }
        
    }
    
    this.init = function(){
        
        /**
         * Initialization requires cookies to store data - else simply exit.
         */
        
        if(!mwf.capability.cookie())
            return;
        
        /**
         * Exit in the event that no_server_init is set as a query string
         * parameter. This helps to ensure that an infinite loop will not occur 
         * as the framework adds this parameter to the query string on
         * redirect back to the originator.
         */
        if (/^(\?|.*&)no_server_init([\=\&].*)?$/.test(window.location.search)) {
            return;
        }
        
        var classificationCookie = classification.generateCookieContent();
        
        /**
         * Set classification cookie if it doesn't already exist on server.
         * Set it if classification has changed (e.g., user turns on or off
         *    something in their settings).
         */
        
        if(!site.cookie.exists(classification.cookieName) || site.cookie.classification != classificationCookie)
            setCookie(classification.cookieName, classificationCookie);
        
        /**
         * Set user agent cookie if it doesn't already exist on server.
         */
        
        if(!site.cookie.exists(userAgent.cookieName))
            setCookie(userAgent.cookieName, userAgent.generateCookieContent());
        
        /**
         * Set screen cookie if it doesn't already exist on server.
         */
        
        if(!site.cookie.exists(screen.cookieName))
            setCookie(screen.cookieName, screen.generateCookieContent());

        /**
         * If the service provider doesn't have cookies, either (1) reload
         * the page if framework is of same-origin or device browser supports 
         * third-party cookies, or (2) redirect to the SP redirector. If the
         * service provider already has cookies, then this isn't necessary.
         */
        
        if(mustReload && !mwf.override.isRedirecting){
            var loc = window.location.href;
            if(loc.indexOf('?') == -1) loc += "?";
            if(loc.indexOf('?') < loc.length-1) loc += "&";
            loc += "no_server_init";
            site.redirect(loc);
        }else if(mustRedirect && !mwf.override.isRedirecting){
            site.redirect(site.asset.root+'/passthru.php?return='+encodeURIComponent(window.location)+'&mode='+mwf.browser.getMode());
        }
        
    }
}

mwf.server.init();
