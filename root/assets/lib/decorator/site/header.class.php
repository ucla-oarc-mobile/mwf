<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.class.php');

class Header_Site_Decorator extends Site_Decorator
{
    private $_title = false;
    private $_title_path = false;
    private $_image = false;

    public function &set_title($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function &set_title_path($path)
    {
        $this->_title_path = $path;
        return $this;
    }

    public function &set_image($image, $alt = '')
    {
        $this->_image = array();
        $this->_image['src'] = $image;
        $this->_image['alt'] = $alt;
        return $this;
    }

    public function render()
    {
        if(!$this->_image)
            $this->_image = array('src'=>Config::get('global', 'header_home_button'),
                                  'alt'=>Config::get('global', 'header_home_button_alt'));
        
        $image = HTML_Decorator::tag('img', false, $this->_image);
        $home_button = HTML_Decorator::tag('a', $image, array('href'=>Config::get('global', 'site_url')));

        if($this->_title_path)
            $title = $this->_title ? HTML_Decorator::tag('a', $this->_title, array('href'=>$this->_title_path)) : false;
        else
            $title = $this->_title ? $this->_title : '';

        $title_span = $title ? HTML_Decorator::tag('span', $title) : '';

        return HTML_Decorator::tag('h1', $home_button.$title_span, array('id'=>'header'))->render();
    }
}
