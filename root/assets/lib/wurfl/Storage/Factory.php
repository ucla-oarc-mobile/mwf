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
class WURFL_Storage_Factory {

    private static $defaultConfiguration = array(
        "provider" => "memory",
        "params" => array()
    );

    public static function create($configuration) {
        $currentConfiguration = is_array($configuration) ?
                array_merge(self::$defaultConfiguration, $configuration)
                : self::$defaultConfiguration;
        $class = self::className($currentConfiguration);
        return new $class($currentConfiguration["params"]);
    }

    private static function className($configuration) {
        $provider = $configuration["provider"];
        return "WURFL_Storage_" . ucfirst($provider);
    }
}