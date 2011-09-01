mwf.user_agent = new function() {
    
    this.getOS = function(){ return ''; }
    this.getOSVersion = function(){ return ''; }
    this.getBrowser = function(){ return ''; }
    this.getBrowserVersion = function(){ return ''; }
    
    
    // User agent specific accessors
    this.is_iphone_os=function(){ return navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)/i) != null }
    this.is_webkit_engine=function(){ return navigator.userAgent.match(/(webkit)/i) != null && !navigator.userAgent.match(/(webkit\/41)/i) != null }
    
    // DEPRECATED!!!!
    this.get_browser=this.getBrowser;
    this.get_browser_version=this.getBrowserVersion;
    this.get_os=this.getOS;
    this.get_os_version=this.getOSVersion;
    this.is_mobile=function(){ return mwf.classification.isMobile() ? 1 : 0; }
    this.is_basic=function(){ return mwf.classification.isBasic() ? 1 : 0; }
    this.is_standard=function(){ return mwf.classification.isStandard() ? 1 : 0; }
    this.is_full=function(){ return mwf.classification.isFull() ? 1 : 0; }
    this.is_touch=function(){ return mwf.classification.isStandard() ? 1 : 0; }
    this.is_overridden=function(){ return mwf.classification.isFull() ? 1 : 0; }
    this.is_overridden=function(){ return mwf.classification.isOverride() ? 1 : 0; }
    this.is_preview=function(){ return mwf.classification.isOverride() && !mwf.classification.isMobile() ? 1 : 0; }
};

(function(){
    var written = false;
    var writer = function(){
        if(written) return; written = true; var classes = document.body.className.split(' '); var i = classes.length;
        var nin = function(v){ for(p in classes) if(v == classes[p]) return false; return true; }
        if(nin('mwf')){
            classes[i++] = 'mwf';
        }
        if(mwf.user_agent.is_mobile()){
            if(nin("mwf_mobile")){
                classes[i++] = "mwf_mobile";
            }
        }else{
            if (nin("mwf_notmobile")){
                classes[i++] = "mwf_notmobile";
            }
        }
        if(mwf.user_agent.is_standard() && nin("mwf_standard")){
            classes[i++] = "mwf_standard";
        }
        if(mwf.user_agent.is_full() && nin("mwf_full")){
            classes[i++] = "mwf_full";
        }
        var t,tv;
        if((t = mwf.user_agent.get_browser()).length > 0) { t = "mwf_browser_"+t.toLowerCase().replace(" ","_"); if(nin(t)) classes[i++] = t; }
        if((tv = mwf.user_agent.get_browser_version()).length > 0) { tv = t+'_'+tv.toLowerCase().replace(" ","_").replace(".","_"); if(nin(tv)) classes[i++] = tv; }
        if((t = mwf.user_agent.get_os()).length > 0) { t = "mwf_os_"+t.toLowerCase().replace(" ","_"); if(nin(t)) classes[i++] = t; }
        if((tv = mwf.user_agent.get_os_version()).length > 0) { tv = t+'_'+tv.toLowerCase().replace(" ","_").replace(".","_"); if(nin(tv)) classes[i++] = tv; }
        document.body.className = classes.join(' ');
    };
    document.addEventListener('DOMContentLoaded',writer,false);
    window.addEventListener('load',writer,false);
})();
