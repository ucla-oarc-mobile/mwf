/**
 * Defines methods under mwf.screen for device screen dimensions.
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
 * @requires mwf.browser
 * @requires mwf.userAgent
 * 
 * @uses window.screen
 * @uses window.devicePixelRatio
 */

mwf.screen = new function() {
    
    this.cookieName = mwf.site.cookie.prefix+"screen";
    
    var ws = window.screen;
    
    /**
     * Bug in Android 2.2-3 prevents it from returning accurate screen 
     * dimensions, so bypass inaccurate values with false instead.
     * 
     * @compat Android 2.2-3
     */
    var version = mwf.userAgent.getOSVersion();
    if(typeof mwf.userAgent !== 'undefined' && mwf.userAgent.getOS() == 'android' && (version.indexOf('2.2') == 0 || version.indexOf('2.3') == 0)) {
        ws = {width:false,height:false}
    }
    
    /**
     * Determine device screen width.
     * 
     * @return int|bool
     */
    this.getWidth=function(){
        return typeof ws.width !== 'undefined'
            ? ws.width 
            : mwf.browser.getWidth(); 
    }
    
    /**
     * Determine device screen height.
     * 
     * @return int|bool
     */
    this.getHeight=function(){
        return typeof ws.height !== 'undefined'
            ? ws.height 
            : mwf.browser.getHeight();
    }
    
    /**
     * Determine device screen pixel ratio.
     * 
     * @return float
     */
    this.getPixelRatio=function(){
        return (typeof window.devicePixelRatio != 'undefined' && window.devicePixelRatio)
            ? window.devicePixelRatio
            : 1;
    }
    
    /**
     * Generate JSON content passed into the cookie written by mwf.server.
     * 
     * @return string
     */
    this.generateCookieContent = function(){
        
        return '{"h":"'+this.getHeight()+'","w":"'+this.getWidth()+'","r":"'+this.getPixelRatio()+'"}';
        
    }
}
