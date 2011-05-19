<?php

/**
 *
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 * @uses Config
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.class.php');
require_once(dirname(__FILE__).'/footer.class.php');

class Default_Footer_Site_Decorator extends Footer_Site_Decorator
{
    public function __construct()
    {
        parent::__construct();

        if($full_site_url = Config::get('global', 'full_site_url'))
            $this->set_full_site('Full Site', Config::get('frontpage', 'full_site_url'));

        if($help_site_url = Config::get('global', 'help_site_url'))
            $this->set_help_site('Help', Config::get('frontpage', 'help_site_url'));
    }
}
