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
 * @version 20111003
 * 
 * @deprecated in MWF 1.2
 * 
 * @requires mwf.userAgent
 * @requires mwf.classification
 */

mwf.user_agent = new function(){

    var userAgent = mwf.userAgent,
        classification = mwf.classification;
    
    this.is_iphone_os=function() {
        return userAgent.getOS() == 'iphone_os';
    }
    
    this.is_webkit_engine=function(){
        return userAgent.getBrowserEngine() == 'webkit';
    }
    
    this.get_browser=function() {
        return userAgent.getBrowser.call(userAgent);
    }
    
    this.get_browser_version=function(){
        return false;
    };
    
    this.get_os=userAgent.getOS;
    
    this.get_os_version=function() {
        return userAgent.getOSVersion.call(userAgent);
    }
    
    this.is_mobile=classification.isMobile;
    
    this.is_basic=classification.isBasic;
    
    this.is_standard=classification.isStandard;
    
    this.is_full=function() {
        return classification.isFull.call(classification);
    }
    
    this.is_touch=classification.isStandard;
    
    this.is_overridden=classification.isOverride;
    
    this.is_preview=function() {
        return classification.isPreview.call(classification);
    }
};
