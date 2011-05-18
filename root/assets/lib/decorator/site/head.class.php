<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))).'/config.class.php');

class Head_Site_Decorator extends Site_Decorator
{
    private $_title = '';
    private $_tags = array();
    private $_handler_css = false;
    private $_handler_css_params = array();
    private $_handler_js = false;
    private $_handler_js_params = array();

    public function &set_title($title)
    {
        $this->_title = $title;
        return $this;
    }

    public function &set_css_handler($path)
    {
        $this->_handler_css = $path;
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
        elseif(strpos($this->_handler_css_params[$type], '+'.$library.'+') === false
                && !(strlen($library)+1 < strlen($this->_handler_css_params[$type])
                        && (
                            substr($this->_handler_css_params[$type], 0, strlen($library)+1) == $library.'+'
                            || substr($this->_handler_css_params[$type], strlen($this->_handler_css_params[$type])-strlen($library)-1, strlen($library)+1) == '+'.$library
                            )
                ))
            $this->_handler_css_params[$type] .= '+'.$library;

        return $this;
    }

    public function &set_js_handler($path)
    {
        $this->_handler_js = $path;
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
        elseif(strpos($this->_handler_js_params[$type], '+'.$library.'+') === false
                && !(strlen($library)+1 < strlen($this->_handler_js_params[$type])
                        && (
                            substr($this->_handler_js_params[$type], 0, strlen($library)+1) == $library.'+'
                            || substr($this->_handler_js_params[$type], strlen($this->_handler_js_params[$type])-strlen($library)-1, strlen($library)+1) == '+'.$library
                            )
                ))
            $this->_handler_js_params[$type] .= '+'.$library;

        return $this;
    }

    public function &add($tag)
    {
        $this->_tags[] = $tag;
        return $this;
    }

    public function &add_tag($tag, $inner = '', $params = array())
    {
        return $this->add(HTML_Decorator::tag($tag, $inner, $params));
    }

    public function &add_stylesheet($href, $media = 'screen')
    {
        return $this->add_tag('link', false, array('rel'=>'stylesheet', 'type'=>'text/css', 'href'=>$href, 'media'=>$media));
    }

    public function &add_javascript($src)
    {
        return $this->add_tag('script', '', array('type'=>'text/javascript', 'src'=>$src));
    }

    public function render()
    {
        $handler_css = $this->_handler_css ? $this->_handler_css : Config::get('global', 'site_assets_url').'/css.php?';
        foreach($this->_handler_css_params as $key=>$val)
            $handler_css .= is_int($key) ? $val.'&' : $key.'='.$val.'&';
        $handler_css = substr($handler_css, 0, strlen($handler_css)-1);

        $handler_js = $this->_handler_js ? $this->_handler_js : Config::get('global', 'site_assets_url').'/js.php?';
        foreach($this->_handler_js_params as $key=>$val)
            $handler_js .= is_int($key) ? $val.'&' : $key.'='.$val.'&';
        $handler_js = substr($handler_js, 0, strlen($handler_js)-1);

        $str = '<head>
    <title>'.$this->_title.'</title>
';
        $str .= HTML_Decorator::tag('link', false, array('rel'=>'stylesheet', 'type'=>'text/css', 'href'=>$handler_css, 'media'=>'screen'));
        $str .= HTML_Decorator::tag('script', null, array('type'=>'text/javascript', 'src'=>$handler_js));
        $str .= HTML_Decorator::tag('meta', false, array('name'=>'viewport', 'content'=>'height=device-height,width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;'));
        
        $str .= implode('
    ', $this->_tags);
    
        $str .= '
</head>';
        return $str;
    }
}

?>
