<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 */

require_once(dirname(dirname(__FILE__)).'decorator.class.php');

class HTML_Decorator extends Decorator
{
    public static function __callStatic($function, $args = array())
    {
        require_once(dirname(__FILE__).'/html/'.$function.'.class.php');
        $class = $function.'_HTML_Decorator';
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }
}
