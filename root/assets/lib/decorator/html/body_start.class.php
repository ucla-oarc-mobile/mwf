<?php

require_once(dirname(__FILE__).'/tag_open.class.php');

class Body_Start_HTML_Decorator extends Tag_Open_HTML_Decorator
{
    public function __construct($params = array())
    {
        parent::__construct('body', $params);
    }

}

?>
