<?php

require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))))
    . '/root/assets/lib/decorator/html/tag.class.php';

/**
 * Test class for Tag_HTML_Decorator.
 * 
 * @author trott
 * @copyright Copyright (c) 2012 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120329
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Tag_HTML_Decorator
 */
class Tag_HTML_DecoratorTest extends PHPUnit_Framework_TestCase {

    protected $object;

    /**
     * @test
     */
    public function setParam_valueIs0_rendersValue() {
        $this->object = HTML_Decorator::tag('input');
        $this->object->set_param('min', 0);
        $this->assertContains('min="0"', $this->object->render());
    }

    /**
     * @test
     */
    public function setParam_valueIsFalse_rendersParamOnly() {
        $this->object = HTML_Decorator::tag('input');
        $this->object->set_param('min', false);
        $this->assertNotContains('min="0"', $this->object->render());
        $this->assertRegExp('/\bmin\b/', $this->object->render());
    }

    /**
     * @test
     */
    public function render_rawHTML_convertedToEntities() {
        $this->object = HTML_Decorator::tag('p', '&<br>');
        $this->assertEquals('<p>&amp;&lt;br&gt;</p>', $this->object->render());
    }

    /**
     * @test
     */
    public function render_rawFlagTruerawHTML_notConvertedToEntities() {
        $this->object = HTML_Decorator::tag('p', '&<br>');
        $this->assertEquals('<p>&<br></p>', $this->object->render(true));
    }

    /**
     * @test
     */
    public function render_rawFlagTrueHTMLDecorator_notConvertedToEntities() {
        $this->object = HTML_Decorator::tag('p')
                ->add_inner_tag('i', "& don't encode me either, Broseph!");
        $this->assertEquals("<p><i>& don't encode me either, Broseph!</i></p>",
                $this->object->render(true));
    }
}

?>
