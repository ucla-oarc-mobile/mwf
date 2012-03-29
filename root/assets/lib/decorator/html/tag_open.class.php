<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120318
 *
 * @uses Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');

class Tag_Open_HTML_Decorator extends Decorator {

    private $_tag;
    private $_params;
    private $_needs_entities;

    public function __construct($tag, $params = array()) {
        $this->_tag = $tag;
        $this->_params = $params;
        $this->_needs_entities = ($this->_tag !== 'script' && $this->_tag !== 'style');
    }

    public function set_param($key, $val) {
        $this->_params[$key] = $val;
        return $this;
    }

    public function set_params($params) {
        $this->_params = array_merge($this->_params, $params);
        return $this;
    }

    public function add_class($class) {
        if (!isset($this->_params['class']))
            $this->_params['class'] = $class;
        else if (!in_array($class, explode(' ', $this->_params['class'])))
            $this->_params['class'] .= ' ' . $class;
        return $this;
    }

    public function remove_class($class) {
        if (isset($this->_params['class'])) {
            $classes = explode(' ', $this->_params['class']);
            if (($i = array_search($class, $classes)) !== false) {
                $classes[$i] = $classes[count($classes) - 1];
                array_pop($classes);
                $this->_params['class'] = implode(' ', $classes);
            }
        }

        return $this;
    }

    /**
     * Whether the contents of the element need to use HTML entities.
     * 
     * @todo Ideally we wouldn't allow script and style tag content at all.
     * 
     * @return boolean 
     */
    public function needs_entities() {
        return $this->_needs_entities;
    }

    public function render($raw = false) {
        $str = '<' . $this->_tag;
        if (count($this->_params) > 0)
            foreach ($this->_params as $name => $val)
                $str .= ' ' . $name . ((string) $val !== '' ? '="' . htmlspecialchars($val) . '"' : '');
        $str .= '>';
        return $str;
    }

}
