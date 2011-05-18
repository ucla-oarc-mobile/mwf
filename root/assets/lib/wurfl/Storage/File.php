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
class WURFL_Storage_File extends WURFL_Storage_Base {

    private $defaultParams = array(
        "dir" => "/var/tmp",
        "expiration" => 0,
    );

    private $expire;
    private $root;

    const DIR = "dir";

    public function __construct($params) {
        $currentParams = is_array($params) ? array_merge($this->defaultParams, $params) : $this->defaultParams;
        $this->initialize($currentParams);
    }

    function initialize($params) {
        $this->root = $params [self::DIR];
        $this->createDirIfNotExist($this->root);
        $this->expire = $params ["expiration"];
    }

    private function createDirIfNotExist($dir) {
        if (!file_exists($dir)) {
            mkdir ($this->root, 0777, TRUE);
        }
    }

    public function load($key) {
        $path = $this->keyPath($key);
        $value = WURFL_FileUtils::read($path);
        return isset($value) ? $this->unwrap($value, $path) : NULL;
    }

    private function unwrap($value, $path) {
        if ($value->isExpired()) {
            unlink($path);
            return NULL;
        }
        return $value->value();
    }

    public function save($key, $value) {
        $value = new StorageObject($value, $this->expire);
        $path = $this->keyPath($key);
        WURFL_FileUtils::write($path, $value);
    }

    public function clear() {
        WURFL_FileUtils::rmdirContents($this->root);
    }


    private function keyPath($key) {
        return WURFL_FileUtils::join(array($this->root, $this->spread(md5($key))));
    }

    function spread($md5, $n = 2) {
        $path = "";
        for ($i = 0; $i < $n; $i++) {
            $path .= $md5 [$i] . DIRECTORY_SEPARATOR;
        }
        $path .= substr($md5, $n);
        return $path;
    }


}

class StorageObject {
    private $value;
    private $expiringOn;

    public function __construct($value, $expire) {
        $this->value = $value;
        $this->expiringOn = ($expire === 0) ? $expire : time() + $expire;
    }

    public function value() {
        return $this->value;
    }

    public function isExpired() {
        if ($this->expiringOn === 0) {
            return false;
        }
        return $this->expiringOn < time();
    }

    public function expiringOn() {
        return $this->expiringOn;
    }

}