/**
 * Unit tests for mwf.browser
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
 *
 * @requires mwf
 * @requires mwf.browser
 * @requires qunit
 * 
 */

module("core/browser.js"); 
            
test("mwf.browser.getWidth()", function()
{
    expect(1); 
    var width = mwf.browser.getWidth();
    
    var isNull = typeof width === 'null';
    var isPosInt = typeof width === 'number' && width % 1 === 0 && width > 0;
    
    ok(isNull || isPosInt, 'mwf.browser.getWidth() should return positive integer or null: ' + width);
});

test("mwf.browser.getHeight()", function()
{
    expect(1); 
    var height = mwf.browser.getHeight();
    
    var isNull = typeof height === 'null';
    var isPosInt = typeof height === 'number' && height % 1 === 0 && height > 0;
    
    ok(isNull || isPosInt, 'mwf.browser.getHeight() should return positive integer or null: ' + height);
});

test("mwf.browser.posLeft()", function()
{
    expect(2); 
    var posLeft = mwf.browser.posLeft();
    
    equal(typeof posLeft, 'number', 'posLeft should be a number');
    equal(posLeft % 1, 0, 'posLeft should be an integer');
});

test("mwf.browser.posTop()", function()
{
    expect(2); 
    var posTop = mwf.browser.posTop();
    
    equal(typeof posTop, 'number', 'posTop should be a number');
    equal(posTop % 1, 0, 'posTop should be an integer');
});

test("mwf.browser.posRight()", function()
{
    expect(2); 
    var posRight = mwf.browser.posRight();
    
    equal(typeof posRight, 'number', 'posRight should be a number');
    equal(posRight % 1, 0, 'posRight should be an integer');
});

test("mwf.browser.posBottom()", function()
{
    expect(2); 
    var posBottom = mwf.browser.posBottom();
    
    equal(typeof posBottom, 'number', 'posBottom should be a number');
    equal(posBottom % 1, 0, 'posBottom should be an integer');
});

test("mwf.browser.pageWidth() DEPRECATED", function()
{
    expect(1);
    equal(mwf.browser.pageWidth(), mwf.browser.getWidth(), "pageWidth() should equal getWidth()");
})

test("mwf.browser.pageHeight() DEPRECATED", function()
{
    expect(1);
    equal(mwf.browser.pageHeight(), mwf.browser.getHeight(), "pageHeight() should equal getHeight()");
})

test("mwf.browser.isQuirksMode()", function()
{
    equal(typeof mwf.browser.isQuirksMode(), "boolean", "isQuirks() should return boolean");
})

test("mwf.browser.isStandardsMode()", function()
{
    equal(typeof mwf.browser.isStandardsMode(), "boolean", "isStandards() should return boolean");
})

test("mwf.browser.getMode()", function()
{
    var mode = mwf.browser.getMode();
    ok((mode=="quirks" || mode=="standards"), "getMode() should return 'quirks' or 'standards'");
})