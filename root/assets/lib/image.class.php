<?php

/**
 * An object that encapsulates an image, allows for transformations of extension
 * and dimensions, handles caching and produces image headers and output.
 *
 * @package core
 * @subpackage path
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110929
 *
 * @uses Path_Validator
 *
 * @todo Comments
 * @todo Refactor
 */
require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once(dirname(__FILE__) . '/path_validator.class.php');

abstract class Image {

    private $_image_path;
    private $_image_ext = null;
    private $_image_file_root = null;
    private $_dim_height = false;
    private $_dim_width = false;
    private $_ext_allowed = array();
    private $_ext_force = null;
    private $_cache_filename = null;

    abstract protected function &get_gd_image();

    abstract protected function get_gd_extension();

    public static function factory($image_path) {
        if (!Path_Validator::is_safe($image_path))
            return NULL;

        // FILTER_VALIDATE_URL needs an encoded URL
        $image_url = preg_replace_callback('#://([^/]+)/([^?]+)#', function ($match) {
                    return '://' . $match[1] . '/' . join('/', array_map('rawurlencode', explode('/', $match[2])));
                }, $image_path);

        if (filter_var($image_url, FILTER_VALIDATE_URL)) {
            require_once(dirname(__FILE__) . '/image/remote_image.class.php');
            return new Remote_Image($image_url);
        } else {
            require_once(dirname(__FILE__) . '/image/local_image.class.php');
            return new Local_Image($image_path);
        }
    }

    private function __construct($imagepath) {
        $this->_image_path = $imagepath;
        $this->_image_file_root = md5($imagepath);
    }

    public function set_max_height($max) {
        $this->_dim_height = round($max);
    }

    public function set_max_width($max) {
        $this->_dim_width = round($max);
    }

    public function set_allowed_extension($ext) {
        $this->_ext_allowed[] = $ext;
    }

    public function force_extension($ext) {
        $this->_ext_force = $ext;
    }

    public function output_header() {
        if ($this->_image_path === false)
            return;

        header($this->generate_header());
    }

    public function output_image() {
        if ($this->_image_path === false)
            return;

        $filename = $this->get_cache_filename();

        if (file_exists($filename)) {
            echo file_get_contents($filename);
            return;
        }

        if (!$this->generate_image($filename)) {
            return false;
        }

        if (file_exists($filename)) {
            echo file_get_contents($filename);
            return;
        }

        return false;
    }

    public function generate_header() {
        return "Content-Type: " . image_type_to_mime_type(constant('IMAGETYPE_' . strtoupper($this->get_gd_extension())));
    }

    public function generate_image($savepath = false) {
        $savefunction = false;

        if ($this->_ext_force)
            $savefunction = 'image' . $this->_ext_force;
        elseif (in_array($this->get_gd_extension(), $this->_ext_allowed))
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

        $source = & $this->get_gd_image();

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
        imagecopyresampled($generated, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        if (!is_writable(dirname($savepath)))
            $savepath = false;

        if (!$savepath)
            return $savefunction($generated, null, $quality);

        $savefunction($generated, $savepath, $quality);
        return file_exists($savepath);
    }

    protected function get_cache_filename() {
        if ($this->_cache_filename !== null)
            return $this->_cache_filename;

        $filename = Config::get('image', 'cache_dir') . $this->_image_file_root;

        list($filerawwidth, $filerawheight, $filerawtype, $filerawattr) = getimagesize($this->_image_path);

        if ($filerawwidth > $this->_dim_width || $filerawheight > $this->_dim_height) {
            if ($this->_dim_width || $this->_dim_height)
                $filename .= '-';
            if ($this->_dim_width)
                $filename .= $this->_dim_width . 'w';
            if ($this->_dim_width && $this->_dim_height)
                $filename .= '-';
            if ($this->_dim_height)
                $filename .= $this->_dim_height . 'h';
        }

        if ($this->_ext_force) {
            $filename .= $this->_ext_force;
        }

        return $filename;
    }

    protected function get_image_path() {
        return $this->_image_path;
    }

}

?>
