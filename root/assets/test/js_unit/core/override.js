/**
 * Unit tests for mwf.useragent
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111017
 *
 * @requires mwf
 * @requires mwf.override
 * @requires mwf.classification
 * @requires qunit
 * 
 */

module("core/override.js"); 

test("mwf.classification.wasFull()", function()
{
    ok(typeof mwf.classification.wasFull === 'undefined' || 
        typeof mwf.classification.wasFull() === 'boolean', 
        'wasFull() should return a Boolean or be undefined');
});

test("mwf.classification.wasStandard()", function()
{
    ok(typeof mwf.classification.wasStandard === 'undefined' || 
        typeof mwf.classification.wasStandard() === 'boolean', 
        'wasStandard() should return a Boolean or be undefined');
});

test("mwf.classification.wasBasic()", function()
{
    ok(typeof mwf.classification.wasBasic === 'undefined' || 
        typeof mwf.classification.wasBasic() === 'boolean', 
        'wasBasic() should return a Boolean or be undefined');
});

test("mwf.classification.wasMobile()", function()
{
    ok(typeof mwf.classification.wasMobile === 'undefined' || 
        typeof mwf.classification.wasMobile() === 'boolean', 
        'wasMobile() should return a Boolean or be undefined');
});