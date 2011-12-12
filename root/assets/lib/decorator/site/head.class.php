<?php

/**
 *
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 * @uses Config
 */

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/https.class.php');
require_once(dirname(dirname(__FILE__)).'/html/tag.class.php');

class Head_Site_Decorator extends Tag_HTML_Decorator
{
    private $_title = '';
    private $_handler_css = false;
    private $_handler_css_params = array();
    private $_handler_js = false;
    private $_handler_js_params = array();

    public function __construct()
    {
        parent::__construct('head');
    }

    public function &set_title($title)
    {
        if($title)
            $this->_title = $title;
        
        return $this;
    }

    public function &set_css_handler($path)
    {
        $this->_handler_css = $path;
        if(strpos($path, '?') === false)
            $this->_handler_css .= '?';
        return $this;
    }

    public function &set_css_handler_params($params = array())
    {
        $this->_handler_css_params = array_merge($this->_handler_css_params, $params);
        return $this;
    }

    public function &add_css_handler_library($type, $library)
    {
        if(is_array($library))
            foreach($library as $l)
                $this->add_css_handler_library($type, $l);
        elseif(!isset($this->_handler_css_params[$type]))
            $this->_handler_css_params[$type] = $library;
        elseif(!in_array($library, explode('+', $this->_handler_css_params[$type])))
            $this->_handler_css_params[$type] .= '+'.$library;

        return $this;
    }

    public function &set_js_handler($path)
    {
        $this->_handler_js = $path;
        if(strpos($path, '?') === false)
            $this->_handler_js .= '?';
        return $this;
    }

    public function &set_js_handler_params($params = array())
    {
        $this->_handler_js_params = array_merge($this->_handler_js_params, $params);
        return $this;
    }

    public function &add_js_handler_library($type, $library)
    {
        if(is_array($library))
            foreach($library as $l)
                $this->add_js_handler_library($type, $l);
        elseif(!isset($this->_handler_js_params[$type]))
            $this->_handler_js_params[$type] = $library;
        elseif(!in_array($library, explode('+', $this->_handler_js_params[$type])))
            $this->_handler_js_params[$type] .= '+'.$library;

        return $this;
    }

    public function &add_stylesheet($href, $media = 'screen')
    {
        return $this->add_inner_tag('link', false, array('rel'=>'stylesheet', 'type'=>'text/css', 'href'=>$href, 'media'=>$media));
    }

    public function &add_javascript($src)
    {
        return $this->add_inner_tag('script', '', array('type'=>'text/javascript', 'src'=>$src));
    }

    private function _generate_url_param_string($params) {
        $rv = '?';
        foreach($params as $key=>$val) {
            $rv .= is_int($key) ? $val.'&' : $key.'='.$val.'&';
        }
        $rv = rtrim($rv,'?&');
        return htmlspecialchars($rv);
    }
    
    public function render()
    {   
        $handler_css = $this->_handler_css ? $this->_handler_css : Config::get('global', 'site_assets_url').'/css.php';
        $handler_css .= $this->_generate_url_param_string($this->_handler_css_params);

        $handler_js = $this->_handler_js ? $this->_handler_js : Config::get('global', 'site_assets_url').'/js.php';
        $handler_js .= $this->_generate_url_param_string($this->_handler_js_params);
        
        $this->add_inner_tag_front('meta', false, array('name'=>'viewport', 'content'=>'height=device-height,width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no'));
        $this->add_inner_tag_front('script', null, array('type'=>'text/javascript', 'src'=>(HTTPS::is_https() ? HTTPS::convert_path($handler_js) : $handler_js)));
        $this->add_inner_tag_front('link', false, array('rel'=>'stylesheet', 'type'=>'text/css', 'href'=>(HTTPS::is_https() ? HTTPS::convert_path($handler_css) : $handler_css), 'media'=>'screen'));
        $this->add_inner_tag_front('title', $this->_title);

        $charset = Config::get('global', 'charset');
        if ($charset !== false) {
            $this->add_inner_tag_front('meta', false, array('charset'=>$charset));
        }
        
        return parent::render();
    }
}
