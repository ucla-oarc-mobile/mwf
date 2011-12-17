/**
 * Unit tests for mwf.capability
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
 *
 * @requires mwf
 * @requires mwf.capablity
 * @requires mwf.userAgent
 * @requires qunit
 * 
 */

module("core/capability.js"); 
            
test("mwf.capability.ajax()", function()
{
    expect(2); 
    var ajax = mwf.capability.ajax();
    equal(typeof ajax, 'boolean', 'mwf.capability.ajax() should return a boolean');
    equal(ajax, true, 'browser is AJAX-capable');
});

test("mwf.capability.applicationcache()", function()
{
    expect(2);
    var applicationcache = mwf.capability.applicationcache();
    equal(typeof applicationcache, 'boolean', 'mwf.capability.applicationcache() should return a boolean');
    equal(applicationcache, true, 'browser is AppCache-capable');
});

test("mwf.capability.audio()", function()
{
    expect(2);
    var audio = mwf.capability.audio();
    equal(typeof audio, 'boolean', 'mwf.capability.audio() should return a boolean');
    equal(audio, true, 'browser is audio-capable');
});

test("mwf.capability.canvas()", function()
{
    expect(2);
    var canvas = mwf.capability.applicationcache();
    equal(typeof canvas, 'boolean', 'mwf.capability.canvas() should return a boolean');
    equal(canvas, true, 'browser is canvas-capable');
});

test("mwf.capability.cookie()", function()
{
    expect(2);
    var cookie = mwf.capability.cookie();
    equal(typeof cookie, 'boolean', 'mwf.capability.cookie() should return a boolean');
    equal(cookie, true, 'browser is cookie-capable');
});

test("mwf.capability.css.borderradius()", function()
{
    expect(2);
    var borderradius = mwf.capability.css.borderradius();
    equal(typeof borderradius, 'boolean', 'mwf.capability.css.borderradius() should return a boolean');
    equal(borderradius, true, 'browser supports borderradius');
});

test("mwf.capability.css.boxshadow()", function()
{
    expect(2);
    var boxshadow = mwf.capability.css.boxshadow();
    equal(typeof boxshadow, 'boolean', 'mwf.capability.css.boxshadow() should return a boolean');
    equal(boxshadow, true, 'browser supports boxshadow');
});

test("mwf.capability.css.fontface()", function()
{
    expect(2);
    var fontface = mwf.capability.css.fontface();
    equal(typeof fontface, 'boolean', 'mwf.capability.css.fontface() should return a boolean');
    equal(fontface, true, 'browser supports fontface');
});

test("mwf.capability.css.gradients()", function()
{
    expect(2);
    var gradients = mwf.capability.css.gradients();
    equal(typeof gradients, 'boolean', 'mwf.capability.css.gradients() should return a boolean');
    equal(gradients, true, 'browser supports gradients');
});

test("mwf.capability.css.transforms()", function()
{
    expect(2);
    var transforms = mwf.capability.css.transforms();
    equal(typeof transforms, 'boolean', 'mwf.capability.css.transforms() should return a boolean');

    var os = mwf.userAgent.getOS();
    var osVersion = parseInt(mwf.userAgent.getOSVersion());
    var supports = (os == 'iphone_os') || (os == 'android' && osVersion >= 3);
    equal(transforms, supports, 'iOS supports transforms, Android only from version 3');
});

test("mwf.capability.css.transforms2d()", function()
{
    expect(2);
    var transforms2d = mwf.capability.css.transforms2d();
    equal(typeof transforms2d, 'boolean', 'mwf.capability.css.transforms2d() should return a boolean');
    equal(transforms2d, true, 'browser supports transforms2d');
});

test("mwf.capability.css.transforms3d()", function()
{
    expect(2);
    var transforms3d = mwf.capability.css.transforms3d();
    equal(typeof transforms3d, 'boolean', 'mwf.capability.css.transforms3d() should return a boolean');
    
    var os = mwf.userAgent.getOS();
    var osVersion = parseInt(mwf.userAgent.getOSVersion());
    var supports = (os == 'iphone_os') || (os == 'android' && osVersion >= 3);
    equal(transforms3d, supports, 'iOS supports transforms3d, Android only from version 3');
});

test("mwf.capability.css.transitions()", function()
{
    expect(2);
    var transitions = mwf.capability.css.transitions();
    equal(typeof transitions, 'boolean', 'mwf.capability.cssltransitions() should return a boolean');
    equal(transitions, true, 'browser supports transitions');
});

test("mwf.capability.css.prop()", function()
{
    expect(4);
    var prop = mwf.capability.css.prop('background');
    equal(typeof prop, 'boolean', 'mwf.capability.css.prop() should return a boolean true');
    equal(prop, true, 'browser supports pointerEvents property');
    prop = mwf.capability.css.prop('nonexistentProperty');
    equal(typeof prop, 'boolean', 'mwf.capability.css.prop() should return a boolean false');
    equal(prop, false, 'browser does not support nonexistant property')
});

