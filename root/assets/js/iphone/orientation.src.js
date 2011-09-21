mwf.iphone.orientation = new function() {

    this.init = function(type, e) {
        var v = mwf.iphone.orientation.getViewportElements();
        if(v.length == 0)
        {
            var head= document.getElementsByTagName('head')[0];
            var meta= document.createElement('meta');
            meta.setAttribute('name', 'viewport')
            meta.setAttribute('content', 'height='+mwf.browser.pageHeight()+',width='+mwf.browser.pageWidth()+',initial-scale=1.0,maximum-scale=1.0,user-scalable=no');
            head.appendChild(meta);
        }
    }

    this.getViewportElements = function() {
        var v = [];
        var l = 0;
        if(typeof(document.querySelectorAll) == 'function')
        {
            v = document.querySelectorAll('meta[name=viewport]');
        }
        else
        {
            var t = document.getElementsByTagName('meta');
            var i = t.length;
            while(i--){
                if(t[i].name == 'viewport')
                    v[l++] = t[i];
            }
        }
        return v;
    }

    this.change = function(type, e) {
        document.getElementsByTagName('body')[0].width = mwf.browser.pageWidth();
        var v = mwf.iphone.orientation.getViewportElements();
        if(v.length > 0)
        {
            var i = v.length;
            while(i--)
            {
                v[i].setAttribute('content', 'height='+mwf.browser.pageHeight()+',width='+mwf.browser.pageWidth()+'; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;');
            }
        }
    }
}

if(mwf.user_agent.is_iphone_os())
{
    document.addEventListener('DOMContentLoaded', mwf.iphone.orientation.init, false);
    window.addEventListener('orientationchange', mwf.iphone.orientation.change, false);
}