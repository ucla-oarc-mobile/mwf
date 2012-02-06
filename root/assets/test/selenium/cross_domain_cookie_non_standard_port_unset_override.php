<?php
/**
 * base.js should write a link to js_unset_override.php on the correct port
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
        <title>Cross-Domain-Cookie Non-Standard-Port Unset Override Test</title>
        <script type="text/javascript" src="/assets/js.php"></script>
    </head>
    <body>
        <p>This space intentionally left blank.</p>
    </body>
</html>