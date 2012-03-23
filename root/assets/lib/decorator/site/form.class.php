<?php

/**
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ilin
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120315
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');
require_once(dirname(__DIR__) . '/html/tag.class.php');

class Form_Site_Decorator extends Tag_HTML_Decorator {

    /**
     * The form's title text.
     * 
     * @var null|bool
     */
    private $_title = false;

    /**
     * 
     * @param type $title Form title text
     * @param type $params 
     */
    public function __construct($title = false, $params = array()) {
        parent::__construct('form', false, array_merge(array('method' => 'get', 'action' => '#'), $params));
        if ($title)
            $this->set_title($title);
    }

    /**
     * Sets the form's padded attribute.
     * 
     * @param boolean $val Defaults to true.
     * @return Form_Site_Decorator 
     */
    public function set_padded($val = true) {
        if ($val) {
            $this->add_class('padded');
        } else {
            $this->remove_class('padded');
        }
        return $this;
    }

    /**
     * Sets the form's short attribute.
     * 
     * @param boolean $val Defaults to true.
     * @return Form_Site_Decorator 
     */
    public function set_short($val = true) {
        if ($val) {
            $this->add_class('short');
        } else {
            $this->remove_class('short');
        }
        return $this;
    }

    /**
     * Sets the form's title.
     * 
     * @param string $text
     * @param array $params Optional params array.  Possible values include 'class' => 'blue'.
     * @return Form_Site_Decorator 
     */
    public function set_title($text, $params = array()) {
        $this->_title = $text === false ? false : HTML_Decorator::tag('h1', $text, $params);
        return $this;
    }

    /**
     * Adds a subtitle.
     * 
     * @param string $text
     * @param array $params
     * @return Form_Site_Decorator 
     */
    public function add_subtitle($text, $params = array()) {
        $this->add_inner_tag('h4', $text, $params);
        return $this;
    }

    /**
     * Adds a paragraph.
     * 
     * @param string $text
     * @param array $params
     * @return Form_Site_Decorator 
     */
    public function add_paragraph($text, $params = array()) {
        $this->add_inner_tag('p', $text, $params);
        return $this;
    }

    public function add_input($input_decorator) {
        if (!is_a($input_decorator, 'Input_Site_Decorator')) {
            trigger_error('Wrong type sent to add_input()', E_USER_ERROR);
        }

        $label = $input_decorator->get_label();
        if ($label) {
            $span_decorator = HTML_Decorator::tag('span', $label);

            if ($input_decorator->is_mandatory()) {
                $span_decorator->add_class('required');
            }

            $label_decorator = HTML_Decorator::tag('label', $span_decorator);

            if ($input_decorator->is_option()) {
                $label_decorator->add_inner_front($input_decorator);
                $label_decorator->add_class('option');
            } else {
                $label_decorator->add_inner($input_decorator);
            }

            $invalid_message = $input_decorator->get_invalid_message();
            if (!empty($invalid_message)) {
                $label_decorator->add_inner(HTML_Decorator::tag('span', $invalid_message, array('class' => 'invalid')));
            }

            $this->add_inner($label_decorator);
        } else {
            $this->add_inner($input_decorator);
        }
        return $this;
    }

    /**
     *
     * @param string $text
     * @param string $url
     * @param string $class
     * @return Form_Site_Decorator 
     */
    private function _add_link_button($text, $url, $class) {
        return $this->add_inner(HTML_Decorator::tag('a', $text, array('href' => $url))->add_class($class)->add_class('button'));
    }

    /**
     *
     * @param string $text
     * @param string $url 
     * @return Form_Site_Decorator
     */
    public function add_link_button_primary($text, $url='#') {
        return $this->_add_link_button($text, $url, 'primary');
    }

    /**
     *
     * @param string $text
     * @param string $url 
     * @return Form_Site_Decorator
     */
    public function add_link_button_secondary($text, $url='#') {
        return $this->_add_link_button($text, $url, 'secondary');
    }

    /**
     *
     * @param string $text
     * @param string $url 
     * @return Form_Site_Decorator
     */
    public function add_link_button_neutral($text, $url='#') {
        return $this->_add_link_button($text, $url, 'neutral');
    }

    /**
     * Adds a group of checkbox input types.
     * 
     * @param string $id Id and name of element.
     * @param string $label
     * @param array $checkboxes Array of Input_Site_Decorators for checkboxes
     * @return Form_Site_Decorator 
     */
    public function add_checkbox_group($id = '', $label = false, $checkboxes = array()) {
        foreach ($checkboxes as $checkbox) {
            if (!is_a($checkbox, 'Input_Site_Decorator')) {
                trigger_error('Wrong type sent to add_checkbox_group()', E_USER_ERROR);
            }
            $checkbox->type_checkbox();
        }
        return $this->_add_options_helper($id, $label, $checkboxes);
    }

    /**
     * Adds a group of radio input types..
     * 
     * @param string $id Id and name of element.
     * @param string $label
     * @param array $options Array of Input_Site_Decorators for checkboxes
     * @return Form_Site_Decorator 
     */
    public function add_radio_group($id, $label = false, $radios = array()) {
        foreach ($radios as $radio) {
            if (!is_a($radio, 'Input_Site_Decorator')) {
                trigger_error('Wrong type sent to add_radio_group()', E_USER_ERROR);
            }
            $radio->type_radio();
            $radio->set_name($id);
        }
        return $this->_add_options_helper($id, $label, $radios);
    }

    /**
     * Helper function to add a group of options (checkboxes or radios).
     * 
     * @param string $id
     * @param string $label
     * @param array $options
     * @return Form_Site_Decorator 
     */
    private function _add_options_helper($id, $label, $options) {
        if ($label) {
            $this->add_inner_tag('label', $label);
        }

        $option_elements = array();

        foreach ($options as $option) {
            $option_elements[] = HTML_Decorator::tag('label', $option->get_label())->add_inner_front($option);
        }

        return $this->add_inner_tag('div', $option_elements, array('id' => $id, 'class' => 'option'));
    }

    /**
     *
     * @return string
     */
    public function render() {
        if (is_a($this->_title, 'Decorator')) {
            $this->add_inner_front($this->_title);
        }

        return parent::render();
    }

}