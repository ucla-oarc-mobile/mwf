mwf.redirect = function(loc){
    
    if(mwf.site.mobile.maxHeight > mwf.screen.getHeight()
            && mwf.site.mobile.maxWidth  > mwf.screen.getWidth()){
        window.location = loc;
    }
    
};