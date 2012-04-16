<?php
$past = time() - 3600;
foreach ($_COOKIE as $key => $value) {
    setcookie($key, FALSE, $past, '/');
}
header('Location: results.html');
