(function(){

    if(!mwf.capability.cookie())
        return false;
    
    var reload = false;
    
    reload = reload || (function(){

        // Check for if a cookie already exists by mwf_capabilities.
        var i, cookies = document.cookie.split(';');
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == mwf.classification.cookieName)
                return false;
        }

        // If cookie is not set, set the cookie and reload the page.
        var cookie = mwf.classification.cookieName+'={';
        cookie += '"mobile":'+mwf.classification.isMobile();
        cookie += ',"basic":'+mwf.classification.isBasic();
        cookie += ',"standard":'+mwf.classification.isStandard();
        cookie += ',"full":'+mwf.classification.isFull();
        if(mwf.classification.isOverride()){
            cookie += ',"actual":{';
            cookie += '"mobile":'+mwf.classification.wasMobile();
            cookie += ',"basic":'+mwf.classification.wasBasic();
            cookie += ',"standard":'+mwf.classification.wasStandard();
            cookie += ',"full":'+mwf.classification.wasFull();
            cookie += '}';
        }
        cookie += '};path=/';
        document.cookie = cookie;
        return true;

    })();
    
    reload = reload || (function(){
        
        var i, cookies = document.cookie.split(';');
        for(i=0; i < cookies.length; i++){
            x = cookies[i].substr(0,cookies[i].indexOf("="));
            x = x.replace(/^\s+|\s+$/g,"");
            if(x == mwf.userAgent.cookieName)
                return false;
        }

        var t;
        var cookie = mwf.userAgent.cookieName+'={';
        cookie += '"s":"'+navigator.userAgent.replace(/\;/g, '\\x3B').replace(/\,/g, '\\x2C')+'"';
        if(t = mwf.userAgent.getOS())
            cookie += ',"os":"'+t+'"';
        if(t = mwf.userAgent.getOSVersion())
            cookie += ',"osv":"'+t+'"';
        if(t = mwf.userAgent.getBrowser())
            cookie += ',"b":"'+t+'"';
        if(t = mwf.userAgent.getBrowserEngine())
            cookie += ',"be":"'+t+'"';
        cookie += '};path=/';
        document.cookie = cookie;
        alert(cookie);
        return true;

    })();


    if(reload)
        document.location.reload();
    
    
})();
