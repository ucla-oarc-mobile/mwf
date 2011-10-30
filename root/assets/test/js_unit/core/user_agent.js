/**
 * Unit tests for mwf.user_agent
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111015
 *
 * @requires mwf
 * @requires mwf.user_agent
 * @requires qunit
 * 
 */

module("core/user_agent.js"); 
            
test("mwf.user_agent.is_iphone_os() DEPRECATED", function()
{    
    equal(typeof mwf.user_agent.is_iphone_os(), 'boolean', 'is_iphone_os() should return a Boolean');
});

test("mwf.user_agent.is_webkit_engine() DEPRECATED", function()
{    
    equal(typeof mwf.user_agent.is_webkit_engine(), 'boolean', 'is_webkit_engine() should return a Boolean');
});

test("mwf.user_agent.get_browser() DEPRECATED", function()
{   
    equal(typeof mwf.user_agent.get_browser(), 'string',' get_browser() should return a string');
});

test("mwf.user_agent.get_browser_version() DEPRECATED", function()
{   
    equal(typeof mwf.user_agent.get_browser_version(), 'boolean',' get_browser() should return a Boolean');
});

test("mwf.user_agent.get_os() DEPRECATED", function()
{   
    equal(typeof mwf.user_agent.get_os(), 'string', 'get_os() should return a string');
});

test("mwf.user_agent.get_os_version() DEPRECATED", function()
{   
    equal(typeof mwf.user_agent.get_os_version(), 'string', 'get_os_version() should return a string');
});

test("mwf.user_agent.is_mobile() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_mobile(),'boolean','is_mobile() should return a Boolean');
});

test("mwf.user_agent.is_basic() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_basic(),'boolean','is_basic() should return a Boolean');
});

test("mwf.user_agent.is_standard() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_standard(),'boolean','is_standard() should return a Boolean');
});

test("mwf.user_agent.is_full() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_full(),'boolean','is_full() should return a Boolean');
});

test("mwf.user_agent.is_touch() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_touch(),'boolean','is_touch() should return a Boolean');
});

test("mwf.user_agent.is_overridden() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_overridden(), 'boolean',
        'is_overridden() should return a Boolean');
});

test("mwf.user_agent.is_preview() DEPRECATED", function()
{
    equal(typeof mwf.user_agent.is_preview(), 'boolean',
        'is_preview() should return a Boolean');
});