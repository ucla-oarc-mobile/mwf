<?php

define('MAGPIE_INPUT_ENCODING', 'UTF-8');
define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');

require_once(dirname(__FILE__).'/magpierss/rss_fetch.inc');

require_once(dirname(__FILE__).'/feed_item.class.php');

class Feed
{
    private $_name;
    private $_path;
    private $_items = false;

    public function __construct($name, $path)
    {
        $this->_name = (string)$name;
        $this->_path = (string)$path;
    }

    public function get_name()
    {
        return $this->_name;
    }

    public function get_path()
    {
        return $this->_path;
    }

    public function get_items()
    {
        return !$this->_items ? $this->fetch_items() : $this->_items;
    }

    public function fetch_items()
    {
        try
        {
            $rss = fetch_rss($this->get_path());
        }
        catch(Exception $e)
        {
            return false;
        }

        $this->_items = array();
        foreach($rss->items as $item)
            $this->_items[] = new Feed_Item($this, $item);
        return $this->_items;
    }

    public function get_item($name)
    {
        foreach($this->get_items() as $item)
            if($item->get_name() == $name)
                return $item;

        return false;
    }

    public function build_item_from_request()
    {
        if(!isset($_GET['article']))
            return false;

        return $this->get_item(urldecode($_GET['article']));
    }

    public function get_page($salt = false)
    {
        $path = 'feed.php?name='.urlencode($this->get_name()).'&path='.urlencode($this->get_path());
        return $salt ? $path.'&signature='.md5($salt.$this->get_name().$this->get_path()) : $path;
    }

    public function verify_page($signature, $salt)
    {
        return $signature == md5($salt.$this->get_name().$this->get_path());
    }

    public static function build_page_from_request()
    {
        if(!isset($_GET['name']) || !isset($_GET['path']))
            return false;

        return new Feed($_GET['name'], $_GET['path']);
    }
}

?>
