/**
 * Unit tests for mwf.standard.geolocation
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120226
 *
 * @requires mwf
 * @requires mwf.standard.geolocation
 * @requires qunit
 * 
 */

module("standard/geolocation.js", {
    setup: function() {
        this.restoreNav = false;
        this.saveNav = navigator;
        this.saveGeo = navigator.geolocation;
        this.proto = navigator.__proto__;
        if (navigator = new Object()) {
            this.restoreNav = true;
            navigator.__proto__ = this.proto;
        }
        Object.defineProperty(navigator, 'geolocation', {
            get: function() {
                return navigator.realGeolocation;
            },
            configurable: true
        });
        navigator.realGeolocation = this.saveGeo;
    },
    teardown: function() {
        if (this.restoreNav) {
            navigator = this.saveNav;
        }
        navigator.realGeolocation = this.saveGeo;
    }
}); 
            
test("mwf.standard.geolocation.getType() HTML Geolocation", function()
{
    var navigatorModified = false;
    if (typeof navigator.geolocation=="undefined") {
        navigatorModified = true;
        Object.defineProperty(navigator, 'geolocation', {
            get: function() {
                return true;
            }
        });
    }
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var type = newGeolocation.getType();
    if (navigatorModified) {
        delete navigator.geolocation;
    }
    strictEqual(type, 1, 'getType() should return 1 for HTML Geolocation');
});

test("mwf.standard.geolocation.getType() Google Gears", function()
{
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return true;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var type = newGeolocation.getType();
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }

    strictEqual(type, 2, 'getType() should return 2 for Google Gears');
});

test("mwf.standard.geolocation.getTypeName()", function()
{
    equal(mwf.standard.geolocation.getTypeName(),"HTML5 Geolocation","getTypeName() should return HTML5 Geolocation for modern browsers");
});

test("mwf.standard.geolocation.getTypeName() Custom", function()
{
    var g = new mwf.standard.geolocation.constructor(null);
    equal(g.getTypeName(),"Custom","getTypeName() should return Custom if we've overridden the geolocation object");
});

test("mwf.standard.geolocation.getTypeName() Google Gears", function()
{
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return true;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var type = newGeolocation.getTypeName();
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
    
    strictEqual(type, 'Google Gears', 'getTypeName() should return Google Gears');
});

test("mwf.standard.geolocation.getTypeName() Unsupported", function()
{
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return false;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var type = newGeolocation.getTypeName();
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
    
    strictEqual(type, 'Unsupported', 'getTypeName() should return Unsupported');
});

test("mwf.standard.geolocation.isSupported()", function() {
    equal(mwf.standard.geolocation.isSupported(),true,"Geolocation is supported.");
})

test("mwf.touch.geolocation.getPosition(onSuccess,onError)", function() {   
    var geo = {};
    geo.getCurrentPosition=function(onSuccess,onError) {
        onSuccess({
            coords:{
                latitude:1.11,
                longitude:2.22,
                accuracy:3
            }
        });
    }
    
    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    var g = new mwf.standard.geolocation.constructor(geo);

    g.getPosition(function(pos) {
        var receivedExpectedResultTypes = 
        typeof pos['latitude']=='number'
        && typeof pos['longitude']=='number'
        && typeof pos['accuracy']=='number';
        ok(receivedExpectedResultTypes, 'lat, long, and accuracy should be numbers');
        start();
    });    
})

test("mwf.touch.geolocation.getPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.touch.geolocation.getApi;
    mwf.touch.geolocation.getApi = function() {
        return null;
    };

    try {
        var rv = mwf.touch.geolocation.getPosition(function() {
            ok(false, 'success callback should not trigger if geolocation is unsupported');
        });
        equal(typeof rv, 'undefined', 'getPosition() function should not return a value');
    }
    catch(ex) {
        ok(false, 'getPosition() should not throw an exception if an onError handler is not provided '
            + 'and geolocation is unsupported');
    }
    finally {
        mwf.touch.geolocation.getApi = getApi;
    }
})

test("mwf.standard.geolocation.getPosition() unsupported with error callback", function()
{
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return false;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.getPosition(function() { 
        ok(false, 'success callback used when Geolocation unsupported')
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start();
    });
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
});

test("mwf.standard.geolocation.getCurrentPosition() unsupported with error callback", function()
{
    navigator.realGeolocation = false;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return false;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.getCurrentPosition(function() { 
        ok(false, 'success callback used when Geolocation unsupported')
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start();
    });
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
});

test("mwf.standard.geolocation.getCurrentPosition(onSuccess)", function() {

    var geo = {};
    geo.getCurrentPosition=function(onSuccess,onError) {
        onSuccess({
            'coords':{
                'latitude':1.11,
                'longitude':2.22, 
                'accuracy':3
            }
        });
    }
    var g = new mwf.standard.geolocation.constructor(geo);
   
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    g.getCurrentPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    });
})

