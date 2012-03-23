<?php

/**
 * @package decorator
 * @subpackage site_decorator
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120322
 *
 * @uses Tag_HTML_Decorator
 * 
 * @implements Tag_ParamsInterface
 */
require_once(dirname(__DIR__) . '/html_decorator.class.php');
require_once(dirname(__DIR__) . '/html/Tag_ParamsInterface.php');

class Input_Site_Decorator extends Decorator implements Tag_ParamsInterface {

    private $_id;
    private $_label;
    private $_attributes;
    private $_element;
    private $_classes = array();
    private $_type = false;
    private $_required = false;
    private $_button_type = false;
    private $_invalid = false;
    private $_invalid_message = '';
    private $_options = array();
    private $_multiple = false;
    private $_size = false;
    private $_first_option_value = false;
    private $_first_option_text = false;

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

        $this->_element = 'input';
        $this->_attributes = $params;
    }

    /**
     *
     * @param string $key
     * @param string $val
     * @return Input_Site_Decorator 
     */
    public function set_param($key, $val) {
        $this->_attributes[$key] = $val;
        return $this;
    }

    /**
     *
     * @param array $params
     * @return Input_Site_Decorator 
     */
    public function set_params($params) {
        $this->_attributes = array_merge($this->_attributes, $params);
        return $this;
    }

    public function add_class($class) {
        $this->_classes[] = $class;
        return $this;
    }

    public function remove_class($class) {
        $index = array_search($class, $this->_classes);
        if ($index !== false) {
            unset($this->_classes[$index]);
            $this->_classes = array_values($this->_classes);
        }
        return $this;
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
    public function get_invalid_message() {
        return $this->_invalid_message;
    }

    /**
     *
     * @return boolean
     */
    public function is_mandatory() {
        return (($this->_required && $this->_type !== 'color'));
    }

    /**
     * 
     * @return boolean
     */
    public function is_option() {
        return ($this->_type === "checkbox" || $this->_type === "radio");
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
    public function set_placeholder($text) {
        return $this->set_param('placeholder', $text);
    }

    /**
     *
     * @param int $size
     * @return Input_Site_Decorator 
     */
    public function set_size($size) {
        $this->_size = true;
        return $this->set_param('size', (int) $size);
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
    public function multiple() {
        $this->_multiple = true;
        return $this->set_param('multiple', false);
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function invalid($message='') {
        $this->_invalid = true;
        if (!empty($message)) {
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
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_color() {
        $this->_type = 'color';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_search() {
        $this->_type = 'search';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function type_telephone() {
        $this->_type = 'tel';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_url() {
        $this->_type = 'url';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_email() {
        $this->_type = 'email';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_date() {
        $this->_type = 'date';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_month() {
        $this->_type = 'month';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_week() {
        $this->_type = 'week';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_datetime_local() {
        $this->_type = 'datetime-local';
        $this->_element = 'input';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_time() {
        $this->_type = 'time';
        $this->_element = 'input';
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
        $this->_element = 'input';
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
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_checkbox() {
        $this->_type = 'checkbox';
        $this->_element = 'input';
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator
     */
    public function type_radio() {
        $this->_type = 'radio';
        $this->_element = 'input';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_number() {
        $this->_type = 'number';
        $this->_element = 'input';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_range() {
        $this->_type = 'range';
        $this->_element = 'input';
        return $this;
    }

    /**
     * 
     * @return Input_Site_Decorator
     */
    public function type_select() {
        $this->_element = 'select';
        $this->_type = false;
        return $this;
    }

    /**
     *
     * @return Input_Site_Decorator 
     */
    public function type_textarea() {
        $this->_element = 'textarea';
        $this->_type = false;
        return $this;
    }

    /**
     *
     * @param string $value
     * @param string $label
     * @param boolean $prepend
     * @return Input_Site_Decorator 
     */
    public function add_option($value, $label, $prepend=false) {
        $value = (string) $value;
        $label = (string) $label;

        $this->type_select();

        $tag = HTML_Decorator::tag('option', $label, array('value' => $value));
 
        if ($prepend) {
            array_unshift($this->_options, $tag);
        } else {
            $this->_options[] = $tag;
        }
        
        if ((count($this->_options) === 1) || $prepend) {
            $this->_first_option_value = $value;
            $this->_first_option_text = $label;
        }
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
        /* HTML5 color input is not permitted to be set to "required" */
        if (($this->_type === 'color') && isset($this->_attributes['required'])) {
            unset($this->_attributes['required']);
        }

        if (($this->_element === 'textarea') && isset($this->_attributes['size'])) {
            unset($this->_attributes['size']);
        }

        if (($this->_element !== 'select') && isset($this->_attributes['multiple'])) {
            unset($this->_attributes['multiple']);
        }


        /*
         * HTML5 requires tha the first child option element of a select element 
         * with a required attribute and without a multiple attribute, and whose 
         * size is 1, must have either an empty value attribute, or must have no 
         * text content.
         */
        if (($this->_element === 'select') &&
                isset($this->_attributes['required']) &&
                !isset($this->_attributes['multiple'])) {

            if (!isset($this->_attributes['size']) ||
                    $this->_attributes['size'] === 1) {

                if (count($this->_options) === 0) {

                    $this->add_option('', '');
                } else if ($this->_first_option_text !== '' &&
                        $this->_first_option_value !== '') {

                    $this->add_option('', '', true);
                }
            }
        }

        $inner = false;
        switch ($this->_element) {
            case 'select':
                $inner = empty($this->_options) ? '' : $this->_options;
                break;

            case 'textarea':
                if (isset($this->_attributes['value'])) {
                    $inner = $this->_attributes['value'];
                    unset($this->_attributes['value']);
                } else {
                    $inner = '';
                }
        }

        $tag_decorator = HTML_Decorator::tag($this->_element, $inner, $this->_attributes);

        foreach ($this->_classes as $class) {
            $tag_decorator->add_class($class);
        }

        if ($this->_button_type) {
            $tag_decorator->add_class($this->_button_type);
        }
        if ($this->_type) {
            $tag_decorator->set_param('type', $this->_type);
        }
        return $tag_decorator->render();
    }

}
