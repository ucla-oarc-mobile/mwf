<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Tag_Open_HTML_Decorator extends HTML_Decorator
{
    private $_tag;
    private $_params;

    public function __construct($tag, $params = array())
    {
        $this->_tag = $tag;
        $this->_params = $params;
    }

    public function &set_param($key, $val)
    {
        $this->_params[$key] = $val;
        return $this;
    }

    public function &set_params($params)
    {
        $this->_params = array_merge($this->_params, $params);
        return $this;
    }

    public function render()
    {
        $str = '<'.$this->_tag;
        if(count($this->_params) > 0)
            foreach($this->_params as $name=>$val)
                $str .= ' '.$name.($val ? '="'.$val.'"' : '');
        $str .= '>';
        return $str.'
';
    }
}

?>