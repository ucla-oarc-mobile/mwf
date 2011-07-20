<?php

/**
 * An adapter class used by the User_Agent so that it can leverage the WURFL
 * PHP API for mobile device capabilities.
 *
 * @package core
 * @subpackage user_agent
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110510
 *
 * @uses User_Agent_Adapter_Interface
 * @uses Config
 * @uses /assets/lib/wurfl/Application.php
 * @uses WURFL_Configuration_XmlConfig
 * @uses WURFL_WURFLManagerFactory
 */

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(Config::get('user_agent', 'wurfl_php_api_path').'/Application.php');
require_once('user_agent_adapter.interface.php');

class User_Agent_WURFL_Adapter implements User_Agent_Adapter_Interface
{
    /**
     * A WURFL PHP API object containing a manager that can build device objects.
     *
     * @var WURFLManager
     */
    private $_manager;

    /**
     * A WURFL PHP API object containing device information.
     *
     * @var WURFL_Device
     */
    private $_device;

    /**
     * This is a string if loaded in as such, else it is null.
     *
     * @var string|null
     */
    private $_user_agent;

    /**
     * Constructor takes user agent that it will use to determine results of
     * other methods. It also builds a chain of WURLF objects (XMLConfig ->
     * ManagerFactory -> Manager), concluding with a manager that calculates
     * device information for the user agent in question and stores it in
     * $_device.
     *
     * In the event that the $useragent passed is NULL,
     *
     * @param string $useragent
     */
    public function __construct($useragent)
    {
        $this->_user_agent = $useragent;
        if(!$this->_user_agent)
        {
            $this->_manager = null;
            $this->_device = null;
        }
        else
        {
            $config = new WURFL_Configuration_XmlConfig(Config::get('user_agent', 'wurfl_config_path'));
            $factory = new WURFL_WURFLManagerFactory($config);
            $this->_manager = $factory->create();
            $this->_device = $this->_manager->getDeviceForUserAgent($useragent);
        }
    }

    /**
     * Accessor to determine if user agent has the capability $capability.
     * This transforms "false" into boolean false value, as XML contains
     * string version of "false".
     *
     * @param stirng $capability
     * @return bool
     */
    public function has_capability($capability)
    {
        return ($this->_user_agent
                && $this->_device->getCapability($capability) != 'false'
                && $this->_device->getCapability($capability) != false);
    }

    /**
     * Accessor to get the $capability for the user agent from WURFL. This 
     * method does not make any promises about the form of the value returned
     * and especial caution should be afforded concerning false versus 'false'.
     *
     * @param string $capability
     * @return bool
     */
    public function  get_capability($capability)
    {
        return $this->_user_agent ? $this->_device->getCapability($capability) : false;
    }

    /**
     * Accessor to determine if user agent denotes a mobile device. This will
     * return true if the user agent is available and if the device has the
     * is_wireless_device capability or is a touch device.
     *
     * @return bool
     */
    public function is_mobile()
    {
        return (!$this->_user_agent
                || (
                        strpos($this->_user_agent, 'MSIE 9.0') === false
                        && $this->_device->getCapability('is_wireless_device') == 'true'
                    )
                );
    }

    /**
     *
     * @return bool
     */
    public function is_standard()
    {
        return ($this->_user_agent
                && $this->_device->getCapability('pointing_method') !== ''
                && $this->_device->getCapability('ajax_support_javascript') == 'true'
                && $this->_device->getCapability('ajax_manipulate_dom') == 'true');
    }

    /**
     *
     * @return bool
     */
    public function is_full()
    {
        return (
                $this->is_standard() === true
                && (
                        $this->is_webkit_engine()
                        || ($this->_device->getCapability('css_rounded_corners') != 'none'
                            && $this->_device->getCapability('css_rounded_corners') != 'none')
                   )
                );
    }

    /**
     *
     * @return bool
     */
    public function is_webkit_engine()
    {
        if(!$this->_user_agent)
            return false;
        $agent = strtolower($this->_user_agent);
        return strpos($agent, 'webkit') !== false && strpos($agent, 'webkit/41') === false;
    }

    /**
     * Accessor to determine if user agent denotes an iPhone OS / iOS device.
     * WURFL provides device_os capability which currently returns "iPhone OS",
     * and in the future might return "iOS" as the former term has been
     * deprecated in favor of the latter.
     *
     * @return bool
     */
    public function is_iphone_os()
    {
        return ($this->_user_agent
                && ($this->_device->getCapability('device_os') == 'iPhone OS'
                    || $this->_device->getCapability('device_os') == 'iOS'));
    }

    /******************************************************************
     *
     * DEPRECATED METHODS
     *
     * Methods below this point must still be supported by the interface
     * but are deprecated in the current version of MWF and may later
     * be removed from this adapter.
     *
     */

    /**
     * Accessor to determine if user agent denotes a Webkit-based browser.
     * This method does not actually use WURFL directly, but instead checks if
     * the device is a touch device (this check indirectly uses WURFL) and then,
     * if it does, also checks to see if the user agent is "webkit" but not
     * "webkit/41". The "webkit/41" user agent is ignored because of the lacking
     * capabilities of phones that use it.
     *
     * @deprecated
     * @return bool
     */
    public function is_webkit()
    {
        return ($this->is_touch() === true && $this->is_webkit_engine());
    }

    /**
     * Accessor to determine if user agent denotes a rich interface device.
     * For the purpose of the mobile application, a rich interface is considered
     * anything besides T9, a la that the device has a "pointing_method" as a
     * WURFL capability. In addition, because touch uses some basic Javascript,
     * this also requires support for basic Javascript and DOM manipulation
     * through document.write.
     *
     * @deprecated
     * @return bool
     */
    public function is_touch()
    {
        return ($this->_user_agent
                && $this->_device->getCapability('pointing_method') !== ''
                && $this->_device->getCapability('ajax_support_javascript') == 'true'
                && $this->_device->getCapability('ajax_manipulate_dom') == 'true');
    }
}

?>