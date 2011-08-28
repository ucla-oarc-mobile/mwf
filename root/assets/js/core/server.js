(function(){
    
    var d = mwf.device;
    
    if(!d.hasCookies())
        return;
    
    // Check for if a cookie already exists by mwf_capabilities.
    var i, cookies = document.cookie.split(';');
    for(i=0; i < cookies.length; i++){
        x = cookies[i].substr(0,cookies[i].indexOf("="));
        x = x.replace(/^\s+|\s+$/g,"");
        if(x == d.cookieName)
            return;
    }
    
    // If cookie is not set, set the cookie and reload the page.
    var cookie = d.cookieName+'={';
    cookie += '"mobile":'+d.isMobile();
    cookie += ',"basic":'+d.isBasic();
    cookie += ',"standard":'+d.isStandard();
    cookie += ',"full":'+d.isFull();
    if(d.isOverride()){
        cookie += ',"actual":{';
        cookie += '"mobile":'+d.wasMobile();
        cookie += ',"basic":'+d.wasBasic();
        cookie += ',"standard":'+d.wasStandard();
        cookie += ',"full":'+d.wasFull();
        cookie += '}';
    }
    cookie += '};path=/';
    document.cookie = cookie;
    document.location.reload();
    
})();
