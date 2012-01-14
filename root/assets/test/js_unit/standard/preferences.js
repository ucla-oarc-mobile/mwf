/**
 * Unit tests for mwf.standard.preferences
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111018
 *
 * @requires mwf
 * @requires mwf.standard.preferences
 * @requires qunit
 * 
 */

module("standard/preferences.js", {
    setup: function() {
        var len = localStorage.length;
        this.oldItems = {};
        var tempKey;
        for (var i=0; i<len; i++) {
            tempKey = localStorage.key(i);
            this.oldItems[tempKey] = localStorage.getItem(tempKey);
        }
        localStorage.clear();
    },
    teardown: function() {
        localStorage.clear();
        for (var key in this.oldItems)
            localStorage.setItem(key,this.oldItems[key]);
    }
}); 

test("mwf.standard.preferences.isSupported()", function()
{
    equal(mwf.standard.preferences.isSupported(), true, "isSupported() should return true for modern browsers");
});

test("mwf.standard.preferences.get()", function()
{
    var gotten = mwf.standard.preferences.get('test');
    ok(gotten === null || typeof gotten === 'string', "get() returns string or null: " + gotten);
});

test("mwf.standard.preferences.set()", function()
{
    mwf.standard.preferences.set('test', 'a test value');
    equal(mwf.standard.preferences.get('test'), 'a test value', 'set() can change the setting');
});

test("mwf.standard.preferences.clearAll() delete a single item", function()
{
    mwf.standard.preferences.set("test", "a temporary value");
    mwf.standard.preferences.clearAll();
    equal(mwf.standard.preferences.get("test"), null, "clearAll() erased previous value");
});

test("mwf.standard.preferences.clearAll() deletes multiple items", function ()
{
    mwf.standard.preferences.set("test", "a temporary value");
    mwf.standard.preferences.set("another_test", "another temporary value");
    mwf.standard.preferences.clearAll();
    equal(mwf.standard.preferences.get("test"), null, "clearAll() erased first of previous values");
    equal(mwf.standard.preferences.get("another_test"), null, "clearAll() erased second of previous values");
});

test("mwf.standard.preferences.clear()", function()
{   
    mwf.standard.preferences.set("test", "just another temporary value from LA");
    mwf.standard.preferences.clear("test");
    equal(mwf.standard.preferences.get("test"), null, "clear() erases previous value");
});
