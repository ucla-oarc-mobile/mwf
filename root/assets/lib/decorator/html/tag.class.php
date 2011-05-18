<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Tag_HTML_Decorator extends HTML_Decorator
{
    private $_tag_open;
    private $_tag_close;
    private $_inner;

    public function __construct($tag, $inner = '', $params = array())
    {
        $this->_tag_open = HTML_Decorator::tag_open($tag, $params);
        $this->_tag_close = $inner !== false ? HTML_Decorator::tag_close($tag) : false;
        $this->_inner = $inner;
    }

    public function &set_param($key, $val)
    {
        $this->_tag_open->set_param($key, $val);
        return $this;
    }

    public function &set_params($params)
    {
        $this->_tag_open->set_params($params);
        return $this;
    }

    public function render()
    {
        return $this->_tag_open . ($this->_inner !== false ? ($this->_inner . $this->_tag_close) : '');
    }
}

?>
