<?php

/**
 *
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110620
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/html/tag.class.php');

class Button_Full_Site_Decorator extends Tag_HTML_Decorator
{
    private $_options = array();
    private $_options_count = 0;
    private $_options_max = false;

    public function __construct($params = array())
    {
        parent::__construct('div', false, $params);
        $this->add_class('button-full');
        $this->set_maximum(2);
    }
    
    public function &set_padded($val = true)
    {
        if($val)
            $this->add_class('button-padded');
        else
            $this->remove_class('button-padded');
        
        return $this;
    }

    public function &set_option($num, $name = false, $url = false, $params = array())
    {
        if($this->_options_count < $num)
            $num = $this->_options_count;
        
        $this->_options[$num++] = HTML_Decorator::tag('a', $name?$name:'', array_merge($params, array('href'=>$url?$url:'#')));
        $this->_options_count = $num;
        return $this;
    }

    public function &add_option($name = false, $url = false, $params = array())
    {
        return $this->set_option($this->_options_count, $name, $url, $params);
    }

    public function &set_option_light($num, $name = false, $url = false, $params = array())
    {
        $this->set_option($num, $name, $url, $params);
        $this->_options[$this->_options_count-1]->add_class('button-light');
        return $this;
    }

    public function &add_option_light($name = false, $url = false, $params = array())
    {
        return $this->set_option_light($this->_options_count, $name, $url, $params);
    }

    public function &set_maximum($max)
    {
        $this->_options_max = $max;
        return $this;
    }

    public function render()
    {
        if($this->_options_max !== false && $this->_options_max < $this->_options_count)
        {
            $options = array();
            for($i=0; $i < $this->_options_max; $i++)
                $options[$i] = $this->_options[$i];
            $this->_options = $options;
            $this->_options_count = $this->_options_max;
        }
        
        if(count($this->_options) == 0)
            return '';

        $this->_options[0]->add_class('button-first');
        $this->_options[$this->_options_count-1]->add_class('button-last');

        $options = '';
        foreach($this->_options as $option)
            $options .= is_a($option, 'Decorator') ? $option->render() : $option;

        $this->add_inner_front($options);
        return parent::render();
    }
}
