<?php

/**
 * A class that represents an item in a Feed (generally an article). Provides
 * accessors for item attributes as well as a method to build a request URL
 * for a given item.
 *
 * @author ebollens
 * @version 20110727
 */

class Feed_Item
{
    /**
     * The item title
     * 
     * @var string 
     */
    private $_title;
    
    /**
     * The item link
     * 
     * @var string 
     */
    private $_link;
    
    /**
     * The item description
     * 
     * @var string 
     */
    private $_description;
    
    /**
     * The feed the item belongs to
     * 
     * @var Feed 
     */
    private $_feed;
    
    /**
     * The date of the item
     * 
     * @var string
     */
    private $_date;
    
    /**
     * The author of the item
     * 
     * @var string 
     */
    private $_author;

    /**
     * The constructor stores feed item attributes as properties.
     * 
     * @param type $feed the feed the new item belongs to
     * @param SimplePie_Item $item SimplePie_Item that contains information
     * about the item
     */
    public function __construct($feed, $item)
    {
        $this->_feed = $feed;
        $this->_title = $item->get_title();
        $this->_link = $item->get_permalink();
        $this->_description = $item->get_content();
        $this->_date = $item->get_date('U');
        $author = $item->get_author();  
        $author_name = $author ? $author->get_name() : NULL;
        $this->_author = $author && empty($author_name) ? $author->get_email() : $author_name;
    }

    /**
     * Accessor method to get the Feed the item belongs to
     * 
     * @return Feed feed the item belongs to
     */
    public function get_feed()
    {
        return $this->_feed;
    }

    /**
     * Accessor method for the feed item name (alias for title)
     * 
     * @return string 
     */
    public function get_name()
    {
        return $this->_title;
    }

    /**
     * Accessor method for the feed item title
     * 
     * @return string 
     */
    public function get_title()
    {
        return $this->_title;
    }

    /**
     * Accessor method for the feed item link
     * 
     * @return string 
     */
    public function get_link()
    {
        return $this->_link;
    }

    /**
     * Accessor method for the feed item date
     * 
     * @return string 
     */
    public function get_date($format='F j, Y')
    {
        return date($format, $this->_date);
    }

    /**
     * Accessor method for the feed item author
     * 
     * @return string 
     */
    public function get_author()
    {
        return $this->_author;
    }

    /**
     * Accessor method for the feed item description
     * 
     * @return string 
     */
    public function get_description()
    {
        return $this->_description;
    }

    /**
     * Accessor method to get a short description, which is simply the item
     * description truncated to $n characters.
     * 
     * @param $n number of characters to truncate description to
     * @return string|false the truncated description or false if not available
     */
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

    /**
     * Produces a URL for viewing a feed item. If a salt is provided, creates
     * a signature and appends it to the URL.
     * 
     * @param string $salt a salt for verifying the page
     * @return string the desired URL
     */
    public function get_page($salt = null)
    {
        $path = 'item.php?name='.urlencode($this->get_feed()->get_name()).'&path='.urlencode($this->get_feed()->get_path()).'&article='.urlencode($this->get_title());
        return $salt ? $path.'&signature='.md5($salt.$this->get_feed()->get_name().$this->get_feed()->get_path().$this->get_title()) : $path;
    }

    /**
     * Verifies a signature based on the given salt.
     * 
     * @param type $signature signature to verify
     * @param type $salt salt to use when verifying
     * @return bool
     */
    public function verify_page($signature, $salt)
    {
        return $signature == md5($salt.$this->get_feed()->get_name().$this->get_feed()->get_path().$this->get_title());
    }
}