(function(){
    
    if(!mwf.capabilities.hasCookies())
        return;
    
    // Check for if a cookie already exists by mwf_capabilities.
    var i, cookies = document.cookie.split(';');
    for(i=0; i < cookies.length; i++){
        x = cookies[i].substr(0,cookies[i].indexOf("="));
        x = x.replace(/^\s+|\s+$/g,"");
        if(x == mwf.classification.cookieName)
            return;
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
    document.location.reload();
    
})();
