<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Decorator_HTML_Tag_Close extends Decorator
{
    private $_tag;

    public function __construct($tag)
    {
        $this->_tag = $tag;
    }

    public function render()
    {
        return '</'.$this->_tag.'>
';
    }
}

?>