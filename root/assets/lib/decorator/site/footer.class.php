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
require_once(dirname(dirname(__FILE__)).'/html/tag.class.php');

class Footer_Site_Decorator extends Tag_HTML_Decorator
{
    private $_copyright = false;
    private $_help_title = false;
    private $_help_url = '#';
    private $_full_title = false;
    private $_full_url = '#';
    private $_powered_by = true;

    public function __construct()
    {
        parent::__construct('div');
        
        if($copyright = Config::get('global', 'copyright_text'))
            $this->set_copyright_text($copyright);
    }

    public function &set_copyright_text($text)
    {
        $this->_copyright = $text;
        return $this;
    }

    public function &set_help_site($title, $url = '#')
    {
        $this->_help_title = $title;
        $this->_help_url = $url;
        return $this;
    }

    public function &set_full_site($title, $url = '#')
    {
        $this->_full_title = $title;
        $this->_full_url = $url;
        return $this;
    }

    public function &show_powered_by($val = true)
    {
        $this->_powered_by = $val ? true : false;
        return $this;
    }

    public function render()
    {
        $this->set_param('id', 'footer');

        if($this->_copyright || $this->_full_title || $this->_help_title)
        {
            $p = HTML_Decorator::tag('p');
            if($this->_copyright)
                $p->add_inner($this->_copyright);
            if($this->_copyright && ($this->_full_title || $this->_help_title))
                $p->add_inner_tag('br',false);
            if($this->_full_title)
                $p->add_inner_tag('a', $this->_full_title, array('href'=>$this->_full_url));
            if($this->_full_title && $this->_help_title)
                $p->add_inner(' | ');
            if($this->_help_title)
                $p->add_inner_tag('a', $this->_help_title, array('href'=>$this->_help_url));
            $this->add_inner($p);
        }

        if($this->_powered_by)
        {
            $this->add_inner_tag('p', 'Powered by the <br><a href="http://mwf.ucla.edu" target="_blank">UCLA Mobile Web Framework</a>', array('style'=>'font-weight:bold;font-style:italic'));
        }
        
        return parent::render();
    }
}
