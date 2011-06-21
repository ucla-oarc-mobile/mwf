<?php

/**
 *
 *
 * @package decorator
 * @subpackage html_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110619
 *
 * @uses Decorator
 */

require_once(dirname(dirname(__FILE__)).'/decorator.class.php');

class HTML_Decorator extends Decorator
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
        require_once(dirname(__FILE__).'/html/'.$name.'.class.php');
        $class = $name.'_HTML_Decorator';
        $refl = new ReflectionClass($class);
        return $refl->hasMethod('__construct') ? $refl->newInstanceArgs($args) : new $class();
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Body_End_HTML_Decorator
     */
    public static function body_end()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Body_Start_HTML_Decorator
     */
    public static function body_start()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return HTML_End_HTML_Decorator
     */
    public static function html_end()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return HTML_Start_HTML_Decorator
     */
    public static function html_start()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Tag_HTML_Decorator
     */
    public static function tag()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Tag_Close_HTML_Decorator
     */
    public static function tag_close()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }

    /**
     *
     * @compat < PHP 5.3
     * @return Tag_Open_HTML_Decorator
     */
    public static function tag_open()
    {
        $args = func_get_args();
        return self::factory(__FUNCTION__, $args);
    }
}
