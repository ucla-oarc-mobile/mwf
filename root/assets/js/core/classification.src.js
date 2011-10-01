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
 * @version 20110906
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.screen
 * @requires mwf.capability
 * 
 * @requires /root/assets/js/core/vars.php
 * @requires /root/assets/js/core/screen.js
 * @requires /root/assets/js/core/capability.js
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
    
    this.isBasic = function(){
        return true; // TODO: Figure out how to determine if basic
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
     * Determine if the device is a a full-level device. This requires that the 
     * device has support for all standard-level features, CSS 2.1 opacity and
     * CSS 3 gradients, border radius and box shadow.
     * 
     * @return bool
     */
    this.isFull = function(){
        return this.isStandard() && mwf.capability.ajax() && mwf.capability.css3();
    }
    
    /**
     * Determine if the device is under preview mode, where preview mode is 
     * defined as a non-mobile device that is overridden as a mobile device.
     * 
     * @return bool
     */
    this.isPreview = function(){
        return (typeof this.isOverride() == 'function') && this.isOverride() && !this.isMobile();
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
};
