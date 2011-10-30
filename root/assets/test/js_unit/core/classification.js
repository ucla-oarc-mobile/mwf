/**
 * Unit tests for mwf.browser
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111016
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

test("mwf.classification.isPreview()", function()
{
    equal(typeof mwf.classification.isPreview(),'boolean','isPreview() should return a boolean');
});

test("mwf.classification.get()", function()
{
    var get = mwf.classification.get();
    var acceptableValues = ['full','standard','basic'];
    ok(acceptableValues.indexOf(get) > -1, 'get() sould return "full", "standard" or "basic": ' + get);
})