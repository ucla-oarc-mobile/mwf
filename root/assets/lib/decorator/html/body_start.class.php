<?php

require_once(dirname(__FILE__).'/tag_open.class.php');

class Decorator_HTML_Body_Start extends Decorator_HTML_Tag_Open
{
    public function __construct($params = array())
    {
        parent::__construct('body', $params);
    }

}

?>
