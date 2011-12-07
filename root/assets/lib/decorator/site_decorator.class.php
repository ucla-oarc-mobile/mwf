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
 * @version 20111207
 *
 * @uses Decorator
 */

require_once(dirname(dirname(__FILE__)).'/decorator.class.php');

class Site_Decorator extends Decorator
{
    /**
     *
     * @param string $name
     * @param array $args
     * @return Decorator
     */
    public static function __callStatic($name, $args = array())
    {
        return self::factory($name, $args);
    }

    /**
     *
     * @param string $name
     * @param array $args
     * @return Decorator
     */
    public static function factory($name, $args = array())
    {
        $name = strtolower($name);
        // Deprecated support for old decorators
        switch($name)
        {
            case 'button_full':
                self::_throw_deprecated_object_error('button_full', 'button');
                $name = 'button';
                break;
            
            case 'content_full':
                self::_throw_deprecated_object_error('content_full', 'content');
                $name = 'content';
                break;
            
            case 'menu_full':
                self::_throw_deprecated_object_error('menu_full', 'menu');
                $name = 'menu';
                break;
        }
        
        require_once(dirname(__FILE__).'/site/'.$name.'.class.php');
        $class = $name.'_Site_Decorator';
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }
    
    private static function _throw_deprecated_object_error($old, $new)
    {
        trigger_error('Site decorator object "'.$old.'" is deprecated and "'.$new.'" should be used instead', E_USER_NOTICE);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Button_Full_Site_Decorator
     */
    public static function button_full()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Default_Footer_Site_Decorator
     */
    public static function default_footer()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Footer_Site_Decorator
     */
    public static function footer()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Head_Site_Decorator
     */
    public static function head()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Header_Site_Decorator
     */
    public static function header()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Content_Full_Site_Decorator
     */
    public static function content_full()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Menu_Full_Site_Decorator
     */
    public static function menu_full()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }
}

?>
