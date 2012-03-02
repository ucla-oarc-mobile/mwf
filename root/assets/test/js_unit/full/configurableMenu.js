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

test("mwf.full.configurableMenu render() no settings, object passed, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    cm.render(
        "fake_main_menu",
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


test("mwf.full.configurableMenu render() no settings, array passed, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
        
    cm.render(
        "fake_main_menu",
        ["<li><a href=\"foo\">Foo<\/a><\/li>","<li><a href=\"foo\">Foo<\/a><\/li>"]
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() has settings, object passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[2],"off":[1,3]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.render(
        "fake_main_menu",
        {
            "1":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "2":"<li><a href=\"bar\">Bar<\/a><\/li>",
            "3":"<li><a href=\"baz\">Baz<\/a><\/li>"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="bar">Bar</a></li>',
        'Prefs set to print just the middle item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});


test("mwf.full.configurableMenu render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[0,2],"off":[1]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.render(
        "fake_main_menu",
        ["<li><a href=\"foo\">Foo<\/a><\/li>","<li><a href=\"bar\">Bar<\/a><\/li>","<li><a href=\"whoa\">Whoa<\/a><\/li>"]
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li>',
        'Prefs set to print first and last menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() mangled settings, graceful handling", function()
{
    var result = true;
    expect(1);
    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','["a]');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    try {
        cm.render(
            "fake_main_menu",
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

test("mwf.full.configurableMenu render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[0,1],"off":[2]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.render(
        "fake_main_menu",
        {
            "0":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "2":"<li><a href=\"whoa\">Whoa<\/a><\/li>",
            "3":"<li><a href=\"baz\">Baz<\/a><\/li>"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="baz">Baz</a></li>',
        'Prefs set, should print items from "on" followed by unlisted items and not items from "off"');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() has settings, array passed", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[0,1],"off":[2]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.render(
        "fake_main_menu",
        {
            "0":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "2":"<li><a href=\"whoa\">Whoa<\/a><\/li>",
            "3":"<li><a href=\"baz\">Baz<\/a><\/li>"
        },

        {
            "2":"<li>No dice!</li>"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="baz">Baz</a></li><li>No dice!</li>',
        'Prefs set, disabled options sent, should print items from "on" followed by unlisted items and finally disabled items from "off"');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu set() enable new item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(7,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2,3,7],
        "off":[4,5,6]
    };
    deepEqual(newPrefs, expectedPrefs, "should add new item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu set() disable new item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(7,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2,3],
        "off":[4,5,6,7]
    };
    deepEqual(newPrefs, expectedPrefs, "should add new item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu set() enable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(4,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2,3,4],
        "off":[5,6]
    };
    deepEqual(newPrefs, expectedPrefs, "should move disabled item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu set() disable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(3,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2],
        "off":[4,5,6,3]
    };
    deepEqual(newPrefs, expectedPrefs, "should move enabled item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu set() enable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(3,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2,3],
        "off":[4,5,6]
    };
    deepEqual(newPrefs, expectedPrefs, "should do nothing with enabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu set() disable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[1,2,3],"off":[4,5,6]}')

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.set(4,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    var expectedPrefs = {
        "on":[1,2,3],
        "off":[4,5,6]
    };
    deepEqual(newPrefs, expectedPrefs, "should do nothing with disabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu render() should not have side effects on passed array", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"off":[],"on":[0]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    var menuItems = ["foo", "bar", "baz"];
    var disabledItems = ["oof", "rab", "zab"];
    cm.render(
        "fake_main_menu",
        menuItems,
        disabledItems
        );
    
    deepEqual(menuItems, ["foo","bar","baz"], "render() should not have side effects on menuItems array");
    deepEqual(disabledItems, ["oof","rab","zab"], "render() should not have side effects on disabledItems array");
    
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
})

test("mwf.full.configurableMenu moveUp() moves item up", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[90,12,14,10]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.moveUp(14);
    
    equal(mwf.standard.preferences.get('homescreen_layout'),'{"on":[90,14,12,10]}');
        
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu moveDown() moves item down", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout','{"on":[90,12,14,10]}');
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.moveDown(14);
    
    equal(mwf.standard.preferences.get('homescreen_layout'),'{"on":[90,12,10,14]}');
        
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() no settings, object passed, sets settings", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
        
    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.render(
        "fake_main_menu",
        ["foo","bar"]
        );
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));

    equal(prefResults.on[0],0,
        'render() should set prefs if they are not already set');
        
    equal(prefResults.on[1],1,
        'render() should set prefs if they are not already set');
    
    equal(prefResults.on.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() some settings, missing items set", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        "on":[1]
    }));
                
    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.render(
        "fake_main_menu",
        ["foo","bar"]
        );
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));

    equal(prefResults.on[0],1,
        'render() should leave set prefs');
        
    equal(prefResults.on[1],0,
        'render() should set prefs if they are not already set');
    
    equal(prefResults.on.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() no settings, object passed, sets settings casting strings to ints", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.clear('homescreen_layout');
        
    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.render(
        "fake_main_menu",
        {
            "0":"foo",
            "1":"bar"
        }
        );
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));

    equal(prefResults.on[0],0,
        'render() should set prefs if they are not already set casting string to int');
        
    strictEqual(prefResults.on[1],1,
        'render() should set prefs if they are not already set casting string to int');
    
    strictEqual(prefResults.on.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() some settings, missing items set casting string to int", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        "on":[1]
    }));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
        
    cm.render(
        "fake_main_menu",
        {
            "0":"foo",
            "1":"bar"
        }
        );
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));

    strictEqual(prefResults.on[0],1,
        'render() should leave set prefs');
        
    strictEqual(prefResults.on[1],0,
        'render() should set prefs if they are not already set');
    
    equal(prefResults.on.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});