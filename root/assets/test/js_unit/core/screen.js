/**
 * Unit tests for mwf.screen
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
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
    var os = mwf.userAgent.getOS();
    var osVersion = mwf.userAgent.getOSVersion();
    if (os=='android' && (osVersion.indexOf('2.2') == 0 || osVersion.indexOf('2.3') == 0)) {
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
    var os = mwf.userAgent.getOS();
    var osVersion = mwf.userAgent.getOSVersion();
    if (os=='android' && (osVersion.indexOf('2.2') == 0 || osVersion.indexOf('2.3') == 0)) {
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

test("mwf.screen.generateCookieContent()", function()
{   
    var re = /^\{\"h\":\"([0-9]+|false)\",\"w\":\"([0-9]+|false)\",\"r\":\"[0-9]+(\.[0-9]+)?\"\}$/;
    var cookie = mwf.screen.generateCookieContent();
    ok(re.exec(cookie), 'cookie should be in expected format');
});
