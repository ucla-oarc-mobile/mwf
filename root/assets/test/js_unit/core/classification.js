/**
 * Unit tests for mwf.browser
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
 *
 * @requires mwf
 * @requires mwf.classification
 * @requires qunit
 * 
 */

module("core/classification.js"); 
            
test("mwf.classification.isMobile()", function()
{
    equal(typeof mwf.classification.isMobile(),'boolean','isMobile() should return a boolean');
});

test("mwf.classification.isBasic()", function()
{
    equal(typeof mwf.classification.isBasic(),'boolean','isBasic() should return a boolean');
});

test("mwf.classification.isStandard()", function()
{
    equal(typeof mwf.classification.isStandard(),'boolean','isStandard() should return a boolean');
});

test("mwf.classification.isFull()", function()
{
    equal(typeof mwf.classification.isFull(),'boolean','isFull() should return a boolean');
});

test("mwf.classification.isOverride()", function()
{
    var override = mwf.classification.isOverride();
    equal(typeof override,'boolean','isOverride() should return a boolean');
    equal(override, false, 'isOverride() should return false on a mobile phone');
})

test("mwf.classification.isPreview()", function()
{
    equal(typeof mwf.classification.isPreview(),'boolean','isPreview() should return a boolean');
});

test("mwf.classification.get()", function()
{
    var get = mwf.classification.get();
    var acceptableValues = ['full','standard','basic'];
    ok(acceptableValues.indexOf(get) > -1, 'get() sould return "full", "standard" or "basic": ' + get);
});

test('mwf.classification.get() and isFull() should return "full"', function()
{
    mwf.classification.isFull = function() { return true; };
    equal(mwf.classification.get(), 'full', 'get() should return "full" if isFull() is true');
});

test('mwf.classification.get(), ! isFull(), and isStandard(); should return "standard"', function()
{
    mwf.classification.isFull = function() { return false; };
    mwf.classification.isStandard = function() { return true; };
    equal(mwf.classification.get(), 'standard', 'get() should return "standard" if isFull() is false and isStandard() is true');
});

test('mwf.classificationget(), ! isFull(), and ! isStandard(); should return "basic"', function()
{
    mwf.classification.isFull = function() { return false; };
    mwf.classification.isStandard = function() { return false; };
    equal(mwf.classification.get(), 'basic', 'get() should return "basic" if isFull(0 is false and isStandard() is false');
});

test("mwf.classification.generateCookieContent()", function()
{   
    var re = /^\{\"mobile\":(true|false),\"basic\":(true|false),\"standard\":(true|false),\"full\":(true|false),\"native\":(true|false)\}$/;
    var cookie = mwf.classification.generateCookieContent();
    ok(re.exec(cookie), 'cookie should be in expected format');
});

test("mwf.classification.generateCookieContent() with override", function()
{
   mwf.classification.isOverride = function() { return true; }
   mwf.classification.wasMobile = function() { return false; }
   mwf.classification.wasBasic = function() { return false; }
   mwf.classification.wasStandard = function() { return false; }
   mwf.classification.wasFull = function() { return false; }
   mwf.classification.wasNative = function() { return true; }
   var re = /^\{\"mobile\":(true|false),\"basic\":(true|false),\"standard\":(true|false),\"full\":(true|false),\"native\":(true|false),\"actual\":{\"mobile\":false,\"basic\":false,\"standard\":false,\"full\":false,\"native\":true\}\}$/;
   var cookie = mwf.classification.generateCookieContent();
   ok(re.exec(cookie), 'cookie should be in expected format: ' + cookie);
});

test("mwf.classification.isNative()", function()
{
    equal(mwf.classification.isNative(), false, 'Native should be false, unit tests not accessible from native container');
});