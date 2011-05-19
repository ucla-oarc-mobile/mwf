<?php

require_once(dirname(__FILE__).'/tag_close.class.php');

class HTML_End_HTML_Decorator extends Tag_Close_HTML_Decorator
{
    public function __construct()
    {
        parent::__construct('html');
    }
}

?>
