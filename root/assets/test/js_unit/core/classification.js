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

test("mwf.classification.generateCookieContent()", function()
{   
    var re = /^\{\"mobile\":(true|false),\"basic\":(true|false),\"standard\":(true|false),\"full\":(true|false)\}$/;
    var cookie = mwf.classification.generateCookieContent();
    ok(re.exec(cookie), 'cookie should be in expected format');
});