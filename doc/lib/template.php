<?php

/**
 * @author ebollens
 * @version 20120516
 */

class Template
{
    /**
     * Path relative to the documentation root directory from whence to load 
     * the template file.
     * 
     * @var string
     */
    public static $path = 'assets/template.php';
    
    /**
     * Initializer that must be called before content output to start the
     * template buffering that will, at end of execution, then render out all
     * output within the template.
     */
    public static function init()
    {
        ob_start();
        
        register_shutdown_function('Template::execute', new Template());
    }
    
    /**
     * Execute template rendition, outputting from Template::render(). This 
     * cannot be called directly, but instead is invoked on script shutdown
     * if Template::init() has been called.
     * 
     * @param Template $obj 
     */
    public static function execute($object = null)
    {
        if(!$object || !is_a($object, __CLASS__))
        {
            trigger_error('Template::execute() cannot be called directly', E_USER_WARNING);
            return;
        }
        
        $CONTENT = ob_get_contents();
        
        ob_end_clean();
        
        include(dirname(dirname(__FILE__)).'/'.self::$path);
    }
}