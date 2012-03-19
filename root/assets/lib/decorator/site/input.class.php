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
    private $_type=false;
    private $_required = false;
    private $_tooltip = '';
    private $_button_type = false;
    private $_invalid = false;
    private $_invalid_message = '';

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
     * @return string
     */
    public function get_invalid_message() {
        return $this->_invalid_message;
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
     * @return boolean
     */
    public function is_option() {
        return ($this->_type==="checkbox" || $this->_type==="radio");
    }
    
    /**
     *
     * @return boolean
     */
    public function is_invalid() {
        return $this->_invalid;
    }

    /**
     * Sets the parameter name for the input. For example, all radio buttons
     * in a group should have the same parameter name.
     * 
     * @param string $text
     * @return Input_Site_Decorator
     */
    public function set_name($text) {
        return $this->set_param('name', $text);
    }

    /**
     *
     * @param string $text
     * @return Input_Site_Decorator 
     */
    public function set_value($text) {
        return $this->set_param('value', $text);
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
        $this->_invalid = true;
        if (! empty($message)) {
            $this->_invalid_message = $message;
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
        $this->_type = 'text';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_color() {
        $this->_type = 'color';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_search() {
        $this->_type = 'search';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function type_telephone() {
        $this->_type = 'tel';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_url() {
        $this->_type = 'url';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_email() {
        $this->_type = 'email';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_date() {
        $this->_type = 'date';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_month() {
        $this->_type = 'month';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_week() {
        $this->_type = 'week';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_datetime_local() {
        $this->_type = 'datetime-local';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_time() {
        $this->_type = 'time';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_submit() {
        if (!$this->_button_type) {
            $this->primary();
        }
        $this->_type = 'submit';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_button() {
        if (!$this->_button_type) {
            $this->neutral();
        }
        $this->_type = 'submit';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_checkbox() {
        $this->_type = 'checkbox';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_radio() {
        $this->_type = 'radio';
        return $this;
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
        if ($this->_type) {
            $this->set_param('type', $this->_type);
        }
        return parent::render();
    }

}
