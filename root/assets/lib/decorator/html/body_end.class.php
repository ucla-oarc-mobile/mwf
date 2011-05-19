<?php

require_once(dirname(__FILE__).'/tag_close.class.php');

class Body_End_HTML_Decorator extends Tag_Close_HTML_Decorator
{
    public function __construct()
    {
        parent::__construct('body');
    }
}

?>
