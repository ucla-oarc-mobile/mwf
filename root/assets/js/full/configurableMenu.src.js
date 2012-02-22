/**
 * mwf.full.ConfigurableMenu object that allows menu items to be determined by 
 * the user.
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

mwf.full.ConfigurableMenu=function(prefsKey){
    
    var _prefsKey = prefsKey;
 
    var _getPrefsLists = function() {
        var keys = null;
        
        if (mwf.standard.preferences.isSupported()) {
            var prefsValue = mwf.standard.preferences.get(_prefsKey);
            if (prefsValue!==null)
                try {
                    keys = JSON.parse(prefsValue);    
                } catch (e) {
                    // String from user's preferences is not a valid JSON object.
                    // Revert to default.
                    keys = null;
                }
        }
        return keys;
    }
        
    /**
     * Renders the items from object or array menuItems (whose keys are 
     * specified in the preferences) into the DOM object with id targetId.
     * 
     * @param targetId string
     * @param menuItems object|array
     * @param disabledMenuItems object|array
     * 
     * @return null
     */
    
    this.render = function(targetId, menuItems, disabledMenuItems){
        var target = document.getElementById(targetId);
        if (target === null)
            return;
        
        var result = '';
        var keys = _getPrefsLists();
        
        if (keys===null) {
            keys={};
            keys.on = [];
            for (var key in menuItems)
                if (menuItems.hasOwnProperty(key)) {
                    keys.on.push(+key);
                    result += menuItems[key];
                }
            if (mwf.standard.preferences.isSupported())
                mwf.standard.preferences.set(_prefsKey,JSON.stringify(keys));
        } else {
            // Render items in 'on' in the correct order
            var i;
            
            if (! keys.hasOwnProperty('on')) 
                keys.on = [];
            var on = keys.on;

            for (i=0; i<on.length; i++) {
                if (menuItems.hasOwnProperty(on[i])) {
                    result += menuItems[on[i]];      
                }
            }

            
            // Render items that are neither in 'on' nor in 'off'
            var off = keys.hasOwnProperty('off') ? keys.off : [];
            
            for (i in menuItems) {
                if (menuItems.hasOwnProperty(i)) {
                    if (off.indexOf(+i)==-1 && on.indexOf(+i)==-1) {
                        keys.on.push(+i);
                        result += menuItems[i];
                    }
                }
            }
            if (mwf.standard.preferences.isSupported())
                mwf.standard.preferences.set(_prefsKey,JSON.stringify(keys));
            
            // If 'disabledMenuItems' was sent, then render items from 'off'
            if (disabledMenuItems) {
                for (i=0; i<off.length; i++) {
                    if (disabledMenuItems.hasOwnProperty(off[i])) {
                        result += disabledMenuItems[off[i]];
                    }
                }
            }
        
        }
        target.innerHTML = result;
    }
    
    /**
     * Enables or disables an item in the menu.
     * 
     * @param itemId string|int Corresponds to array key in ini file for menu.
     * @param enable boolean If true, enable item. Otherwise, disable.
     */
    this.set = function(itemId, enable) {
        var prop = enable ? "on" : "off";
        var keys = _getPrefsLists();

        if (keys==null) {
            keys={};
        }

        if (! keys.hasOwnProperty(prop)) {
            keys[prop] = [itemId];
        } else {
            if (keys[prop].indexOf(itemId)==-1)
                keys[prop].push(+itemId)
        }
        
        otherProp = prop=="on" ? "off" : "on";
        
        if (keys.hasOwnProperty(otherProp)) {
            while (keys[otherProp].indexOf(itemId)!=-1)
                keys[otherProp].splice(keys[otherProp].indexOf(itemId),1);
        }
        mwf.standard.preferences.set(_prefsKey,JSON.stringify(keys));
    }
    
    /**
     * Moves the specified item up one space in the enabled items list.
     * 
     * @param itemId string|int
     * 
     */
    this.moveUp = function(itemId) {
        keys = _getPrefsLists();
        if (keys.hasOwnProperty('on')) {
            var index = keys.on.indexOf(itemId);
            if (index > 0) {
                var temp = keys.on[index];
                keys.on[index] = keys.on[index-1];
                keys.on[index-1] = temp;
                mwf.standard.preferences.set(_prefsKey,JSON.stringify(keys))
            }   
        }
    }
    
    /**
     * Moves the specified item down one space in the enabled items list.
     * 
     * @param itemId string|int
     * 
     */
    this.moveDown = function(itemId) {
        keys = _getPrefsLists();
        if (keys.hasOwnProperty('on')) {
            var index = keys.on.indexOf(itemId);
            if (index > -1 && index < keys.on.length-1) {
                var temp = keys.on[index];
                keys.on[index] = keys.on[index+1];
                keys.on[index+1] = temp;
                mwf.standard.preferences.set(_prefsKey,JSON.stringify(keys))
            }   
        }
    }   
}