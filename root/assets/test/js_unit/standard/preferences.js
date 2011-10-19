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
    equal(typeof mwf.standard.preferences.get('test'), 'string', 'get() should return a string');
})

test("mwf.standard.preferences.set()", function()
{
    mwf.standard.preferences.set('test', 'a test value');
    equal(mwf.standard.preferences.get('test'), 'a test value', 'set() can change the setting');
});

test("mwf.standard,preferences.reset()", function()
{
    mwf.standard.preferences.set("test", "a temporary value");
    mwf.standard.preferences.reset();
    equal(mwf.standard.preferences.get("test"), "", "reset() erases previous values");
})