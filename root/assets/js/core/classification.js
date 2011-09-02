mwf.classification=new function(){
    
    this.cookieName = mwf.site.cookie.prefix+'classification';

    this.isMobile = function(){
        return mwf.site.mobile.maxHeight > mwf.screen.getHeight()
            && mwf.site.mobile.maxWidth  > mwf.screen.getWidth();
    }
    
    this.isBasic = function(){
        return true; // TODO: Figure out how to determine if basic
    }
    
    /**
     * Determine if the device is at least a standard-level device.
     *
     * This requires that the device has support for:
     *      - DOM writing
     *      - AJAX
     *      - Load Event Listener
     */
    this.isStandard = function(){
        return mwf.capability.cookie() && mwf.capability.write() && mwf.capability.events();
    }
    
    /**
     * Determine if the device is a a full-level device.
     *
     * This requires that the device has support for:
     *      - All standard-level features
     *      - CSS 2.1 opacity
     *      - CSS 3 gradients, border radius and box shadow
     */
    this.isFull = function(){
        return this.isStandard() && mwf.capability.ajax() && mwf.capability.css3();
    }
    
    this.isPreview = function(){
        return (typeof this.isOverride() == 'function') && this.isOverride() && !this.isMobile();
    }
    
    this.get = function(){
        if(this.isFull())
            return 'full';
        else if(this.isStandard())
            return 'standard';
        else
            return 'basic';
    }
};
