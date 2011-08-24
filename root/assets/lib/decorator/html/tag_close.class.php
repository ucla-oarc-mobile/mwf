<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Tag_Close_HTML_Decorator extends Decorator
{
    private $_tag;

    public function __construct($tag)
    {
        $this->_tag = $tag;
    }

    public function render()
    {
        return '</'.$this->_tag.'>';
    }
}
