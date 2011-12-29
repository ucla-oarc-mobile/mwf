<?php

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
?>
<!doctype html>
<html lang=en>
<head>
<meta charset=utf-8>
<title>Nuke Cookies</title>
</head>
<body>
<p>Cookies nuked!</p>
</body>
</html>