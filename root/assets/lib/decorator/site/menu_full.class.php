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
 * @version 20110518
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/html/tag.class.php');

class Menu_Full_Site_Decorator extends Tag_HTML_Decorator
{
    private $_padded = null;
    private $_detailed = null;
    private $_title = false;
    private $_list = array();

    public function __construct($title = false, $params = array())
    {
        parent::__construct('div', false, $params);
        $this->add_class('menu-full');
        if($title)
            $this->set_title($title);
    }

    public function &set_padded($val = true)
    {
        $this->_padded = $val ? true : false;
        return $this;
    }

    public function &set_detailed($val = true)
    {
        $this->_detailed = $val ? true : false;
        return $this;
    }

    public function &set_title($inner, $params = array())
    {
        $this->_title = $inner === false ? false : HTML_Decorator::tag('h1', $inner, $params);
        return $this;
    }

    public function &set_title_light($inner, $params = array())
    {
        if(!isset($params['class']))
            $params['class'] = 'light';
        elseif(!in_array('light', explode(' ', $params['class'])))
            $params['class'] .= ' light';

        return $this->set_title($inner, $params);
    }

    public function &add_item($name, $url, $li_params = array(), $a_params = array())
    {
        if(!is_array($this->_list))
            $this->_list = array();
        if(!is_array($li_params))
            $li_params = array();
        if(!is_array($a_params))
            $a_params = array();

        $link = HTML_Decorator::tag('a', $name?$name:'', array_merge($a_params, array('href'=>$url?$url:'#')));
        $this->_list[] = HTML_Decorator::tag('li', $link, $li_params);

        return $this;
    }

    public function &add_text($text, $li_params = array(), $p_params = array())
    {
        if(!is_array($this->_list))
            $this->_list = array();
        if(!is_array($li_params))
            $li_params = array();
        if(!is_array($p_params))
            $p_params = array();

        $p = HTML_Decorator::tag('p', $text?$text:'', $p_params);
        $this->_list[] = HTML_Decorator::tag('li', $p, $li_params);

        return $this;
    }

    public function render()
    {
        $count = count($this->_list);
        
        if($this->_title)
            $this->_title->add_class('menu-first');
        elseif($count > 0)
            $this->_list[0]->add_class('menu-first');

        if($count > 0)
            $this->_list[$count-1]->add_class('menu-last');
        else if($this->_title)
            $this->_title->add_class('menu-last');

        if($this->_detailed)
            $this->add_class('menu-detailed');
        elseif($this->_detailed === false)
            $this->remove_class('menu-detailed');

        if($this->_padded)
            $this->add_class('menu-padded');
        elseif($this->_padded === false)
            $this->remove_class('menu-padded');

        $list = '';
        if($count > 0)
        {
            $inner = '';
            foreach($this->_list as $list_item)
                $inner .= $list_item->render();
            $list = HTML_Decorator::tag('ol', $inner)->render();
        }

        $title = is_a($this->_title, 'Decorator') ? $this->_title->render() : ($this->_title ? $this->_title : '');

        $this->add_inner_front($title.$list);
        return parent::render();
    }
}
