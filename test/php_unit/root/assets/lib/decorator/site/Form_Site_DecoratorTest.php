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
    public function addButton_noClass_neutral() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo', array('bar' => 'baz'));
        $this->assertContains('class="neutral"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addButton_class_classRendered() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo', array('bar' => 'baz', 'class' => 'classy'));
        $this->assertContains('class="neutral classy"', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addButton_ampersand_escapedOnce() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_button('foo&bar');
        $this->assertContains('foo&amp;bar', $this->object->render());
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

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addText_ampersandInId_idIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_text('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addText_ampersandInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_text('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTime_ampersandInId_idIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_time('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTime_ampersandInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_time('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addPrimaryLinkButton_bracketsInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_primary_link_button('<encode me>');
        $result = $this->object->render();
        $this->assertContains('&lt;encode me&gt;', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addCheckboxes_ampersandInId_idIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_checkboxes('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addCheckboxes_ampersandInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_checkboxes('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addCheckboxes_bracketsInOptionIdLabelAndValue_bracketsAreEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_checkboxes('BartlesAndJames', 'LogginsAndMessina', array(array('id' => 'a<wiggle>', 'label' => 'and><or', 'value' => 'a<waggle>')));
        $result = $this->object->render();
        $this->assertContains('&lt;wiggle&gt;', $result);
        $this->assertContains('and&gt;&lt;or', $result);
        $this->assertContains('&lt;waggle&gt;', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addSelect_ampersandInId_idIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_select('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addSelect_ampersandInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_select('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addSelect_bracketsInOptionLabelAndValue_bracketsAreEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_checkboxes('BartlesAndJames', 'LogginsAndMessina', array(array('label' => 'and><or', 'value' => 'a<waggle>')));
        $result = $this->object->render();
        $this->assertContains('and&gt;&lt;or', $result);
        $this->assertContains('&lt;waggle&gt;', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTextarea_ampersandInId_idIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_textarea('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTextarea_ampersandInLabel_labelIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_textarea('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addSelect_quotationMarksInTooltip_tooltipIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_select(
                'BartlesAndJames', 'Loggins&Messina', array(array('id' => 'id', 'label' => 'label', 'value' => 'value')), array('tooltip' => '"Palace Family Steak House"'));
        $result = $this->object->render();
        $this->assertContains('<span class="tiptext">&quot;Palace Family Steak House&quot;</span>', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTextarea_ampersandInPlaceholder_placeholderIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_textarea('BartlesAndJames', 'Loggins&Messina', array('placeholder' => 'Hall & Oates'));
        $result = $this->object->render();
        $this->assertContains('<span class="placeholder">Hall &amp; Oates</span>', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addTextarea_ampersandInInvalid_invalidIsEncoded() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $this->object->add_textarea('BartlesAndJames', 'Loggins&Messina', array('invalid' => 'Simon & Garfunkel'));
        $result = $this->object->render();
        $this->assertContains('<p class="invalid">Simon &amp; Garfunkel</p>', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function addCheckboxes_required_classIsRequired() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';
        $this->object = new Form_Site_Decorator;
        $result = $this->object
                ->add_checkboxes('checkbox-group', 'Checkbox', array(
            array('id' => 'checkbox-1', 'label' => 'One', 'value' => 1),
            array('id' => 'checkbox-2', 'label' => 'Two', 'value' => 2),
            array('id' => 'checkbox-3', 'label' => 'Three', 'value' => 3)
                ), array('required' => true)
        )->render();
        $this->assertContains('class="required"',$result);
    }

}
