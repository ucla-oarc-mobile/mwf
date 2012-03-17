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
            $label_decorator = HTML_Decorator::tag('label', $label, array('for' => $input_decorator->get_id()));

            if ($input_decorator->is_mandatory()) {
                $label_decorator->add_class('required');
            }

            $this->add_inner($label_decorator);

            $tooltip = $input_decorator->get_tooltip();
            if (!empty($tooltip)) {
                $tooltip_decorator = HTML_Decorator::tag('span', $tooltip)
                        ->add_class('tiptext');
                $this->add_inner($tooltip_decorator);
            }
        }
        return $this->add_inner($input_decorator);
    }

    /**
     * Adds a submit button (defaults to a primary button).
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_submit($value = 'Submit', $params = array()) {
        return $this->_add_button_helper($value, 'primary', $params);
    }

    /**
     * Adds a primary submit button.
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_primary_button($value = '', $params = array()) {
        return $this->_add_button_helper($value, 'primary', $params);
    }

    /**
     * Adds a secondary submit button.
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_secondary_button($value = '', $params = array()) {
        return $this->_add_button_helper($value, 'secondary', $params);
    }

    /**
     * Adds a neutral submit button.
     * 
     * @param string $value
     * @param array $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_button($value = '', $params = array()) {
        return $this->_add_button_helper($value, 'neutral', $params);
    }

    /**
     * Helper function to generate form buttons.
     * 
     * @param string $value
     * @param array $params
     * @param string|false $class
     * @return Form_Site_Decorator 
     */
    private function _add_button_helper($value, $class, $params) {
        if (isset($params['class'])) {
            $class = $class . ' ' . $params['class'];
            unset($params['class']);
        }

        $this->add_inner_tag('input', false, array_merge($params, array('type' => 'submit', 'value' => $value, 'class' => $class)));

        return $this;
    }

    /**
     * Adds a primary link button.
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_primary_link_button($value = '', $params = array()) {
        return $this->_add_link_button_helper($value, 'primary', $params);
    }

    /**
     * Adds a secondary link button.
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_secondary_link_button($value = '', $params = array()) {
        return $this->_add_link_button_helper($value, 'secondary', $params);
    }

    /**
     * Adds a neutral link button.
     * 
     * @param type $value
     * @param type $params Optiaonal parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_link_button($value = '', $params = array()) {
        return $this->_add_link_button_helper($value, 'neutral', $params);
    }

    /**
     * Helper function to generate form link button.
     * 
     * @param type $value
     * @param type $class
     * @param array $params
     * @return Form_Site_Decorator 
     */
    private function _add_link_button_helper($value, $class, $params) {
        $this->add_inner_tag('a', $value, array_merge($params, array('class' => 'button ' . $class)));

        return $this;
    }

    /**
     * Adds a group of checkbox input types.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $options Array of arrays representing checkboxes.
     *      array(
     *          array('id' => 'checkbox-1', 'label' => 'One', 'value' => 1),
     *          array('id' => 'checkbox-2', 'label' => 'Two', 'value' => 2),
     *          array('id' => 'checkbox-3', 'label' => 'Three', 'value' => 3)
     *      )
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_checkboxes($id = '', $label = false, $options = array(), $params = array()) {
        return $this->_add_options_helper('checkbox', $id, $label, $options, $params);
    }

    /**
     * Adds a group of radio input types..
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $options Array of arrays representing checkboxes.
     *      array(
     *          array('id' => 'radio-1', 'label' => 'One', 'value' => 1),
     *          array('id' => 'radio-2', 'label' => 'Two', 'value' => 2),
     *          array('id' => 'radio-3', 'label' => 'Three', 'value' => 3)
     *      )
     * @param type $params Optiaonal parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_radios($id = '', $label = false, $options = array(), $params = array()) {
        return $this->_add_options_helper('radio', $id, $label, $options, $params);
    }

    /**
     * Helper function to add a group of options (checkboxes or radios).
     * 
     * @param type $type
     * @param type $id
     * @param type $label
     * @param type $options
     * @param type $params
     * @return Form_Site_Decorator 
     */
    private function _add_options_helper($type, $id, $label, $options, $params) {
        $align = 'left';
        //@todo $options et al. should be an object, not an array of arrays.
        //@todo align options et al. should be enum/constants, not string values
        if (!empty($params['align'])) {
            $align = $params['align'];
        }

        $this->_is_invalid_helper($params);

        $this->_disabled_helper($params);

        if ($label) {
            $this->_add_label_tooltip($id, $label, $params);
        }

        $option_elements = array();

        foreach ($options as $option) {
            $option_id = isset($option['id']) ? $option['id'] : false;
            $option_label = $option['label'];
            $option_value = $option['value'];
            $option_params = isset($option['params']) ? $options['param'] : array();

            if (!is_array($option_params))
                $option_params = array();

            if (!empty($params['disabled'])) {
                $option_params['disabled'] = 'disabled';
            }

            if ($align !== 'left') {
                $option_elements[] = HTML_Decorator::tag('label', $option_label, array_merge($params, array('for' => $option_id)));
            }

            $option_elements[] = HTML_Decorator::tag('input', false, array_merge($option_params, array('type' => $type,
                                'id' => $option_id,
                                'name' => $id,
                                'value' => $option_value)));

            if ($align === 'left') {
                $option_elements[] = HTML_Decorator::tag('label', $option_label, array_merge($params, array('for' => $option_id)));
            }

            $option_elements[] = HTML_Decorator::tag('br', false);
        }

        $class = 'option';

        if ($align === 'right') {
            $class = $class . ' right';
        } else if ($align === 'justify') {
            $class = $class . ' justify';
        }

        $this->add_inner_tag('div', $option_elements, array('id' => $id, 'class' => $class));

        $this->_add_invalid($params);

        return $this;
    }

    /**
     * Adds a number input field.
     * 
     * @param string $id Id and name of element.
     * @param string $label
     * @param type $min
     * @param type $max
     * @param array $params Optional parameters.  Possible values include 'step' => 2, 'selected' => 4, 'required' => true.
     * @return type 
     */
    public function add_number($id = false, $label = false, $min = false, $max = false, $params = array()) {
        $min = (float) $min;
        $max = (float) $max;

        $step = 1;
        if (isset($params['step']) && is_numeric($params['step'])) {
            $step = (float) $params['step'];
        }

        $options = array();
        for ($i = $min; $i <= $max; $i += $step) {
            $options[] = array('label' => $i, 'value' => $i);
        }

        $params['class'] = isset($params['class']) ?
                $params['class'] . ' number-field' :
                'number-field';

        return $this->add_select($id, $label, $options, $params);
    }

    /**
     * Adds a range input field.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min
     * @param type $max
     * @param array $params Optional parameters.  Possible values include 'step' => 2, 'selected' => 4, 'required' => true.
     * @return type 
     */
    public function add_range($id = false, $label = false, $min = false, $max = false, $params = array()) {
        $min = (float) $min;
        $max = (float) $max;

        $step = 1;
        if (isset($params['step']) && is_numeric($params['step'])) {
            $step = (float) $params['step'];
        }

        $options = array();

        for ($i = $min; $i <= $max; $i += $step) {
            $options[] = array('label' => $i, 'value' => $i);
        }

        $params['class'] = isset($params['class']) ?
                $params['class'] . ' range-field' :
                'range-field';

        return $this->add_select($id, $label, $options, $params);
    }

    /**
     * Adds a select input field.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $options An array of arrays representing options.
     *      array(
     *          array('label' => 'One', 'value' => 1),
     *          array('label' => 'Two', 'value' => 2),
     *          array('label' => 'Three', 'value' => 3)
     *      )
     * @param array $params Optional parameters.  Possible values include 'disabled' => true.
     * @return type 
     */
    public function add_select($id = false, $label = false, $options = array(), $params = array()) {
        $selected = isset($params['selected']) ? $params['selected'] : false;

        $this->_is_invalid_helper($params);

        $this->_disabled_helper($params);

        if ($label) {
            $this->_add_label_tooltip($id, $label, $params);
        }

        $option_elements = array();

        foreach ($options as $option) {
            $option_label = $option['label'];
            $option_value = $option['value'];
            $option_params = isset($option['params']) ? $option['params'] : array();

            if (!is_array($option_params))
                $option_params = array();

            if ($selected && $option_value === $selected)
                $option_params['selected'] = 'selected';

            $option_elements[] = HTML_Decorator::tag('option', $option_label, array_merge($option_params, array('value' => $option_value)));
        }

        $this->add_inner_tag('select', $option_elements, array_merge($params, array('id' => $id, 'name' => $id)));

        $this->_add_invalid($params);

        return $this;
    }

    /**
     * Adds a textarea input field.
     * 
     * @param type $id
     * @param type $label
     * @param type $required
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return Form_Site_Decorator 
     */
    public function add_textarea($id = false, $label = false, $params = array()) {
        $this->_is_invalid_helper($params);

        $this->_disabled_helper($params);

        if ($label) {
            $this->_add_label_tooltip($id, $label, $params);
        }

        $this->add_inner_tag('textarea', '', array_merge($params, array('id' => $id, 'name' => $id)));

        $this->_add_placeholder($params);

        $this->_add_invalid($params);

        return $this;
    }

    /**
     * Helper function to handle decorating invalid fields.
     * 
     * @param string $params 
     */
    // @todo We don't really want to pass-by-reference, do we?  Maybe set an instance variable instead of modifying the $params array?
    private function _is_invalid_helper($params) {
        if (!empty($params['invalid'])) {
            if (!isset($params['class'])) {
                $params['class'] = '';
            }
            $params['class'] = $params['class'] . ' invalid';
        }
    }

    /**
     * Helper function to handle decorating disabled fields.
     * 
     * @param string $params 
     */
    private function _disabled_helper(&$params) {
        if (!empty($params['disabled'])) {
            $params['disabled'] = 'disabled';
        }
    }

    /**
     * Helper function to add label and tooltips.
     * 
     * @param string $id
     * @param string $label
     * @param array $params 
     */
    private function _add_label_tooltip($id, $label, $params) {
        $label_params = array();
        if (!empty($params['required'])) {
            if (!empty($label_params['class'])) {
                $label_params['class'] = $params['class'] . ' required';
            } else {
                $label_params['class'] = 'required';
            }
        }
        $this->add_inner_tag('label', $label, array_merge($label_params, array('for' => $id)));

        if (!empty($params['tooltip'])) {
            $this->add_inner_tag('span', $params['tooltip'], array('class' => 'tiptext'));
        }
    }

    /**
     * Helper function to add placeholder.
     * 
     * @param array $params 
     */
    private function _add_placeholder($params) {
        if (!empty($params['placeholder'])) {
            $this->add_inner_tag('span', $params['placeholder'], array('class' => 'placeholder'));
        }
    }

    /**
     * Helper function to add invalid text.
     * 
     * @param type $params 
     */
    private function _add_invalid($params) {
        if (!empty($params['invalid'])) {
            $this->add_inner_tag('p', $params['invalid'], array('class' => 'invalid'));
        }
    }

    public function render() {
        if (is_a($this->_title, 'Decorator')) {
            $this->add_inner_front($this->_title);
        }

        return parent::render();
    }

}