<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120320
 *
 */
interface Tag_ParamsInterface {

    public function set_param($key, $val);

    public function set_params($params);

    public function add_class($class);

    public function remove_class($class);
}
