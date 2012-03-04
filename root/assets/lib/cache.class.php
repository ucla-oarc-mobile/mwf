<?php

/**
 * Object that represents a cache. 
 * 
 * Examples:
 * 
 *   Get (or create) a cache labeled "rss".
 *     $rss_cache = new Cache('rss');
 *   Note that the label may only contain alphanumeric characters and underscores.
 * 
 *   Retrieve the cache directory for the cache labeled "rss". This is useful
 *   for libraries like SimplePie that handle their own caching but need to be
 *   told where the cache directory is. Do not use the Cache object to read or
 *   write to the cache if you do that.
 *     $rss_cache_dir = $rssCache->get_cache_dir();
 *
 * @package core
 * @subpackage cache
 *
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120303
 * 
 * @uses Config
 * 
 * @throws InvalidArgumentException
 * @throws RuntimeException
 */
require_once(__DIR__ . '/config.class.php');

class Cache {

    private $_cache_dir;

    /**
     *
     * @param string $label 
     */
    public function __construct($label) {
        if (! preg_match('/^\w+$/', $label)) {
            throw new InvalidArgumentException("Invalid label " . $label);
        }

        $base_dir = Config::get('global', 'var_dir');
        if (! file_exists($base_dir)) {
            throw new RuntimeException("MWF var directory does not exist: " . $base_dir);
        }
        
        $this->_cache_dir = Config::get('global', 'var_dir') . '/cache/' . $label;

        if (! file_exists($this->_cache_dir)) {
            if (!mkdir($this->_cache_dir, 0700, true)) {
                throw new RuntimeException("Could not create directory (check directory permission): " . $this->_cache_dir);
            }
        }
    }

    /**
     *
     * @return string
     */
    public function get_cache_dir() {
        return $this->_cache_dir;
    } 
}
?>