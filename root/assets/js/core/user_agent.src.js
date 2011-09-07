/**
 * Defines methods under mwf.user_agent namespace. These are deprecated, but
 * still supported for backwards compatibility reasons.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110906
 * 
 * @deprecated
 * 
 * @uses mwf.userAgent
 * @uses mwf.classification
 */

mwf.user_agent = new function(){

    var userAgent = mwf.userAgent,
        classification = mwf.classification;
    
    this.is_iphone_os=function(){
        return userAgent.getOS() == 'ios';
    }
    
    this.is_webkit_engine=function(){
        return navigator.userAgent.match(/(webkit)/i) != null 
            && !navigator.userAgent.match(/(webkit\/41)/i) != null
    }
    
    this.get_browser=userAgent.getBrowser;
    
    this.get_browser_version=userAgent.getBrowserVersion;
    
    this.get_os=userAgent.getOS;
    
    this.get_os_version=userAgent.getOSVersion;
    
    this.is_mobile=function(){
        return classification.isMobile() ? 1 : 0;
    }
    
    this.is_basic=function(){
        return classification.isBasic() ? 1 : 0;
    }
    
    this.is_standard=function(){
        return classification.isStandard() ? 1 : 0;
    }
    
    this.is_full=function(){
        return classification.isFull() ? 1 : 0;
    }
    
    this.is_touch=function(){
        return classification.isStandard() ? 1 : 0;
    }
    
    this.is_overridden=function(){
        return classification.isFull() ? 1 : 0;
    }
    
    this.is_overridden=function(){
        return classification.isOverride() ? 1 : 0;
    }
    
    this.is_preview=function(){
        return classification.isOverride() && !classification.isMobile() ? 1 : 0;
    }
};
