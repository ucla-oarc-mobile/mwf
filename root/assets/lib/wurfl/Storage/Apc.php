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
class WURFL_Storage_Apc extends WURFL_Storage_Base {

    const EXTENSION_MODULE_NAME = "apc";
    private $currentParams = array(
        "namespace" => "wurfl",
        "expiration" => 0
    );

    
    public function __construct($params = array()) {
        if(is_array($params))  {
            array_merge($this->currentParams, $params);
        }
        //$this->initialize();
    }


    public function initialize() {
        $this->ensureModuleExistence();
    }

    public function save($objectId, $object) {
        apc_store($this->encode($this->apcNameSpace(), $objectId), $object, $this->expire());
    }

    public function load($objectId) {
        $value = apc_fetch($this->encode($this->apcNameSpace(), $objectId));
        return $value !== false ? $value : NULL;
    }

    public function remove($objectId) {
        apc_delete($this->encode($this->apcNameSpace(), $objectId));
    }

    /**
     * Removes all entry from the Persistence Provider
     *
     */
    public function clear() {
        apc_clear_cache("user");
    }


    private function apcNameSpace() {
        return $this->currentParams["namespace"];
    }

    private function expire() {
        return $this->currentParams["expiration"];   
    }

    /**
     * Ensures the existence of the the PHP Extension apc
     *
     */
    private function ensureModuleExistence() {
        if (!(extension_loaded(self::EXTENSION_MODULE_NAME) && ini_get('apc.enabled') == true)) {
            throw new WURFL_Xml_PersistenceProvider_Exception ("The PHP extension apc must be installed, loaded and enabled.");
        }
    }

}