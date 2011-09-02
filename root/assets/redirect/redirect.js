mwf.redirect = function(loc){
    
    if(mwf.classification.isMobile()){
        window.location = loc;
    }
    
};