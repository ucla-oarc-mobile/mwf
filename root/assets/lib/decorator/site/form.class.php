<?php

/**
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ilin
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120313
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');
require_once(dirname(__DIR__) . '/html/tag.class.php');

class Form_Site_Decorator extends Tag_HTML_Decorator {

    /**
     * Is form padded?  Defaults to false.
     * 
     * @var bool
     */
    private $_padded = false;

    /**
     * Is form short?  Defaults to false.
     * 
     * @var bool
     */
    private $_short = false;

    /**
     * The form's title text.
     * 
     * @var null|bool
     */
    private $_title = false;

    /**
     * An array representing all form elements inside this form.
     * 
     * @var array
     */
    private $_form_elements = array();

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
     * @param type $val Defaults to true.
     * @return Form_Site_Decorator 
     */
    public function set_padded($val = true) {
        $this->_padded = $val ? true : false;
        return $this;
    }

    /**
     * Sets the form's short attribute.
     * 
     * @param type $val Defaults to true.
     * @return Form_Site_Decorator 
     */
    public function set_short($val = true) {
        $this->_short = $val ? true : fasle;
        return $this;
    }

    /**
     * Sets the form's title.
     * 
     * @param type $inner
     * @param type $params Optional params array.  Possible values include 'class' => 'blue'.
     * @return Form_Site_Decorator 
     */
    public function set_title($inner, $params = array()) {
        $this->_title = $inner === false ? false : HTML_Decorator::tag('h1', $inner, $params);
        return $this;
    }

    /**
     * Adds a subtitle.
     * 
     * @param type $inner
     * @param type $params
     * @return Form_Site_Decorator 
     */
    public function add_subtitle($inner, $params = array()) {
        $this->_form_elements[] = HTML_Decorator::tag('h4', $inner, $params);
        return $this;
    }

    /**
     * Adds a paragraph.
     * 
     * @param type $inner
     * @param type $params
     * @return Form_Site_Decorator 
     */
    public function add_paragraph($inner, $params = array()) {
        $this->_form_elements[] = HTML_Decorator::tag('p', $inner, $params);
        return $this;
    }

    /**
     * Adds a section.
     * 
     * @param type $inner
     * @param type $params
     * @return Form_Site_Decorator 
     */
    public function add_section($inner, $params = array()) {
        $this->_form_elements[] = HTML_Decorator::tag('div', $inner, $params);
        return $this;
    }

    /**
     * Adds a fieldset.
     * 
     * @param type $inner
     * @param type $params
     * @return Form_Site_Decorator 
     */
    public function add_fieldset($inner, $params = array()) {
        $this->_form_elements[] = HTML_Decorator::tag('fieldset', $inner, $params);
        return $this;
    }

    /**
     * Adds an input text form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_text($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'text', $params);
    }

    /**
     * Adds an input color form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_color($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'color-field', $params);
    }

    /**
     * Adds an input search form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_search($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'search-field', $params);
    }

    /**
     * Adds an input tel form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_tel($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'tel-field', $params);
    }

    /**
     * Adds an input url form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_url($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'url-field', $params);
    }

    /**
     * Adds an input email form element.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $params Optional parameters.  Possible values include 'required' => true, 'disabled' => true.
     * @return type 
     */
    public function add_email($id = false, $label = false, $params = array()) {
        return $this->_add_input_helper($id, $label, 'email-field', $params);
    }

    /**
     * Helper function to add input form element.
     * 
     * @param string $id
     * @param string $label
     * @param string $field
     * @param array $params
     * @return Form_Site_Decorator 
     */
    private function _add_input_helper($id, $label, $field, $params) {
        $this->_is_invalid_helper($params);

        $this->_disabled_helper($params);

        if ($label) {
            $this->_add_label_tooltip($id, $label, $params);
        }

        if ($field !== 'text') {
            $params['class'] = $params['class'] . ' ' . $field;
        }

        $this->_form_elements[] = HTML_Decorator::tag('input', false, array_merge($params, array('type' => 'text', 'id' => $id, 'name' => $id)));

        $this->_add_placeholder($params);

        $this->_add_invalid($params);

        return $this;
    }

    /**
     * Adds a date form element.  Three select inputs with month, day and year.  
     * The default selected value is 'now'.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min Valid format is 'YYYY-MM-DD'.  Such as '2012-12-31'.
     * @param type $max Valid format is 'YYYY-MM-DD'.  Such as '2012-12-31'.
     * @param type $params Optional parameters.  Possible values include 'selected' => '2012-12-31', disabled' => true.
     * @return type 
     */
    public function add_date($id = false, $label = false, $min = false, $max = false, $params = array()) {
        return $this->_add_datetime_helper('date', $id, $label, $min, $max, $params);
    }

    /**
     * Adds a month form element.  Two select inputs with month and year.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min Valid format is 'YYYY-MM'.  Such as '2012-12'.
     * @param type $max Valid format is 'YYYY-MM'.  Such as '2012-12'.
     * @param type $params Optional parameters.  Possible values include 'selected' => '2012-12', disabled' => true.
     * @return type 
     */
    public function add_month($id = false, $label = false, $min = false, $max = false, $params = array()) {
        return $this->_add_datetime_helper('month', $id, $label, $min, $max, $params);
    }

    /**
     * Adds a week form element.  Two select inputs with week and year.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min Valid format is 'YYYY-WWW'.  Such as '2012-W12'.
     * @param type $max Valid format is 'YYYY-WWW'.  Such as '2012-W12'.
     * @param type $params Optional parameters.  Possible values include 'selected' => '2012-W12', disabled' => true.
     * @return type 
     */
    public function add_week($id = false, $label = false, $min = false, $max = false, $params = array()) {
        return $this->_add_datetime_helper('week', $id, $label, $min, $max, $params);
    }

    /**
     * Adds a datetime local form element.  Six select inputs with month, day, 
     * year, hour, minute and seconds.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min Valid format is 'YYYY-MM-DD HH:MM:SS'.  Such as '2012-12-31 23:59:59'.
     * @param type $max Valid format is 'YYYY-MM-DD HH:MM:SS'.  Such as '2012-12-31 23:59:59'.
     * @param type $params Optional parameters.  Possible values include 'selected' => '2012-12-31 23:59:59', disabled' => true.
     * @return type 
     */
    public function add_datetime_local($id = false, $label = false, $min = false, $max = false, $params = array()) {
        return $this->_add_datetime_helper('datetime-local', $id, $label, $min, $max, $params);
    }

    /**
     * Adds a time form element.  Three select inputs with hour, minute and second.
     * 
     * @param type $id Id and name of element.
     * @param type $label
     * @param type $min Valid format is 'HH:MM:SS'.  Such as '23:59:59'.
     * @param type $max Valid format is 'HH:MM:SS'.  Such as '23:59:59'.
     * @param type $params Optional parameters.  Possible values include 'selected' => '23:59:59', disabled' => true.
     * @return type 
     */
    public function add_time($id = false, $label = false, $min = false, $max = false, $params = array()) {
        return $this->_add_datetime_helper('time', $id, $label, $min, $max, $params);
    }

    /**
     * Helper function to generate date/time related form elements.
     * 
     * @param string $field
     * @param string $id
     * @param string $label
     * @param type $min
     * @param type $max
     * @param type $params
     * @return Form_Site_Decorator 
     */
    private function _add_datetime_helper($field, $id, $label, $min, $max, $params) {
        $selected = isset($params['selected']) ? $params['selected'] : 'now';


        $this->_is_invalid_helper($params);

        $this->_disabled_helper($params);

        if ($label) {
            $this->_add_label_tooltip($id, $label, $params);
        }

        $min = new DateTime($min);
        $max = new DateTime($max);

        $selected = new DateTime($selected);

        $current = $min;

        $years = array();
        $months = array();
        $weeks = array();
        $days = array();
        $hours = array();
        $minutes = array();
        $seconds = array();

        /* increment from min to max differently depending on field type */
        if ($field === 'date' || $field === 'datetime-local') {
            while ($current <= $max) {
                $Y = $current->format('Y');
                $M = $current->format('M');
                $m = $current->format('m');
                $d = $current->format('d');

                $years[$Y] = array('label' => $Y, 'value' => $Y);
                $months[$m] = array('label' => $M, 'value' => $m);
                $days[$d] = array('label' => ltrim($d, '0'), 'value' => $d);

                $current->add(DateInterval::createFromDateString('1 day'));
            }

            if ($field === 'datetime-local') {
                /* hours */
                for ($i = 0; $i < 24; $i++) {
                    $v = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $hours[$i] = array('label' => $i, 'value' => $v);
                }

                /* minutes & seconds */
                for ($i = 0; $i < 60; $i++) {
                    $v = str_pad($i, 2, "0", STR_PAD_LEFT);
                    $minutes[$i] = array('label' => $i, 'value' => $v);
                    $seconds[$i] = array('label' => $i, 'value' => $v);
                }
            }
        } else if ($field === 'month') {
            while ($current <= $max) {
                $Y = $current->format('Y');
                $M = $current->format('M');
                $m = $current->format('m');

                $years[$Y] = array('label' => $Y, 'value' => $Y);
                $months[$m] = array('label' => $M, 'value' => $m);

                $current->add(DateInterval::createFromDateString('1 month'));
            }
        } else if ($field === 'week') {
            while ($current <= $max) {
                $Y = $current->format('Y');
                $W = $current->format('W');

                $years[$Y] = array('label' => $Y, 'value' => $Y);
                $weeks[$W] = array('label' => $W, 'value' => $W);

                $current->add(DateInterval::createFromDateString('1 week'));
            }
        } else if ($field === 'time') {
            while ($current <= $max) {
                $H = $current->format('H');
                $i = $current->format('i');

                $hours[$H] = array('label' => ltrim($H, '0'), 'value' => $H);
                $minutes[$i] = array('label' => $v = str_pad(ltrim($i, '0'), 1, "0", STR_PAD_LEFT), 'value' => $i);

                $current->add(DateInterval::createFromDateString('1 minute'));
            }

            for ($i = 0; $i < 60; $i++) {
                $v = str_pad($i, 2, "0", STR_PAD_LEFT);
                $seconds[$i] = array('label' => $i, 'value' => $v);
            }
        }

        /* sort the array */
        usort($years, array('Form_Site_Decorator', '_sortTimeByValue'));
        usort($months, array('Form_Site_Decorator', '_sortTimeByValue'));
        usort($weeks, array('Form_Site_Decorator', '_sortTimeByValue'));
        usort($hours, array('Form_Site_Decorator', '_sortTimeByValue'));
        usort($minutes, array('Form_Site_Decorator', '_sortTimeByValue'));

        /* now we start generating the select form elements */
        $date_element = array();

        /* month */
        if ($field === 'date' || $field === 'month' || $field === 'datetime-local') {
            $month_options = array();
            foreach ($months as $month) {
                $month_params = array();
                $month_params['value'] = $month['value'];
                if ($month['value'] == $selected->format('m')) {
                    $month_params['selected'] = 'selected';
                }
                $month_options[] = HTML_Decorator::tag('option', $month['label'], $month_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $month_options, array('class' => 'month'));
        }

        /* week */
        if ($field === 'week') {
            $week_options = array();
            foreach ($weeks as $week) {
                $week_params = array();
                $week_params['value'] = $week['value'];
                if ($week['value'] == $selected->format('W')) {
                    $week_params['selected'] = 'selected';
                }
                $week_options[] = HTML_Decorator::tag('option', $week['label'], $week_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $week_options, array('class' => 'week'));
        }

        /* day */
        if ($field === 'date' || $field === 'datetime-local') {
            $day_options = array();
            foreach ($days as $day) {
                $day_params = array();
                $day_params['value'] = $day['value'];
                if ($day['value'] == $selected->format('d')) {
                    $day_params['selected'] = 'selected';
                }
                $day_options[] = HTML_Decorator::tag('option', $day['label'], $day_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $day_options, array('class' => 'day'));
        }

        /* year */
        if ($field === 'date' || $field === 'month' || $field === 'week' || $field === 'datetime-local') {
            $year_options = array();
            foreach ($years as $year) {
                $year_params = array();
                $year_params['value'] = $year['value'];
                if ($year['value'] == $selected->format('Y')) {
                    $year_params['selected'] = 'selected';
                }
                $year_options[] = HTML_Decorator::tag('option', $year['label'], $year_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $year_options, array('class' => 'year'));
        }

        /* hour */
        if ($field === 'datetime-local' || $field === 'time') {
            $hour_options = array();
            foreach ($hours as $hour) {
                $hour_params = array();
                $hour_params['value'] = $hour['value'];
                if ($hour['value'] == $selected->format('H')) {
                    $hour_params['selected'] = 'selected';
                }
                $hour_options[] = HTML_Decorator::tag('option', $hour['label'], $hour_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $hour_options, array('class' => 'hour'));

            /* minute */
            $date_element[] = ':';

            $minute_options = array();
            foreach ($minutes as $minute) {
                $minute_params = array();
                $minute_params['value'] = $minute['value'];
                if ($minute['value'] == $selected->format('i')) {
                    $minute_params['selected'] = 'selected';
                }
                $minute_options[] = HTML_Decorator::tag('option', $minute['label'], $minute_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $minute_options, array('class' => 'minute'));


            /* second */
            $date_element[] = ':';

            $second_options = array();
            foreach ($seconds as $second) {
                $second_params = array();
                $second_params['value'] = $second['value'];
                if ($second['value'] == $selected->format('s')) {
                    $second_params['selected'] = 'selected';
                }
                $second_options[] = HTML_Decorator::tag('option', $second['label'], $second_params);
            }
            $date_element[] = HTML_Decorator::tag('select', $second_options, array('class' => 'second'));
        }

        $this->_form_elements[] = HTML_Decorator::tag('div', $date_element, array('class' => $field . '-field'));

        $this->_add_invalid($params);

        return $this;
    }

    private function _sortTimeByValue($a, $b) {
        return $a['value'] > $b['value'];
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

        $this->_form_elements[] = HTML_Decorator::tag('input', false, array_merge($params, array('type' => 'submit', 'value' => $value, 'class' => $class)));

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
        $this->_form_elements[] = HTML_Decorator::tag('a', $value, array_merge($params, array('class' => 'button ' . $class)));

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

        $this->_form_elements[] = HTML_Decorator::tag('div', $option_elements, array('id' => $id, 'class' => $class));

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

        $params['class'] = $params['class'] . ' number-field';

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

        $params['class'] = $params['class'] . ' range-field';

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

        $this->_form_elements[] = HTML_Decorator::tag('select', $option_elements, array_merge($params, array('id' => $id, 'name' => $id)));

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

        $this->_form_elements[] = HTML_Decorator::tag('textarea', '', array_merge($params, array('id' => $id, 'name' => $id)));

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
    private function _is_invalid_helper(&$params) {
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
        $this->_form_elements[] = HTML_Decorator::tag('label', $label, array_merge($label_params, array('for' => $id)));

        if (!empty($params['tooltip'])) {
            $this->_form_elements[] = HTML_Decorator::tag('span', $params['tooltip'], array('class' => 'tiptext'));
        }
    }

    /**
     * Helper function to add placeholder.
     * 
     * @param array $params 
     */
    private function _add_placeholder($params) {
        if (!empty($params['placeholder'])) {
            $this->_form_elements[] = HTML_Decorator::tag('span', $params['placeholder'], array('class' => 'placeholder'));
        }
    }

    /**
     * Helper function to add invalid text.
     * 
     * @param type $params 
     */
    private function _add_invalid($params) {
        if (!empty($params['invalid'])) {
            $this->_form_elements[] = HTML_Decorator::tag('p', $params['invalid'], array('class' => 'invalid'));
        }
    }

    public function render() {
        if ($this->_padded)
            $this->add_class('padded');
        elseif ($this->_padded === false)
            $this->remove_class('padded');

        if ($this->_short)
            $this->add_class('short');
        elseif ($this->_short === false)
            $this->remove_class('short');

        if (count($this->_form_elements) > 0) {
            foreach ($this->_form_elements as $element) {
                $this->add_inner($element);
            }
        }

        if (is_a($this->_title, 'Decorator')) {
            $this->add_inner_front($this->_title);
        }

        return parent::render();
    }

}

