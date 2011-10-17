/**
 * Unit tests for mwf.useragent
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
 *
 * @requires mwf
 * @requires mwf.userAgent
 * @requires qunit
 * 
 */

module("core/useragent.js"); 
            
test("mwf.userAgent.getOS()", function()
{
    expect(1); 
    var os = mwf.userAgent.getOS();
    
    ok(typeof os === 'string','getOS() should return a string');
});

test("mwf.userAgent.getOSVersion()", function()
{
    expect(1); 
    var osVersion = mwf.userAgent.getOSVersion();
    
    ok(typeof osVersion === 'string','getOSVersion() should return a string');
});

test("mwf.userAgent.getBrowser()", function()
{
    expect(1); 
    var browser = mwf.userAgent.getBrowser();
    
    ok(typeof browser === 'string','getBrowser() should return a string');
});

test("mwf.userAgent.getBrowserEngine()", function()
{
    expect(1); 
    var browserEngine = mwf.userAgent.getBrowserEngine();
    
    ok(typeof browserEngine === 'string','getBrowserEngine() should return a string');
});

test("mwf.userAgent.getBrowserEngineVersion()", function()
{
    expect(1); 
    var browserEngineVersion = mwf.userAgent.getBrowserEngineVersion();
    
    ok(typeof browserEngineVersion === 'string','getBrowserEngineVersion() should return a string');
});