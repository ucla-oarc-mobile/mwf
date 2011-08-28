mwf.browser = new function() {
    this.pageWidth=function(){return window.innerWidth != null? window.innerWidth : document.documentElement && document.documentElement.clientWidth ?       document.documentElement.clientWidth : document.body != null ? document.body.clientWidth : null;}
    this.pageHeight=function(){return  window.innerHeight != null? window.innerHeight : document.documentElement && document.documentElement.clientHeight ?  document.documentElement.clientHeight : document.body != null? document.body.clientHeight : null;}
    this.posLeft=function(){return typeof window.pageXOffset != 'undefined' ? window.pageXOffset :document.documentElement && document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ? document.body.scrollLeft : 0;}
    this.posTop=function(){return typeof window.pageYOffset != 'undefined' ?  window.pageYOffset : document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ? document.body.scrollTop : 0;}
    this.posRight=function(){return mwf.browser.posLeft()+mwf.browser.pageWidth();}
    this.posBottom=function(){return mwf.browser.posTop()+mwf.browser.pageHeight();}
};

document.cookie=mwf.site.cookie.prefix+'bw='+mwf.browser.pageWidth()+';path=/';
document.cookie=mwf.site.cookie.prefix+'bh='+mwf.browser.pageHeight()+';path=/';