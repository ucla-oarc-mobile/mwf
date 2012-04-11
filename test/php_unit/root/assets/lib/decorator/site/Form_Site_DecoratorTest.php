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
require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/form.class.php';

class Form_Site_DecoratorTest extends PHPUnit_Framework_TestCase {

    //@todo: remove this after fixing Config object
    public function setUp() {
        $_SERVER['HTTP_HOST'] = 'http://www.example.com';
        $this->object = new Form_Site_Decorator();
    }

    protected $object;

    /**
     * @test
     */
    public function render_padded_padded() {
        $this->object->set_padded();
        $this->assertNotContains('class="not-padded"', $this->object->render());
    }
    
    /**
     * @test
     */
    public function render_notPadded_notPadded() {
        $this->object->set_not_padded();
        $this->assertContains('class="not-padded"', $this->object->render());
    }

    /**
     * @test
     */
    public function render_title_title() {
        $this->object->set_title('Totally Legit Title');
        $this->assertContains('<h2>Totally Legit Title</h2>', $this->object->render());
    }

    /**
     * @test
     */
    public function addInput_buttonType_classIsNeutral() {
        $this->object->add_input(Site_Decorator::input()->type_button());
        $this->assertContains('class="neutral"', $this->object->render());
    }

    /**
     * @test
     */
    public function addInput_buttonWithAmpersandInValue_escapedOnce() {
        $this->object->add_input(Site_Decorator::input()->type_button()->set_value('foo&bar'));
        $this->assertContains('foo&amp;bar', $this->object->render());
    }

    /**
     * @test
     */
    public function addInnerTag_beforeButton_renderedBeforeButton() {
        $this->object->add_inner_tag('div', 'foo');
        $this->object->add_input(Site_Decorator::input()->type_button()->set_value('bar'));
        $this->assertRegExp('/<div\b.+bar/', $this->object->render());
    }

    /**
     * @test
     */
    public function addInnerTag_afterParagraph_renderedAfterParagrph() {
        $this->object->add_paragraph('Lorem ipsum grumblecakes');
        $this->object->add_inner_tag('div', 'totally a div over here');
        $this->assertRegExp('/<p\b.+Lorem ipsum grumblecakes\b.*<\/p>.*<div\b.+totally a div over here\b.*<\/div>/', $this->object->render());
    }

