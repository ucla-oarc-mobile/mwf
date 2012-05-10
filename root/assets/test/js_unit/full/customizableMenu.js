/**
 * Unit tests for mwf.full.customizableMenu
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120310
 *
 * @requires mwf
 * @requires mwf.full.customizableMenu
 * @requires mwf.standard.preferences
 * @requires qunit
 * 
 */

module("full/customizableMenu.js", {
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

test("mwf.full.customizableMenu render() no settings, string keys, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.clear('home_screen_layout');
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem('a', '<li><a href="foo">Foo</a></li>', '');
    cm.addItem('b', '<li><a href="foo">Foo</a></li>');
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});


test("mwf.full.customizableMenu render() no settings, numeric keys, returns everything", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.clear('home_screen_layout');
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    
    cm.addItem(0, '<li><a href="foo">Foo</a></li>', '');
    cm.addItem(1, '<li><a href="foo">Foo</a></li>', '');
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="foo">Foo</a></li>',
        'No prefs set, should print all menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() has settings, one item enabled two disabled", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
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
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(1, '<li><a href="foo">Foo</a></li>', '');
    cm.addItem(2, '<li><a href="bar">Bar</a></li>', '');
    cm.addItem(3, '<li><a href="baz">Baz</a></li>', '');
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="bar">Bar</a></li>',
        'Prefs set to print just the middle item');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});


test("mwf.full.customizableMenu render() has settings, two items enabled, one disabled", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
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
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(0, '<li><a href="foo">Foo</a></li>', '');
    cm.addItem(1, '<li><a href="bar">Bar</a></li>', '');
    cm.addItem(2, '<li><a href="whoa">Whoa</a></li>', '');
    
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li>',
        'Prefs set to print first and last menu items');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() mangled settings, graceful handling", function()
{
    var result = true;
    expect(1);
    
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout','["a]');
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem("a");
    cm.addItem("b");
    cm.addItem("c");
    
    try {
        cm.render("fake_main_menu");
    } catch (e) {
        result = false;
    } finally {
        if (oldValue != null) {
            mwf.standard.preferences.set('home_screen_layout',oldValue);
        }
    }
        
    ok(result,"Exception should handled");

});

test("mwf.full.customizableMenu render() has settings, no disabled items sent", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
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
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(0, '<li><a href="foo">Foo</a></li>');
    cm.addItem(2, '<li>a href="whoa">Whoa</a></li>');
    cm.addItem(3, '<li><a href="baz">Baz</a></li>');
    
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="baz">Baz</a></li>',
        'Prefs set, should print enabled items followed by unlisted items and not disabled items');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() disabled items sent", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
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
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem('0', '<li><a href="foo">Foo</a></li>', 'foo disabled');
    cm.addItem('1', '<li><a href="whoa">Whoa</a></li>', 'whoa totally disabled');
    cm.addItem('2', '<li><a href="baz">Baz</a></li>', 'baz has left the building');
    
    cm.render("fake_main_menu");

    equal(document.getElementById('fake_main_menu').innerHTML, 
        '<li><a href="foo">Foo</a></li><li><a href="whoa">Whoa</a></li>baz has left the building',
        'Disabled items sent, should be rendered');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
})

test("mwf.full.customizableMenu enableItem() enable new item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(7,true);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    deepEqual(newPrefs, expectedPrefs, "should add new item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu enableItem() disable new item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(7,false);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);

    deepEqual(newPrefs, expectedPrefs, "should add new item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu enableItem() enable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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

    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(4,true);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);
    
    deepEqual(newPrefs, expectedPrefs, "should move disabled item to enabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu enableItem() disable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(3,false);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);
 
    deepEqual(newPrefs, expectedPrefs, "should move enabled item to disabled list");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu enableItem() enable enabled item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    
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
    
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(3,true);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);
 
    deepEqual(newPrefs, expectedPrefs, "should do nothing with enabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu enableItem() disable disabled item", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    
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
    
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));

    var cm = mwf.full.customizableMenu('home_screen_layout');

    cm.enableItem(4,false);
    
    var newPrefsString = mwf.standard.preferences.get('home_screen_layout');
    var newPrefs = JSON.parse(newPrefsString);

    deepEqual(newPrefs, expectedPrefs, "should do nothing with disabled item");

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
    
});

test("mwf.full.customizableMenu render() should not have side effects on passed values", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
        items:[{
            key:0,
            on:0
        }]
    }));
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    
    var menuItems = ["foo", "bar", "baz"];
    cm.addItem(0, menuItems[0]);
    cm.addItem(1, menuItems[1]);
    cm.addItem(2, menuItems[2]);
    cm.render("fake_main_menu");
    
    deepEqual(menuItems, ["foo","bar","baz"], "render() should not have side effects on menuItems array");
    
    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
})

test("mwf.full.customizableMenu setItemPosition() moves item up", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    
    cm.setItemPosition(14,2);
    cm.setItemPosition(12,3);
    
    var newPrefs = JSON.parse(mwf.standard.preferences.get('home_screen_layout'));
    deepEqual(newPrefs,expectedPrefs);
        
    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu moveDown() moves item down", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout');
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
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify(initialPrefs));
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    
    cm.setItemPosition(14,4);
    cm.setItemPosition(10,3);
    
    deepEqual(JSON.parse(mwf.standard.preferences.get('home_screen_layout')),expectedPrefs);
        
    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() no settings, object passed, sets settings", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.clear('home_screen_layout');
        
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(0,'foo');
    cm.addItem(1,'bar');

    cm.render("fake_main_menu");
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('home_screen_layout'));

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
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() some settings, missing items set", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
        items:[{
            key:1,
            on:1
        }]
    }));
                
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(0, 'foo');
    cm.addItem(1, 'bar');
    cm.render("fake_main_menu");
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('home_screen_layout'));

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
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() no settings, sets settings, keys are numbers", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.clear('home_screen_layout');
        
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem(0,"foo");
    cm.addItem(1,"bar");

    cm.render("fake_main_menu");
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('home_screen_layout'));

    deepEqual(prefResults.items[0],{
        key:0,
        on:1
    },
    'render() should set first pref if not already set');
        
    deepEqual(prefResults.items[1],{
        key:1,
        on:1
    },
    'render() should set second pref if not already set');
    
    strictEqual(prefResults.items.length,2,
        'render() should result in one pref setting per menu item');

    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu render() some settings, missing items set, keys are strings", function()
{    
    var oldValue = mwf.standard.preferences.get('home_screen_layout',oldValue);
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
        "items":[{
            key:1,
            on:1
        }]
    }));
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.addItem("0","foo");
    cm.addItem("1","bar");
    cm.render("fake_main_menu");
            
    var prefResults = JSON.parse(mwf.standard.preferences.get('home_screen_layout'));
    
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
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
});

test("mwf.full.customizableMenu reset() removes settings", function()
{
    var oldValue = mwf.standard.preferences.get('home_screen_layout', oldValue);
    mwf.standard.preferences.set('home_screen_layout',JSON.stringify({
        "on":[1]
    }));
    
    var cm = mwf.full.customizableMenu('home_screen_layout');
    cm.reset();
    var prefResults = mwf.standard.preferences.get('home_screen_layout');
    strictEqual(prefResults,null,'clear() should remove preferences list');
    
    if (oldValue != null) {
        mwf.standard.preferences.set('home_screen_layout',oldValue);
    }
})