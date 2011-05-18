<?php

require_once(dirname(dirname(dirname(__FILE__))).'/decorator.class.php');

class Decorator_Site_Content_Full extends Decorator
{
    private $_tags = array();
    private $_padded = false;

    public function &set_padded($val = true)
    {
        $this->_padded = $val ? true : false;
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

    public function &add_header($inner, $params = array())
    {
        return $this->add_tag('h1', $inner, $params);
    }

    public function &add_header_light($inner, $params = array())
    {
        if(!isset($params['class']))
            $params['class'] = 'light';
        elseif(!strpos($params['class'], ' light ')
                    && substr($params['class'], 0, 6) != 'light '
                    && substr($params['class'], strlen($params['class'])-6, 6) != ' light'
                    && trim($params['class']) != 'light')
            $params['class'] .= ' light';
            
        return $this->add_header($inner, $params);
    }

    public function &add_subheader($inner, $params = array())
    {
        return $this->add_tag('h4', $inner, $params);
    }

    public function &add_paragraph($inner, $params = array())
    {
        return $this->add_tag('p', $inner, $params);
    }

    public function &add_section($inner, $params = array())
    {
        return $this->add_tag('div', $inner, $params);
    }

    public function render()
    {
        $str = '<div class="content-full'.($this->_padded ? ' content-padded' : '').'">
';
        $str .= implode('
', $this->_tags);
        $str .= '</div>
';
        return $str;
    }
}

?>
