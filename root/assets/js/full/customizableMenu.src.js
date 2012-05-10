/**
 * mwf.full.customizableMenu object that allows menu items to be determined by 
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
mwf.full.customizableMenu = function (prefsKey) {   
    //polyfill Array.filter() for IE 8 and earlier
    //from https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/filter
    if (!Array.prototype.filter)
    {
        Array.prototype.filter = function(fun /*, thisp */)
        {
            "use strict";

            if (this == null)
                throw new TypeError();

            var t = Object(this);
            var len = t.length >>> 0;
            if (typeof fun != "function")
                throw new TypeError();

            var res = [];
            var thisp = arguments[1];
            for (var i = 0; i < len; i++)
            {
                if (i in t)
                {
                    var val = t[i]; // in case fun mutates this
                    if (fun.call(thisp, val, i, t))
                        res.push(val);
                }
            }

            return res;
        };
    }
    //end polyfill for IE 8 and earlier
    
    var getPrefsLists = function () {
        var keys = null,
        prefsValue;

        if (mwf.standard.preferences.isSupported()) {
            prefsValue = mwf.standard.preferences.get(prefsKey);
            if (prefsValue !== null) {
                try {
                    keys = JSON.parse(prefsValue);
                } catch (e) {
                    // String from user's preferences is not a valid JSON object. 
                    // Revert to default.
                    keys = null;
                }
            }
        }
        return keys;
    }
    
    var menuItems = [];
    var disabledMenuItems = [];
    
    return {   
        /**
         * Renders the items from object or array menuItems (whose keys are 
         * specified in the preferences) into the DOM object with id targetId.
         * 
         * @todo: menuItems should be an array of menuItem objects of the form {'key':key, 'value':value} so that order can be preserved
         * 
         * @param targetId string
         * 
         * @return undefined
         */
    
        render: function(targetId){
            var i, items, processed, filtered;
            var target = document.getElementById(targetId);
            if (target === null) {
                return;
            }
        
            var result = '';
            var keys = getPrefsLists();

            if (keys===null) {
                keys={};
                keys.items = [];
                for (i=0; i<menuItems.length; i++) {
                    keys.items.push({
                        key:menuItems[i].key,
                        on:1
                    });
                    result += menuItems[i].value;
                }
                if (mwf.standard.preferences.isSupported()) {
                    mwf.standard.preferences.set(prefsKey, JSON.stringify(keys));
                }
            } else {
                // Render items in the correct order
                items = keys.items || [];

                processed=[];
                for (i=0; i<items.length; i++) {
                    if (items[i].hasOwnProperty('key')) {
                        processed.push(items[i].key);

// @todo: refactor for DRY
                        if (items[i].hasOwnProperty('on')) {
                            if (items[i].on === 1) {
                                filtered = menuItems.filter(function(element, index, array){
                                    return element.key === this.key;
                                }, items[i]);
                                if (filtered.length > 0) {
                                    result += filtered[0].value;
                                }
                            } else if (items[i].on === 0) {
                                filtered = disabledMenuItems.filter(function(element, index, array){
                                    return element.key === this.key;
                                }, items[i]);
                                if (filtered.length > 0) {
                                    result += filtered[0].value;
                                }
                            }
                        }
                    }
                }
                
                for (i=0; i<menuItems.length; i++) {
                    if (processed.indexOf(menuItems[i].key)==-1) {
                        result += menuItems[i].value;
                        keys.items.push({
                            key:menuItems[i].key,
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
         * Add an item to the end of the list of menu possibilities.
         * 
         * @param key string
         * @param enabledMarkup string
         * @param disabledMarkup string
         */
        addItem: function(key, enabledMarkup, disabledMarkup) {
            key = parseInt(key, 10);
            menuItems.push({
                key: key, 
                value: enabledMarkup || ''
            });
            disabledMenuItems.push({
                key: key, 
                value: disabledMarkup || ''
            });
        },
    
        /**
         * Enables or disables an item in the menu.
         * 
         * @param itemId string|int Corresponds to array key in ini file for menu.
         * @param enable boolean If true, enable item. Otherwise, disable.
         */
        enableItem: function(itemId, enable) {
            itemId = parseInt(itemId, 10);
            var i, add, on, found;
            var keys = getPrefsLists();
            
            on = enable ? 1 : 0;
            
            add = {
                key:itemId,
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
                if (keys.items[i].hasOwnProperty('key') && keys.items[i].key === itemId) {
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
         * @param position integer
         * 
         */
        setItemPosition: function(itemId, position) {
            itemId = parseInt(itemId, 10);
            var keys = getPrefsLists() || {};
            if (! keys.hasOwnProperty('items')) {
                keys.items = [];
            }
            keys.items[position - 1] = {
                key:itemId,
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
