<?php

/**
 * An object that encapsulates an image, allows for transformations of extension
 * and dimensions, and handles caching.
 *
 * @package core
 * @subpackage path
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120303
 *
 * @uses Config
 * @uses Cache
 * @uses Path_Validator
 *
 * @todo phpdoc
 */
require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once(dirname(__FILE__) . '/path_validator.class.php');

abstract class Image {

    private $_image_path;
    private $_image_file_root;
    private $_memory_limit;
    protected $_image_ext = null;
    private $_dim_height = false;
    private $_dim_width = false;
    protected $_cache;

    /** GIF, JPG, and JPEG are within XHTML MP 1.0 specification. */
    private $_ext_allowed = array('gif', 'png', 'jpg', 'jpeg');

    abstract protected function get_gd_image();

    abstract protected function get_gd_extension();

    /**
     *
     * @param string $image_path
     * @return Image|null
     */
    public static function factory($image_path) {
        if (!Path_Validator::is_safe($image_path))
            return null;

        //@todo: use Path::get_contents() and get rid of Remote vs. Local image

        if (array_key_exists('scheme', parse_url($image_path))) {
            require_once(dirname(__FILE__) . '/image/remote_image.class.php');
            return new Remote_Image($image_path);
        } else {
            require_once(dirname(__FILE__) . '/image/local_image.class.php');
            return new Local_Image($image_path);
        }
    }

    protected function __construct($imagepath) {
        $this->_image_path = $imagepath;

        $this->_cache = new Cache(Config::get('image', 'cache_name'));
        $this->_memory_limit = Config::get('image', 'memory_limit') ?
                Config::get('image', 'memory_limit') : 33554432;
    }

    public function set_max_height($max) {
        $this->_dim_height = round($max);
    }

    public function set_max_width($max) {
        $this->_dim_width = round($max);
    }

    public function get_mimetype() {
        if ($this->_image_path === false)
            return '';

        if ($this->get_gd_extension()) {
            return image_type_to_mime_type(constant('IMAGETYPE_' . strtoupper($this->get_gd_extension())));
        } else {
            return '';
        }
    }

    /**
     *
     * @return type string Returns image as a string. Returns an empty string on failure.
     */
    public function find_or_create_image_as_string() {
        if ($this->_image_path === false)
            return '';

        $key = $this->get_cache_key();

        $image = $this->_cache->get_raw($key);
        if ($image) {
            return $image;
        }

        if ($this->generate_image()) {
            $return = file_get_contents($this->_cache->get_cache_path($key));
            return $return ? $return : '';
        }

        return '';
    }

    protected function get_cache_key() {
        $key = $this->_image_path;
        $key .= $this->_dim_width ? $this->_dim_width . 'w' : '0w';
        $key .= $this->_dim_height ? $this->_dim_height . 'h' : '0h';
        return $key;
    }

    protected function generate_image() {
        if (in_array($this->get_gd_extension(), $this->_ext_allowed))
            $savefunction = 'image' . $this->get_gd_extension();
        else
            $savefunction = 'imagegif';

        switch ($this->get_gd_extension()) {
            case 'jpeg':
                $quality = 70;
                break;
            case 'png':
                $quality = 0;
                break;
            default:
                $quality = null;
                break;
        }

        $source = $this->get_gd_image();

        if ($source === false) {
            return false;
        }

        $height = imagesy($source);
        $width = imagesx($source);

        $scale_factor_height = 1;
        $scale_factor_width = 1;
        if ($this->_dim_height)
            $scale_factor_height = $this->_dim_height / $height;
        if ($this->_dim_width)
            $scale_factor_width = $this->_dim_width / $width;

        if ($scale_factor_height < $scale_factor_width)
            $scale_factor = $scale_factor_height;
        else
            $scale_factor = $scale_factor_width;

        if ($scale_factor > 1)
            $scale_factor = 1;

        $new_height = round($height * $scale_factor);
        $new_width = round($width * $scale_factor);

        $generated = imagecreatetruecolor($new_width, $new_height);
        if (imagecopyresampled($generated, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
            return $savefunction($generated, $this->_cache->get_cache_path($this->get_cache_key()), $quality);
        }
        
        return false;
    }

    protected function get_image_path() {
        return $this->_image_path;
    }

    protected function check_memory($path) {
        // GD can consume a lot of memory. Check that the image will not likely
        //  use more memory than we want.
        $imageinfo = getimagesize($path);

        if (isset($imageinfo[0]) && isset($imageinfo[1]) && isset($imageinfo['bits'])) {
            $predicted_mem_usage = $imageinfo[0] * $imageinfo[1] * ($imageinfo['bits'] / 8)
                    * (isset($imageinfo['channels']) ? $imageinfo['channels'] : 3);
        }

        return (!empty($predicted_mem_usage) &&
                $predicted_mem_usage > $this->_memory_limit);
    }

}
