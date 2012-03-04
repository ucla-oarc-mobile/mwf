<?php

/**
 * A class that represents a feed specified by a name and path. Provides methods
 * for building a URL from a Feed object as well as building a path object from
 * a request
 *
 * @author ebollens
 * @author nemerson
 * @version 20110727
 *
 * @uses SimplePie
 * @uses Cache
 * @uses Config
 * @uses Feed_Item
 */
require_once(__DIR__ . '/simplepie.php');
require_once(dirname(dirname(__DIR__)) . '/root/assets/lib/config.class.php');
require_once(dirname(dirname(__DIR__)) . '/root/assets/lib/cache.class.php');
require_once(__DIR__ . '/feed_item.class.php');

class Feed {

    /**
     * Specifies the name of the feed
     * 
     * @var string 
     */
    private $_name;

    /**
     * Specifies the path for the feed
     * 
     * @access private
     * @var string 
     */
    private $_path;

    /**
     * Array of Feed_Items representative of the articles in the feeds
     * 
     * @access private
     * @var array
     */
    private $_items = array();

    /**
     * Cache object
     * 
     * @access private
     * @var Cache
     */
    private $_cache;

    /**
     * Constructor sets the Feed's properties with the supplied name and path.
     * 
     * @param string $name the name for the feed
     * @param string $path the path for the feed
     */
    public function __construct($name, $path) {
        $this->_name = (string) $name;
        $this->_path = (string) $path;
        try {
            $this->_cache = new Cache(Config::get('auxiliary/feed', 'cache_name'));
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
            $this->_cache = NULL;
        }
    }

    /**
     * Accessor method for the feed name
     * 
     * @return string The name of the feed 
     */
    public function get_name() {
        return $this->_name;
    }

    /**
     * Accessor method for the feed path
     * 
     * @return string The feed path
     */
    public function get_path() {
        return $this->_path;
    }

    /**
     * Returns an array of all Feed_Items for the given feed. Will fetch the
     * feed items if they have not yet been fetched.
     * 
     * @return array|false Array of Feed_Items on success, or false on failure 
     */
    public function get_items() {
        if ($this->_items) {
            return $this->_items;
        }

        $simplepie = $this->create_simplepie_reader();

        if (!$simplepie) {
            return false;
        }

        $this->_items = array();
        foreach ($simplepie->get_items() as $item)
            $this->_items[] = new Feed_Item($this, $item);
        return (empty($this->_items)) ? false : $this->_items;
    }

    /**
     * Create a SimplePie object to read the feed.
     * 
     * @access private
     * @return SimplePie|false
     */
    private function create_simplepie_reader() {
        try {
            $simplepie = new SimplePie();
            $simplepie->enable_order_by_date(false);
            $simplepie->set_feed_url($this->get_path());
            if (isset($this->_cache)) {
                $simplepie->set_cache_location($this->_cache->get_cache_path());
            } else {
                $simplepie->enable_cache(false);
            }
            $simplepie->init();
            $simplepie->handle_content_type();
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
            return false;
        }
        
        return $simplepie;
    }

    /**
     * Returns a single item as specified by name. If an item of the given name
     * is not found in the items contained by the Feed object, returns false.
     * 
     * @param type $name name of item to get
     * @return type Feed_Item|false
     */
    public function get_item($name) {
        foreach ($this->get_items() as $item)
            if ($item->get_name() == $name)
                return $item;

        return false;
    }

    /**
     * Builds an item from the request URL.
     * 
     * @return Feed_Item|false
     */
    public function build_item_from_request() {
        if (!isset($_GET['article']))
            return false;

        return $this->get_item($_GET['article']);
    }

    /**
     * Produces a URL that will build a page around the Feed object.
     * 
     * @param type $salt salt that will be used to verify the page
     * @return string a url that will build a page for the Feed Object
     */
    public function get_page($salt = false) {
        $path = 'feed.php?name=' . urlencode($this->get_name()) . '&path=' . urlencode($this->get_path());
        return $salt ? $path . '&signature=' . md5($salt . $this->get_name() . $this->get_path()) : $path;
    }

    /**
     * Used to verify a signature given in the request for the Feed object based
     * on a salt.
     * 
     * @param string $signature the signature to verify
     * @param string $salt
     * @return true|false
     */
    public function verify_page($signature, $salt) {
        return $signature == md5($salt . $this->get_name() . $this->get_path());
    }

    /**
     * Static factory method to build a Feed object from the request string.
     * 
     * @return Feed
     */
    public static function build_page_from_request() {
        if (!isset($_GET['name']) || !isset($_GET['path']))
            return false;

        return new Feed($_GET['name'], $_GET['path']);
    }

}