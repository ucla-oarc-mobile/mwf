<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Tag_Open_HTML_Decorator extends Decorator
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

    public function &add_class($class)
    {
        if(!isset($this->_params['class']))
            $this->_params['class'] = $class;
        else if(!in_array($class, explode(' ', $this->_params['class'])))
            $this->_params['class'] .= ' '.$class;
        return $this;
    }

    public function &remove_class($class)
    {
        if(isset($this->_params['class']))
        {
            $classes = explode(' ', $this->_params['class']);
            if(($i = array_search($class, $classes)) !== false)
            {
                $classes[$i] = $classes[count($classes)-1];
                array_pop($classes);
                $this->_params['class'] = implode(' ', $classes);
            }
        }

        return $this;
    }

    public function render()
    {
        $str = '<'.$this->_tag;
        if(count($this->_params) > 0)
            foreach($this->_params as $name=>$val)
                $str .= ' '.$name.($val ? '="'.$val.'"' : '');
        $str .= '>';
        return $str;
    }
}
