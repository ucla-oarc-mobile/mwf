/**
 * Unit tests for mwf.standard.layoutPreferences
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111018
 *
 * @requires mwf
 * @requires mwf.standard.layoutPreferences
 * @requires qunit
 * 
 */

module("standard/layout_preferences.js"); 
            
test("mwf.standard.layoutPreferences.isSupported()", function()
{
    equal(mwf.standard.layoutPreferences.isSupported(), true, "isSupported() should return true for modern browsers");
});
