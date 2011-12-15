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
 * @version 20111213
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.capability
 * @requires mwf.classification
 * 
 * @uses document.cookie
 * @uses RegExp
 * @uses window.location
 * 
 * @see /root/assets/js/core/capability.js
 * @see /root/assets/js/core/server.js
 */

mwf.override = new function(){
    
    this.cookieName = mwf.site.cookie.prefix+'override';
    
    this.isRedirecting = false;
    
    /**
     * Store reference as local variable as optimized for compression.
     */
    var classification = mwf.classification;
    
    var currentOverride = mwf.site.cookie.override;
    
    var requestedOverride = (new RegExp("[\\?&]override=([^&#]*)")).exec( window.location.href );
    
    /**
     * If a match, extract the value.
     */
    if(requestedOverride != null) {
        requestedOverride = requestedOverride[1];
    }
    
    if(requestedOverride && requestedOverride != currentOverride) {
        
        
        /**
         * If no support for cookies, then set isOverride false, since override
         * requires a cookie, and then return early from this initialization.
         */
        if(!mwf.capability.cookie()) {
            
            classification.isOverride = function(){ return false; }
            return false;
            
        }
        
        /**
         * Requested override must be a valid request for the device.
         */
        if(requestedOverride == 'full' && classification.isFull()
            || requestedOverride == 'standard' && classification.isStandard()
            || requestedOverride == 'basic' || requestedOverride == 'no'){
            
            /**
             * Determine the returnLocation on the content provider, removing
             * the override parameter.
             */
            var returnLocation = document.location.href,
                urlparts= returnLocation.split('?');

            if (urlparts.length>=2)
            {
                var urlBase=urlparts.shift(), 
                    queryString=urlparts.join("?"),
                    prefix = 'override=',
                    pars = queryString.split(/[&;]/g);
                for (var i= pars.length; i-->0;) 
                  if (pars[i].lastIndexOf(prefix, 0)!==-1)
                      pars.splice(i, 1);
                returnLocation = urlBase+'?'+pars.join('&');
            }
            
            /**
             * Set the override cookie and refresh.
             */
            if(mwf.site.local.isSameOrigin()) {
                
                if(requestedOverride == 'no') {
                    
                    document.cookie = this.cookieName+'=;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT;';
                    document.cookie = mwf.classification.cookieName+'=0;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT;';
                    
                }else{
                    
                    document.cookie = this.cookieName+'='+requestedOverride+';path=/;';
                    document.cookie = mwf.classification.cookieName+'=0;path=/;expires=Thu, 01-Jan-1970 00:00:01 GMT;';
                    
                }
                
                /**
                 * Force server to redefine all cookies.
                 */
                mwf.site.cookie.exists = function(){ return false; }
                currentOverride = requestedOverride;
                window.location = returnLocation;
            
            /**
             * Redirect to the service provider.
             */
            } else {
                
                window.location = mwf.site.asset.root+'/passthru.php?override='+requestedOverride+'&return='+encodeURIComponent(returnLocation)+'&mode='+mwf.browser.getMode();
                
            }
            
            /**
             * Mark this as redirecting so that mwf.server does not rewrite 
             * window.location as well.
             */
            this.isRedirecting = true;
            
            /**
             * Early exit since this is going to redirect.
             */
            return;
            
        }
        
    }
    
    /**
     * If no current override, then set mwf.classification.isOverride() to a 
     * false response and exit early - no need to define the wasX methods.
     */
    if(!currentOverride) {
    
        classification.isOverride = function(){return false;};
        return;
        
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
    classification.wasFull = function(){return _full;};
    classification.wasStandard = function(){return _standard;};
    classification.wasBasic = function(){return _basic;};
    classification.wasMobile = function(){return _mobile;};
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades downward from full for true values.
     */
    switch(currentOverride){
        case 'full':
            classification.isFull = function(){return true;};
        case 'standard':
            classification.isStandard = function(){return true;};
        case 'basic':
            classification.isBasic = function(){return true;};
    }
    
    /**
     * Redefine the mwf.classification.isX methods based on override. This set
     * cascades upward from basic for false values.
     */
    switch(currentOverride){
        case 'basic':
            classification.isStandard = function(){return false;};
        case 'standard':
            classification.isFull = function(){return false;};
    }
    
    /**
     * Override prototype such that isOverride() returns true.
     */
    classification.isOverride = function(){return true;};
};
