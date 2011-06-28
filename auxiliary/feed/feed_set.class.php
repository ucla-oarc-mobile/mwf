<?php

require_once(dirname(__FILE__).'/feed.class.php');

class Feed_Set implements Iterator
{
    private $_set = array();
    private $_pos = 0;

    public function __construct($path_or_array = null)
    {
        if(is_array($path_or_array))
            $this->add_feeds($path_or_array);
        else if(is_string($path_or_array))
            $this->add_feeds_xml($path_or_array);
    }

    public function add_feed($name, $path)
    {
        $this->_set[] = new Feed($name, $path);
    }

    public function add_feeds($array)
    {
        foreach($array as $name=>$path)
            $this->_set[] = new Feed($name, $path);
    }

    public function add_feeds_xml($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if(!($result = curl_exec($ch)))
            trigger_error(curl_error($ch));
        curl_close($ch);

        $root = new SimpleXMLElement($result);
        foreach($root->Feed as $feed)
           $this->add_feed($feed->Name, $feed->URL);
    }

    public function remove_all_feeds()
    {
        $this->_set = array();
    }

    /*public function get_all()
    {
        $array = array();
        foreach($this->_set as $item)
            $array[] =
    }*/

    public function rewind()
    {
        $this->_pos = 0;
    }

    public function current()
    {
        return $this->_set[$this->_pos];
    }

    public function key()
    {
        return $this->_pos;
    }

    public function next()
    {
        $this->_pos++;
    }

    public function valid()
    {
        return isset($this->_set[$this->_pos]);
    }
}

?>