    /**
     * @test
     */
    public function addInputText_ampersandInId_idIsEncoded() {
        $this->object->add_input(Site_Decorator::input('Bartles&James', 'LogginsAndMessina'));
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     */
    public function addInputText_ampersandInLabel_labelIsEncoded() {
        $this->object->add_input(Site_Decorator::input('BartlesAndJames', 'Loggins&Messina'));
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     */
    public function addTime_ampersandInId_idIsEncoded() {
        $this->object->add_input(
                Site_Decorator::input('Bartles&James', 'LogginsAndMessina')
                        ->type_time()
        );
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     */
    public function addTime_ampersandInLabel_labelIsEncoded() {
        $this->object->add_input(
                Site_Decorator::input('BartlesAndJames', 'Loggins&Messina')
                        ->type_time()
        );
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     */
    public function addCheckboxGroup_ampersandInId_idIsEncoded() {
        $this->object->add_checkbox_group('Bartles&James', 'LogginsAndMessina');
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     */
    public function addCheckboxGroup_ampersandInLabel_labelIsEncoded() {
        $this->object->add_checkbox_group('BartlesAndJames', 'Loggins&Messina');
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     */
    public function addCheckboxGroup_bracketsInOptionIdLabelAndValue_bracketsAreEncoded() {
        $this->object->add_checkbox_group('BartlesAndJames', 'LogginsAndMessina', array(Site_Decorator::input('a<wiggle>', 'and><or')->set_value('a<waggle>')));
        $result = $this->object->render();
        $this->assertContains('&lt;wiggle&gt;', $result);
        $this->assertContains('and&gt;&lt;or', $result);
        $this->assertContains('&lt;waggle&gt;', $result);
    }

    /**
     * @test
     */
    public function addCheckboxGroup_optionRequired_checkboxRequiredRendered() {
        $options = array(
            Site_Decorator::input(false, 'Checking this box is totally required!')->required()
        );
        $this->object->add_checkbox_group(false, false, $options);
        $result = $this->object->render();
        $this->assertRegexp('/<input[^>]*\brequired\b[^>]*\btype="checkbox".*>|<input[^>]*\btype="checkbox"[^>]*\brequired\b.*>/', $result);
    }

    /**
     * @test
     */
    public function addRadioGroup_optionRequired_radioRequiredRendered() {
        $options = array(
            Site_Decorator::input(false, 'Selecting a radio button is totally required!')->required()
        );
        $this->object->add_radio_group('radio-group-id', false, $options);
        $result = $this->object->render();
        $this->assertRegexp('/<input[^>]*\brequired\b[^>]*\btype="radio".*>|<input[^>]*\btype="radio"[^>]*\brequired\b.*>/', $result);
    }

    /**
     * @test
     */
    public function addRadioGroup_multipleOptions_namesIdentical() {
        $options = array(
            Site_Decorator::input('radio-button-1', 'Radio Button 1'),
            Site_Decorator::input('radio-button-2', 'Radio Button 2')
        );
        $this->object->add_radio_group("var_name", false, $options);
        $result = $this->object->render();
        $this->assertRegexp('/<input\b[^>]*\bname="var_name"[^>]*\btype="radio".*>|<input[^>]*\btype="radio"[^>]*\bname="var_name".*>/', $result);
    }

    /**
     * @test
     */
    public function addInput_selectWithAmpersandInId_idIsEncoded() {
        $select = Site_Decorator::input('Bartles&James', 'LogginsAndMessina')
                ->type_select();
        $this->object->add_input($select);
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     */
    public function addInput_SelectWithAmpersandInLabel_labelIsEncoded() {
        $select = Site_Decorator::input('BartlesAndJames', 'Loggins&Messina')
                ->type_select();
        $this->object->add_input($select);
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }

    /**
     * @test
     */
    public function addInput_bracketsInOptionLabelAndValue_bracketsAreEncoded() {
        $select = Site_Decorator::input('BartlesAndJames', 'LogginsAndMessina')
                ->add_option('a<waggle>', 'and><or');
        $this->object->add_input($select);
        $result = $this->object->render();
        $this->assertContains('and&gt;&lt;or', $result);
        $this->assertContains('&lt;waggle&gt;', $result);
    }

    /**
     * @test
     */
    public function addInput_textareaWithAmpersandInId_idIsEncoded() {
        $textarea = Site_Decorator::input('Bartles&James', 'LogginsAndMessina')
                ->type_textarea();
        $this->object->add_input($textarea);
        $result = $this->object->render();
        $this->assertContains('Bartles&amp;James', $result);
    }

    /**
     * @test
     */
    public function addInput_textareaWithAmpersandInLabel_labelIsEncoded() {
        $textarea = Site_Decorator::input('BartlesAndJames', 'Loggins&Messina')
                ->type_textarea();
        $this->object->add_input($textarea);
        $result = $this->object->render();
        $this->assertContains('Loggins&amp;Messina', $result);
    }
    
    /**
     * @test
     */
    public function addInput_colorRequired_requiredIgnored() {
        $color = Site_Decorator::input('foo', 'bar')->type_color()->required();
        $this->object->add_input($color);
        $this->assertNotContains('required', $this->object->render());
    }

    /**
     * @test
     */
    public function addInput_textareaWithAmpersandInPlaceholder_placeholderIsEncoded() {
        $textarea = Site_Decorator::input('BartlesAndJames', 'Loggins&Messina')
                ->type_textarea()
                ->set_placeholder('Hall & Oates');
        $this->object->add_input($textarea);
        $result = $this->object->render();
        $this->assertContains('placeholder="Hall &amp; Oates"', $result);
    }

    /**
     * @test
     */
    public function addInput_textareaWithAmpersandInInvalid_invalidIsEncoded() {
        $textarea = Site_Decorator::input('BartlesAndJames', 'Loggins&Messina')
                ->type_textarea()
                ->invalid('Simon & Garfunkel');
        $this->object->add_input($textarea);
        $result = $this->object->render();
        $this->assertContains('<span class="invalid">Simon &amp; Garfunkel</span>', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonPrimary_text_classPrimary() {
        $result = $this->object->add_link_button_primary('primary')->render();
        $this->assertRegExp('/class="[^"]*primary[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonPrimary_text_classButton() {
        $result = $this->object->add_link_button_primary('primary')->render();
        $this->assertRegExp('/class="[^"]*button[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function addButtonPrimaryLink_bracketsInText_textIsEncoded() {
        $this->object->add_link_button_primary('<encode me>');
        $result = $this->object->render();
        $this->assertContains('&lt;encode me&gt;', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonSecondary_text_classSecondary() {
        $result = $this->object->add_link_button_secondary('not a primary button')->render();
        $this->assertRegExp('/class="[^"]*secondary[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonSecondary_text_classButton() {
        $result = $this->object->add_link_button_secondary('not primary')->render();
        $this->assertRegExp('/class="[^"]*button[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonNeutral_text_classNeutral() {
        $result = $this->object->add_link_button_neutral('i can do it all on my own')->render();
        $this->assertRegExp('/class="[^"]*neutral[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function addLinkButtonNeutral_text_classButton() {
        $result = $this->object->add_link_button_neutral('switzerland')->render();
        $this->assertRegExp('/class="[^"]*button[^"]*"/', $result);
    }

    /**
     * @test
     */
    public function invalid_void_classInvalidOnInput() {
        $this->object->add_input(Site_Decorator::input('Bartles&James', 'LogginsAndMessina')->invalid());
        $this->assertContains('class="invalid"', $this->object->render());
    }

    /**
     * @test
     */
    public function invalid_message_messageRendered() {
        $this->object->add_input(Site_Decorator::input('Bartles&James', 'LogginsAndMessina')->invalid('Input invalid!'));
        $rendered = $this->object->render();
        $this->assertRegExp('/class="invalid">.*<span class="invalid"/', $rendered);
        $this->assertContains('<span class="invalid">Input invalid!</span>', $rendered);
    }

}