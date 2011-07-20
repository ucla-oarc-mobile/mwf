<?php

/**
 * Configuration file for User Agent class and its adapters.
 *
 * This should NOT be included directly; instead /assets/config.php should be.
 *
 * @author ebollens
 * @version 20110511
 *
 * @uses Config
 * @link /assets/config.php
 */

require_once(dirname(dirname(__FILE__)).'/root/assets/lib/config.class.php');

/**
 * user_agent_adapter
 *
 * Name of the class (and file) in /assets/lib used as the adapter for
 * interpretting a user agent in User_Agent.
 *
 * Default: User_Agent_WURFL_Adapter
 * 
 * @link /assets/lib/user_agent.class.php
 */
Config::set('user_agent', 'adapter', 'User_Agent_WURFL_Adapter');


/**
 * user_agent_adapter_wurfl_config_path
 *
 * Path of the WURFL configuration file. This is set up when the install script
 * is run, but it may be changed to make WURFL use a different path. This only
 * applies if the user_agent_adapter is User_Agent_WURFL_Adapter.
 *
 * Default: /var/mobile/wurfl/wurfl-config.xml
 * 
 * @link /assets/lib/user_agent_wurfl_adapter.class.php
 */
Config::set('user_agent', 'wurfl_config_path', '/var/mobile/wurfl/wurfl-config.xml');


/**
 * user_agent_adapter_wurlf_php_api_path
 *
 * Path of the WURFL PHP API directory.
 *
 * Default: /var/mobile/wurfl/api/WURFL
 *
 * @link /assets/lib/user_agent_wurfl_adapter.class.php
 */
Config::set('user_agent', 'wurfl_php_api_path', '/var/mobile/wurfl/api/WURFL');
