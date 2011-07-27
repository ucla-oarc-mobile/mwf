<?php

class Feed_Item
{
    private $_title;
    private $_link;
    private $_description;
    private $_feed;
    private $_author;

    public function __construct($feed, $item)
    {
        $this->_feed = $feed;
        $this->_name = $item->get_title();
        $this->_title = $item->get_title();
        $this->_link = $item->get_permalink();
        $this->_description = $item->get_content();
        $this->_date = $item->get_date('F j, Y');
        $author = $item->get_author();
        $author_name = $author->get_name();
        $this->_author = empty($author_name) ? $author->get_email() : $author_name;
    }

    public function get_feed()
    {
        return $this->_feed;
    }

    public function get_name()
    {
        return $this->_name;
    }

    public function get_title()
    {
        return $this->_title;
    }

    public function get_link()
    {
        return $this->_link;
    }

    public function get_date()
    {
        return $this->_date;
    }

    public function get_author()
    {
        return $this->_author;
    }

    public function get_description()
    {
        return $this->_description;
    }

    public function get_short_description($n = 100)
    {
        if(!$this->_description)
            $short_desc = false;
        else
        {
            $desc = strip_tags($this->_description);
            if( ($desc_len = strlen($desc)) < $n)
                $short_desc = $desc;
            else
            {
                $pos = strrpos($desc, ' ', (-1)*($desc_len-$n));
                if($pos > 0)
                    $short_desc = substr($desc, 0, $pos).'...';
                else
                    $short_desc = false;
            }
        }

        return $short_desc;
    }

    public function get_page($salt = null)
    {
        $path = 'item.php?name='.urlencode($this->get_feed()->get_name()).'&path='.urlencode($this->get_feed()->get_path()).'&article='.urlencode($this->get_title());
        return $salt ? $path.'&signature='.md5($salt.$this->get_feed()->get_name().$this->get_feed()->get_path().$this->get_title()) : $path;
    }

    public function verify_page($signature, $salt)
    {
        return $signature == md5($salt.$this->get_feed()->get_name().$this->get_feed()->get_path().$this->get_title());
    }
}