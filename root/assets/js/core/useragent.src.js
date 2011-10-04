/**
 * Defines methods under mwf.userAgent that use the browser's user agent to 
 * provide information about the operating system, browser and browser engine.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111003
 * 
 * @requires mwf.site
 * @requires mwf.classification
 * 
 * @uses document.addEventListener
 * @uses document.body
 * @uses nagivator.userAgent
 * @uses window.attachEvent
 */

mwf.userAgent = new function() {
    
    /**
     * Name of the user agent cookie that may be written to expose UA-based
     * telemetry to the server.
     */
    this.cookieName = mwf.site.cookie.prefix+'user_agent';
    
    var userAgent = navigator.userAgent.toLowerCase();
    
    var userAgentSubstringExists = function(s){
        return userAgent.indexOf(s) != -1;
    }
    
    /**
     * Determines the operating system from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getOS = function(){ 
        if(userAgent.match(/(iphone)|(ipad)|(ipod)/) != null) 
            return 'iphone_os';
        
        var i = 0,
            osToTest = ['android','blackberry','windows phone os','windows mobile',
                        'symbian','webos','mac os x','windows nt','linux'];
                    
        for(;i<osToTest.length;i++)
            if(userAgentSubstringExists(osToTest[i]))
                return osToTest[i];
        
        return '';
    }
    
    /**
     * Determines the operating system version from string or else returns 
     * an empty string.
     *
     * @return string
     */
    this.getOSVersion = function(){ 
        var ua = userAgent, s, r='';
        switch(this.getOS())
        {
            case 'iphone_os':
                s = ua.indexOf('iphone os')+10;
                r = ua.substring(s, ua.indexOf(' ', s));
            case 'blackberry':
                if(ua.substring(0, 10) == 'blackberry'){
                    s = ua.indexOf('/')+1;
                    r = ua.substring(s, ua.indexOf(' ', s));
                }
                break;
            case 'android':
                if((s = ua.indexOf('android ')) != -1){
                    s += 8;
                    r = ua.substring(s, Math.min(ua.indexOf(' ', s), ua.indexOf(';', s), ua.indexOf('-', s)));
                }
                break;
            case 'windows_phone':
                if((s = ua.indexOf('windows phone os ')) != -1){
                    s += 17;
                    r = ua.substring(s, ua.indexOf(';', s));
                }
                break;
            case 'windows_mobile':
                if((s = ua.indexOf('windows mobile/')) != -1){
                    s += 15;
                    r = ua.substring(s, ua.indexOf(';', s));
                }
                break;
            case 'symbian':
                if((s = ua.indexOf('symbianos/')) != -1){
                    s += 10;
                    r = ua.substring(s, ua.indexOf(';', s));
                }
                else if((s = ua.indexOf('symbian/')) != -1){
                    s += 8;
                    r = "s"+ua.substring(s, ua.indexOf(';', s));
                }
                break;
            case 'webos':
                if((s = ua.indexOf('webos/')) != -1){
                    s += 6;
                    r = ua.substring(s, Math.min(ua.indexOf(';', s)));
                }
                break;
        }
        return r.replace(/\_/g,".");
    }
    
    /**
     * Determines the web browser from string or else returns an empty string.
     *
     * @return string
     */
    this.getBrowser = function(){
        
        if(userAgentSubstringExists('safari'))
            return this.getOS() == 'android' ? 'android_webkit' : 'safari';

        var i = 0,
            browsersToTest = ['chrome','iemobile','camino','seamonkey','firefox','opera_mobi','opera_mini'];
            
        for(;i<browsersToTest.length;i++)
            if(userAgentSubstringExists(browsersToTest[i]))
                return browsersToTest[i];
        
        return '';
    }
    
    /**
     * Determines the web browser engine from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getBrowserEngine = function(){
        
        if(userAgentSubstringExists('applewebkit')) 
            return 'webkit';
        
        var i = 0,
            browserEnginesToTest = ['trident','gecko','presto','khtml'];
            
        for(;i<browserEnginesToTest.length;i++)
            if(userAgentSubstringExists(browserEnginesToTest[i])) 
                return browserEnginesToTest[i];
    }
    
    /**
     * Determines the web browser engine version from string or else returns an 
     * empty string.
     *
     * @todo
     * @return string
     */
    this.getBrowserEngineVersion = function(){
        var ua = userAgent, s;
        var userAgentAfterPatternToSpace = function(p){
            var s = ua.indexOf(p)+p.length;
            return ua.substring(s, ua.indexOf(' ',s));
        }
        switch(this.getBrowserEngine())
        {
            case 'webkit':
                return userAgentAfterPatternToSpace('applewebkit/');
            case 'trident':
                return userAgentAfterPatternToSpace('trident/');
            case 'gecko':
                return userAgentAfterPatternToSpace('gecko/');
            case 'presto':
                s = ua.indexOf('presto/')+7;
                return ua.substring(s, Math.min(ua.indexOf('/', s), ua.indexOf(' ', s), ua.indexOf(')', s)));
        }
        
        return '';
    }
};

