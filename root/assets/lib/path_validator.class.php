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
 * @version 20101021
 */

class Path_Validator
{
    /**
     * Returns true if the system regards the path as "safe" by the following
     * criteria: a safe path is considered "safe" if it is either (1) a remote
     * path (with the scheme "http://" or "https://") or if it is local and
     * within the local web root. This means that a path in the repository
     * but not beneath /root is considered unsafe. If $ext is provided, it
     * also checks the file to ensure that the proper extension exists.
     *
     * @param string $path
     * @param string $ext
     * @return bool
     */
    public static function is_safe($path, $ext = false)
    {
        if($ext && substr($path, strlen($path) - strlen($ext), strlen($ext)) != $ext)
            return false;
        
        if(self::is_remote($path))
            return true;

        $docroot = dirname(dirname(dirname(__FILE__)));
       
        $full_path = $docroot . '/' . $path;
        
        // Check to see if file path appended to docroot is still under
        //  docroot. This prevents ..-style shenanigans.
        if(substr(realpath($full_path), 0, strlen($docroot)) == $docroot)
                return true;
        
        // @deprecated Check to see if true full path is specified
        if(substr(realpath($path), 0, strlen($docroot)) == $docroot)
            return true;

        return false;
    }

    /**
     * Returns true if the scheme begins with "http://" or "https://", or false
     * otherwise.
     * 
     * @param string $path
     * @return bool
     */
    public static function is_remote($path)
    {
        return (substr($path, 0, 7) == 'http://' || substr($path, 0, 8) == 'https://');
    }

    /**
     * Returns true if the path is not remote (does not start with the scheme
     * "http://" or "https://", or false otherwise.
     *
     * @param string $path
     * @return bool
     */
    public static function is_local($path)
    {
        return !self::is_remote($path);
    }
}
