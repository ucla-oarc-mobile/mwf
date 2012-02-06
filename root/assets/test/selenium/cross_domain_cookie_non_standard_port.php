<?php

/**
 * If mwf.site.cookie.domain does not strip the port from HTTP_HOST, the end 
 *     result is an infinite redirect loop if MWF cookies have not yet been set.
 * 
 * This bug existed in 1.2.10 but was fixed in 1.2.11.  See 
 *     https://github.com/ucla/mwf/issues/77
 */

    $_SERVER['HTTP_HOST'] = 'www.example.com:8080';
?><!DOCTYPE html>
<html>
    <head>
        <title>Cross-Domain-Cookie Non-Standard-Port Test</title>
        <script type="text/javascript">
            <?php require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/assets/js/core/vars.php'); ?>
        </script>
    </head>
    <body>
       <script type="text/javascript">
            document.write('HTTP_HOST: <?php echo $_SERVER['HTTP_HOST'];?> <br/>');
            document.write('mwf.site.cookie.domain: ' + mwf.site.cookie.domain + '<br/>');
            if (mwf.site.cookie.domain=='www.example.com')
                document.write('<div id="success">SUCCESS</div>');
            else
                document.write('<div id="failure">FAILURE</div>');
        </script> 
    </body>
</html>