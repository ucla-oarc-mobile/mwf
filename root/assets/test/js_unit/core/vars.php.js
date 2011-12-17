/**
 * Unit tests for JS loaded via vars.php
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
 *
 * @requires mwf
 * @requires mwf.site
 * @requires qunit
 * 
 */

module("core/vars.php"); 
            
test("mwf.site.root", function()
{
    var root = mwf.site.root;
    ok(root, "mwf.site.root is " + root);
});

test("mwf.site.asset.root", function()
{
    var root = mwf.site.asset.root;
    ok(root, "mwf.site.asset.root is " + root);
});
            
test("mwf.site.cookie.prefix", function()
{
    var prefix = mwf.site.cookie.prefix;
    ok(prefix, "mwf.site.cookie.prefix is " + prefix);
})

test("mwf.site.cookie.domain", function()
{
    var domain = mwf.site.cookie.domain;
    ok(typeof domain == 'string' || typeof domain == 'boolean',
        "cookie domain should be string or boolean");
})

test("mwf.site.cookie.exists()", function()
{
    equal(mwf.site.cookie.exists('this_cookie_should_not_exist'), false,
        'totally wacky cookie should not exist');
    //@todo: write a cookie and then confirm that exists() can find it
})

test("mwf.site.cookie.override()", function()
{
    //@todo: minimal unit test for override()
})

test("mwf.site.cookie.classification()", function()
{
    //@todo: minimal unit test for classification()
})

test("mwf.site.analytics.key", function()
{
    var key = mwf.site.analytics.key;
    ok(key===null ? true : key, "mwf.site.analytics.key should return either null or a non-false value.");
})

test("mwf.site.mobile", function()
{
    var maxWidth = mwf.site.mobile.maxWidth;
    var maxHeight = mwf.site.mobile.maxHeight;
    equal(typeof maxWidth, 'number', 'maxWidth should be a number');
    equal(typeof maxHeight, 'number', 'maxHeight should be a number');
    equal(maxWidth % 1, 0, 'maxWidth should be an integer');
    equal(maxHeight % 1, 0, 'maxHeight should be an integer');
})

test("mwf.site.local.domain()", function()
{
    //@todo: minimal test for domain()
})

test("mwf.site.local.isSameOrigin()", function()
{
    var isSameOrigin = mwf.site.local.isSameOrigin();
    equal(typeof isSameOrigin, 'boolean', 'isSameOrigin() should return a boolean');
})

test("mwf.site.local.cookie.exists()", function()
{
    //@todo: minimal test for local.cookie.exists()
})

test("mwf.site.local.cookie.value()", function()
{
    //@todo: minimal test for local.cookie.value()
})

test("mwf.site.domain DEPRECATED", function()  
{  
    var domain = mwf.site.domain();
    ok(domain, "mwf.site.domain() returned " + domain);
});
                        
test("mwf.site.webroot DEPRECATED", function() 
{
    var webroot = mwf.site.webroot();
    ok(webroot, "mwf.site.webroot() returned " + webroot);
});

test("mwf.site.frontpage DEPRECATED", function()
{
    var frontpage = mwf.site.frontpage();
    ok(frontpage, "mwf.site.frontpage() returned " + frontpage);
});

test("mwf.site.webassetroot DEPRECATED", function()
{
    var webassetroot = mwf.site.webassetroot();
    ok(webassetroot, "mwf.site.webassetroot() returned " + webassetroot);
});