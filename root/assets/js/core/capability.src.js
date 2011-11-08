/**
 * Defines methods under mwf.capability that poll device capabilities.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111003
 *
 * @requires mwf
 * @requires mwf.site
 * @requires Modernizr
 * 
 * @uses ActiveXObject
 * @uses document.addEventListener
 * @uses document.cookie
 * @uses document.createElement
 * @uses document.documentElement
 * @uses document.write
 * @uses navigator.cookieEnabled
 * @uses XMLHttpRequest
 * 
 * @see /root/assets/js/core/capability.js
 */

mwf.capability=new function(){

    /**
     * Local reference to the Modernizr object.
     * 
     * @var object
     */
    var _m = Modernizr;
    
    /**
     * Name of the capabilities cookie that may be written to expose device
     * capabilities to the server.
     */
    this.cookieName = mwf.site.cookie.prefix+'capabilities';
    
    /**
     * Cached value for AJAX support once determined. If false, then it has not
     * yet been determined. If null, then AJAX is not supported. In all other 
     * cases, this will have been written by mwf.capability.ajax as either an
     * XMLHttpRequest or an ActiveXObject, thus indicating AJAX support.
     * 
     * @var false|null|XMLHttpRequest|ActiveXObject
     */
    var _ajax = false;
    
    /**
     * Determine if the device browser supports AJAX. This attempts to create an
     * XHR object of the standard type and ActiveXObject varieties and, if any 
     * succeed, then it returns true. This uses _ajax to cache the result.
     * 
     * @uses _ajax
     * @return bool
     */
    this.ajax = function(){
        if(_ajax === false){
            _ajax = null;
            try { _ajax = new XMLHttpRequest(); } catch (e) {}
            try { _ajax = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
            try { _ajax = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {}
        }
        return _ajax != null;
    }
    
    /**
     * Determine if the device browser supports application cache (offline web
     * application functionality).
     * 
     * @return bool
     */
    this.applicationcache = function(){
        return _m.applicationcache;
    }
    
    /**
     * Determine if the device browser supports HTML 5 audio tag.
     * 
     * @return bool
     */
    this.audio = function(){
        return !! _m.audio;
    }
    
    /**
     * Determine if the device browser supports HTML 5 canvas tag.
     * 
     * @return bool
     */
    this.canvas = function(){
        return _m.canvas;
    }
    
    /**
     * Cached value for if device browser supports cookies. This is null if it
     * is not yet known if cookies are supported, or a boolean if cookie support
     * has been determined.
     *
     * @var null|bool
     */
    var _cookie = null;
    
    /**
     * Determine if the device browser supports cookies.
     * 
     * @return bool
     */
    this.cookie = function(){
        if(_cookie === null){
            _cookie = (navigator.cookieEnabled && typeof document.cookie != 'undefined') ? true : false
            if (!_cookie){ 
                document.cookie= mwf.site.cookie.prefix+'test';
                _cookie = (document.cookie.indexOf(+mwf.site.cookie.prefix+'test') != -1) ? true : false;
            }
        }
        return _cookie;
    }
    
    /**
     * Methods that determine CSS support.
     */
    this.css = new function(){
    
        /**
         * Determine if the device browser supports border radius (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.borderradius = function(){
            return _m.borderradius
        }

        /**
         * Determine if the device browser supports box radius (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.boxshadow = function(){
            return _m.boxshadow
        }
    
        /**
         * Determine if the device browser supports CSS 3 @font-face.
         * 
         * @return bool
         */
        this.fontface = function(){
            return _m.fontface;
        }

        /**
         * Determine if the device browser supports gradients (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.gradients = function(){
            return _m.cssgradients
        }
    
        /**
         * Determine if the device browser supports transforms (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.transforms = function(){
            return _m.csstransforms && _m.csstransforms3d;
        }
    
        /**
         * Determine if the device browser supports 2D transforms (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.transforms2d = function(){
            return _m.csstransforms;
        }
    
        /**
         * Determine if the device browser supports 3D transforms (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.transforms3d = function(){
            return _m.csstransforms3d;
        }
        
        /**
         * Determine if the device browser supports transitions (including 
         * vendor prefixed versions).
         * 
         * @return bool
         */
        this.transitions = function(){
            return _m.csstransitions;
        }
    
        /**
         * Determine if the device browser supports a particular property.
         * 
         * @return bool
         */
        this.prop = function(prop){
            return _m.testProp(prop)
        }
    
    }
    
    /**
     * Determine if the device browser supports the simplest CSS 3 properties,
     * namely border radius, box shadow and gradients. This is a qualifier for
     * the mwf.classification.isFull() method.
     *
     * @return bool
     */
    this.css3 = function(){
        return this.css.borderradius() && this.css.boxshadow() && this.css.gradients()
    }
    
    /**
     * Determine if the device browser supports HTML 5 drag and drop.
     * 
     * @return bool
     */
    this.draganddrop = function(){
        return _m.draganddrop;
    }
    
    /**
     * Determine if the device browser supports events with .addEventListener().
     * 
     * @return bool
     */
    this.events = function(){
        var el = document.createElement('div');
        var isSupported = (typeof document.addEventListener == 'function');
        el = null;
        return isSupported;
    }
    
    /**
     * Determine if the device browser supports a particular event.
     * 
     * @return bool
     */
    this.event = function(eventName){
        return _m.hasEvent(eventName)
    }
    
    /**
     * Determine if the device browser supports HTML 5 flexible box model.
     * 
     * @return bool
     */
    this.flexbox = function(){
        return _m.flexbox;
    }
    
    /**
     * Determine if the device browser supports inline SVG.
     * 
     * @return bool
     */
    this.inlinesvg = function(){
        return _m.inlinesvg
    }
    
    /**
     * Determine if the device browser supports the DOM localStorage object and
     * associated local storage API.
     * 
     * @return bool
     */
    this.localstorage = function(){
        return _m.localstorage
    }
    
    /**
     * Determine if the device browser supports the DOM sessionStorage object
     * and associated session storage API.
     * 
     * @return bool
     */
    this.sessionstorage = function(){
        return _m.sessionstorage;
    }
    
    /**
     * Determine if the device browser supports SVG.
     * 
     * @return bool
     */
    this.svg = function(){
        return _m.svg
    }
    
    /**
     * Determine if device supports touch events.
     *
     * Modernizr Adapter: Check the modernizr.touch property.
     */
    this.touch = function(){
        return _m.touch
    }
    
    /**
     * Determine if the device browser supports HTML 5 video tag.
     * 
     * @return bool
     */
    this.video = function(){
        return !! _m.video;
    }
    
    /**
     * Determine if the device browser supports web sockets.
     * 
     * @return bool
     */
    this.websockets = function(){
        return _m.websockets;
    }
    
    /**
     * Determine if the device browser supports live writes to the DOM.
     * 
     * @return bool
     */
    this.write = function(){
        /**
         * Checks if Modernizr was able to write "js" class to DOM.
         */
        return (" " + document.documentElement.className + " ").replace(/[\n\t]/g, " ").indexOf(" js ") > -1
    }
};
