<?php

/**
 * An object that encapsulates an image via its path, determines if its safe,
 * allows for transformations of extension and dimensions, and handles caching.
 *
 * @package core
 * @subpackage path
 *
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110929
 *
 * @uses Image
 * @uses Path
 *
 * @todo Comments
 * @todo Refactor
 */
require_once(dirname(dirname(__FILE__)) . '/image.class.php');
require_once(dirname(dirname(__FILE__)) . '/path.class.php');

class Local_Image extends Image {

    private $_image_gd = null;

    protected function &get_gd_image() {
        if ($this->_image_gd !== null)
            return $this->_image_gd;

        $image_path = $this->get_image_path();
        if ($image_path === false) {
            $this->_image_gd = false;
            return $this->_image_gd;
        }

        $path = $image_path;
        $this->_image_gd = imagecreatefromstring(Path::get_contents($path));

        if (!$this->_image_gd) {
            $this->_image_ext = false;
        } else {

            $pathinfo = pathinfo($path);
            $ext = array_key_exists('extension',$pathinfo) ? $pathinfo['extension'] : '';

            switch (strtolower($ext)) {
                case 'jpg':
                case 'jpeg':
                    $this->_image_ext = 'jpeg';
                    break;
                case 'gif':
                    $this->_image_ext = 'gif';
                    break;
                case 'png':
                    $this->_image_ext = 'png';
                    break;
                default:
                    $this->_image_gd = false;
                    $this->_image_ext = false;
                    break;
            }
        }
        return $this->_image_gd;
    }

    protected function get_gd_extension() {
        $this->get_gd_image();
        return $this->_image_ext;
    }

}

?>