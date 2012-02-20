/**
 * Unit tests for mwf.full.configurableMenu
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120218
 *
 * @requires mwf
 * @requires mwf.full.configurableMenu
 * @requires mwf.standard.preferences
 * @requires qunit
 * 
 */

module("full/configurableMenu.js", {
    setup: function() {
        var target = document.createElement('div');
        target.setAttribute('id',"fake_main_menu");
        target.setAttribute('style',"display:none");
        document.body.appendChild(target);
    },
    teardown: function() {
        var target = document.getElementById('fake_main_menu');
        if (target) 
            target.parentNode.removeChild(target);
    }
});

test("mwf.full.configurableMenu.render() no settings, object passed, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
        
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        {
            "a":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "b":"<li><a href=\"foo\">Foo<\/a><\/li>"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});


test("mwf.full.configurableMenu.render() no settings, array passed, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
        
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        ["<li><a href=\"foo\">Foo<\/a><\/li>","<li><a href=\"foo\">Foo<\/a><\/li>"]
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu.render() has settings, object passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":["b"],"off":["a","c"]}');
    
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        {
            "a":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "b":"<li><a href=\"bar\">Bar<\/a><\/li>",
            "c":"<li><a href=\"baz\">Baz<\/a><\/li>"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="bar">Bar</a></li>',
        'Prefs set to print just the middle item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});


test("mwf.full.configurableMenu.render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[0,2],"off":[1]}');
    
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        ["<li><a href=\"foo\">Foo<\/a><\/li>","<li><a href=\"bar\">Bar<\/a><\/li>","<li><a href=\"whoa\">Whoa<\/a><\/li>"]
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li>',
        'Prefs set to print first and last menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurable.render() mangled settings, graceful handling", function()
{
    var result = true;
    expect(1);
    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','["a]');
    
    try {
        mwf.full.configurableMenu.render(
            "fake_main_menu",
            "homescreen_layout",
            ["a","b","c"]
            );
    } catch (e) {
        result = false;
    } finally {
        if (oldValue != null) {
            mwf.standard.preferences.set('homescreen_layout',oldValue);
        }
    }
        
    ok(result,"Exception should handled");

});

test("mwf.full.configurableMenu.render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[0,1],"off":[2]}');
    
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        {"0":"<li><a href=\"foo\">Foo<\/a><\/li>",
         "2":"<li><a href=\"whoa\">Whoa<\/a><\/li>",
         "3":"<li><a href=\"baz\">Baz<\/a><\/li>"}
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="baz">Baz</a></li>',
        'Prefs set, should print items from "on" followed by unlisted items and not items from "off"');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});