test("mwf.capability.css3()", function()
{
    expect(2);
    var css3 = mwf.capability.css3();
    equal(typeof css3, 'boolean', 'mwf.capability.css3() should return a boolean');
    equal(css3, true, 'browser supports CSS3');
});

test("mwf.capability.draganddrop()", function()
{
    expect(2);
    var draganddrop = mwf.capability.draganddrop();
    equal(typeof draganddrop, 'boolean', 'mwf.capability.draganddrop() should return a boolean');
    equal(draganddrop, true, 'browser supports draganddrop');
});

test("mwf.capability.events()", function()
{
    expect(2);
    var events = mwf.capability.events();
    equal(typeof events, 'boolean', 'mwf.capability.events() should return a boolean');
    equal(events, true, 'browser supports events with addEventListener()');
});

test("mwf.capability.css.event()", function()
{
    expect(4);
    var event = mwf.capability.event('load');
    equal(typeof event, 'boolean', 'mwf.capability.event() should return a boolean');
    equal(event, true, 'browser supports touchstart event');
    event = mwf.capability.event('nonexistent');
    equal(typeof event, 'boolean', 'mwf.capability.event() should return a boolean');
    equal(event, false, 'browser does not support nonexistent event')
});

test("mwf.capability.flexbox()", function()
{
    expect(2);
    var flexbox = mwf.capability.flexbox();
    equal(typeof flexbox, 'boolean', 'mwf.capability.flexbox() should return a boolean');
    equal(flexbox, true, 'browser supports flexible box model');
});


test("mwf.capability.inlinesvg()", function()
{
    expect(2);
    var inlinesvg = mwf.capability.inlinesvg();
    equal(typeof inlinesvg, 'boolean', 'mwf.capability.inlinesvg() should return a boolean');
    var os = mwf.userAgent.getOS();
    var osVersion = parseInt(mwf.userAgent.getOSVersion());
    var supports = (os == 'iphone_os' && osVersion >= 5) || (os == 'android' && osVersion >= 3);
    
    equal(inlinesvg, supports, 'iOS 5 and Android 3 support inline SVG. otherwise, not so much...');
});


test("mwf.capability.localstorage()", function()
{
    expect(2);
    var localstorage = mwf.capability.localstorage();
    equal(typeof localstorage, 'boolean', 'mwf.capability.localstorage() should return a boolean');
    equal(localstorage, true, 'browser supports localStorage');
});


test("mwf.capability.sessionstorage()", function()
{
    expect(2);
    var sessionstorage = mwf.capability.sessionstorage();
    equal(typeof sessionstorage, 'boolean', 'mwf.capability.sessionstorage() should return a boolean');
    equal(sessionstorage, true, 'browser supports sessionStorage');
});

test("mwf.capability.svg()", function()
{
    expect(2);
    var svg = mwf.capability.svg();
    equal(typeof svg, 'boolean', 'mwf.capability.svg() should return a boolean');
    var os = mwf.userAgent.getOS();
    var osVersion = parseInt(mwf.userAgent.getOSVersion());
    var supports = (os == 'iphone_os') || (os == 'android' && osVersion >= 3);
    equal(svg, supports, 'iOS (all versions) and Android 3 and above support SVG');
});

test("mwf.capability.touch()", function()
{
    expect(2);
    var touch = mwf.capability.touch();
    equal(typeof touch, 'boolean', 'mwf.capability.touch() should return a boolean');
    equal(touch, true, 'browser supports touch events');
});

test("mwf.capability.video()", function()
{
    expect(2);
    var video = mwf.capability.video();
    equal(typeof video, 'boolean', 'mwf.capability.video() should return a boolean');
    equal(video, true, 'browser supports HTML5 video tag');
});

test("mwf.capability.websockets()", function()
{
    expect(2);
    var websockets = mwf.capability.websockets();
    equal(typeof websockets, 'boolean', 'mwf.capability.websockets() should return a boolean');
    var os = mwf.userAgent.getOS();
    var osVersion = mwf.userAgent.getOSVersion();
    var supports = (os == 'iphone_os' && 
        (parseInt(osVersion) > 4 || osVersion.indexOf('4.2')==0 || osVersion.indexOf('4.3')==0));
    equal(websockets, supports, 'browser supports web sockets');
});

test("mwf.capability.write()", function()
{
    expect(2);
    var write = mwf.capability.write();
    equal(typeof write, 'boolean', 'mwf.capability.write() should return a boolean');
    equal(write, true, 'browser supports live writes to the DOM');
});