<?php

/**
 * server.js should redirect to passthru.php on the correct port
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120204
 */

$_SERVER['HTTP_HOST'] = 'www.example.com:8080';
?><!DOCTYPE html>
<html>
    <head>
        <title>Cross-Domain-Cookie Non-Standard-Port Redirect Test</title>
        <script type="text/javascript">
            <?php require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/assets/js/core/vars.php'); ?>
                mwf.capability = new function() { this.cookie = function() {return true} }
                var stub = new function() { this.cookieName='foo'; this.generateCookieContent = function() { return;} }
                mwf.classification = stub;
                mwf.userAgent = stub;
                mwf.screen = stub
                mwf.site.cookie.exists = function() { return false; }
                mwf.override = new function() { this.isRedirecting = false }
                mwf.browser = new function() { this.getMode = function() {return 'mode'}}
                mwf.site.redirect = function(target) {document.write('<div id="target">'+target+'</div>')}
            <?php require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/assets/js/core/server.js'); ?>
        </script>
    </head>
    <body>
       <script type="text/javascript">
            var result = document.getElementById('target').innerHTML;
            if (/^http:\/\/www\.example\.com:8080\//.test(result))
                document.write('<div id="success">SUCCESS</div>');
            else
                document.write('<div id="failure">FAILURE</div>');
        </script> 
    </body>
</html>