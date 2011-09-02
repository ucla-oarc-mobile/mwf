mwf.userAgent = new function() {
    
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
    
    var ua = navigator.userAgent.toLowerCase();
    
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
    
    // TODO
    this.getBrowserVersion = function(){return '';}
    
    this.getBrowserEngine = function(){
        if(ua.indexOf('applewebkit') != -1) return 'webkit';
        if(ua.indexOf('trident') != -1) return 'trident';
        if(ua.indexOf('gecko') != -1) return 'gecko';
        if(ua.indexOf('presto') != -1) return 'presto';
        if(ua.indexOf('khtml') != -1) return 'khtml';
    }
    
    // TODO
    this.getBrowserEngineVersion = function(){return '';}
};

(function(){
    var written = false;
    var writer = function(){
        if(written) return;written = true;var classes = document.body.className.split(' ');var i = classes.length;
        var nin = function(v){for(p in classes) if(v == classes[p]) return false; return true;}
        if(nin('mwf')){
            classes[i++] = 'mwf';
        }
        if(mwf.classification.isMobile()){
            if(nin("mwf_mobile")){
                classes[i++] = "mwf_mobile";
            }
        }else{
            if (nin("mwf_notmobile")){
                classes[i++] = "mwf_notmobile";
            }
        }
        if(mwf.classification.isStandard() && nin("mwf_standard")){
            classes[i++] = "mwf_standard";
        }
        if(mwf.classification.isFull() && nin("mwf_full")){
            classes[i++] = "mwf_full";
        }
        var t,tv;
        if((t = mwf.userAgent.getBrowser()).length > 0) {t = "mwf_browser_"+t.toLowerCase().replace(" ","_");if(nin(t)) classes[i++] = t;}
        if((tv = mwf.userAgent.getBrowserVersion()).length > 0) {tv = t+'_'+tv.toLowerCase().replace(/ /g,"_").replace(/\./g,"_");if(nin(tv)) classes[i++] = tv;}
        if((t = mwf.userAgent.getOS()).length > 0) {t = "mwf_os_"+t.toLowerCase().replace(" ","_");if(nin(t)) classes[i++] = t;}
        if((tv = mwf.userAgent.getOSVersion()).length > 0) {tv = t+'_'+tv.toLowerCase().replace(/ /g,"_").replace(/\./g,"_");if(nin(tv)) classes[i++] = tv;}
        document.body.className = classes.join(' ');
    };
    document.addEventListener('DOMContentLoaded',writer,false);
    window.addEventListener('load',writer,false);
})();

// DEPRECATED!!!! 
mwf.user_agent = new function(){
    // user agent specific accessors that exist for backwards compatibility
    this.is_iphone_os=function(){return mwf.userAgent.getOS() == 'ios';}
    this.is_webkit_engine=function(){return navigator.userAgent.match(/(webkit)/i) != null && !navigator.userAgent.match(/(webkit\/41)/i) != null}
    // functions moved to mwf.classification or mwf.userAgent with camelCase
    this.get_browser=mwf.userAgent.getBrowser;
    this.get_browser_version=mwf.userAgent.getBrowserVersion;
    this.get_os=mwf.userAgent.getOS;
    this.get_os_version=mwf.userAgent.getOSVersion;
    this.is_mobile=function(){return mwf.classification.isMobile() ? 1 : 0;}
    this.is_basic=function(){return mwf.classification.isBasic() ? 1 : 0;}
    this.is_standard=function(){return mwf.classification.isStandard() ? 1 : 0;}
    this.is_full=function(){return mwf.classification.isFull() ? 1 : 0;}
    this.is_touch=function(){return mwf.classification.isStandard() ? 1 : 0;}
    this.is_overridden=function(){return mwf.classification.isFull() ? 1 : 0;}
    this.is_overridden=function(){return mwf.classification.isOverride() ? 1 : 0;}
    this.is_preview=function(){return mwf.classification.isOverride() && !mwf.classification.isMobile() ? 1 : 0;}
};
