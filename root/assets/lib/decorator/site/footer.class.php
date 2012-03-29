<?php

/**
 *
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120312
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 * @uses Config
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');
require_once(dirname(dirname(__DIR__)) . '/config.class.php');
require_once(dirname(__DIR__) . '/html/tag.class.php');

class Footer_Site_Decorator extends Tag_HTML_Decorator {

    private $_copyright = false;
    private $_footer_link_titles = array();
    private $_footer_link_urls = array();
    private $_powered_by = true;

    public function __construct() {
        parent::__construct('div');

        if ($copyright = Config::get('global', 'copyright_text'))
            $this->set_copyright_text($copyright);
    }

    public function &set_copyright_text($text) {
        $this->_copyright = $text;
        return $this;
    }

    public function &add_footer_link($title, $url = '#') {
        $this->_footer_link_titles[] = $title;
        $this->_footer_link_urls[] = $url;
        return $this;
    }

    // @deprecated
    public function &set_help_site($title, $url = '#') {
        return $this->add_footer_link($title, $url);
    }

    // @deprecated
    public function &set_full_site($title, $url = '#') {
        return $this->add_footer_link($title, $url);
    }

    public function &show_powered_by($val = true) {
        $this->_powered_by = $val ? true : false;
        return $this;
    }

    public function render($raw) {
        $this->set_param('id', 'footer');

        if ($this->_copyright || $this->_footer_link_urls) {
            $p = HTML_Decorator::tag('p');
            if ($this->_copyright)
                $p->add_inner($this->_copyright);
            if ($this->_copyright && $this->_footer_link_urls)
                $p->add_inner_tag('br', false);
            for ($i = 0; $i < count($this->_footer_link_urls); $i++) {
                $p->add_inner_tag('a', $this->_footer_link_titles[$i], array('href' => $this->_footer_link_urls[$i]));
                if ($i < (count($this->_footer_link_urls) - 1))
                    $p->add_inner(' | ');
            }
            $this->add_inner($p);
        }

        if ($this->_powered_by) {
            $contents = array();
            $contents[] = 'Powered by the';
            $contents[] = HTML_Decorator::tag_open('br');
            $anchor =
                    HTML_Decorator::tag('a', 'Mobile Web Framework', array(
                        'rel' => 'external',
                        'class' => 'no-ext-ind',
                        'href' => 'http://mwf.ucla.edu',
                        'target' => '_blank'
                            )
            );
            $contents[] = HTML_Decorator::tag('span', $anchor, array('class' => 'external'));
            $this->add_inner_tag('p', $contents, array('style' => 'font-weight:bold;font-style:italic'));
        }

        return parent::render($raw);
    }

}
