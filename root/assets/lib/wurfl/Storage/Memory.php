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
 * @package    WURFL_Storage
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Storage_Memory extends WURFL_Storage_Base {

	const IN_MEMORY = "memory";

	protected $persistenceIdentifier = "MEMORY_PERSISTENCE_PROVIDER";

    private $defaultParams = array(
        "namespace" => "wurfl"
    );

    private $namespace;
	private $map;

	public function __construct($params=array()) {
        $currentParams = is_array($params) ? array_merge($this->defaultParams, $params) : $this->defaultParams;
        $this->namespace = $currentParams["namespace"];
		$this->map = array();
	}

	public function save($objectId, $object) {
		$this->map[$this->encode ( $this->namespace, $objectId )] = $object;
	}

	public function load($objectId) {
		$key = $this->encode ($this->namespace, $objectId);
		if (isset($this->map [$key])) {
			return $this->map [$key];
		}

		return NULL;

	}

	public function remove($objectId) {
		$key = $this->encode ($this->namespace, $objectId );
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
