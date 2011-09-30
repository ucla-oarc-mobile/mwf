<?php

/**
 * If json_encode() and json_decode() are not defined within PHP, then this
 * file loads SimpleJSON emulation for json_encode() and json_decode().
 *
 * @package core
 * @package json
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110827
 */

if(!function_exists('json_encode') || !function_exists('json_decode'))
{
    /**
     * Include SimpleJSON library file that defines fromJSON() and toJSON().
     */
    if(!function_exists('fromJSON') && !function_exists('toJSON'))
    {
        require_once('json.simplejson.php');
    }

    /**
     * Define emulation for json_encode() via SimpleJSON function toJSON().
     */
    if(!function_exists('json_encode'))
    {
        function json_encode($value)
        {
            return toJSON($value);
        }
    }

    /**
     * Define emulation for json_decode() via SimpleJSON function fromJSON().
     */
    if(!function_exists('json_decode'))
    {
        function json_decode($value, $assoc = false)
        {
            return fromJSON($value, $assoc);
        }
    }
}
