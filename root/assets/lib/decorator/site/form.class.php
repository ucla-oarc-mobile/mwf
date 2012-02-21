<?php

/**
 * @package decorator
 * @subpackage site_decorator
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120220
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/decorator.class.php');
require_once(dirname(dirname(__FILE__)) . '/html/tag.class.php');

class Form_Site_Decorator extends Tag_HTML_Decorator {

    private $_padded = null;
    private $_title = false;

    public function __construct($title = false, $params = array()) {
        parent::__construct('form', false, 
                array_merge(array('method'=>'get', 'action'=>'#'), $params));
        if ($title)
            $this->set_title($title);
    }

    public function set_padded($val = true) {
        $this->_padded = $val ? true : false;
        return $this;
    }

    public function set_title($inner, $params = array()) {
        $this->_title = $inner === false ? 
                false : HTML_Decorator::tag('h1', $inner, $params);
        return $this;
    }

    public function render() {
        if ($this->_padded)
            $this->add_class('padded');
        elseif ($this->_padded === false)
            $this->remove_class('padded');

        $title = is_a($this->_title, 'Decorator') ? 
                $this->_title->render() : ($this->_title ? $this->_title : '');

        $this->add_inner_front($title);
        return parent::render();
    }

}
