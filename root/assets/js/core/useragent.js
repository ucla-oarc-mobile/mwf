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
 * @version 20110902
 */

mwf.userAgent = new function() {
    
    /**
     * Name of the user agent cookie that may be written to expose UA-based
     * telemetry to the server.
     */
    this.cookieName = mwf.site.cookie.prefix+'user_agent';
    
    /**
     * Determines the operating system from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getOS = function(){ 
        var ua = navigator.userAgent.toLowerCase();
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
        var ua = navigator.userAgent.toLowerCase(), s;
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
     * Immutable value used by remaining methods.
     */
    var ua = navigator.userAgent.toLowerCase();
    
    /**
     * Determines the web browser from string or else returns an empty string.
     *
     * @return string
     */
    this.getBrowser = function(){
        
        if(ua.indexOf('safari') != -1){
            if(this.getOS() == 'android') return 'android_webkit';
            return 'safari';
        }
        
        if(ua.indexOf('chrome') != -1) return 'chrome';
        if(ua.indexOf('iemobile') != -1) return 'iemobile';
        if(ua.indexOf('camino') != -1) return 'camino';
        if(ua.indexOf('seamonkey') != -1) return 'seamonkey';
        if(ua.indexOf('firefox') != -1) return 'firefox';
        if(ua.indexOf('opera mobi')) return 'opera_mobile';
        if(ua.indexOf('opera_mini')) return 'opera_mini';
        
        return '';
    }
    
    /**
     * Determines the web browser version from string or else returns an empty 
     * string.
     *
     * @todo
     * @return string
     */
    this.getBrowserVersion = function(){return '';}
    
    /**
     * Determines the web browser engine from string or else returns an empty 
     * string.
     *
     * @return string
     */
    this.getBrowserEngine = function(){
        if(ua.indexOf('applewebkit') != -1) return 'webkit';
        if(ua.indexOf('trident') != -1) return 'trident';
        if(ua.indexOf('gecko') != -1) return 'gecko';
        if(ua.indexOf('presto') != -1) return 'presto';
        if(ua.indexOf('khtml') != -1) return 'khtml';
    }
    
    /**
     * Determines the web browser engine version from string or else returns an 
     * empty string.
     *
     * @todo
     * @return string
     */
    this.getBrowserEngineVersion = function(){return '';}
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
        var classes = document.body.className.split(' ');
        var i = classes.length;
        
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
        if(mwf.classification.isMobile()){
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
        if(mwf.classification.isStandard() && nin("mwf_standard")){
            classes[i++] = "mwf_standard";
        }
        
        /**
         * Add body.mwf_full if device is classified as full.
         */
        if(mwf.classification.isFull() && nin("mwf_full")){
            classes[i++] = "mwf_full";
        }
        
        var t,tv;
        
        /**
         * Add body class for mwf_browser_{name} when possible.
         */
        if((t = mwf.userAgent.getBrowser()).length > 0) {
            t = "mwf_browser_"+t.toLowerCase().replace(" ","_");
            if(nin(t)) 
                classes[i++] = t;
        }
        
        /**
         * Add body class for mwf_browser_{name}_{version} when possible.
         */
        if((tv = mwf.userAgent.getBrowserVersion()).length > 0) {
            tv = t+'_'+tv.toLowerCase().replace(/ /g,"_").replace(/\./g,"_");
            if(nin(tv)) 
                classes[i++] = tv;
        }
        
        /**
         * Add body class for mwf_os_{name} when possible.
         */
        if((t = mwf.userAgent.getOS()).length > 0) {
            t = "mwf_os_"+t.toLowerCase().replace(" ","_");
            if(nin(t)) 
                classes[i++] = t;
        }
        
        /**
         * Add body class for mwf_os_{name}_{version} when possible.
         */
        if((tv = mwf.userAgent.getOSVersion()).length > 0) {
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
    document.addEventListener('DOMContentLoaded',writer,false);
    window.addEventListener('load',writer,false);
})();

/**
 * The mwf.user_agent namespace is deprecated, but still supported for backwards
 * compatibility reasons.
 *
 * @deprecated
 * 
 * @uses mwf.userAgent
 * @uses mwf.classification
 */
mwf.user_agent = new function(){
    
    this.is_iphone_os=function(){
        return mwf.userAgent.getOS() == 'ios';
    }
    
    this.is_webkit_engine=function(){
        return navigator.userAgent.match(/(webkit)/i) != null 
            && !navigator.userAgent.match(/(webkit\/41)/i) != null
    }
    
    this.get_browser=mwf.userAgent.getBrowser;
    
    this.get_browser_version=mwf.userAgent.getBrowserVersion;
    
    this.get_os=mwf.userAgent.getOS;
    
    this.get_os_version=mwf.userAgent.getOSVersion;
    
    this.is_mobile=function(){
        return mwf.classification.isMobile() ? 1 : 0;
    }
    
    this.is_basic=function(){
        return mwf.classification.isBasic() ? 1 : 0;
    }
    
    this.is_standard=function(){
        return mwf.classification.isStandard() ? 1 : 0;
    }
    
    this.is_full=function(){
        return mwf.classification.isFull() ? 1 : 0;
    }
    
    this.is_touch=function(){
        return mwf.classification.isStandard() ? 1 : 0;
    }
    
    this.is_overridden=function(){
        return mwf.classification.isFull() ? 1 : 0;
    }
    
    this.is_overridden=function(){
        return mwf.classification.isOverride() ? 1 : 0;
    }
    
    this.is_preview=function(){
        return mwf.classification.isOverride() && !mwf.classification.isMobile() ? 1 : 0;
    }
};
