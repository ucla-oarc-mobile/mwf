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

require_once(dirname(__FILE__).'/decorator/html_decorator.class.php');
require_once(dirname(__FILE__).'/decorator/site_decorator.class.php');

?>
