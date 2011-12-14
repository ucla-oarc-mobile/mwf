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
 * @version 20111027
 *
 * @uses Config
 * @uses Tag_Open_HTML_Decorator
 */
require_once(dirname(__FILE__) . '/tag_open.class.php');

class HTML_Start_HTML_Decorator extends Tag_Open_HTML_Decorator {

    public function __construct($params = array()) {
        if (!array_key_exists('lang', $params)) {
            $lang = Config::get('global', 'language');
            if ($lang != false) {
                $params['lang'] = $lang;
            }
        }
        parent::__construct('html', $params);
    }
    
    public function &add_appcache() {
        return parent::set_param('manifest',Config::get('global','site_assets_url').'/appcache.php');
    }

    public function render() {
        return '<!DOCTYPE html>
' . parent::render();
    }

}
