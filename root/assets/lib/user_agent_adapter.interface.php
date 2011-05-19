<?php

/**
 * An interface for user agent adapters that may be used with User_Agent as
 * specified in the {'user_agent':'adapter'} config setting.
 *
 * @package core
 * @subpackage user_agent
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110510
 */

interface User_Agent_Adapter_Interface
{
    /**
     * Constructor takes user agent that it will use to determine results of
     * other methods.
     *
     * @param string $useragent 
     */
    public function __construct($useragent);

    /**
     * Accessor to determine if user agent has the capability $capability.
     *
     * @param string $capability
     * @return bool
     */
    public function has_capability($capability);


    /**
     * @param string $capability
     * @return mixed
     */
    public function get_capability($capability);

    /**
     * Accessor to determine if user agent denotes a mobile device.
     *
     * @return bool
     */
    public function is_mobile();

    /**
     * Accessor to determine if user agent denotes that the device has
     * standard capabilities including DOM write support and a rich
     * navigation interface.
     *
     * @return bool
     */
    public function is_standard();

    /**
     * Accessor to determine if user agent denotes that the device has
     * full capabilities including CSS 3 and HTML 5 support.
     *
     * @return bool
     */
    public function is_full();

    /**
     * Accessor to determine if user agent denotes that the device uses the
     * Webkit engine.
     *
     * @return bool
     *
     */
    public function is_webkit_engine();

    /**
     * Accessor to determine if user agent denotes an iPhone OS / iOS device.
     *
     * @return bool
     */
    public function is_iphone_os();

    /******************************************************************
     *
     * DEPRECATED METHODS
     *
     * Methods below this point must still be supported by the interface
     * but are deprecated in the current version of MWF and may later
     * be removed from this interface and associated adapters.
     *
     */

    /**
     * Accessor to determine if user agent denotes a Webkit-based browser.
     *
     * @deprecated
     * @return bool
     */
    public function is_webkit();

    /**
     * Accessor to determine if user agent denotes a rich interface device.
     *
     * @deprecated
     * @return bool
     */
    public function is_touch();
}

?>