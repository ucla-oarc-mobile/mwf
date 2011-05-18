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
 * @package    WURFL_Configuration
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Configuration_XmlConfig extends WURFL_Configuration_Config {


    private $configurationDir;

    /**
     * Constructor
     *
     * @param string $confLocation
     */
    function __construct($configFilePath) {
        $this->configurationDir = dirname($configFilePath);
        $this->initialize($configFilePath);
    }


    protected function initialize($configurationFilePath) {
        $xmlConfig = simplexml_load_file($configurationFilePath);
        $this->wurflFile = $this->wurflFile($xmlConfig->xpath("/wurfl-config/wurfl/main-file"));
        $this->wurflPatches = $this->wurflPatches($xmlConfig->xpath("/wurfl-config/wurfl/patches/patch"));
        $this->allowReload = $this->allowReload($xmlConfig->xpath('/wurfl-config/allow-reload'));
        $this->persistence = $this->persistence($xmlConfig->xpath('/wurfl-config/persistence'));
        $this->cache = $this->persistence($xmlConfig->xpath('/wurfl-config/cache'));
    }

    private function wurflFile($maiFileElement) {
        return $this->fullPath((string) $maiFileElement[0]);
    }

    private function wurflPatches($patchElements) {
        $patches = array();
        if ($patchElements) {
            foreach ($patchElements as $patchElement) {
                $patches[] = $this->fullPath((string) $patchElement);
            }
        }
        return $patches;
    }

    private function allowReload($allowReloadElement) {
        if (!empty($allowReloadElement)) {
            return (bool) $allowReloadElement[0];
        }
        return false;
    }

    private function persistence($persistenceElement) {
        $persistence = array();
        if ($persistenceElement) {
            $persistence["provider"] = (string)$persistenceElement[0]->provider;
            $persistence["params"] = $this->_toArray((string)$persistenceElement[0]->params);
        }
        return $persistence;
    }



    //************************* Utility Functions ********************************//

    private function fullPath($path) {
        if(realpath($path) && !(basename($path) === $path )) {
            return realpath($path);
        }

        return join(DIRECTORY_SEPARATOR, array($this->configurationDir, $path));
    }

    private function _toArray($params) {
        $paramsArray = array();

        foreach (explode(",", $params) as $param) {
            $paramNameValue = explode("=", $param);
            if(count($paramNameValue) > 1) {
                if (strcmp(WURFL_Configuration_Config::DIR, $paramNameValue[0]) == 0) {
                    $paramNameValue[1] = $this->fullPath($paramNameValue[1]);
                }
                $paramsArray[trim($paramNameValue[0])] = trim($paramNameValue[1]);                                
            }
        }


        return $paramsArray;
    }

 
    const  WURFL_CONF_SCHEMA = '<?xml version="1.0" encoding="utf-8" ?>
	<element name="wurfl-config" xmlns="http://relaxng.org/ns/structure/1.0">
    	<element name="wurfl">
    		<element name="main-file"><text/></element>
    		<element name="patches">
    			<zeroOrMore>
      				<element name="patch"><text/></element>
    			</zeroOrMore>
  			</element>
  		</element>
        <optional>
  		    <element name="allow-reload"><text/></element>
        </optional>
  		<element name="persistence">
      		<element name="provider"><text/></element>
      		<optional>
      			<element name="params"><text/></element>
      		</optional>
  		</element>
  		<element name="cache">
      		<element name="provider"><text/></element>
      		<optional>
      			<element name="params"><text/></element>
      		</optional>
  		</element>
	</element>';

}

?>