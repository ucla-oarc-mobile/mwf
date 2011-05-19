<?php

/**
 * 
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 */

require_once(dirname(dirname(__FILE__)).'decorator.class.php');

class Site_Decorator extends Decorator
{
    public static function __callStatic($function, $args)
    {
        require_once(dirname(__FILE__).'/site/'.$function.'.class.php');
        $class = $function.'_Site_Decorator';
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }
}

?>
