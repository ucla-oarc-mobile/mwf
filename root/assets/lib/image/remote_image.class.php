<?php

/**
 * An object that encapsulates an image via its path, determines if its safe,
 * allows for transformations of extension and dimensions, handles caching
 * and produces image headers and output.
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
 *
 * @todo Comments
 * @todo Refactor
 */
require_once(dirname(dirname(__FILE__)).'/image.class.php');

class Remote_Image extends Image {
    
    private $_image_gd = null;

    protected function &get_gd_image() {
        if ($this->_image_gd !== null)
            return $this->_image_gd;

        $image_path = $this->get_image_path();
        if ($image_path === false) {
            $this->_image_gd = false;
            return $this->_image_gd;
        }
        
        $unlink_path = FALSE;
        $path = $this->get_cache_filename();
        if (! file_exists($path)) {
            $path = tempnam(sys_get_temp_dir(), 'mwf');
            if (ini_get('allow_url_fopen')) {
                /* NB: We are trusting that the URL is encoded already. This is true if it came from the image minifier. */
                file_put_contents($path, file_get_contents($image_path, FALSE, NULL, -1, 9999999));
            } else {
                $ch = curl_init($image_path);
                $fh = fopen($path, 'wb');
                curl_setopt($ch, CURLOPT_FILE, $fh);
                curl_setopt($ch, CURLOPT_HEADER,0);
                curl_setopt($ch, CURLOPT_FAILONERROR, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                curl_exec($ch);
                curl_close($ch);
                fclose($fh);
            }
            $unlink_path = TRUE;
        }
        
        $ext = image_type_to_extension(exif_imagetype($path));

        switch ($ext) {
            case '.jpg':
            case '.jpeg':
                $this->_image_gd = imagecreatefromjpeg($path);
                $this->_image_ext = 'jpeg';
                break;
            case '.gif':
                $this->_image_gd = imagecreatefromgif($path);
                $this->_image_ext = 'gif';
                break;
            case '.png':
                $this->_image_gd = imagecreatefrompng($path);
                $this->_image_ext = 'png';
                break;
            default:
                $this->_image_gd = false;
                $this->_image_ext = false;
                break;
        }
        if ($unlink_path) {
            unlink($path);
        }
        return $this->_image_gd;
    }
    
    protected function get_gd_extension() {
        $this->get_gd_image();
        return $this->_image_ext;
    }
}

?>