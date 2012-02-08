/**
 * Unit tests for mwf.standard.geolocation
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111018
 *
 * @requires mwf
 * @requires mwf.standard.geolocation
 * @requires qunit
 * 
 */

module("standard/geolocation.js"); 
            
test("mwf.standard.geolocation.getType()", function()
{
    equal(mwf.standard.geolocation.getType(),1,"getType() should return 1 for modern browsers");
});

test("mwf.standard.geolocation.getTypeName()", function()
{
    equal(mwf.standard.geolocation.getTypeName(),"HTML5 Geolocation","getTypeName() should return HTML5 Geolocation for modern browsers");
});

test("mwf.standard.geolocation.isSupported()", function() {
    equal(mwf.standard.geolocation.isSupported(),true,"Geolocation is supported.");
})

test("mwf.standard.geolocation.getCurrentPosition(onSuccess,onError)", function() {
    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.standard.geolocation.getCurrentPosition(function(pos) {
        var receivedExpectedResultTypes = 
            typeof pos['latitude']=='number'
            && typeof pos['longitude']=='number'
            && typeof pos['accuracy']=='number';
        ok(receivedExpectedResultTypes, 'lat, long, and accuracy should be numbers');
        start();
    }, function(error) {
        var matchesPositionErrorInterface =
            typeof error.code === 'number'
            && typeof error.message === 'string'
            && typeof error.PERMISSION_DENIED === 'number'
            && typeof error.POSITION_UNAVAILABLE === 'number'
            && typeof error.TIMEOUT === 'number'
        ok(matchesPositionErrorInterface, 'error should implement PositionError interface');
        start();
    });
})

test("mwf.standard.geolocation.getCurrentPosition(onSuccess)", function() {
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.standard.geolocation.getCurrentPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    });
})

test("mwf.standard.geolocation.getCurrentPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.standard.geolocation.getApi;
    mwf.standard.geolocation.getApi = function() { return null; };

    try {
        var rv = mwf.standard.geolocation.getCurrentPosition(function() {
           ok(false, 'success callback should not trigger if geolocation is unsupported');
        });
        equal(typeof rv, 'undefined', 'getCurrentPosition() function should not return a value'); 
    }
    catch(ex) {
        ok(false, 'getCurrentPosition() should not throw an exception if an onError handler is not '
                    + 'provided and geolocation is unsupported');
    }
    finally {
        mwf.standard.geolocation.getApi = getApi;
    }
})

test("mwf.standard.geolocation.setTimeout()", function() {
    equal(typeof mwf.standard.geolocation.setTimeout(3000), 'undefined', 'setter should not return a value');
})

test("mwf.standard.geolocation.setHighAccuracy()", function() {
    equal(typeof mwf.standard.geolocation.setHighAccuracy(true), 'undefined', 'setter should not return a value');
})

test("mwf.standard.geolocation.getApi()", function() {
    equal(Object.prototype.toString.call(mwf.standard.geolocation.getApi()), "[object Geolocation]", 'modern phones support navigator.geolocation');
})

test("mwf.standard.geolocation.watchPosition()", function() {
    watchId = mwf.standard.geolocation.watchPosition(function(pos) {});
    equal(typeof watchId, 'number', 'watchPosition() should return a number');
    mwf.standard.geolocation.clearWatch(watchId);
})

test("mwf.standard.geolocation.watchPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.standard.geolocation.getApi;
    mwf.standard.geolocation.getApi = function() { return null; };

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

test("mwf.standard.geolocation.clearWatch()", function() {
    equal(typeof mwf.standard.geolocation.clearWatch(1),'undefined', 'clearWatch() should not return a value');
})