<?php

class WURFL_Xml_PersistenceProvider_InMemoryPersistenceProvider extends WURFL_Xml_PersistenceProvider_AbstractPersistenceProvider {
	
	const IN_MEMORY = "memory";
	
	protected $persistenceIdentifier = "IN_MEMORY_PERSISTENCE_PROVIDER";
	
	
	private $map;
	
	public function __construct() {
		$this->map = array();
	}
	
	public function save($objectId, $object) {
		$this->map[$this->encode ( $objectId )] = $object;
	}
	
	public function load($objectId) {
		$key = $this->encode ( $objectId);
		if (isset($this->map [$key])) {
			return $this->map [$key];
		}
		
		return NULL;
	
	}
	
	public function remove($objectId) {
		$key = $this->encode ( $objectId );
		if($this->map [$key]) {
			unset ( $this->map [$key] );
		}
	
	}
	
	/**
	 * Removes all entry from the Persistence Provier
	 *
	 */
	public function clear() {
		unset($this->map);
	}
}