test("mwf.standard.geolocation.getCurrentPosition(onSuccess) Geolocation unsupported", function() {

    var geo = null;
    var g = new mwf.standard.geolocation.constructor(geo);
    
    try {
        var rv = g.getCurrentPosition(function() {
            ok(false, 'success callback should not trigger if geolocation is unsupported');
        });
        equal(typeof rv, 'undefined', 'getCurrentPosition() function should not return a value'); 
    }
    catch(ex) {
        ok(false, 'getCurrentPosition() should not throw an exception if an onError handler is not '
            + 'provided and geolocation is unsupported');
    }
})

test("mwf.standard.geolocation.setTimeout()", function() {
    equal(typeof mwf.standard.geolocation.setTimeout(3000), 'undefined', 'setter should not return a value');
})

test("mwf.standard.geolocation.setHighAccuracy()", function() {
    equal(typeof mwf.standard.geolocation.setHighAccuracy(true), 'undefined', 'setter should not return a value');
})

test("mwf.standard.geolocation.getApi()", function() {
    equal(typeof mwf.standard.geolocation.getApi(), "object", 'getApi() returns an object');
})

test("mwf.standard.geolocation.getApi() Google Gears", function() {
    navigator.realGeolocation = false;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
    } else {
        window.google = new Object();
    }
    
    google.gears = {
        'factory': {
            'create': function(foo) {
                return foo + ' success!';
            }
        }
    }
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var api = newGeolocation.getApi();
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
    
    strictEqual(api, 'beta.geolocation success!', 'getApi() should call Google Gears factory');
})

test("mwf.standard.geolocation.getApi() Unsupported", function() {
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
    } 
    
    delete window.google;
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    var api = newGeolocation.getApi();
    
    if (typeof saveGoogle != 'undefined')
        window.google = saveGoogle;
    
    strictEqual(api, null, 'getApi() should return null if Geolocation is unsupported');
})

test("mwf.standard.geolocation.watchPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.standard.geolocation.getApi;
    mwf.standard.geolocation.getApi = function() {
        return null;
    };

    try {
        var rv = mwf.standard.geolocation.watchPosition(function() {
            ok(false, 'success callback should not trigger if geolocation is unsupported');
        });
        equal(typeof rv, 'undefined', 'watchPosition() function should not return a value');
    }
    catch(ex) {
        ok(false, 'watchPosition() should not throw an exception if an onError handler is not '
            + 'provided and geolocation is unsupported');
    }
    finally {
        mwf.standard.geolocation.getApi = getApi;
    }
})

test("mwf.standard.geolocation.watchPosition() unsupported with error callback", function()
{
    navigator.realGeolocation = undefined;
    
    var saveGoogle;
    if (typeof window.google != 'undefined') {
        saveGoogle = window.google;
        window.google = new Object();
        window.google.__proto__ = saveGoogle;
    } else {
        window.google = new Object();
    }
        
    Object.defineProperty(google, 'gears', {
        get: function() {
            return false;
        }
    });
    
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.watchPosition(function() { 
        ok(false, 'success callback used when Geolocation unsupported')
        start();
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start();
    });
    
    if (typeof saveGoogle != 'undefined') {
        window.google = saveGoogle;
    } else {
        delete window.google;
    }
});

test("mwf.standard.geolocation.watchPosition() Geolocation supported and watchPosition() successful", function() {
    navigator.geolocation.watchPosition=function(onSuccess,onError) {
        onSuccess({
            'coords':{
                'latitude':1.11,
                'longitude':2.22, 
                'accuracy':3
            }
        });
    }
   
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.watchPosition(function() {
        ok(true, 'success callback used when Geolocation unsupported')
        start();
    }, function() {
        ok(false, 'error callback used when Geolocation unsupported')
        start(); 
    });
})

test("mwf.standard.geolocation.watchPosition() Geolocation supported but error occurred", function() {
    navigator.geolocation.watchPosition=function(onSuccess,onError) {
        onError();
    }
   
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.watchPosition(function() {
        ok(false, 'success callback used when Geolocation unsupported')
        start();
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start(); 
    });
})

test("mwf.standard.geolocation.getCurrentPosition() Geolocation supported but error occurred", function() {
    navigator.geolocation.getCurrentPosition=function(onSuccess,onError) {
        onError({
            code:2,
            message:'Totally Lame Error Occurred! Bummer!'
        });
    }
   
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.getCurrentPosition(function() {
        ok(false, 'success callback used when Geolocation unsupported')
        start();
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start(); 
    });
})

test("mwf.standard.geolocation.getPosition() Geolocation supported but error occurred", function() {
    navigator.geolocation.getCurrentPosition=function(onSuccess,onError) {
        onError({
            code:2,
            message:'Totally Lame Error Occurred! Bummer!'
        });
    }
   
    var newGeolocation = new mwf.standard.geolocation.constructor;

    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    newGeolocation.getPosition(function() {
        ok(false, 'success callback used when Geolocation unsupported')
        start();
    }, function() {
        ok(true, 'error callback used when Geolocation unsupported')
        start(); 
    });
})

test("mwf.standard.geolocation.clearWatch()", function() {
    equal(typeof mwf.standard.geolocation.clearWatch(1),'undefined', 'clearWatch() should not return a value');
})