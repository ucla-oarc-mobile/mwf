/**
 * Defines methods under mwf.standard.layoutPreferences that create, read, and 
 * update layout preferences.
 *
 * @package standard
 * @subpackage js
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111018
 *
 * @requires mwf
 * @requires mwf.capability
 * 
 */

mwf.standard.layoutPreferences=new function(){
    /**
     * Determine if the device has sufficient capabilities to support layout 
     * preferences.
     * 
     * @return bool
     */
    this.isSupported = function(){
        return mwf.capability.localstorage(); 
    }
};
