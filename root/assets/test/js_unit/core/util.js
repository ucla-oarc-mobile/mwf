/**
 * Unit tests for mwf.util
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111016
 *
 * @requires mwf
 * @requires mwf.util
 * @requires qunit
 * 
 */

module("core/util.js",
{
    "setup": function () {
        this.oldDocwrite = document.write;
        document.write = function(text) {
            document.testResult = text;
        }
    },
    "teardown": function () {
        document.write = this.oldDocwrite;
    }
}); 
            
test("mwf.util.importJS()", function()
{
    mwf.util.importJS('test.js');
    ok(document.testResult.indexOf('script') > -1, 'importJS() writes a <script> tag');
});

test("mwf.util.importCSS()", function()
{
    mwf.util.importCSS('test.css');
    ok(document.testResult.indexOf('link') > -1, 'importCSS() writes a <link> tag')

});