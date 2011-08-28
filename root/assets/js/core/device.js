/**
 * mwf.device namespace contains functions related to device capabilities.
 * 
 * This implementation uses Modernizr.
 */
mwf.device=new function(){

    /**
     * Modernizr object reference that mwf.adapter leverages.
     */
    var _modernizr = Modernizr;
    
    this.cookieName = mwf.site.cookie.prefix+'caps';
    
    this.hasCookies = function(){
        var cookieEnabled = (navigator.cookieEnabled) ? true : false
        if (typeof navigator.cookieEnabled == 'undefined' && !cookieEnabled){ 
            document.cookie= 'mwf_test';
            cookieEnabled = (document.cookie.indexOf("mwf_test") != -1) ? true : false;
        }
        return cookieEnabled;
    }
    
    /**
     * Determine if device supports live DOM writes.
     *
     * Modernizr Adapter: Since Modernizr writes a series of classes to the
     * document.documentElement, check if the base class "js" exists.
     */
    this.hasWrite = function(){
        return (" " + document.documentElement.className + " ").replace(/[\n\t]/g, " ").indexOf(" js ") > -1
    }
    
    /**
     * Determine if device supports AJAX. This attempts to create an XHR object
     * of the standard type and ActiveXObject varieties and, if any succeed, then
     * it returns true.
     */
    this.hasAJAX = function(){
        var xhr = null;
        try { xhr = new XMLHttpRequest(); } catch (e) {}
        try { xhr = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
        try { xhr = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {}
        return xhr != null;
    }
    
    /**
     * Determine if device supports addEventListener.
     */
    this.hasEvents = function(){
        var el = document.createElement('div');
        var isSupported = (typeof document.addEventListener == 'function');
        el = null;
        return isSupported;
    }
    
    /**
     * Determine if device supports a particular event.
     *
     * This method is courtesy of: 
     * http://perfectionkills.com/detecting-event-support-without-browser-sniffing
     */
    this.hasEvent = function(eventName){
        if(!this.hasEvents())
            return false;
        var TAGNAMES = {
            'select':'input','change':'input',
            'submit':'form','reset':'form',
            'error':'img','load':'img','abort':'img',
            'DOMContentLoaded':'window'
        }
        var el = document.createElement(TAGNAMES[eventName] || 'div');
        eventName = 'on' + eventName;
        var isSupported = (eventName in el);
        if (!isSupported) {
            el.setAttribute(eventName, 'return;');
            isSupported = (typeof el[eventName] == 'function');
        }
        el = null;
        return isSupported;
    }
    
    /**
     * Determine if device supports touch events.
     *
     * Modernizr Adapter: Check the modernizr.touch property.
     */
    this.hasTouch = function(){
        return _modernizr.touch;
    }
    
    this.hasBorderRadius = function(){
        return _modernizr.borderradius;
    }
    
    this.hasBoxShadow = function(){
        return _modernizr.boxshadow;
    }
    
    this.hasGradients = function(){
        return _modernizr.cssgradients;
    }
    
    this.hasCSS3 = function(){
        return this.hasBorderRadius() && this.hasBoxShadow() && this.hasGradients();
    }
    
    this.isMobile = function(){
        return true; // TODO: Figure out how to determine if mobile
    }
    
    this.isBasic = function(){
        return true; // TODO: Figure out how to determine if basic
    }
    
    /**
     * Determine if the device is at least a standard-level device.
     *
     * This requires that the device has support for:
     *      - DOM writing
     *      - AJAX
     *      - Load Event Listener
     */
    this.isStandard = function(){
        return this.hasCookies() && this.hasWrite() && this.hasEvents();
    }
    
    /**
     * Determine if the device is a a full-level device.
     *
     * This requires that the device has support for:
     *      - All standard-level features
     *      - CSS 2.1 opacity
     *      - CSS 3 gradients, border radius and box shadow
     */
    this.isFull = function(){
        return this.isStandard() && this.hasAJAX() && this.hasCSS3();
    }
    
    this.getClassification = function(){
        if(this.isFull())
            return 'full';
        else if(this.isStandard())
            return 'standard';
        else
            return 'basic';
    }
};
