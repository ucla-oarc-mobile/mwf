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
        '<ol><li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li></ol>',
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
        '<ol><li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li></ol>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu.render() has settings, object passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','["b"]');
    
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
        '<ol><li><a href="bar">Bar</a></li></ol>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});


test("mwf.full.configurableMenu.render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','[0,2]');
    
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        ["<li><a href=\"foo\">Foo<\/a><\/li>","<li><a href=\"bar\">Bar<\/a><\/li>","<li><a href=\"whoa\">Whoa<\/a><\/li>"]
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<ol><li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li></ol>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurable.render() mangled settings, graceful handling", function()
{
    expect(1);
    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','["a]');
    
    mwf.full.configurableMenu.render(
        "fake_main_menu",
        "homescreen_layout",
        ["a","b","c"]
    );
        
    ok(true,"No error thrown");
    
});