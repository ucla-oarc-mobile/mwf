/**
 * Defines methods under mwf.browser related to the web browser and provides
 * telemetry accessors. If not already in a cookie, these values are written
 * out as such by mwf.server.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111213
 *
 * @requires document
 * @requires mwf
 * @requires mwf.site
 * @requires window
 */

mwf.browser = new function() {
    
    this.cookieName = mwf.site.cookie.prefix+"browser";
    
    var w = window;
    var d = document;
    
    /**
     * Width of the web browser, or null if it cannot be determined.
     *
     * @return int|null
     */
    this.getWidth = function(){
        return w.innerWidth != null 
            ? w.innerWidth 
            : d.documentElement && d.documentElement.clientWidth 
                ? d.documentElement.clientWidth 
                : d.body != null 
                    ? d.body.clientWidth 
                    : null;
    }
    
    /**
     * Height of the web browser, or null if it cannot be determined.
     *
     * @return int|null
     */
    this.getHeight = function(){
        return  w.innerHeight != null
            ? w.innerHeight 
            : d.documentElement && d.documentElement.clientHeight 
                ?  d.documentElement.clientHeight 
                : d.body != null
                    ? d.body.clientHeight 
                    : null; 
    }
    
    /**
     * Offset from the left of page, or 0 if it cannot be determined.
     * 
     * @return int
     */
    this.posLeft = function(){
        
        return typeof w.pageXOffset != 'undefined' 
            ? w.pageXOffset 
            : d.documentElement && d.documentElement.scrollLeft 
                ? d.documentElement.scrollLeft 
                : d.body.scrollLeft 
                    ? d.body.scrollLeft 
                    : 0;
               
    }
    
    /**
     * Offset from the top of page, or 0 if it cannot be determined.
     * 
     * @return int
     */
    this.posTop = function(){
        return typeof w.pageYOffset != 'undefined' 
            ?  w.pageYOffset 
            : d.documentElement && d.documentElement.scrollTop 
                ? d.documentElement.scrollTop 
                : d.body.scrollTop 
                    ? d.body.scrollTop 
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
     * @deprecated 1.2.00
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
    
    /**
     * Return true if browser is running in quirks mode: IE, Moz, Saf, Chrome
     * use "BackCompat" to define quirks mode, while Op uses "QuirksMode".
     * 
     * @return bool
     */
    this.isQuirksMode = function(){
        return document.compatMode == 'BackCompat' || document.compatMode == 'QuirksMode';
    }
    
    /**
     * Return true if browser is running in standards mode.
     * 
     * @return bool
     */
    this.isStandardsMode = function(){
        return !this.isQuirksMode();
    }
    
    /**
     * Return string "standards" or "quirks" from mwf.browser.isQuirksMode().
     * 
     * @return "standards"|"quirks"
     */
    this.getMode = function(){
        return this.isQuirksMode() ? "quirks" : "standards";
    }
};
