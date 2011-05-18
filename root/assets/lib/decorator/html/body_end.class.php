<?php

require_once(dirname(__FILE__).'/tag_close.class.php');

class Decorator_HTML_Body_End extends Decorator_HTML_Tag_Close
{
    public function __construct()
    {
        parent::__construct('body');
    }
}

?>
