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
 * OperaHandlder
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */
class WURFL_Handlers_OperaMiniHandler extends WURFL_Handlers_Handler {

    protected $prefix = "OPERA_MINI";

    function __construct($wurflContext, $userAgentNormalizer = null) {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }

    /**
     * Intercept all UAs Containing Opera Mini
     *
     * @param string $userAgent
     * @return boolean
     */
    public function canHandle($userAgent) {
        return WURFL_Handlers_Utils::checkIfContains($userAgent, "Opera Mini");
    }

    private $operaMinis = array(
        "Opera Mini/1" => "browser_opera_mini_release1",
        "Opera Mini/2" => "browser_opera_mini_release2",
        "Opera Mini/3" => "browser_opera_mini_release3",
        "Opera Mini/4" => "browser_opera_mini_release4",
        "Opera Mini/5" => "browser_opera_mini_release5"
    );

    function applyRecoveryMatch($userAgent) {
        foreach ($this->operaMinis as $key => $deviceId) {
            if (WURFL_Handlers_Utils::checkIfContains($userAgent, $key)) {
                return $deviceId;
            }
        }

        return WURFL_Constants::GENERIC;

    }

}