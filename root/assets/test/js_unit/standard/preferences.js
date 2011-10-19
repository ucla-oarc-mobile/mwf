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

module("standard/preferences.js"); 

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

test("mwf.standard,preferences.clearAll()", function()
{
    mwf.standard.preferences.set("test", "a temporary value");
    mwf.standard.preferences.clearAll();
    equal(mwf.standard.preferences.get("test"), null, "clearAll() erases previous values");
})

test("mwf.standard.preferences.clear()", function()
{
    mwf.standard.preferences.set("test", "just another temporary value from LA");
    mwf.standard.preferences.clear("test");
    equal(mwf.standard.preferences.get("test"), null, "clear() erases previous value");
})