<?php

/**
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120312
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 * @uses Classification
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/decorator.class.php');
require_once(dirname(dirname(__FILE__)) . '/html/tag.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/classification.class.php');

class Menu_Site_Decorator extends Tag_HTML_Decorator {

    private $_padded = null;
    private $_detailed = null;
    private $_homescreen = null;
    private $_title = false;
    private $_list = array();
    private $_align = false;

    public function __construct($title = false, $params = array()) {
        parent::__construct('div', false, $params);
        $this->add_class('menu');
        if ($title)
            $this->set_title($title);
    }

    public function set_padded($val = true) {
        $this->_padded = $val ? true : false;
        return $this;
    }

    public function set_detailed($val = true) {
        $this->_detailed = $val ? true : false;
        return $this;
    }

    public function set_homescreen($val = true) {
        $this->_homescreen = $val ? true : false;
        return $this;
    }

    public function set_center_aligned() {
        $this->_align = 'center';
        return $this;
    }

    public function set_left_aligned() {
        $this->_align = 'left';
        return $this;
    }

    public function set_title($inner, $params = array()) {
        $this->_title = $inner === false ? false : HTML_Decorator::tag('h1', $inner, $params);
        return $this;
    }

    public function set_title_light($inner, $params = array()) {
        if (!isset($params['class']))
            $params['class'] = 'light';
        elseif (!in_array('light', explode(' ', $params['class'])))
            $params['class'] .= ' light';

        return $this->set_title($inner, $params);
    }

    public function add_item($name, $url, $li_params = array(), $a_params = array(), $key=null) {
        if (!is_array($this->_list))
            $this->_list = array();
        if (!is_array($li_params))
            $li_params = array();
        if (!is_array($a_params))
            $a_params = array();

        $link = HTML_Decorator::tag('a', $name ? $name : '', array_merge($a_params, array('href' => $url ? $url : '#')));
        if (is_string($key) || is_int($key)) {
            $this->_list[$key] = HTML_Decorator::tag('li', $link, $li_params);
        } else {
            $this->_list[] = HTML_Decorator::tag('li', $link, $li_params);
        }

        return $this;
    }

    public function add_text($text, $li_params = array(), $p_params = array()) {
        if (!is_array($this->_list))
            $this->_list = array();
        if (!is_array($li_params))
            $li_params = array();
        if (!is_array($p_params))
            $p_params = array();

        $p = HTML_Decorator::tag('p', $text ? $text : '', $p_params);
        $this->_list[] = HTML_Decorator::tag('li', $p, $li_params);

        return $this;
    }

    public function render($raw = false) {
        if ($this->_detailed)
            $this->add_class('detailed');
        elseif ($this->_detailed === false)
            $this->remove_class('detailed');

        if ($this->_padded)
            $this->add_class('padded');
        elseif ($this->_padded === false)
            $this->remove_class('padded');

        if ($this->_homescreen)
            $this->add_class('front')->set_param('id', 'main_menu');
        elseif ($this->_homescreen === false)
            $this->remove_class('front');

        if ($this->_align)
            $this->add_class($this->_align);

        if ($this->_title) {
            $this->add_inner_front($this->_title);
        }

        if ($this->_homescreen && Classification::is_full() && Config::get('frontpage', 'configurable_homescreen')) {
            $js = 'mwf.full.configurableMenu("homescreen_layout").render("main_menu_list",' .
                    json_encode(
                            array_map(function($obj) {
                                        return $obj->render($raw);
                                    }, $this->_list)) . ');';

            $this->add_inner(HTML_Decorator::tag('ol')->set_param('id', 'main_menu_list'));
            $this->add_inner(HTML_Decorator::tag('script', $js));
        } else {
            if (count($this->_list) > 0) {
                $this->add_inner(HTML_Decorator::tag('ol', $this->_list));
            }
        }

        return parent::render($raw);
    }

}
