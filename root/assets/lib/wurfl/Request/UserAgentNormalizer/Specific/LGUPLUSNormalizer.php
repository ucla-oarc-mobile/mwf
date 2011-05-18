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
 * @package    WURFL_Request_UserAgentNormalizer_Specific
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @author     Fantayeneh Asres Gizaw
 * @version    $id$
 */
class WURFL_Request_UserAgentNormalizer_Specific_LGUPLUSNormalizer implements WURFL_Request_UserAgentNormalizer_Interface {

    /**
     *
     * @param string $userAgent
     * @return string
     */
    const LGPLUS_PATTERN = "/Mozilla.*(Windows (?:NT|CE)).*(POLARIS|WV).*lgtelecom;.*;(.*);.*/";

    public function normalize($userAgent) {
        return preg_replace(self::LGPLUS_PATTERN, "$3 $1 $2", $userAgent);
        /*
        $matches = array();
        if (preg_match(self::LGPLUS_PATTERN, $userAgent, $matches) != 0) {
            return $matches[1];
        }
        return $userAgent;
        */
    }

}

