<?php

require_once dirname(__FILE__) . '/../../../../../../../root/assets/lib/decorator/site/menu.class.php';

/**
 * Test class for Head_Site_Decorator.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120206
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Menu_Site_Decorator
 */
class Menu_Site_DecoratorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Menu_Site_Decorator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Menu_Site_Decorator;
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
    public function render_ampersandInUrlParam_ampersandEntityUsed() {
        $this->object->add_item('test', 'http://www.example.com/test?foo&bar');
        $this->assertContains('http://www.example.com/test?foo&amp;bar', $this->object->render());
    }
    
    /**
     * @test
     */
    public function render_quotesInUrlParam_quotesNotReplacedWithEntities() {
        $this->object->add_item('test', 'http://www.example.com/test?"foo"\'bar\'');
        $this->assertContains('http://www.example.com/test?"foo"\'bar\'', $this->object->render());
    }
}
?>
