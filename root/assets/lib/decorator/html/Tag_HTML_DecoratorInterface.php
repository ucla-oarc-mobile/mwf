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
interface Tag_HTML_DecoratorInterface {

    public function set_param($key, $val);

    public function set_params($params);

    public function add_class($class);

    public function remove_class($class);

    public function add_inner_tag($tag, $inner, $params);

    public function add_inner_tag_front($tag, $inner, $params);

    public function add_inner($content);

    public function add_inner_front($content);

    public function flush_inner();
    
    public function render();

}
