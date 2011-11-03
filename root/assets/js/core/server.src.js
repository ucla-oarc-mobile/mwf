/**
 * 
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.capability
 * @requires mwf.classification
 * @requires mwf.userAgent
 * 
 * @requires /root/assets/js/core/vars.php
 * @requires /root/assets/js/core/capability.js
 * @requires /root/assets/js/core/classification.js
 * @requires /root/assets/js/core/userAgent.js
 */

mwf.server = new function(){
    
    this.cookieNameLocal = mwf.site.cookie.prefix+'server';
    this.mustRedirect = false;
    this.mustReload = false;
    
    var site = mwf.site,
        classification = mwf.classification,
        userAgent = mwf.userAgent,
        screen = mwf.screen;
    
    this.init = function(){
        
        /**
         * Initialization requires cookies to store data - else simply exit.
         */
        
        if(!mwf.capability.cookie())
            return;
        
        
        /**
         * Set classification cookie if it doesn't already exist on server.
         */
        
        if(!site.cookie.exists(classification.cookieName))
            this.setCookie(classification.cookieName, classification.generateCookieContent());
        
        /**
         * Set user agent cookie if it doesn't already exist on server.
         */
        
        if(!site.cookie.exists(userAgent.cookieName))
            this.setCookie(userAgent.cookieName, userAgent.generateCookieContent());
        
        /**
         * Set screen cookie if it doesn't already exist on server.
         */
        
        if(!site.cookie.exists(screen.cookieName))
            this.setCookie(screen.cookieName, screen.generateCookieContent());
        
        /**
         * If the service provider doesn't have cookies, either (1) reload
         * the page if framework is of same-origin or device browser supports 
         * third-party cookies, or (2) redirect to the SP redirector. If the
         * service provider already has cookies, then this isn't necessary.
         */
        
        if(this.mustReload){
            
            document.location.reload();
            
        }else if(this.mustRedirect){
            
            window.location = site.asset.root+'/passthru.php?return='+encodeURIComponent(window.location);
            
        }else{
            
            // do nothing!
            
        }
        
    }
    
    this.setCookie = function(cookieName, cookieContent) {
    
        /**
         * Function to generate a cookie on the service provider, specifying a
         * domain if this is a cross
         */
        
        var cookieSuffix = ';path=/';
        
        var isCrossDomain = (function(){

                /**
                 * No support for cross-domain framework without SP cookie domain.
                 */
                if(!site.cookie.domain)
                    return false;

                var serviceProvider = "."+site.cookie.domain.toLowerCase();
                var contentProvider = "."+site.local.domain.toLowerCase();

                return contentProvider.substring(contentProvider.length - serviceProvider.length, serviceProvider.length) != serviceProvider;

            })();
        
        var isFirstLoad = !site.local.cookie.exists(this.cookieNameLocal);
        
        /**
         *
         *
         * @todo determine other operating systems that prevent third-party
         */
        
        var isThirdPartySupported = (function(){

                return userAgent.getBrowser() != 'safari' && userAgent.getBrowser() != 'firefox';

            })();
            
        /**
         * If not cross-domain or this is the first load and third party is
         * supported, then attempt to write the cookie to the SP directly.
         */
        
        if(!isCrossDomain || isFirstLoad && isThirdPartySupported){
            
            if(isFirstLoad){
                document.cookie = this.cookieNameLocal + '=1;path=/';
            }
        
            /**
             * Error condition will be encountered where domain isn't set if
             * we're cross-domain but the mwf.site.cookie.domain config
             * variable is not set.
             */
            if(isCrossDomain && site.cookie.domain) {
                cookieSuffix += ';domain='+site.cookie.domain;
            }
            
            /**
             * Write the cookie with the proper suffix for service provider.
             */
            document.cookie = cookieName + "=" + cookieContent+cookieSuffix;
            
            /**
             * Must reload the page to propagate the cookie to SP.
             */
            this.mustReload = true;
            
        /**
         * If third-party cookies aren't supported and this is cross domain,
         * then redirect through the SP and then back to CP.
         */    
        
        } else {
            
            this.mustRedirect = true;
            
        }
        
    }
    
}

mwf.server.init();
