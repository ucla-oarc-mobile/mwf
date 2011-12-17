<?php

/**
 * Static class that validates paths for if they're local or remove and if they
 * are "safe" if local (so that one cannot provide a path to an image outside of
 * the mobile root to access data in the rest of the file system).
 *
 * @package core
 * @subpackage path
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111102
 *
 * @uses Path_Validator
 */
/**
 * Require necessary parent class definition.
 */
require_once('path_validator.class.php');

class Path extends Path_Validator {

    /**
     * The timeout that curl will wait for on HTTP GET. If this is causing
     * curl to fail the download, then this should be increased. However, in
     * most cases, the default of 1 second should be more than enough for a
     * HTTP GET between well-connected resources.
     *
     * @var int
     */
    private static $_curl_timeout_download = 1;

    /**
     * The timeout that curl will wait for on HTTP HEAD. If this is causing
     * curl to fail the request, then this should be increased. However, in
     * most cases, the default of 1 second should be more than enough for a
     * HTTP HEAD request between well-connected resources.
     *
     * @var int
     */
    private static $_curl_timeout_exists = 1;

    /**
     * Returns true if the file exists by way of an HTTP HEAD curl request. This
     * will also fail if the $path is unsafe and $safe is not set to false.
     *
     * @param string $path
     * @uses curl
     * @return bool
     */
    public static function exists($path, $safe = true) {
        if ($safe && !self::is_safe($path))
            return false;

        if (self::is_local($path))
            return file_exists($path);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$_curl_timeout_exists);
        $result = curl_exec($ch);
        curl_close($ch);
        return substr($result, 0, strlen('HTTP/1.1 200')) == 'HTTP/1.1 200';
    }

    /**
     * Returns path contents if the file exists by way of an HTTP HEAD curl
     * request. This will also fail if the $path is unsafe and $safe is not
     * set to false.
     *
     * @param string $path
     * @uses curl
     * @return bool
     */
    public static function get_contents($path, $safe = true) {
        if ($safe && !self::is_safe($path))
            return false;

        if (self::is_local($path)) {
            $docroot = dirname(dirname(dirname(__FILE__)));
            $result = file_get_contents($docroot . '/' . $path);
            
            // @deprecated: if file isn't found under docroot, try from /
            if ($result === false) {
                $result = file_get_contents($path);
            }

            return $result;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$_curl_timeout_download);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
