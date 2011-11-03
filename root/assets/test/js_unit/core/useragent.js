/**
 * Unit tests for mwf.userAgent
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
 *
 * @requires mwf
 * @requires mwf.userAgent
 * @requires qunit
 * 
 */

module("core/useragent.js"); 
            
test("mwf.userAgent.getOS()", function()
{
    var os = mwf.userAgent.getOS();
    
    ok(typeof os === 'string','getOS() should return a string');
    
    var expected_results = ['iphone_os', 'android','blackberry','windows phone os','windows mobile',
        'symbian','webos','mac os x','windows nt','linux', ''];
    
    ok(expected_results.indexOf(os) > -1, 'getOS() should be expected value: ' + os);
});

test("mwf.userAgent.getOSVersion()", function()
{
    var osVersion = mwf.userAgent.getOSVersion();
    
    ok(typeof osVersion === 'string','getOSVersion() should return a string');
});

test("mwf.userAgent.getBrowser()", function()
{
    var browser = mwf.userAgent.getBrowser();
    
    ok(typeof browser === 'string','getBrowser() should return a string');
    
    var expected_results = ['android_webkit', 'safari', 'chrome', 'iemobile', 'camino', 
        'seamonkey', 'firefox', 'opera_mobi', 'opera_mini', ''];
    
    ok(expected_results.indexOf(browser) > -1, 'getBrowser() should be expected value: ' + browser);
});

test("mwf.userAgent.getBrowserEngine()", function()
{
    var browserEngine = mwf.userAgent.getBrowserEngine();
    
    ok(typeof browserEngine === 'string','getBrowserEngine() should return a string');
    
    var expected_results = ['webkit', 'trident', 'gecko', 'presto', 'khtml', ''];
    
    ok(expected_results.indexOf(browserEngine) > -1, 'getBrowserEngine() should be expected value: ' + browserEngine);
    
    var saveNavigator = navigator;
    navigator = new Object();
    navigator.__proto__ = saveNavigator;
    Object.defineProperty(navigator, 'userAgent', { get: function() { return "unknown user agent"; }});
    var newUserAgent = new mwf.userAgent.constructor;
    var newBrowserEngine = newUserAgent.getBrowserEngine();

    strictEqual(newBrowserEngine, '', 'Unknown user agent should result in empty browserEngine: ' + newBrowserEngine);

    navigator = saveNavigator;
});

test("mwf.userAgent.getBrowserEngineVersion()", function()
{
    var browserEngineVersion = mwf.userAgent.getBrowserEngineVersion();
    
    ok(typeof browserEngineVersion === 'string','getBrowserEngineVersion() should return a string');
});

test("mwf.userAgent.generateCookieContent()", function()
{   
    var re = /^\{\"s\":\".*\",\"os\":\".*\",\"osv\":\".*",\"b\":\".*\",\"be\":\".*\",\"bev\":\".*\"\}$/;
    var cookie = mwf.userAgent.generateCookieContent();
    ok(re.exec(cookie), 'cookie should be in expected format');
});