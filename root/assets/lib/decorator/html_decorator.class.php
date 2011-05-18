<?php

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

?>
