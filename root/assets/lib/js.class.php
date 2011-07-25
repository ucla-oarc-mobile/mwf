<?php

/**
 * Singleton that provides a variety of utility functions for working
 * with framework and external Javascript.
 *
 * @package core
 * @subpackage handler
 * 
 * @author ebollens
 * @version 20101021
 *
 * @todo This file needs comments for methods and variables.
 */

class JS
{
    private $_ext;
    private $_webroot;
    private $_fileroot;
    private $_map;
    private $_req;
    private $_imp;
    private $_extern;

    private static $_instance = null;

    private function __construct()
    {
        $this->_webroot = !isset($_SERVER['SERVER_PORT']) || $_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443 || !$_SERVER['SERVER_PORT']
                ? 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/'
                : 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].dirname($_SERVER['SCRIPT_NAME']).'/';
        $this->_fileroot = dirname($_SERVER['SCRIPT_FILENAME']).'/';
        $this->_ext = '.js';

        $this->_map = array('jquery'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
                            'jquery.swipe'=>$this->_webroot.'js/full/jquery.swipe.js');

        $this->_extern = array('standard'  => array('jquery'=>$this->_map['jquery']),
                               'full' => array('jquery.swipe'=>$this->_map['jquery.swipe']));

        $this->_req = array('standard'  => array('geolocation'=>array()),
                            'full' => array('transitions'=>array('jquery'),
                                              'touch_transitions'=>array('jquery', 'jquery.swipe')),
                            'iphone' => array('orientation'=>array()),
                            'desktop'=> array('preview'=>array('jquery')));

        $this->_imp = array();
    }

    public static function library_path($item)
    {
        return self::instance()->_map[$item];
    }

    /**
     *
     * @return JS
     */
    public static function &instance()
    {
        if(self::$_instance === null)
            self::$_instance = new JS();
        return self::$_instance;
    }

    public static function include_library($name, $type, $ext = false)
    {
        if(!$ext)
            $ext = self::instance()->_ext;
        else
            $ext = '.'.$ext;
        
        if(file_exists(self::instance()->_fileroot.'js/'.$type.'/'.$name.$ext))
            include(self::instance()->_fileroot.'js/'.$type.'/'.$name.$ext);
        else
            echo '/* failed to include "'.self::instance()->_fileroot.'js/'.$type.'/'.$name.$ext.'"*/';
    }

    public static function import_file($file, $localpath = null)
    {
        if(in_array($file, self::instance()->_imp))
            return;

        if(!($f = @fopen($file, "r")))
        {
            return;
        }
        fclose($f);

        if(User_Agent::has_capability('ajax_manipulate_dom') || User_Agent::is_preview())
            echo 'mwf.util.importJS(\''.$file.'\');';
        elseif($localpath !== null && file_exists($localpath))
            include($localpath);
        else
            return;

        self::instance()->_imp[] = $file;
    }

    public static function import_library($alias, $type)
    {
        $req =& self::instance()->_req;
        if(isset($req[$type]) && isset($req[$type][$alias]) && is_array($req[$type][$alias]))
        {
            $map =& self::instance()->_map;
            $req_libs = self::instance()->_req[$type][$alias];
            foreach($req_libs as $req_lib)
            {
                if(isset($map[$req_lib]))
                    self::import_file($map[$req_lib]);
            }
        }

        $extern =& self::instance()->_extern;
        if(isset($extern[$type][$alias]))
            self::import_file($extern[$type][$alias]);
        else
            self::import_file(self::instance()->_webroot.'js/'.$type.'/'.$alias.self::instance()->_ext,
                              self::instance()->_fileroot.'/js/'.$type.'/'.$alias.self::instance()->_ext);
    }
}

?>