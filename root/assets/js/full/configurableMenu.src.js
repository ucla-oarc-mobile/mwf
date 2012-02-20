/**
 * Defines methods under mwf.standard.configurableMenu that allow menu items to
 * be determined by the user.
 *
 * @package full
 * @subpackage js
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120218
 *
 * @requires mwf
 * @requires mwf.standard.preferences
 * 
 */

mwf.full.configurableMenu=new function(){
    /**
     * Renders the items from object or array menuItems whose keys are specified
     * in the preferences key prefsKey into the DOM object with id targetId.
     * 
     * @param targetId string
     * @param prefsKey string
     * @param menuItems object|array
     * 
     * @return null
     */
    this.render = function(targetId, prefsKey, menuItems){
        var target = document.getElementById(targetId);
        if (target === null)
            return;
        
        var result = '';
        var keys = null;
        
        if (mwf.standard.preferences.isSupported()) {
            var prefsValue = mwf.standard.preferences.get(prefsKey);
            if (prefsValue!==null)
                try {
                    keys = JSON.parse(prefsValue);    
                } catch (e) {
                    // String from user's preferences is not a valid JSON object.
                    // Revert to default.
                    keys = null;
                }
        }
        
        if (keys === null) {            
            for (var key in menuItems) {
                if (menuItems.hasOwnProperty(key))
                    result += menuItems[key];
            }
        } else {
            var i;
            if (keys.hasOwnProperty('on')) {
                for (i=0; i<keys.on.length; i++) {
                    if (menuItems.hasOwnProperty(keys.on[i])) {
                        result += menuItems[keys.on[i]];      
                        delete menuItems[keys.on[i]];
                    }
                }
            }
            var off = keys.hasOwnProperty('off') ? keys.off : [];
            
            for (i in menuItems) {
                if (menuItems.hasOwnProperty(i)) {
                    // Use +i so that it gets cast to an integer if it's a string in integer form.
                    // This allows objects and arrays to play nicely together as object keys will 
                    // always be strings. 
                    if (!(off.indexOf(i)>=0 || off.indexOf(+i)>=0))
                        result += menuItems[i];
                }
            }
        }
        
        target.innerHTML = result;
    }
}