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
 * @version 20120320
 *
 * @uses Decorator
 */
require_once(dirname(dirname(__DIR__)) . '/decorator.class.php');
require_once(__DIR__) . '/Tag_ParamsInterface.php';

class Tag_HTML_Decorator extends Decorator implements Tag_ParamsInterface {

    private $_tag_open;
    private $_tag_close;
    private $_inner = array();

    public function __construct($tag, $inner = '', $params = array()) {
        $this->_tag_open = HTML_Decorator::tag_open($tag, $params);
        $this->_tag_close = HTML_Decorator::tag_close($tag);
        $this->add_inner($inner);
    }

    public function set_param($key, $val) {
        $this->_tag_open->set_param($key, $val);
        return $this;
    }

    public function set_params($params) {
        $this->_tag_open->set_params($params);
        return $this;
    }

    public function add_class($class) {
        $this->_tag_open->add_class($class);
        return $this;
    }

    public function remove_class($class) {
        $this->_tag_open->remove_class($class);
        return $this;
    }

    public function add_inner_tag($tag, $inner = '', $params = array()) {
        return $this->add_inner(new Tag_HTML_Decorator($tag, $inner, $params));
    }

    public function add_inner_tag_front($tag, $inner = '', $params = array()) {
        return $this->add_inner_front(new Tag_HTML_Decorator($tag, $inner, $params));
    }

    public function add_inner($content) {
        if (is_array($content)) {
            foreach ($content as $c) {
                $this->add_inner($c);
            }
        } else if ($content !== false) {
            $this->_inner[] = $content;
        }
        return $this;
    }

    public function add_inner_front($content) {
        if (is_array($content))
            for ($i = count($content) - 1; $i >= 0; $i--)
                $this->add_inner_front($content[$i]);
        elseif ($content !== false)
            array_unshift($this->_inner, $content);
        return $this;
    }

    public function flush_inner() {
        $this->_inner = array();
        return $this;
    }


    /**
     * Render the tag for output.
     * 
     * @param boolean $raw set to TRUE if the tag's content is raw markup and should remain unescaped
     * @return string
     */    
    public function render ($raw = false) {
        $str = $this->_tag_open->render($raw);

        if (count($this->_inner) === 0)
            return $str;

        foreach ($this->_inner as $inner) {
            if (is_a($inner, 'Decorator')) {
                $str .= $inner->render($raw);
            } else {
                if (!$raw && $this->_tag_open->needs_entities()) {
                    $str .= htmlentities($inner, ENT_COMPAT, 'UTF-8');
                } else {
                    $str .= $inner;
                }
            }
        }

        $str .= $this->_tag_close->render($raw);
        return $str;
    }

}

