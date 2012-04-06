/**
 * Unit tests for mwf.full.configurableMenu
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120310
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
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:1,
            on:0
        },{
            key:2,
            on:1
        },{
            key:3,
            on:0
        }]
    }));
    
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
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:0,
            on:1
        },{
            key:1,
            on:0
        },{
            key:2,
            on:1
        }]
    }));
    
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
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:0,
            on:1
        },{
            key:1,
            on:1
        },{
            key:2,
            on:0
        }]
    }));
    
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
        'Prefs set, should print enabled items followed by unlisted items and not disabled items');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() disabled items sent", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:0,
            on:1
        },{
            key:1,
            on:1
        },{
            key:2,
            on:0
        }]
    }));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.render(
        "fake_main_menu",
        {
            "0":"<li><a href=\"foo\">Foo<\/a><\/li>",
            "1":"<li><a href=\"whoa\">Whoa<\/a><\/li>",
            "2":"<li><a href=\"baz\">Baz<\/a><\/li>"
        },
        {
            "0":"foo disabled",
            "1":"whoa totally disabled",
            "2":"baz has left the building"
        }
        );

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li>baz has left the building',
        'Disabled items sent, should be rendered');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
})

test("mwf.full.configurableMenu enableItem() enable new item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        },
        {
            key:7,
            on:1
        }]
    };
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(7,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    deepEqual(newPrefs, expectedPrefs, "should add new item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu enableItem() disable new item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        },
        {
            key:7,
            on:0
        }]
    };
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(7,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);

    deepEqual(newPrefs, expectedPrefs, "should add new item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu enableItem() enable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:1
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };

    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(4,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    
    deepEqual(newPrefs, expectedPrefs, "should move disabled item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu enableItem() disable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:0
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(3,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
 
    deepEqual(newPrefs, expectedPrefs, "should move enabled item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu enableItem() enable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(3,true);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);
 
    deepEqual(newPrefs, expectedPrefs, "should do nothing with enabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu enableItem() disable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    
    var initialPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    var expectedPrefs = {
        items:[{
            key:1,
            on:1
        },
        {
            key:2,
            on:1
        },
        {
            key:3,
            on:1
        },
        {
            key:4,
            on:0
        },
        {
            key:5,
            on:0
        },
        {
            key:6,
            on:0
        }]
    };
    
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.enableItem(4,false);
    
    var newPrefsString = mwf.standard.preferences.get('homescreen_layout');
    var newPrefs = JSON.parse(newPrefsString);

    deepEqual(newPrefs, expectedPrefs, "should do nothing with disabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
    
});

test("mwf.full.configurableMenu render() should not have side effects on passed array", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:0,
            on:0
        }]
        }));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    var menuItems = ["foo", "bar", "baz"];
    cm.render(
        "fake_main_menu",
        menuItems
        );
    
    deepEqual(menuItems, ["foo","bar","baz"], "render() should not have side effects on menuItems array");
    
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
})

test("mwf.full.configurableMenu setItemPosition() moves item up", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[

        {
            key:90,
            on:1
        },

        {
            key:12,
            on:1
        },

        {
            key:14,
            on:1
        },

        {
            key:10,
            on:1
        }
        ]
    };
    
    var expectedPrefs = {
        items:[

        {
            key:90,
            on:1
        },
        
        {
            key:14,
            on:1
        },

        {
            key:12,
            on:1
        },
        {
            key:10,
            on:1
        }
        ]
    }
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.setItemPosition(14,2);
    cm.setItemPosition(12,3);
    
    var newPrefs = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));
    deepEqual(newPrefs,expectedPrefs);
        
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu moveDown() moves item down", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout');
    var initialPrefs = {
        items:[

        {
            key:90,
            on:1
        },

        {
            key:12,
            on:1
        },

        {
            key:14,
            on:1
        },

        {
            key:10,
            on:1
        }
        ]
    };
    var expectedPrefs = {
        items:[

        {
            key:90,
            on:1
        },

        {
            key:12,
            on:1
        },

        {
            key:10,
            on:1
        },

        {
            key:14,
            on:1
        }
        ]
    };
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify(initialPrefs));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    
    cm.setItemPosition(14,4);
    cm.setItemPosition(10,3);
    
    deepEqual(JSON.parse(mwf.standard.preferences.get('homescreen_layout')),expectedPrefs);
        
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

    deepEqual(prefResults.items[0],{
        key:0,
        on:1
    },
    'render() should set prefs if they are not already set');
        
    deepEqual(prefResults.items[1],{
        key:1,
        on:1
    },
    'render() should set prefs if they are not already set');
    
    strictEqual(prefResults.items.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() some settings, missing items set", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        items:[{
            key:1,
            on:1
        }]
    }));
                
    var cm = mwf.full.configurableMenu('homescreen_layout');

    cm.render(
        "fake_main_menu",
        ["foo","bar"]
        );
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('homescreen_layout'));

    deepEqual(prefResults.items[0],{
        key:1,
        on:1
    },
    'render() should leave set prefs');
        
    deepEqual(prefResults.items[1],{
        key:0,
        on:1
    },
    'render() should set prefs if they are not already set');
    
    strictEqual(prefResults.items.length,2,
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

    deepEqual(prefResults.items[0],{
        key:0,
        on:1
    },
    'render() should set prefs if they are not already set casting string to int');
        
    deepEqual(prefResults.items[1],{
        key:1,
        on:1
    },
    'render() should set prefs if they are not already set casting string to int');
    
    strictEqual(prefResults.items.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu render() some settings, missing items set casting string to int", function()
{    
    var oldValue = mwf.standard.preferences.get('homescreen_layout',oldValue);
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        "items":[{
            key:1,
            on:1
        }]
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

    deepEqual(prefResults.items[0],{
        key:1,
        on:1
    },
    'render() should leave set prefs');
        
    deepEqual(prefResults.items[1],{
        key:0,
        on:1
    },
    'render() should set prefs if they are not already set');
    
    strictEqual(prefResults.items.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
});

test("mwf.full.configurableMenu reset() removes settings", function()
{
    var oldValue = mwf.standard.preferences.get('homescreen_layout', oldValue);
    mwf.standard.preferences.set('homescreen_layout',JSON.stringify({
        "on":[1]
    }));
    
    var cm = mwf.full.configurableMenu('homescreen_layout');
    cm.reset();
    var prefResults = mwf.standard.preferences.get('homescreen_layout');
    strictEqual(prefResults,null,'clear() should remove preferences list');
    
    if (oldValue != null) {
        mwf.standard.preferences.set('homescreen_layout',oldValue);
    }
})