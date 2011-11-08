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
 * @uses Config
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/https.class.php');
require_once(dirname(dirname(__FILE__)).'/html/tag.class.php');

class Header_Site_Decorator extends Tag_HTML_Decorator
{
    private $_title = false;
    private $_title_path = false;
    private $_image = false;

    public function __construct()
    {
        parent::__construct('h1');
    }

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
            $this->_image = array('src'=>(HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'header_home_button')) : Config::get('global', 'header_home_button')),
                                  'alt'=>Config::get('global', 'header_home_button_alt'));

        $image = HTML_Decorator::tag('img', false, $this->_image)->render();
        $home_button = HTML_Decorator::tag('a', $image, array('href'=>(HTTPS::is_https() ? HTTPS::convert_path(Config::get('global', 'site_url')) : Config::get('global', 'site_url'))))->render();

        if($this->_title_path)
            $title = $this->_title ? HTML_Decorator::tag('a', $this->_title, array('href'=>$this->_title_path)) : false;
        else
            $title = $this->_title ? $this->_title : '';

        $title_span = $title ? HTML_Decorator::tag('span', $title)->render() : '';

        $this->set_param('id', 'header');
        $this->add_inner_front($home_button.$title_span);
        
        return parent::render();
    }
}
