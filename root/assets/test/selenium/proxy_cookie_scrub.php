<?php
if (count($_COOKIE) > 0) {
    $past = time() - 3600;
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, FALSE, $past, '/');
    }
    echo '<div>Redirecting...</div>';
    echo '<script>window.location.reload(true);</script>';
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <script src="//localhost/assets/js.php"></script>
        <script>
            success = '<div id="success">This text will appear after a delay if the test has passed.</div>';
            setTimeout('document.write(success)', 2000);
        </script>
    </head>
    <body>
        <div>
            Access this page as http://localhost/assets/test/selenium/proxy_cookie_scrub.php.
            If it loads and does not redirect indefinitely, the test has passed.
        </div>

    </body>
</html>

