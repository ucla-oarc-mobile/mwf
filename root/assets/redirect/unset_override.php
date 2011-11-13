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
 * @uses Config
 * @uses Cookie
 * 
 * @link /assets/redirect/js.php
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(dirname(dirname(__FILE__)).'/lib/cookie.class.php');

if(!headers_sent())
{
    $ovrrdr_name = 'ovrrdr';
    foreach(Cookie::get_all_names() as $name)
    {
        if(substr($name, 0, strlen($ovrrdr_name)) == $ovrrdr_name)
                Cookie::set($name,0,time(),'/');
    }
}

?>