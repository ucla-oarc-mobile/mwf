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

/**
 * Base Storage Provider
 *
 * A Skeleton implementation of the Storage Interface
 *
 * @category   WURFL
 * @package    WURFL_Storage
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
abstract class WURFL_Storage_Base implements WURFL_Storage {

    const APPLICATION_PREFIX = "WURFL_";
    const WURFL_LOADED = "WURFL_WURFL_LOADED";


    public function __construct() {
    }

    /**
     * Saves the object.
     *
     * @param string $objectId
     * @param mixed $object
     * @return
     */
    public function save($objectId, $object) {
    }

    /**
     * Returns the object identified by $objectId
     *
     * @param string $objectId
     */
    public function load($objectId) {
    }


    /**
     * Removes from the persistence provider the
     * object identified by $objectId
     *
     * @param string $objectId
     */
    public function remove($objectId) {
    }


    /**
     * Removes all entry from the Persistence Provider
     *
     */
    public function clear() {
    }


    /**
     * Checks if WURFL is Loaded
     *
     * @return boolean
     */
    public function isWURFLLoaded() {
        return $this->load(self::WURFL_LOADED);
    }

    /**
     * Sets a flag
     *
     * @return
     */
    public function setWURFLLoaded($loaded = TRUE) {
        $this->save(self::WURFL_LOADED, $loaded);
    }


    /*
	 * Encode the Object Id using the Persistence Identifier
	 *
	 * @param string $input
	 */
    protected function encode($namespace, $input) {
        return join(":", array(self::APPLICATION_PREFIX, $namespace, $input));
    }

    /**
     * Decode the Object Id
     *
     * @param unknown_type $input
     */
    protected function decode($namespace, $input) {
        $inputs = split(":", $input);
        return $input[2];
    }


}
