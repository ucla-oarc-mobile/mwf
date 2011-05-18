<?php

/**
 * A PHP file that may be included in another file with headers not already sent
 * that unsets the redirection override preference set by /assets/redirect/js.php.
 *
 * @author ebollens
 * @version 20101021
 *
 * @link /assets/redirect/js.php
 */

include_once(dirname(dirname(__FILE__)).'/config.php');

if(!headers_sent())
{
    foreach($_COOKIE as $name=>$value)
    {
        if(substr($name, 0, 14) == Config::get('global', 'cookie_prefix').'ovrrdr')
             setcookie($name, 0, time(), '/');
    }
}

?>