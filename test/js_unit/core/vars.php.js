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
    expect(1);
    var root = mwf.site.root;
    ok(root, "mwf.site.root is " + root);
});

test("mwf.site.asset.root", function()
{
    expect(1);
    var root = mwf.site.asset.root;
    ok(root, "mwf.site.asset.root is " + root);
});
            
test("mwf.site.cookie.prefix", function()
{
    expect(1);
    var prefix = mwf.site.cookie.prefix;
    ok(prefix, "mwf.site.cookie.prefix is " + prefix);
})

test("mwf.site.analytics.key", function()
{
    expect(1);
    var key = mwf.site.analytics.key;
    ok(key===null ? true : key, "mwf.site.analytics.key should return either null or a non-false value.");
})

test("mwf.site.mobile", function()
{
    expect(4);
    var maxWidth = mwf.site.mobile.maxWidth;
    var maxHeight = mwf.site.mobile.maxHeight;
    equal(typeof maxWidth, 'number', 'maxWidth should be a number');
    equal(typeof maxHeight, 'number', 'maxHeight should be a number');
    equal(maxWidth % 1, 0, 'maxWidth should be an integer');
    equal(maxHeight % 1, 0, 'maxHeight should be an integer');
})


test("mwf.site.domain", function()  
{  
    expect(1);
    var domain = mwf.site.domain();
    ok(domain, "mwf.site.domain() returned " + domain);
});
                        
test("mwf.site.webroot DEPRECATED", function() 
{
    expect(1);
    var webroot = mwf.site.webroot();
    ok(webroot, "mwf.site.webroot() returned " + webroot);
});

test("mwf.site.frontpage DEPRECATED", function()
{
    expect(1);
    var frontpage = mwf.site.frontpage();
    ok(frontpage, "mwf.site.frontpage() returned " + frontpage);
});

test("mwf.site.webassetroot DEPRECATED", function()
{
    expect(1);
    var webassetroot = mwf.site.webassetroot();
    ok(webassetroot, "mwf.site.webassetroot() returned " + webassetroot);
});