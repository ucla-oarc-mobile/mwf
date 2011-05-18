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
 * @package    WURFL
 * @copyright  WURFL-PRO SRL, Rome, Italy
 * @license
 * @version    $id$
 */

class WURFL_Handlers_Utils {
	
	private static $mobileBrowsers = array (
        "cldc",
        "symbian",
        "midp",
        "j2me",
        "mobile",
        "wireless",
        "palm",
        "phone",
        "pocket pc",
        "pocketpc",
        "netfront",
        "bolt",
        "iris",
        "brew",
        "openwave",
        "windows ce",
        "wap2",
        "android",
        "opera mini",
        "opera mobi",
        "maemo",
        "fennec",
        "blazer",
        "160x160",
        "tablet",
        "webos",
        "sony",
        "nitro",
        "480x640",
        "aspen simulator",
        "up.browser",
        "up.link",
        "embider",
        "danger hiptop",
        "obigo",
        "foma");
	
	public static function risMatch($collection, $needle, $tolerance) {
		return WURFL_Handlers_Matcher_RISMatcher::INSTANCE ()->match ( $collection, $needle, $tolerance );
	}
	
	public static function ldMatch($collection, $needle, $tolerance = 7) {
		return WURFL_Handlers_Matcher_LDMatcher::INSTANCE ()->match ( $collection, $needle, $tolerance );
	}
	
	public static function indexOfOrLength($string, $target, $startingIndex = 0) {
		$length = strlen ( $string );
		$pos = strpos ( $string, $target, $startingIndex );
		return $pos === false ? $length : $pos;
	}
	
	public static function indexOfAnyOrLength($userAgent, $needles = array(), $startIndex) {
		$positions = array ();
		foreach ( $needles as $needle ) {
			$pos = strpos ( $userAgent, $needle, $startIndex );
			if ($pos !== false) {
				$positions [] = $pos;
			}
		}
		sort ( $positions );		
		return count ( $positions ) > 0 ? $positions [0] : strlen ( $userAgent );
	}
	
	public static function isMobileBrowser($userAgent) {
		$mobileBrowser = false;
		foreach ( self::$mobileBrowsers as $key ) {
			if (stripos ( $userAgent, $key ) !== FALSE) {
				$mobileBrowser = true;
				break;
			}
		}
		return $mobileBrowser;
	
	}
	
	public static function isSpamOrCrawler($userAgent) {
		//$spamOrCrawlers = array("FunWebProducts", "Spam");		
		return self::checkIfContains ( $userAgent, "Spam" ) || self::checkIfContains ( $userAgent, "FunWebProducts" );
	}
	
	/**
	 * 
	 * Returns the position of third occurrence of a ;(semi-column) if it exists
	 * the string length otherwise
	 *
	 * @param string $haystack
	 */
	public static function thirdSemiColumn($haystack) {
		$thirdSemiColumnIndex = self::ordinalIndexOf ( $haystack, ";", 3 );
		if ($thirdSemiColumnIndex < 0) {
			return strlen ( $haystack );
		}
		
		return $thirdSemiColumnIndex;
	}
	
	public static function ordinalIndexOf($haystack, $needle, $ordinal) {
		if (is_null ( $haystack ) || empty ( $haystack )) {
			throw new InvalidArgumentException ( "haystack must not be null or empty" );
		}
		
		if (! is_integer ( $ordinal )) {
			throw new InvalidArgumentException ( "ordinal must be a positive ineger" );
		}
		
		$found = 0;
		$index = - 1;
		do {
			$index = strpos ( $haystack, $needle, $index + 1 );
			$index = is_int ( $index ) ? $index : - 1;
			if ($index < 0) {
				return $index;
			}
			$found ++;
		} while ( $found < $ordinal );
		
		return $index;
	
	}
	
	public static function firstSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		return $firstSlash != 0 ? $firstSlash : strlen ( $string );
	}
	
	public static function secondSlash($string) {
		$firstSlash = strpos ( $string, "/" );
		if ($firstSlash === false)
			return strlen ( $string );
		return strpos ( substr ( $string, $firstSlash + 1 ), "/" ) + $firstSlash;
	}
	
	public static function firstSpace($string) {
		$firstSpace = strpos ( $string, " " );
		return ($firstSpace == 0) ? strlen ( $string ) : $firstSpace;
	}
	
	public static function firstSemiColonOrLength($string) {
		return self::firstMatchOrLength ( $string, ";" );
	}
	
	public static function firstMatchOrLength($string, $toMatch) {
		$firstMatch = strpos ( $string, $toMatch );
		return ($firstMatch == 0) ? strlen ( $string ) : $firstMatch;
	}
	
	public static function checkIfContains($haystack, $needle) {
		return strpos ( $haystack, $needle ) !== FALSE;
	}

    public static function checkIfContainsAnyOf($haystack, $needles) {
        foreach($needles as $needle) {
            if(self::checkIfContains($haystack, $needle)) return true;
        }
		return false;
	}

    public static function checkIfContainsAll($haystack, $needles=array()) {
        foreach($needles as $needle) {
            if(!self::checkIfContains($haystack, $needle)) return false;
        }
		return true;

    }
    
	
	public static function checkIfContainsCaseInsensitive($haystack, $needle) {
		return stripos ( $haystack, $needle ) !== FALSE;
	}
	
	public static function checkIfStartsWith($haystack, $needle) {
		return strpos ( $haystack, $needle ) === 0;
	}
	
	public static function checkIfStartsWithAnyOf($haystack, $needles) {
		if (is_array ( $needles )) {
			foreach ( $needles as $needle ) {
				if (strpos ( $haystack, $needle ) === 0) {
					return true;
				}
			}
		}
		
		return false;
	}
	
	const LANGUAGE_PATTERN = "/; [a-z]{2}(-[a-zA-Z]{0,2})?(?!=[;)])/";
	/**
	 * Removes the locale portion from the userAgent
	 * @param string $userAgent
	 */
	public static function removeLocale($userAgent) {
		return preg_replace ( self::LANGUAGE_PATTERN, "", $userAgent, 1 );
	}



    const WORST_MATCH = 7;

}

