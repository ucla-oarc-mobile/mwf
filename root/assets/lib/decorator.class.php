<?php

/**
 *
 * @package decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @link HTML_Decorator
 * @link Site_Decorator
 */

class Decorator
{
    public function render()
    {
        return '';
    }

    public function __toString()
    {
        echo '[debug] Using __toString.<br>';
        echo debug_print_backtrace().'<br><br>';
        return $this->render();
    }
}

require_once(dirname(__FILE__).'/decorator/html_decorator.class.php');
require_once(dirname(__FILE__).'/decorator/site_decorator.class.php');
