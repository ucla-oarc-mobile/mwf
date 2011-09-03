/**
 * Defines methods under mwf.browser related to the web browser and write the
 * height and width cookies that expose these values to User_Browser.
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
 * @requires /root/assets/js/core/vars.php
 */

mwf.browser = new function() {
    
    /**
     * Width of the web browser, or null if it cannot be determined.
     *
     * @return int|null
     */
    this.getWidth = function(){
        return window.innerWidth != null 
            ? window.innerWidth 
            : document.documentElement && document.documentElement.clientWidth 
                ? document.documentElement.clientWidth 
                : document.body != null 
                    ? document.body.clientWidth 
                    : null;
    }
    
    /**
     * Height of the web browser, or null if it cannot be determined.
     *
     * @return int|null
     */
    this.getHeight = function(){
        return  window.innerHeight != null
            ? window.innerHeight 
            : document.documentElement && document.documentElement.clientHeight 
                ?  document.documentElement.clientHeight 
                : document.body != null
                    ? document.body.clientHeight 
                    : null; 
    }
    
    /**
     * Offset from the left of page, or 0 if it cannot be determined.
     * 
     * @return int
     */
    this.posLeft = function(){
        
        return typeof window.pageXOffset != 'undefined' 
            ? window.pageXOffset 
            : document.documentElement && document.documentElement.scrollLeft 
                ? document.documentElement.scrollLeft 
                : document.body.scrollLeft 
                    ? document.body.scrollLeft 
                    : 0;
               
    }
    
    /**
     * Offset from the top of page, or 0 if it cannot be determined.
     * 
     * @return int
     */
    this.posTop = function(){
        return typeof window.pageYOffset != 'undefined' 
            ?  window.pageYOffset 
            : document.documentElement && document.documentElement.scrollTop 
                ? document.documentElement.scrollTop 
                : document.body.scrollTop 
                    ? document.body.scrollTop 
                    : 0;
    }
    
    /**
     * Distance across to the right edge of browser.
     * 
     * @return int
     */
    this.posRight = function(){
        return mwf.browser.posLeft() + mwf.browser.pageWidth();
    }
    
    /**
     * Distance across to the bottom edge of browser.
     * 
     * @return int
     */
    this.posBottom = function(){
        return mwf.browser.posTop() + mwf.browser.pageHeight();
    }
    
    /**
     * Width of the web browser, or null if it cannot be determined.
     *
     * @return int|null
     */
    this.pageWidth = this.getWidth;
    
    /**
     * Height of the web browser, or null if it cannot be determined.
     *
     * @deprecated 1.2.00
     * @return int|null
     */
    this.pageHeight = this.getHeight;
};

/**
 * Expose the browser height and width to the server.
 * 
 * @see /root/assets/lib/user_browser.class.php
 */
document.cookie=mwf.site.cookie.prefix+'bw='+mwf.browser.getWidth()+';path=/';
document.cookie=mwf.site.cookie.prefix+'bh='+mwf.browser.getHeight()+';path=/';