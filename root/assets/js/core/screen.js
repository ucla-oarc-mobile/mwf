mwf.screen = new function() {
    this.getWidth=function(){return window.screen.width ? window.screen.width : mwf.browser.getWidth() }
    this.getHeight=function(){return window.screen.width ? window.screen.width : mwf.browser.getWidth() }
}
