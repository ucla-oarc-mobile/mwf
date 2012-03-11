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
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';

        $this->object = new Form_Site_Decorator;

        $this->object->set_padded();
        $this->assertContains('class="padded"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_title_title() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';

        $this->object = new Form_Site_Decorator;

        $this->object->set_title('Totally Legit Title');
        $this->assertContains('<h1>Totally Legit Title</h1>', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addButton_withParams_paramsAreIncluded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo', array('bar' => 'baz'));
        $this->assertContains('bar="baz"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addButton_noClass_noClassRendered() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo', array('bar' => 'baz'));
        $this->assertNotContains('class', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addButton_class_classRendered() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo', array('bar' => 'baz', 'class' => 'classy'));
        $this->assertContains('class="classy"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addSection_beforeFormElements_renderedBeforeFormElements() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_section('foo');
        $this->object->add_button('bar');
        $this->assertRegExp('/<div\b.+bar/', $this->object->render());
    }

}
