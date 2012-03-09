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

test("mwf.userAgent.getOS() is iphone", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOS(),'iphone_os','should detect iPhone userAgent string');
    navigator = oldNav;
});

test("mwf.userAgent.getOS() unknwon", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'totally crazy user agent!'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOS(), '', 'should return empty string for unknown userAgent string');
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion()", function()
{
    var osVersion = mwf.userAgent.getOSVersion();
    
    ok(typeof osVersion === 'string','getOSVersion() should return a string');
});

test("mwf.userAgent.getOSVersion() for iPhone", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"4.3.3","getOSVersion() should parse iOS 4.3.3 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for Blackberry 7.0", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/5.0 (BlackBerry; U; BlackBerry 9860; en-GB) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.296 Mobile Safari/534.11+'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"7.0.0.296","getOSVersion() should parse Blackberry 7.0.0.296 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for Blackberry 5.0", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'BlackBerry9650/5.0.0.732 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"5.0.0.732","getOSVersion() should parse Blackberry 5.0.0.732 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for Android", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/5.0 (Linux; U; Android 4.0.2; en-us; Galaxy Nexus Build/ICL53F) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"4.0.2","getOSVersion() should parse Android 4.0.2 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for Windows Phone OS", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/4.0 (compatible; MSIE 7.0; Windows Phone OS 7.0; Trident/3.1; IEMobile/7.0; DELL; Venue Pro)'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"7.0","getOSVersion() should parse Windows Phone OS 7.0 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for Symbian OS", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Nokia3650/1.0 SymbianOS/6.1 Series60/1.2 Profile/MIDP-1.0 Configuration/CLDC-1.0'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"6.1","getOSVersion() should parse Symbian OS 6.1 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getOSVersion() for WebOS", function()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Mozilla/5.0 (webOS/1.4.5; U; en-US) AppleWebKit/532.2 (KHTML, like Gecko) Version/1.0 Safari/532.2 Pre/1.0'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getOSVersion(),"1.4.5","getOSVersion() should parse WebOS 1.4.5 userAgent string");
    navigator = oldNav;
});

test("mwf.userAgent.getBrowser()", function()
{
    var browser = mwf.userAgent.getBrowser();
    
    ok(typeof browser === 'string','getBrowser() should return a string');
    
    var expected_results = ['android_webkit', 'safari', 'chrome', 'iemobile', 'camino', 
        'seamonkey', 'firefox', 'opera_mobi', 'opera_mini', ''];
    
    ok(expected_results.indexOf(browser) > -1, 'getBrowser() should be expected value: ' + browser);
});

test("mwf.userAgent.getBrowser() Opera Mini", function ()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'Opera/9.50 (J2ME/MIDP; Opera Mini/4.0.10031/298; U; en)'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getBrowser(),"opera mini","getBrowser() should detect Opera Mini");
    navigator = oldNav;
})

test("mwf.userAgent.getBrowser() unknown browser", function ()
{
    var oldNav = navigator;
    navigator = {
        'userAgent':'NoBrowserYouRecognize/1.00 (J2ME/MIDP; Crazy Browser/4.0.10031/298; U; en)'
    };
    var ua = new mwf.userAgent.constructor();
    equal(ua.getBrowser(),"","getBrowser() should return an empty string for unrecognized browsers");
    navigator = oldNav;
})

test("mwf.userAgent.getBrowserEngine()", function()
{
    var browserEngine = mwf.userAgent.getBrowserEngine();
    
    ok(typeof browserEngine === 'string','getBrowserEngine() should return a string');
    
    var expected_results = ['webkit', 'trident', 'gecko', 'presto', 'khtml', ''];
    
    ok(expected_results.indexOf(browserEngine) > -1, 'getBrowserEngine() should be expected value: ' + browserEngine);   
});

test("mwf.userAgent.getBrowserEngine() unknown userAgent string", function()
{
    var saveNavigator = navigator;
    navigator = new Object();
    navigator.__proto__ = saveNavigator;
    Object.defineProperty(navigator, 'userAgent', {
        get: function() {
            return "Opera/9.80 (J2ME/MIDP; Opera Mini/4.1.15082/22.414; U; en) Presto/2.5.25 Version/10.54";
        }
    });
    var newUserAgent = new mwf.userAgent.constructor;
    var newBrowserEngine = newUserAgent.getBrowserEngine();
    strictEqual(newBrowserEngine, 'presto', 'getBrowserEngine() should detect Presto engine');
    navigator = saveNavigator;
});

test("mwf.userAgent.getBrowserEngine() unknown userAgent string", function()
{
    var saveNavigator = navigator;
    navigator = new Object();
    navigator.__proto__ = saveNavigator;
    Object.defineProperty(navigator, 'userAgent', {
        get: function() {
            return "unknown user agent";
        }
    });
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
    var re = /^\{"s":".*","os":".*",("osv":".*",)?("b":".*",)?"be":".*","bev":".*"\}$/;
    var cookie = mwf.userAgent.generateCookieContent();
    ok(re.exec(cookie), 'cookie should be in expected format: ' + cookie);
});

test("mwf.userAgent.generateCookieContente() iPhone", function()
{
    var saveNavigator = navigator;
    navigator = new Object();
    navigator.__proto__ = saveNavigator;
    Object.defineProperty(navigator, 'userAgent', {
        get: function() {
            return "Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3";
        }
    });
    var newUserAgent = new mwf.userAgent.constructor;
    var cookie = newUserAgent.generateCookieContent();

    strictEqual(cookie, '{"s":"Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3","os":"iphone_os","osv":"5.0.1","b":"safari","be":"webkit","bev":"534.46"}', 
    'iPhone cookie content should be set to correct values');

    navigator = saveNavigator;
})

test("mwf.userAgent.isNative()", function()
{
    equal(mwf.userAgent.isNative(), false, 'Native should be false, unit tests not accessible from native container');

});