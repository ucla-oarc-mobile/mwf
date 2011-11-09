<?php

/**
 * A PHP file that may be included in another file with headers not already sent
 * that unsets the redirection override preference set by /assets/redirect/js.php.
 *
 * @package core
 * @subpackage redirect
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20101021
 *
 * @link /assets/redirect/js.php
 */

include_once(dirname(dirname(__FILE__)).'/config.php');

if(!headers_sent())
{
    $ovrrdr_name = Config::get('global', 'cookie_prefix').'ovrrdr';
    foreach($_COOKIE as $name=>$value)
    {
        if($name == $ovrrdr_name)
             setcookie($name, 0, time(), '/');
    }
}

?>