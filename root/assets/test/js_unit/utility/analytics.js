/**
 * Unit tests for mwf.site.analytics
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120208
 *
 * @requires mwf
 * @requires mwf.site.analytics
 * @requires qunit
 * 
 */

module("utility/analytics.js", {
    setup: function() {
         this._gaq_orig = _gaq;
         _gaq = [];
         this.key_orig = mwf.site.analytics.key;
         this.pathKeys_orig = mwf.site.analytics.pathKeys;
    },
    teardown: function() {
        _gaq = this._gaq_orig;
        mwf.site.analytics.key = this.key_orig;
        mwf.site.analytics.pathKeys = this.pathKeys_orig
    }
}); 

test("mwf.site.analytics.pathKeys is in expected format", function()
{
    // Use the var stashed by setup()
    var pathKeys = this.pathKeys_orig;
    ok(pathKeys instanceof Array, "pathKeys should be an array");
    for (var i=0; i<pathKeys.length; i++) {
        ok(pathKeys[i] instanceof Object, "pathKeys elements should be objects");
        if (pathKeys[i].hasOwnProperty('a')) {
            ok(typeof pathKeys[i].a == "string", "pathKeys 'a' property should be a string");
        } else {
            ok(false,"pathKeys elements should have 'a' (account) property")
        }
        if (pathKeys[i].hasOwnProperty('s')) {
            ok(typeof pathKeys[i].s == "string", "pathKeys 's' property should be a string");
        } else {
            ok(false,"pathKeys elements should have 's' (account) property")
        }
    }
})

test("mwf.site.analytics.key is in expected format", function()
{
    // Use the var stashed by setup()
    var key = this.key_orig;
    ok(typeof key == "string" || key === null, "key should be a string or null");
})

test("mwf.site.analytics.trackPageview() no keys", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [];
    mwf.site.analytics.trackPageview("/foo.html");
    same(_gaq, [], "no reporting should occur if keys are not set");
});

test("mwf.site.analytics.trackPageview() global key only", function()
{
    mwf.site.analytics.key = "UA-XXXXXX-X";
    mwf.site.analytics.pathKeys = [];
    mwf.site.analytics.trackPageview("/foo.html");
    same(_gaq, 
        [["_trackPageview", "/foo.html"]], 
        "reporting should occur if global key is set");
})

test("mwf.site.analytics.trackPageview() path key only, no match", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"}];
    mwf.site.analytics.trackPageview("/bar.html");
        same(_gaq, 
        [], 
        "no reporting should occur if path key is set but path does not match");
})

test("mwf.site.analytics.trackPageview() path key only, match", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"}];
    mwf.site.analytics.trackPageview("/foo/bar.html");
        same(_gaq, 
        [["t0._trackPageview", "/foo/bar.html"]], 
        "reporting should occur if path key is set and path matches");
})

test("mwf.site.analytics.trackPageview() global and path keys, no path match", function()
{
mwf.site.analytics.key = "UA-XXXXXX-X";
mwf.site.analytics.pathKeys = [{a:"UA-YYYYYY-Y", s:"/foo/"}];
    mwf.site.analytics.trackPageview("/bar/baz.html");
        same(_gaq, 
        [["_trackPageview", "/bar/baz.html"]], 
        "reporting should occur for global key only");
})

test("mwf.site.analytics.trackPageview() global and path keys, path match", function()
{
mwf.site.analytics.key = "UA-XXXXXX-X";
mwf.site.analytics.pathKeys = [{a:"UA-YYYYYY-Y", s:"/bar/"}];
    mwf.site.analytics.trackPageview("/bar/baz.html");
        same(_gaq, 
        [["_trackPageview", "/bar/baz.html"],["t0._trackPageview", "/bar/baz.html"]], 
        "reporting should occur if for both keys");
})

test("mwf.site.analytics.trackPageview(), no global key, multiple path keys with no match", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"},{a:"UA-ZZZZZZ-Z", s:"/bar/"}];
    mwf.site.analytics.trackPageview("/bar.html");
        same(_gaq, 
        [], 
        "no reporting should occur");
})

test("mwf.site.analytics.trackPageview(), global key, multiple path keys with no match", function()
{
    mwf.site.analytics.key = "UA-YYYYYY-Y";
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"},{a:"UA-ZZZZZZ-Z", s:"/bar/"}];
    mwf.site.analytics.trackPageview("/bar.html");
        same(_gaq, 
        [["_trackPageview", "/bar.html"]], 
        "reporting should occur for global key only");
})

test("mwf.site.analytics.trackPageview(), no global key, multiple path keys with single match", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"},{a:"UA-ZZZZZZ-Z", s:"/bar/"}];
    mwf.site.analytics.trackPageview("/foo/bar.html");
        same(_gaq, 
        [["t0._trackPageview", "/foo/bar.html"]], 
        "reporting should occur only for matching key");
})

test("mwf.site.analytics.trackPageview(), global key, multiple path keys with single match", function()
{
    mwf.site.analytics.key = "UA-YYYYYY-Y";
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/"},{a:"UA-ZZZZZZ-Z", s:"/bar/"}];
    mwf.site.analytics.trackPageview("/foo/bar.html");
        same(_gaq, 
        [["_trackPageview", "/foo/bar.html"],["t0._trackPageview", "/foo/bar.html"]], 
        "reporting should occur only for global key and matching key");
})

test("mwf.site.analytics.trackPageview(), no global key, multiple path keys with multiple matches", function()
{
    mwf.site.analytics.key = null;
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/bar/"},{a:"UA-ZZZZZZ-Z", s:"/foo/"}];
    mwf.site.analytics.trackPageview("/foo/bar/baz.html");
        same(_gaq, 
        [["t0._trackPageview", "/foo/bar/baz.html"],["t1._trackPageview", "/foo/bar/baz.html"]], 
        "reporting should occur for multiple matching keys");
})

test("mwf.site.analytics.trackPageview(), global key, multiple path keys with multiple matches", function()
{
    mwf.site.analytics.key = "UA-YYYYYY-Y";
    mwf.site.analytics.pathKeys = [{a:"UA-XXXXXX-X", s:"/foo/bar/"},{a:"UA-ZZZZZZ-Z", s:"/foo/"},{a:"UA-AAAAAA-A", s:"/whatever/"}];
    mwf.site.analytics.trackPageview("/foo/bar/baz.html");
        same(_gaq, 
        [["_trackPageview", "/foo/bar/baz.html"], ["t0._trackPageview", "/foo/bar/baz.html"], ["t1._trackPageview", "/foo/bar/baz.html"]], 
        "reporting should occur for global key and multiple matching keys");
})