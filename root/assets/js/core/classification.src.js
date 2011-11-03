/**
 * Defines methods under mwf.classification that use device telemetry to 
 * classify a device as basic, standard and full.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111103
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.screen
 * @requires mwf.capability
 * 
 * @see /root/assets/js/core/override.js
 * @see /root/assets/js/core/server.js
 */

mwf.classification=new function(){
    
    /**
     * Name of the capabilities cookie that may be written to expose device
     * classification to the server.
     */
    this.cookieName = mwf.site.cookie.prefix+'classification';

    /**
     * Determine if the device is classified as mobile based on the size of
     * the screen.
     * 
     * @return bool
     */
    this.isMobile = function(){
        return mwf.site.mobile.maxHeight > mwf.screen.getHeight()
            && mwf.site.mobile.maxWidth  > mwf.screen.getWidth();
    }
    
    /**
     * Determine if the device is at least a basic-level device. All devices are
     * of the basic classification.
     * 
     * @return bool
     */ 
    this.isBasic = function(){
        return true;
    }
    
    /**
     * Determine if the device is at least a standard-level device. This 
     * requires that the device has support for DOM writing, AJAX, load event 
     * listener.
     * 
     * @return bool
     */
    this.isStandard = function(){
        return mwf.capability.cookie() && mwf.capability.write() && mwf.capability.events();
    }
    
    /**
     * Determine if the device is a full-level device. This requires that the 
     * device has support for all standard-level features, CSS 2.1 opacity and
     * CSS 3 gradients, border radius and box shadow.
     * 
     * @return bool
     */
    this.isFull = function(){
        return this.isStandard() && mwf.capability.ajax() && mwf.capability.css3();
    }
    
    /**
     * Determine if the device is overridden. This defaults to false in its
     * classification.js definition, though override.js may redefine it to
     * return true if an override is in progress as determined by mwf.override.
     *
     * @return bool
     */
    this.isOverride = function(){ 
        return false;
    }
    
    /**
     * Determine if the device is under preview mode, where preview mode is 
     * defined as a non-mobile device that is overridden as a mobile device.
     * 
     * @return bool
     */
    this.isPreview = function(){
        return this.isOverride() && !this.isMobile();
    }
    
    /**
     * Returns the string of the top-level classification related to the device.
     * 
     * @return string
     */
    this.get = function(){
        if(this.isFull())
            return 'full';
        else if(this.isStandard())
            return 'standard';
        else
            return 'basic';
    }
    
    /**
     * Generate JSON content passed into the cookie written by mwf.server.
     * 
     * @return string
     */
    this.generateCookieContent = function(){
        
        var cookie = '{';
        cookie += '"mobile":'+this.isMobile();
        cookie += ',"basic":'+this.isBasic();
        cookie += ',"standard":'+this.isStandard();
        cookie += ',"full":'+this.isFull();
        if(this.isOverride()){
            cookie += ',"actual":{';
            cookie += '"mobile":'+this.wasMobile();
            cookie += ',"basic":'+this.wasBasic();
            cookie += ',"standard":'+this.wasStandard();
            cookie += ',"full":'+this.wasFull();
            cookie += '}';
        }
        cookie += '}';
        return cookie;
    }
};
