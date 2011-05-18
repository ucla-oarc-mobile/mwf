<?php

class WURFL_FileUtils {
	
	/**
	 * Create a directory structure recursiveley
	 * @param string $path
	 * @param int $mode
	 */
	public static function mkdir($path, $mode=0755) {
		@mkdir ( $path, $mode, TRUE );
	}
	
	public static function rmdirContents($path) {
		$files = scandir ( $path );
		array_shift ( $files ); // remove '.' from array
		array_shift ( $files ); // remove '..' from array
		

		foreach ( $files as $file ) {
			$file = $path . DIRECTORY_SEPARATOR . $file;
			if (is_dir ( $file )) {
				self::rmdir ( $file );
				rmdir ( $file );
			} else {
				unlink ( $file );
			}
		}	
	}
	
	public static function rmdir($path) {
		self::rmdirContents( $path );
	}
	
	
	public static function read($path) {
		if(file_exists($path)) {
			return unserialize ( file_get_contents ( $path ) );			
		}
		return null;
	}
	
	public static function write($path, $data, $mtime = 0) {
		if (! file_exists ( dirname ( $path ) )) {
			self::mkdir ( dirname ( $path ), 0755, TRUE );
		}
		if (file_put_contents ( $path, serialize ( $data ), LOCK_EX )) {
			$mtime = $mtime > 0 ? $mtime : time ();
			@chmod ( $path, 0777 );
			@touch ( $path, $mtime );
		}
	}
	
	public static function join($strings = array()) {
		return join ( DIRECTORY_SEPARATOR, $strings );
	}

}