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
    private $_button_type = false;

    /**
     *
     * @param string $id
     * @param string $label
     * @param array $params 
     */
    public function __construct($id = false, $label = false, $params = array()) {
        $this->_id = $id;
        $this->_label = $label;

        if ($this->_id !== false) {
            $params['id'] = $this->_id;
        }

        if ($this->_label !== false) {
            $params['name'] = $this->_id;
        }

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
        return $this->set_param('required', 'required');
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function invalid($message='') {
        if (!empty($message)) {
            $invalid = HTML_Decorator::tag('p', $message)
                    ->add_class('invalid');
            $this->add_inner($invalid);
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
    public function type_text() {
        return $this->set_param('type', 'text');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_color() {
        return $this->set_param('type', 'color');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_search() {
        return $this->set_param('type', 'search');
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function type_telephone() {
        return $this->set_param('type', 'tel');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_url() {
        return $this->set_param('type', 'url');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_email() {
        return $this->set_param('type', 'email');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_date() {
        return $this->set_param('type', 'date');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_month() {
        return $this->set_param('type', 'month');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_week() {
        return $this->set_param('type', 'week');
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_datetime_local() {
        return $this->set_param('type', 'datetime-local');
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_time() {
        return $this->set_param('type', 'time');
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_submit() {
        if (! $this->_button_type) {
            $this->primary();
        }
        return $this->set_param('type', 'submit');
    }
    
    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_button() {
        if (! $this->_button_type) {
            $this->neutral();
        }
        return $this->set_param('type', 'submit');
    }
    
    /**
     *
     * @return Input_Site_Decorator 
     */
    public function primary() {
        $this->_button_type = 'primary';
        return $this;
    }
    
    /**
     *
     * @return Input_Site_Decorator 
     */
    public function secondary() {
        $this->_button_type = 'secondary';
        return $this;
    }
    
    /**
     *
     * @return Input_Site_Decorator 
     */
    public function neutral() {
        $this->_button_type = 'neutral';
        return $this;
    }

    /**
     *
     * @return string
     */
    public function render() {
        if ($this->_button_type) {
            $this->add_class($this->_button_type);
        }
        return parent::render();
    }

}
