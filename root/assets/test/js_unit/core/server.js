/**
 * Unit tests for mwf.server
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120415
 *
 * @requires mwf
 * @requires qunit
 * 
 */

module("core/server.js"); 

test("mwf.server.init() not same origin, redirects if cookie not set", function()
{
    window.test_result = false;
    var saveIsSameOrigin = mwf.site.local.isSameOrigin;
    mwf.site.local.isSameOrigin = function() {
        return false;
    }
    
    var saveExists = mwf.site.cookie.exists;
    mwf.site.cookie.exists = function(cookieName) {
        return cookieName != mwf.screen.cookieName;
    }
    
    var saveRedirect = mwf.site.redirect;
    mwf.site.redirect = function() {
        window.test_result = true;
    }
    
    mwf.server.init();
    ok(window.test_result,'if not same origin, setting cookie should result in redirect');

    mwf.site.local.isSameOrigin = saveIsSameOrigin;
    mwf.site.cookie.exists = saveExists;
    mwf.site.redirect = saveRedirect;
    delete window.test_result;
});

test("mwf.server.init() same origin sets cookies", function()
{
    var saveIsSameOrigin = mwf.site.local.isSameOrigin;
    mwf.site.local.isSameOrigin = function() {
        return true;
    }
    
    var saveClassification = mwf.classification.generateCookieContent;
    var saveUserAgent = mwf.userAgent.generateCookieContent;
    var saveScreen = mwf.screen.generateCookieContent;
    
    mwf.classification.generateCookieContent = function() {
        return "a=b"
    };
    mwf.userAgent.generateCookieContent = function() {
        return "c=d"
    };
    mwf.screen.generateCookieContent = function() {
        return "e=f"
    };
    
    var saveRedirect = mwf.site.redirect;
    mwf.site.redirect=function() {
        return;
    };
    
    var saveCookieExists = mwf.site.cookie.exists;
    mwf.site.cookie.exists=function() {
        return false;
    }
    
    mwf.server.mustReload=false;
    mwf.server.mustRedirect=false;
    
    mwf.server.init();
    ok(/classification=a%3Db/i.test(document.cookie), 
        'classification cookie should be set and values encoded');
    ok(/user_agent=c%3Dd/i.test(document.cookie), 
        'user_agend cookie should be set and values encoded');
    ok(/screen=e%3Df/i.test(document.cookie), 
        'screen cookie should be set and values encoded');
    
    mwf.site.cookie.exists = saveCookieExists;
    mwf.site.redirect = saveRedirect;
    mwf.screen.generateCookieContent = saveScreen;
    mwf.userAgent.generateCookieContent = saveUserAgent;
    mwf.classification.generateCookieContent = saveClassification;
    mwf.site.local.isSameOrigin = saveIsSameOrigin;   
})

test("mwf.server.init() different origin redirects", function()
{
    var saveIsSameOrigin = mwf.site.local.isSameOrigin;
    mwf.site.local.isSameOrigin = function() {
        return false;
    }
    
    var saveClassification = mwf.classification.generateCookieContent;
    var saveUserAgent = mwf.userAgent.generateCookieContent;
    var saveScreen = mwf.screen.generateCookieContent;
    
    mwf.classification.generateCookieContent = function() {
        return "a=b"
    };
    mwf.userAgent.generateCookieContent = function() {
        return "c=d"
    };
    mwf.screen.generateCookieContent = function() {
        return "e=f"
    };
    
    var saveReload = mwf.site.reload;
    mwf.site.reload=function() {
        ok(false,"Different origin should redirect, not reload");
        start();
    }
    
    var saveRedirect = mwf.site.redirect;
    mwf.site.redirect=function() {
        ok(true,'Different origin should redirect');
        start();
    };
    
    var saveCookieExists = mwf.site.cookie.exists;
    mwf.site.cookie.exists=function() {
        return false;
    }
    
    mwf.server.mustReload=false;
    mwf.server.mustRedirect=false;
    
    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    
    mwf.server.init();
    
    mwf.site.cookie.exists = saveCookieExists;
    mwf.site.redirect = saveRedirect;
    mwf.site.reload = saveReload;
    mwf.screen.generateCookieContent = saveScreen;
    mwf.userAgent.generateCookieContent = saveUserAgent;
    mwf.classification.generateCookieContent = saveClassification;
    mwf.site.local.isSameOrigin = saveIsSameOrigin;   
})

test("mwf.server.init() no cookie capability, no redirect or reload", function()
{
    var saveCookie = mwf.capability.cookie;
    mwf.capability.cookie = function() {
        return false;
    }
    
    mwf.server.mustReload=false;
    mwf.server.mustRedirect=false;
    
    mwf.server.init();
    
    equal(mwf.server.mustReload,false,'mustReload should not change if no cookie capability');
    equal(mwf.server.mustRedirect,false,'mustRedirect should not change if no cookie capability');
    
    mwf.capability.cookie = saveCookie;
})