/**
 * mwf.full.configurableMenu object that allows menu items to be determined by 
 * the user.
 *
 * @package full
 * @subpackage js
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120310
 *
 * @requires mwf
 * @requires mwf.standard.preferences
 * 
 */

mwf.full.configurableMenu=function(prefsKey){
     
    var getPrefsLists = function() {
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
        return keys;
    }
        
    return {   
        /**
         * Renders the items from object or array menuItems (whose keys are 
         * specified in the preferences) into the DOM object with id targetId.
         * 
         * @param targetId string
         * @param menuItems object|array
         * @param disabledMenuItems object|array
         * 
         * @return undefined
         */
    
        render: function(targetId, menuItems, disabledItems){
            var i, items, processed;
            var target = document.getElementById(targetId);
            if (target === null) {
                return;
            }
            
            if (! menuItems) {
                menuItems = [];
            }
            
            if (! disabledItems) {
                disabledItems = [];
            }
        
            var result = '';
            var keys = getPrefsLists();
        
            if (keys===null) {
                keys={};
                keys.items = [];
                for (var key in menuItems)
                    if (menuItems.hasOwnProperty(key)) {
                        keys.items.push({
                            key:+key,
                            on:1
                        });
                        result += menuItems[key];
                    }
                if (mwf.standard.preferences.isSupported())
                    mwf.standard.preferences.set(prefsKey,JSON.stringify(keys));
            } else {
                // Render items in the correct order
                if (! keys.hasOwnProperty('items')) { 
                    keys.items = [];
                }
                items = keys.items;

                processed=[];
                for (i=0; i<items.length; i++) {
                    if (items[i].hasOwnProperty('key')) {
                        processed.push(items[i].key);

                        if (items[i].hasOwnProperty('on')) {
                            if ((items[i].on === 1) && (menuItems.hasOwnProperty(items[i].key))) {
                                result += menuItems[items[i].key];
                            } else if ((items[i].on === 0) && (disabledItems.hasOwnProperty(items[i].key))) {
                                result += disabledItems[items[i].key];
                            }
                        }
                    }
                }
                
                for (i in menuItems) {
                    if ((menuItems.hasOwnProperty(i) && processed.indexOf(+i)==-1)) {
                        result += menuItems[i];
                        keys.items.push({
                            key:+i,
                            on:1
                        });
                    }
                }
            
                if (mwf.standard.preferences.isSupported()) {
                    mwf.standard.preferences.set(prefsKey,JSON.stringify(keys));
                }
        
            }
            target.innerHTML = result;
        },
    
        /**
         * Enables or disables an item in the menu.
         * 
         * @param itemId string|int Corresponds to array key in ini file for menu.
         * @param enable boolean If true, enable item. Otherwise, disable.
         */
        enableItem: function(itemId, enable) {
            var i, add, on, found;
            var keys = getPrefsLists();
            
            on = enable ? 1 : 0;
            
            add = {
                key:+itemId,
                on:on
            };

            if (keys===null) {
                keys={};
            }

            if (! keys.hasOwnProperty('items')) {
                keys.items = [];
            }
            
            found = false;
            for (i in keys.items) {
                if (keys.items[i].hasOwnProperty('key') && keys.items[i].key === +itemId) {
                    keys.items[i].on = on;
                    found = true;
                    break;
                }
            }
            if (! found) {
                keys.items.push(add);
            }

            mwf.standard.preferences.set(prefsKey,JSON.stringify(keys));
        },
    
        /**
         * Sets specified item at the specified position in the items list, 
         * overwriting anything that was already there..
         * 
         * @param itemId integer
         * @param positioin integer
         * 
         */
        setItemPosition: function(itemId, position) {
            var keys = getPrefsLists() || {};
            if (! keys.hasOwnProperty('items')) {
                keys.items = [];
            }
            keys.items[position - 1] = {
                key:+itemId,
                on:1
            };
            mwf.standard.preferences.set(prefsKey,JSON.stringify(keys));                      
        },
        
        /**
         * Resets the list order to the default.
         * 
         */
        reset: function() {
            mwf.standard.preferences.clear(prefsKey);
        }
    }
};