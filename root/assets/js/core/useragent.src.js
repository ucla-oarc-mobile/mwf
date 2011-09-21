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
 * @version 20110921
 */

mwf.userAgent = new function() {
    
    /**
     * Name of the user agent cookie that may be written to expose UA-based
     * telemetry to the server.
     */
    this.cookieName = mwf.site.cookie.prefix+'user_agent';
    
    var userAgent = navigator.userAgent.toLowerCase();
    
    /**
     * Determines the operating system from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getOS = function(){ 
        var ua = userAgent;
        if(ua.match(/(iphone)|(ipad)|(ipod)/) != null) return 'iphone_os';
        else if(ua.indexOf('android') != -1) return 'android';
        else if(ua.indexOf('blackberry') != -1) return 'blackberry';
        else if(ua.indexOf('windows phone os') != -1) return 'windows_phone';
        else if(ua.indexOf('windows mobile') != -1) return 'windows_mobile';
        else if(ua.indexOf('symbian') != -1) return 'symbian';
        else if(ua.indexOf('webos') != -1) return 'webos';
        else if(ua.indexOf('mac os x') != -1) return 'mac_os';
        else if(ua.indexOf('windows nt') != -1) return 'windows';
        else if(ua.indexOf('linux') != -1) return 'linux';
        else return '';
    }
    
    /**
     * Determines the operating system version from string or else returns 
     * an empty string.
     *
     * @return string
     */
    this.getOSVersion = function(){ 
        var ua = userAgent, s;
        switch(this.getOS())
        {
            case 'iphone_os':
                s = ua.indexOf('iPhone OS')+10;
                ua = ua.substring(s, Math.min(ua.indexOf(' ', s), ua.indexOf('.', ua.indexOf('.', s)+1)));
                return ua;
            case 'blackberry':
                if(ua.substring(0, 10).toLowerCase() == 'blackberry'){
                    s = ua.indexOf('/')+1;
                    ua = ua.substring(s, Math.min(ua.indexOf(' ', s), ua.indexOf('.', ua.indexOf('.', s)+1)));
                    return ua;
                }
                break;
            case 'android':
                if((s = ua.indexOf('Android ')) != -1){
                    s += 8;
                    ua = ua.substring(s, Math.min(ua.indexOf(' ', s), ua.indexOf(';', s), ua.indexOf('-', s), ua.indexOf('.', ua.indexOf('.', s)+1)))
                    return ua;
                }
                break;
            case 'windows_phone':
                if((s = ua.indexOf('Windows Phone OS ')) != -1){
                    s += 17;
                    ua = ua.substring(s, ua.indexOf(';', s));
                    return ua;
                }
                break;
            case 'windows_mobile':
                if((s = ua.indexOf('Windows Mobile/')) != -1){
                    s += 15;
                    ua = ua.substring(s, ua.indexOf(';', s));
                    return ua;
                }
                break;
            case 'symbian':
                if((s = ua.indexOf('SymbianOS/')) != -1){
                    s += 10;
                    ua = ua.substring(s, ua.indexOf(';', s));
                    return ua;
                }
                else if((s = ua.indexOf('Symbian/')) != -1){
                    s += 8;
                    ua = "s"+ua.substring(s, ua.indexOf(';', s));
                    return ua;
                }
                break;
            case 'webos':
                if((s = ua.indexOf('webOS/')) != -1){
                    s += 6;
                    ua = ua.substring(s, Math.min(ua.indexOf(';', s), ua.indexOf('.', ua.indexOf('.', s)+1)));
                    return ua;
                }
                break;
        }
        return '';
    }
    
    /**
     * Determines the web browser from string or else returns an empty string.
     *
     * @return string
     */
    this.getBrowser = function(){
        
        if(userAgent.indexOf('safari') != -1){
            if(this.getOS() == 'android') return 'android_webkit';
            return 'safari';
        }
        
        if(userAgent.indexOf('chrome') != -1) return 'chrome';
        if(userAgent.indexOf('iemobile') != -1) return 'iemobile';
        if(userAgent.indexOf('camino') != -1) return 'camino';
        if(userAgent.indexOf('seamonkey') != -1) return 'seamonkey';
        if(userAgent.indexOf('firefox') != -1) return 'firefox';
        if(userAgent.indexOf('opera mobi')) return 'opera_mobile';
        if(userAgent.indexOf('opera_mini')) return 'opera_mini';
        
        return '';
    }
    
    /**
     * Determines the web browser engine from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getBrowserEngine = function(){
        if(userAgent.indexOf('applewebkit') != -1) return 'webkit';
        if(userAgent.indexOf('trident') != -1) return 'trident';
        if(userAgent.indexOf('gecko') != -1) return 'gecko';
        if(userAgent.indexOf('presto') != -1) return 'presto';
        if(userAgent.indexOf('khtml') != -1) return 'khtml';
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
        switch(this.getBrowserEngine())
        {
            case 'webkit':
                s = ua.indexOf('applewebkit/')+12;
                return ua.substring(s, ua.indexOf(' ', s));
            case 'trident':
                s = ua.indexOf('trident/')+8;
                return ua.substring(s, ua.indexOf(' ', s));
            case 'gecko':
                s = ua.indexOf('gecko/')+6;
                return ua.substring(s, ua.indexOf(' ', s));
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
