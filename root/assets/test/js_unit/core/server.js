/**
 * Unit tests for mwf.server
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111214
 *
 * @requires mwf
 * @requires qunit
 * 
 */

module("core/server.js"); 
            
test("mwf.server.setCookie()", function()
{
    expect(1);
    mwf.server.setCookie('mwf_test_cookie',';');
    if (mwf.site.local.isSameOrigin()) {
        ok(document.cookie.match(/mwf_test_cookie=%3B/), 'cookie should be set and values encoded');

    } else {
        ok(mwf.server.mustRedirect,'if not same origin, setting cookie should result in redirect');

    }
});
