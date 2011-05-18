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
class WURFL_UserAgentHandlerChainFactory {

    private static $_userAgentHandlerChain = NULL;

    private function __construct() {
    }


    public static function createFrom(WURFL_Context $context) {
        self::init($context);
        return self::$_userAgentHandlerChain;
    }

    static private function init(WURFL_Context $context) {

        self::$_userAgentHandlerChain = new WURFL_UserAgentHandlerChain ();

        $genericNormalizers = self::createGenericNormalizers();


        $chromeNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Chrome ());
        $konquerorNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Konqueror ());
        $safariNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Safari ());
        $firefoxNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Firefox ());
        $msieNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_MSIE ());

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_NokiaHandler ($context, $genericNormalizers));
        $lguplusNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_LGUPLUSNormalizer());
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_LGUPLUSHandler ($context, $genericNormalizers));

        $androidNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Android());
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_AndroidHandler ($context, $androidNormalizer));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SonyEricssonHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_MotorolaHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_BlackBerryHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SiemensHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SagemHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SamsungHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_PanasonicHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_NecHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_QtekHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_MitsubishiHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_PhilipsHandler ($context, $genericNormalizers));
        $lgNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_LGNormalizer());
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_LGHandler ($context, $lgNormalizer));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_AppleHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_KyoceraHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_AlcatelHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SharpHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SanyoHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_BenQHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_PantechHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_ToshibaHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_GrundigHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_HTCHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_VodafoneHandler ($context, $genericNormalizers));


        // BOT
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_BotCrawlerTranscoderHandler ($context, $genericNormalizers));


        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SPVHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_WindowsCEHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_PortalmmmHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_DoCoMoHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_KDDIHandler ($context, $genericNormalizers));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_OperaMiniHandler ($context, $genericNormalizers));
        $maemoNormalizer = $genericNormalizers->addUserAgentNormalizer(new WURFL_Request_UserAgentNormalizer_Specific_Maemo());
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_MaemoBrowserHandler ($context, $maemoNormalizer));


        // Web Browsers handlers
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_ChromeHandler($context, $chromeNormalizer));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_AOLHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_OperaHandler ($context, $genericNormalizers));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_KonquerorHandler ($context, $konquerorNormalizer));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_SafariHandler ($context, $safariNormalizer));
        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_FirefoxHandler ($context, $firefoxNormalizer));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_MSIEHandler ($context, $msieNormalizer));

        self::$_userAgentHandlerChain->addUserAgentHandler(new WURFL_Handlers_CatchAllHandler ($context, $genericNormalizers));

    }


    private static function createGenericNormalizers() {
        return new WURFL_Request_UserAgentNormalizer(
            array(
                new WURFL_Request_UserAgentNormalizer_Generic_UPLink(),
                new WURFL_Request_UserAgentNormalizer_Generic_BlackBerry(),
                new WURFL_Request_UserAgentNormalizer_Generic_YesWAP(),
                new WURFL_Request_UserAgentNormalizer_Generic_BabelFish(),
                new WURFL_Request_UserAgentNormalizer_Generic_SerialNumbers(),
                new WURFL_Request_UserAgentNormalizer_Generic_NovarraGoogleTranslator(),
                new WURFL_Request_UserAgentNormalizer_Generic_LocaleRemover()
            )
        );
    }


}

