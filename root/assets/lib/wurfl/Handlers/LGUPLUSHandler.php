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
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

/**
 * LGUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_LGUPLUSHandler extends WURFL_Handlers_Handler {

    protected $prefix = "LGUPLUS";

    function __construct($wurflContext, $userAgentNormalizer = null) {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }

    /**
     *
     * @param string $userAgent
     * @return string
     */
    public function canHandle($userAgent) {
        return WURFL_Handlers_Utils::checkIfContainsAnyOf($userAgent, array("LGUPLUS", "lgtelecom"));
    }

    
    /**
     *
     * @param string $userAgent
     * @return string
     */
    function applyConclusiveMatch($userAgent) {
        return WURFL_Constants::GENERIC;
    }


    private $lgupluses = array(
        "generic_lguplus_rexos_facebook_browser" => array("Windows NT 5", "POLARIS"),
        "generic_lguplus_rexos_webviewer_browser" => array("Windows NT 5"),
        "generic_lguplus_winmo_facebook_browser" => array("Windows CE", "POLARIS"),
        "generic_lguplus_android_webkit_browser" => array("Android", "AppleWebKit")
    );

    function applyRecoveryMatch($userAgent) {
        foreach($this->lgupluses as $deviceId => $values) {
            if(WURFL_Handlers_Utils::checkIfContainsAll($userAgent, $values)) {
                return $deviceId;
            }
        }
        return "generic_lguplus";
    }

}
