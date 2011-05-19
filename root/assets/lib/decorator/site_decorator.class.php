<?php

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
