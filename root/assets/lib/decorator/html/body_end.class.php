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
 * @uses Tag_Close_HTML_Decorator
 */

require_once(dirname(__FILE__).'/tag_close.class.php');

class Body_End_HTML_Decorator extends Tag_Close_HTML_Decorator
{
    public function __construct()
    {
        parent::__construct('body');
    }
}
