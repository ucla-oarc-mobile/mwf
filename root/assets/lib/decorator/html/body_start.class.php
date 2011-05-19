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
 * @uses Tag_Open_HTML_Decorator
 */

require_once(dirname(__FILE__).'/tag_open.class.php');

class Body_Start_HTML_Decorator extends Tag_Open_HTML_Decorator
{
    public function __construct($params = array())
    {
        parent::__construct('body', $params);
    }

}
