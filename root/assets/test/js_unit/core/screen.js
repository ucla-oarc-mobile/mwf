/**
 * Unit tests for mwf.screen
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111016
 *
 * @requires mwf
 * @requires mwf.screen
 * @requires mwf.userAgent
 * @requires qunit
 * 
 */

module("core/screen.js"); 
            
test("mwf.screen.getWidth()", function()
{
    expect(2); 
    var width = mwf.screen.getWidth();
    if (mwf.userAgent.getOS()=='android' && (version.indexOf('2.2') == 0 || version.indexOf('2.3') == 0)) {
        equal(typeof width,'boolean','Android 2.2/2.3 should return Boolean false')
        equal(width,false,'Android 2.2/2.3 cannot reliably report width')
    } else {
        equal(typeof width,'number','width should be a number');
        ok(width % 1 === 0 && width > 0, 'width should be a positive integer: ' + width);
    }
});

test("mwf.screen.getHeight()", function()
{
    expect(2); 
    var height = mwf.screen.getHeight();
    if (mwf.userAgent.getOS()=='android' && (version.indexOf('2.2') == 0 || version.indexOf('2.3') == 0)) {
        equal(typeof height,'boolean','Android 2.2/2.3 should return Boolean false')
        equal(height,false,'Android 2.2/2.3 cannot reliably report height')
    } else {
        equal(typeof height,'number','height should be a number');
        ok(height % 1 === 0 && height > 0, 'height should be a positive integer: ' + height);
    }
});

test("mwf.screen.getPixelRatio()", function()
{
    expect(2);
    var pixelRatio = mwf.screen.getPixelRatio();
    equal(typeof pixelRatio, 'number', 'pixel ratio should be a number');
    ok(pixelRatio > 0, 'pixelRatio should be positive: ' + pixelRatio);
})