/**
 * Anonymous routine that writes body telemetry classes.
 */
(function(){
    var written = false;
    
    /**
     * Telemetry-writing function attached onDOMContentLoaded and onLoad. The
     */
    var writer = function(){
        
        if(written) 
            return;
        
        written = true;
        var classes = document.body.className.split(' '),
            i = classes.length,
            classification = mwf.classification,
            userAgent = mwf.userAgent;
        
        /**
         * Function that returns true iff class v is not defined in classes.
         */
        var nin = function(v){
            for(p in classes) 
                if(v == classes[p]) 
                    return false; 
            return true;
        }
        
        /**
         * Always add body.mwf.
         */
        if(nin('mwf')){
            classes[i++] = 'mwf';
        }
        
        /**
         * Add body.mwf_mobile if device is mobile, else add body.mwf_notmobile.
         */
        if(classification.isMobile()){
            if(nin("mwf_mobile")){
                classes[i++] = "mwf_mobile";
            }
        }else{
            if (nin("mwf_notmobile")){
                classes[i++] = "mwf_notmobile";
            }
        }
        
        /**
         * Add body.mwf_standard if device is classified as standard.
         */
        if(classification.isStandard() && nin("mwf_standard")){
            classes[i++] = "mwf_standard";
        }
        
        /**
         * Add body.mwf_full if device is classified as full.
         */
        if(classification.isFull() && nin("mwf_full")){
            classes[i++] = "mwf_full";
        }
        
        var t,tv;
        
        /**
         * Add body class for mwf_browser_{name} when possible.
         */
        if((t = userAgent.getBrowser()).length > 0) {
            t = "mwf_browser_"+t.toLowerCase().replace(" ","_");
            if(nin(t)) 
                classes[i++] = t;
        }
        
        /**
         * Add body class for mwf_browser_engine_{name} when possible.
         */
        if((t = userAgent.getBrowserEngine()).length > 0) {
            t = "mwf_browser_engine_"+t.toLowerCase().replace(" ","_");
            if(nin(t)) 
                classes[i++] = t;
        }
        
        /**
         * Add body class for mwf_os_{name} when possible.
         */
        if((t = userAgent.getOS()).length > 0) {
            t = "mwf_os_"+t.toLowerCase().replace(" ","_");
            if(nin(t)) 
                classes[i++] = t;
        }
        
        /**
         * Add body class for mwf_os_{name}_{version} when possible.
         */
        if((tv = userAgent.getOSVersion()).length > 0) {
            tv = t+'_'+tv.toLowerCase().replace(/ /g,"_").replace(/\./g,"_");
            if(nin(tv)) 
                classes[i++] = tv;
        }
        
        /**
         * Write classes to the body in one bulk operation.
         */
        document.body.className = classes.join(' ');
    };
    
    /**
     * Attaches the writer to both document onDOMContentLoaded and window onLoad
     * so as to execute as early as when the DOM content is ready, if the device
     * supports it, or else when the DOM content has fully loaded.
     */
    if(document.addEventListener) {
        document.addEventListener('DOMContentLoaded',writer,false);
    }
    
    if(window.addEventListener) {
        window.addEventListener('load',writer,false);
    } else if (window.attachEvent) {
        window.attachEvent('onload',writer);
    }
})();
