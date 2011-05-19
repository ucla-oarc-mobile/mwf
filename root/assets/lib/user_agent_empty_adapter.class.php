<?php

/**
 * An adapter class used by the User_Agent when it does not detect a user agent
 * for the client that responds as though its is a "basic" device.
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
 */

require_once('user_agent_adapter.interface.php');

class User_Agent_Empty_Adapter implements User_Agent_Adapter_Interface
{
    public function __construct()
    {
        return;
    }

    public function has_capability($capability)
    {
        return false;
    }

    public function  get_capability($capability)
    {
        return false;
    }

    public function is_mobile()
    {
        return true;
    }

    public function is_standard()
    {
        return false;
    }

    public function is_full()
    {
        return false;
    }

    public function is_webkit_engine()
    {
        return false;
    }

    public function is_iphone_os()
    {
        return false;
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

    public function is_webkit()
    {
        return false;
    }

    public function is_touch()
    {
        return false;
    }
}

?>