<?php

/**
 * Static class that validates paths for if they're local or remove and if they
 * are "safe" if local (so that one cannot provide a path to an image outside of
 * the mobile root to access data in the rest of the file system).
 *
 * @author ebollens
 * @version 20101021
 *
 * @todo This file needs comments for methods and variables.
 */

class Path_Validator
{	
	public static function is_safe($path, $ext = false)
	{
		if(self::is_remote($path))
			return true;
			
		if($ext && substr($path, strlen($path) - strlen($ext), strlen($ext)) != $ext)
			return false;
		
		$local = dirname(dirname(dirname(__FILE__)));
		
		if(substr(realpath($path), 0, strlen($local)) == $local)
			return true;
			
		return false;
	}
	
	public static function is_remote($path)
	{
		return (substr($path, 0, 7) == 'http://' || substr($path, 0, 8) == 'https://');
	}
	
	public static function is_local($path)
	{
		return !self::is_remote($path);
	}
}

?>