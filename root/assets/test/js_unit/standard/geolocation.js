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


//NB: The tester will need to manually allow the script to access location data.
test("mwf.touch.geolocation.getPosition(onSuccess,onError)", function() {
    expect(3);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    }, function(errorMsg) {
        ok(false,'getPosition() error: ' + errorMsg);
        start();
    });
})

test("mwf.touch.geolocation.getPosition(onSuccess)", function() {
    expect(3);
    QUnit.config.testTimeout = 5000;
    QUnit.stop();
    mwf.touch.geolocation.getPosition(function(pos) {
        equal(typeof pos['latitude'], 'number', 'latitude should be a number');
        equal(typeof pos['longitude'], 'number', 'longitude should be a number');
        equal(typeof pos['accuracy'], 'number', 'accuracy should be a number');
        start();
    });
    
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

test("mwf.touch.geolocation.clearWatch()", function() {
    equal(typeof mwf.touch.geolocation.clearWatch(1),'undefined', 'clearWatch() should not return a value');
})