<?php

$past = time() - 3600;
foreach ( $_COOKIE as $key => $value )
{
    setcookie( $key, FALSE, $past, '/' );
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