<?php

/**
 * Test class for Form_Site_Decorator.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120220
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Form_Site_Decorator
 */
class Form_Site_DecoratorTest extends PHPUnit_Framework_TestCase {

    //@todo: remove this after fixing Config object
    public function setUp() {
        $_SERVER['HTTP_HOST'] = 'http://www.example.com';
    }

    protected $object;

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_padded_padded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/root/assets/lib/decorator/site/form.class.php';

        $this->object = new Form_Site_Decorator;

        $this->object->set_padded();
        $this->assertContains('class="padded"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_title_title() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/root/assets/lib/decorator/site/form.class.php';

        $this->object = new Form_Site_Decorator;

        $this->object->set_title('Totally Legit Title');
        $this->assertContains('<h1>Totally Legit Title</h1>', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_checkbox_checkbox() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/root/assets/lib/decorator/site/form.class.php';
        
        $this->object = new Form_Site_Decorator;
        
        $this->object->add_checkbox('foo','');
        $this->assertContains('<input type="checkbox" id="foo" name="foo"', $this->object->render());
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_checkboxWithLabel_checkboxWithLabel() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))) . '/root/assets/lib/decorator/site/form.class.php';
        
        $this->object = new Form_Site_Decorator;
        
        $this->object->add_checkbox('foo','Foo & Bar!');
        $this->assertContains('<label for="foo">Foo &amp; Bar!</label>', $this->object->render());
    }

}
