mwf.capability=new function(){

    /**
     * Modernizr object reference that mwf.adapter leverages.
     */
    var _m = Modernizr;
    
    this.cookieName = mwf.site.cookie.prefix+'capabilities';
    
    /**
     * Determine if device supports AJAX. This attempts to create an XHR object
     * of the standard type and ActiveXObject varieties and, if any succeed, then
     * it returns true.
     */
    this.ajax = function(){
        var xhr = null;
        try { xhr = new XMLHttpRequest(); } catch (e) {}
        try { xhr = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) {}
        try { xhr = new ActiveXObject("Msxml2.XMLHTTP"); } catch (e) {}
        return xhr != null;
    }
    
    this.applicationcache = function(){
        return _m.applicationcache;
    }
    
    this.audio = function(){
        return _m.audio;
    }
    
    this.canvas = function(){
        return _m.canvas;
    }
    
    this.cookie = function(){
        var cookieEnabled = (navigator.cookieEnabled) ? true : false
        if (typeof navigator.cookieEnabled == 'undefined' && !cookieEnabled){ 
            document.cookie= 'mwf_test';
            cookieEnabled = (document.cookie.indexOf("mwf_test") != -1) ? true : false;
        }
        return cookieEnabled;
    }
    
    this.css = new function(){
    
        this.borderradius = function(){
            return _m.borderradius
        }

        this.boxshadow = function(){
            return _m.boxshadow
        }

        this.gradients = function(){
            return _m.cssgradients
        }
    
        this.transforms = function(){
            return _m.csstransforms && _m.csstransforms3d;
        }
    
        this.transforms2d = function(){
            return _m.csstransforms;
        }
    
        this.transforms3d = function(){
            return _m.csstransforms3d;
        }
        
        this.transitions = function(){
            return _m.csstransitions;
        }
    
        this.prop = function(prop){
            return _m.testProp(prop)
        }
    
    }
    
    this.css3 = function(){
        return this.css.borderradius() && this.css.boxshadow() && this.css.gradients()
    }
    
    this.draganddrop = function(){
        return _m.draganddrop;
    }
    
    /**
     * Determine if device supports addEventListener.
     */
    this.events = function(){
        var el = document.createElement('div');
        var isSupported = (typeof document.addEventListener == 'function');
        el = null;
        return isSupported;
    }
    
    /**
     * Determine if device supports a particular event.
     */
    this.event = function(eventName){
        return _m.hasEvent(eventName)
    }
    
    this.flexbox = function(){
        return _m.flexbox;
    }
    
    this.fontface = function(){
        return _m.fontface;
    }
    
    this.inlinesvg = function(){
        return _m.inlinesvg
    }
    
    this.localstorage = function(){
        return _m.localstorage
    }
    
    this.sessionstorage = function(){
        return _m.sessionstorage;
    }
    
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
    
    this.video = function(){
        return _m.video;
    }
    
    this.webgl = function(){
        return _m.webgl;
    }
    
    this.websockets = function(){
        return _m.websockets;
    }
    
    /**
     * Determine if device supports live DOM writes.
     *
     * Modernizr Adapter: Since Modernizr writes a series of classes to the
     * document.documentElement, check if the base class "js" exists.
     */
    this.write = function(){
        return (" " + document.documentElement.className + " ").replace(/[\n\t]/g, " ").indexOf(" js ") > -1
    }
};
