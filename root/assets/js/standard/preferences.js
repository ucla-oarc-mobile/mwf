/**
 * Defines methods under mwf.standard.preferences that create, read, and update 
 * preferences.
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

mwf.standard.preferences=new function(){
    /**
     * Prefix for the preferences data in localStorage
     */
    var _localStorageName = mwf.site.localStorage.prefix+'prefs';

    /**
     * Determine if the device has sufficient capabilities to support preferences.
     * 
     * @return bool
     */
    this.isSupported = function(){
        return mwf.capability.localstorage(); 
    }
};
