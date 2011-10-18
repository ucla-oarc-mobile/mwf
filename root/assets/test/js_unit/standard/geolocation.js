/**
 * Unit tests for mwf.browser
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
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
    expect(3);
    // TODO: Is this the way to do a timeout?
    QUnit.config.testTimeout = 3000;
    stop();
    mwf.touch.geolocation.getPosition(function() {
        equal(typeof latitude, 'number', 'latitude should be a number');
        equal(typeof longitude, 'number', 'longitude should be a number');
        equal(typeof accuracy, 'number', 'accuracy should be a number');
        start();
    }, function(errorMsg) {
        ok(false,'getPosition() error: ' + errorMsg);
        start();
    });
})

test("mwf.touch.geolocation.getPosition(onSuccess)", function() {
    expect(3);
    // TODO: Is this the way to do a timeout?
    QUnit.config.testTimeout = 3000;
    stop();
    mwf.touch.geolocation.getPosition(function() {
        equal(typeof latitude, 'number', 'latitude should be a number');
        equal(typeof longitude, 'number', 'longitude should be a number');
        equal(typeof accuracy, 'number', 'accuracy should be a number');
        start();
    });
    
})

test("mwf.touch.geolocation.setTimeout()", function() {
    equal(typeof mwf.touch.geolocation.setTimeout(3000), 'undefined', 'setter should not return a value');
})

test("mwf.touch.geolocation.setHighSccuracy()", function() {
    equal(typeof mwf.touch.geolocation.setHighAccuracy(true), 'undefined', 'setter should not return a value');
})