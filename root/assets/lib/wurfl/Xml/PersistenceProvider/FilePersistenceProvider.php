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
 * @package    WURFL_Xml_PersistenceProvider
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Xml_PersistenceProvider_FilePersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {
	
	private $_persistenceDir;
	
	protected $persistenceIdentifier = "FILE_PERSISTENCE_PROVIDER";
	
	const DIR = "dir";
	
	public function __construct($params) {
		$this->initialize ( $params );
	}
	
	/**
	 * Initializes the Persistence Dir
	 *
	 * @param array of parameters for configuring the Persistence Provider
	 */
	function initialize($params) {
		if (is_array ( $params )) {
			if (! array_key_exists ( self::DIR, $params )) {
				throw new WURFL_WURFLException ( "Specify a valid Persistence dir in the configuration file" );
			}
			
			// Check if the directory exist and it is also write access
			if (! is_writable ( $params [self::DIR] )) {
				throw new WURFL_WURFLException ( "The diricetory specified <" . $params [self::DIR] . "> for the persistence provider does not exist or it is not writable\n" );
			}
			
			$this->_persistenceDir = $params [self::DIR] . DIRECTORY_SEPARATOR . $this->persistenceIdentifier;
			
			WURFL_FileUtils::mkdir( $this->_persistenceDir );
		}
	}
	
	/**
	 * Saves the object on the file system
	 * 
	 *
	 * @param string $objectId
	 * @param mixed $object
	 */
	public function save($objectId, $object) {
		$path = $this->keyPath ( $objectId  );
		WURFL_FileUtils::write ( $path, $object );
	}
	
	private function keyPath($key) {
		return WURFL_FileUtils::join ( array ($this->_persistenceDir, $this->spread ( md5 ( $key ) ) ) );
	}
	
	function spread($md5, $n = 2) {
		$path = "";
		for($i = 0; $i < $n; $i ++) {
			$path .= $md5 [$i] . DIRECTORY_SEPARATOR;
		}
		$path .= substr ( $md5, $n );
		return $path;
	}
	
	public function load($objectId) {
		$path = $this->keyPath ( $objectId );
		return WURFL_FileUtils::read ( $path );
	}
	
	public function remove($objectId) {
		$path = $this->keyPath ( $objectId );
		@unlink($path);
	}
	
	/**
	 * Clears the persistence provider by removing the directory 
	 *
	 */
	public function clear() {
		WURFL_FileUtils::rmdir($this->_persistenceDir);
	}
}