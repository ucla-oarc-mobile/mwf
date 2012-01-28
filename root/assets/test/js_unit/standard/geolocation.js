/**
 * Unit tests for mwf.touch.geolocation
 *
 * @author trott
 * @copyright Copyright (c) 2011 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111018
 *
 * @requires mwf
 * @requires mwf.touch.geolocation
 * @requires qunit
 * 
 */

module("standard/geolocation.js"); 
            
test("mwf.touch.geolocation.getType()", function()
{
    equal(mwf.touch.geolocation.getType(),1,"getType() should return 1 for modern browsers");
});

test("mwf.touch.geolocation.getTypeName()", function()
{
    equal(mwf.touch.geolocation.getTypeName(),"HTML5 Geolocation","getTypeName() should return HTML5 Geolocation for modern browsers");
});

test("mwf.touch.geolocation.isSupported()", function() {
    equal(mwf.touch.geolocation.isSupported(),true,"Geolocation is supported.");
})

test("mwf.touch.geolocation.getPosition(onSuccess,onError)", function() {
    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getPosition(function(pos) {
        var receivedExpectedResultTypes = 
            typeof pos['latitude']=='number'
            && typeof pos['longitude']=='number'
            && typeof pos['accuracy']=='number';
        ok(receivedExpectedResultTypes, 'lat, long, and accuracy should be numbers');
        start();
    }, function(errorMsg) {
        equal(errorMsg,'Geolocation permission not granted.', 'errorMsg should be permission denied: ' + errorMsg);
        start();
    });
})

test("mwf.touch.geolocation.getPosition(onSuccess)", function() {
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    }); 
})

test("mwf.touch.geolocation.getPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.touch.geolocation.getApi;
    mwf.touch.geolocation.getApi = function() { return null; };

    try {
        mwf.touch.geolocation.getPosition(function() {});
    }
    catch(ex) {
        ok(false, 'getPosition should not throw an exception if an onError handler is not provided '
                    + 'and geolocation is unsupported');
    }
    finally {
        mwf.touch.geolocation.getApi = getApi;
    }
})

test("mwf.touch.geolocation.getCurrentPosition(onSuccess,onError)", function() {
    expect(1);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getCurrentPosition(function(pos) {
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

test("mwf.touch.geolocation.getCurrentPosition(onSuccess)", function() {
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getCurrentPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    });
})

test("mwf.touch.geolocation.getCurrentPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.touch.geolocation.getApi;
    mwf.touch.geolocation.getApi = function() { return null; };

    try {
        mwf.touch.geolocation.getCurrentPosition(function() {});
    }
    catch(ex) {
        ok(false, 'getCurrentPosition should not throw an exception if an onError handler is not '
                    + 'provided and geolocation is unsupported');
    }
    finally {
        mwf.touch.geolocation.getApi = getApi;
    }
})

test("mwf.touch.geolocation.setTimeout()", function() {
    equal(typeof mwf.touch.geolocation.setTimeout(3000), 'undefined', 'setter should not return a value');
})

test("mwf.touch.geolocation.setHighAccuracy()", function() {
    equal(typeof mwf.touch.geolocation.setHighAccuracy(true), 'undefined', 'setter should not return a value');
})

test("mwf.touch.geolocation.getApi()", function() {
    equal(Object.prototype.toString.call(mwf.touch.geolocation.getApi()), "[object Geolocation]", 'modern phones support navigator.geolocation');
})

test("mwf.touch.geolocation.watchPosition()", function() {
    watchId = mwf.touch.geolocation.watchPosition(function(pos) {});
    equal(typeof watchId, 'number', 'watchPosition() should return a number');
    mwf.touch.geolocation.clearWatch(watchId);
})

test("mwf.touch.geolocation.watchPosition(onSuccess) Geolocation unsupported", function() {

    var getApi = mwf.touch.geolocation.getApi;
    mwf.touch.geolocation.getApi = function() { return null; };

    try {
        mwf.touch.geolocation.watchPosition(function() {});
    }
    catch(ex) {
        ok(false, 'watchPosition should not throw an exception if an onError handler is not '
                    + 'provided and geolocation is unsupported');
    }
    finally {
        mwf.touch.geolocation.getApi = getApi;
    }
})

test("mwf.touch.geolocation.clearWatch()", function() {
    equal(typeof mwf.touch.geolocation.clearWatch(1),'undefined', 'clearWatch() should not return a value');
})