<?php

require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . 
        '/root/assets/lib/decorator/site/head.class.php';

/**
 * Test class for Head_Site_Decorator.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120312
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Head_Site_Decorator
 */
class Head_Site_DecoratorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Head_Site_Decorator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Head_Site_Decorator;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @test
     */
    public function render_multipleJSLibs_ampersandEntityUsed() {
        $this->object->add_js_handler_library('standard_libs', 'geolocation');
        $this->object->add_js_handler_library('standard', '/my/awesome/library.js');
        $this->assertContains('&amp;', $this->object->render());
    }
    
    /**
     * @test
     */
    public function render_multipleJSLibs_noDoubleEncoding() {
               $this->object->add_js_handler_library('standard_libs', 'geolocation');
        $this->object->add_js_handler_library('standard', '/my/awesome/library.js');
        $this->assertNotContains('&amp;amp;', $this->object->render());
    }
}

?>
