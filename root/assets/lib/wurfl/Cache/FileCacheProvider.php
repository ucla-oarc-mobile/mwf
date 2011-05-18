<?php
/**
 * WURFL API
 *
 * LICENSE
 *
 * This file is released under the GNU General Public License. Refer to the
 * COPYING file distributed with this package.
 *
 * Copyright (c) 2008-2009, WURFL-Pro S.r.l., Rome, Italy
 * 
 * 
 *
 * @category   WURFL
 * @package    WURFL_Cache
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * A Cache Provider that uses the File System as a storage
 *
 *
 * @category   WURFL
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Cache_FileCacheProvider implements WURFL_Cache_CacheProvider {
	
	private $_cacheDir;
	const DIR = "dir";
	
	private $cacheIdentifier = "FILE_CACHE_PROVIDER";
	private $expire;
	private $root;
	
	function __construct($params) {
		if (is_array ( $params )) {
			if (! array_key_exists ( self::DIR, $params )) {
				throw new WURFL_WURFLException ( "Specify a valid cache dir in the configuration file" );
			}
			
			// Check if the directory exist and it is also write access
			if (! is_writable ( $params [self::DIR] )) {
				throw new WURFL_WURFLException ( "The diricetory specified <" . $params [self::DIR] . " > for the cache provider does not exist or it is not writable\n" );
			}
			
			$this->_cacheDir = $params [self::DIR] . DIRECTORY_SEPARATOR . $this->cacheIdentifier;
			$this->root = $params [self::DIR] . DIRECTORY_SEPARATOR . $this->cacheIdentifier;
			$this->expire = isset ( $params [WURFL_Cache_CacheProvider::EXPIRATION] ) ? $params [WURFL_Cache_CacheProvider::EXPIRATION] : WURFL_Cache_CacheProvider::NEVER;
			
			WURFL_FileUtils::mkdir( $this->_cacheDir );
		}
	
	}
	
	public function get($key) {
		$path = $this->keyPath ( $key );
		$data = WURFL_FileUtils::read ( $path );
		if (! is_null ( $data ) && $this->expired ( $path )) {
			unlink ( $path );
			return NULL;
		}
		return $data;
	}
	
	public function put($key, $value) {
		$mtime = time () + $this->expire;
		$path = $this->keyPath ( $key );
		WURFL_FileUtils::write ( $path, $value, $mtime );
	}
	
	public function clear() {
		WURFL_FileUtils::rmdirContents($this->root);
	}
	
	private function expired($path) {
		if ($this->expire === 0) {
			return FALSE;
		}
		return filemtime ( $path ) < time ();
	}
	
	private function neverToExpire() {
		return $this->expire === 0;
	}
	
	private function keyPath($key) {
		return WURFL_FileUtils::join ( array ($this->root, $this->spread ( md5 ( $key ) ) ) );
	}
	
	function spread($md5, $n = 2) {
		$path = "";
		for($i = 0; $i < $n; $i ++) {
			$path .= $md5 [$i] . DIRECTORY_SEPARATOR;
		}
		$path .= substr ( $md5, $n );
		return $path;
	}

}

