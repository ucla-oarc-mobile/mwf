<?php

class Decorator
{
    public function render()
    {
        return '';
    }

    public function __toString()
    {
        return $this->render();
    }
}

class HTML_Decorator extends Decorator
{
    public static function __callStatic($function, $args = array())
    {
        require_once(dirname(__FILE__).'/decorator/html/'.$function.'.class.php');
        $class = 'Decorator_HTML_'.$function;
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }
}

class Site_Decorator extends Decorator
{
    public static function __callStatic($function, $args)
    {
        require_once(dirname(__FILE__).'/decorator/site/'.$function.'.class.php');
        $class = 'Decorator_Site_'.$function;
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }
}

?>
