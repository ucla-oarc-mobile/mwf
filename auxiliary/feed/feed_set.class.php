<?php

/**
 * A class that represents a set of feeds. A Feed Set can be populated with an
 * associative array of paths keyed by name, or by an XML file that contains
 * feed information.
 *
 * @author ebollens
 * @version 20110727
 * 
 * @uses Feed
 */

require_once(dirname(__FILE__).'/feed.class.php');

class Feed_Set implements Iterator
{
    /**
     * the set of feeds
     * 
     * @var array array of Feed objects 
     */
    private $_set = array();
    
    /**
     * used to track the position in the feed set when iterating
     * 
     * @var int 
     */
    private $_pos = 0;

    /**
     * Allows a Feed_Set to be constructed from an XML file (specified by a
     * path) or from an associative array of feed paths keyed by name.
     * 
     * @param string|array $path_or_array the path to the xml file or the array
     * of feeds
     */
    public function __construct($path_or_array = null)
    {
        if(is_array($path_or_array))
            $this->add_feeds($path_or_array);
        else if(is_string($path_or_array))
            $this->add_feeds_xml($path_or_array);
    }

    /**
     * Adds a single feed tot he Feed Set, specified by name and path
     * 
     * @param string $name name of the feed
     * @param string $path path of the feed
     */
    public function add_feed($name, $path)
    {
        $this->_set[] = new Feed($name, $path);
    }

    /**
     * Adds feeds to the Feed Set from an associative array of paths keyed by
     * name.
     * 
     * @param array $array associative array of feed paths keyed by name.
     */
    public function add_feeds($array)
    {
        foreach($array as $name=>$path)
            $this->_set[] = new Feed($name, $path);
    }

    /**
     * Populates a set of feeds based on an xml file.
     * 
     * @param string $path path to the xml file
     */
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

    /**
     * Reinitializes the Feed_Set so it is empty.
     */
    public function remove_all_feeds()
    {
        $this->_set = array();
    }

    /**
     * The following functions are those required by the Iterable interface for
     * use when iterating.
     */
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