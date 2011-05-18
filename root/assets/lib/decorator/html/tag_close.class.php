<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Tag_Close_HTML_Decorator extends HTML_Decorator
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