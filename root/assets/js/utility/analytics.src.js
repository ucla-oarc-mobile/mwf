/**
 *
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120208
 *
 * @requires mwf.userAgent
 */

mwf.site.analytics.trackPageview = function(url) {
    url = url || window.location.pathname + window.location.search + window.location.hash; 
    if (mwf.site.analytics.key) {
        _gaq.push(["_trackPageview",url]);
    }
    
    for (var i = 0; i < mwf.site.analytics.pathKeys.length; i++) {
        if (url.substring(0,mwf.site.analytics.pathKeys[i].s.length) == mwf.site.analytics.pathKeys[i].s)
            _gaq.push(["t"+i+"._trackPageview",url]);
    }
}


var _gaq = _gaq || [];


mwf.site.analytics.init = function() {
    if(mwf.site.analytics.key) {
        _gaq.push(["_setAccount", mwf.site.analytics.key]);
    }
    
    for (var i = 0; i < mwf.site.analytics.pathKeys.length; i++) {
        _gaq.push(["t"+i+"._setAccount",mwf.site.analytics.pathKeys[i].a]);
    }
    
    if (mwf.userAgent.isNative()) {
        // Special tracking for native client.
        // @todo: Make this configurable (on|off, at least) and customizable
        //   (might want to track native container version number, for example)
        // @todo: Possible to integration test this with PHP code?
        _gaq.push(['_setCustomVar', 1, 'mwf_native_client', mwf.userAgent.getOS()]);       
    }

    mwf.site.analytics.trackPageview();

    if (_gaq.length!=0) {
        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    }
}

mwf.site.analytics.init();