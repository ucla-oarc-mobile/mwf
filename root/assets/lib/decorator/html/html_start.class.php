<?php

require_once(dirname(__FILE__).'/tag_open.class.php');

class Decorator_HTML_HTML_Start extends Decorator_HTML_Tag_Open
{
    public function __construct()
    {
        parent::__construct('html');
    }

    public function render()
    {
        return '<!DOCTYPE html>
'.parent::render();
    }
}

?>
