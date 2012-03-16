<?php

/**
 * @package decorator
 * @subpackage site_decorator
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 201203145
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');
require_once(dirname(__DIR__) . '/html/tag.class.php');

class Input_Site_Decorator extends Tag_HTML_Decorator {

    private $_id;
    private $_label;
    private $_required = false;
    private $_tooltip = '';

    /**
     *
     * @param string $id
     * @param string $label
     * @param array $params 
     */
    public function __construct($id, $label, $params = array()) {
        $this->_id = $id;
        $this->_label = $label;

        $params = array_merge($params, array('id'=>$this->_id, 'name'=>$this->_id));
        parent::__construct('input', false, $params);
    }

    /**
     * 
     * @return string 
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     *
     * @return string
     */
    public function get_label() {
        return $this->_label;
    }

    /**
     *
     * @return string
     */
    public function get_tooltip() {
        return $this->_tooltip;
    }

    /**
     *
     * @return boolean
     */
    public function is_mandatory() {
        return $this->_required;
    }

    /**
     *
     * @param string $text
     * @return Input_Site_Decorator 
     */
    public function set_tooltip($text) {
        $this->_tooltip = $text;
        return $this;
    }

    /**
     *
     * @param string $text
     * @return Input_Site_Decorator
     */
    public function set_placeholder($text) {
        $placeholder = HTML_Decorator::tag('span', $text)
                ->add_class('placeholder');
        return $this->add_inner($placeholder);
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function mandatory() {
        $this->_required = true;
        return $this->set_param('required','required');
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function invalid($message) {
        if (!empty($message)) {
            $this->add_inner_tag('p', $message, array('class' => 'invalid'));
        }
        return $this->add_class('invalid');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function disable() {
        return $this->set_param('disabled', 'disabled');
    }
    
    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_color() {
        return $this->add_class('color-field');
    }
    
    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_search() {
        return $this->add_class('search-field');
    }
    
    /**
     *
     * @return Input_Site_Decorator 
     */
    public function type_telephone() {
        return $this->add_class('tel-field');
    }
    
    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_url() {
        return $this->add_class('url-field');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_email() {
        return $this->add_class('email-field');
    }

    /**
     *
     * @return string
     */
    public function render() {
        return parent::render();
    }

}
