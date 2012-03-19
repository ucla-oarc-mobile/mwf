/**
 * mwf.full.formsPolyfills enables polyfills for HTML5 form elements.
 *
 * @package full
 * @subpackage js
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120316
 *
 * @requires mwf
 * @requires mwf.site
 * @requires mwf.util
 * 
 */

mwf.util.importJS(mwf.site.webassetroot() + "/js/auxiliary/js-webshim/minified/polyfiller.js");

$(document).ready(function(){
    $.webshims.setOptions({
        waitReady: false
    });
    $.webshims.polyfill('forms-ext');
});

