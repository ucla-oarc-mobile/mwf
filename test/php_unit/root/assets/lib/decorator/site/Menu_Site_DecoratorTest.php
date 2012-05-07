<?php

/**
 * Test class for Menu_Site_Decorator.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120229
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Menu_Site_Decorator
 */
class Menu_Site_DecoratorTest extends PHPUnit_Framework_TestCase {

    //@todo: remove this after fixing Config object
    public function setUp() {
        $_SERVER['HTTP_HOST'] = 'http://www.example.com';
    }

    protected $object;

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_ampersandInUrlParam_ampersandEntityUsed() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/menu.class.php';

        $this->object = new Menu_Site_Decorator;

        $this->object->add_item('test', 'http://www.example.com/test?foo&bar');
        $this->assertContains('http://www.example.com/test?foo&amp;bar', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_quotesInUrlParam_quotesReplacedWithEntities() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/menu.class.php';

        $this->object = new Menu_Site_Decorator;

        $this->object->add_item('test', 'http://www.example.com/test?"foo"\'bar\'');
        $this->assertContains('http://www.example.com/test?&quot;foo&quot;\'bar\'', $this->object->render());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function setHomeScreen_noParam_isHomeScreen() {
        require dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/menu.class.php';

        $this->object = new Menu_Site_Decorator;

        $this->object->set_home_screen();
        $result = $this->object->render();
        $this->assertRegExp('/\bclass\=\"[^"]*\bfront\b/', $result);
        $this->assertRegExp('/\bid=\"main_menu\"[\s>]/', $result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function render_homeScreenAndFull_jsObject() {
        require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/config.class.php';
        Config::set('frontpage', 'customizable_home_screen', true);
        Config::set('global', 'cookie_prefix', 'mwftest_');
        $_COOKIE['mwftest_classification'] = '{"mobile":false,"basic":true,"standard":true,"full":true,"native":false}';
        require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/classification.class.php';
        require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))))) . '/root/assets/lib/decorator/site/menu.class.php';

        $this->object = new Menu_Site_Decorator;
        $this->object->set_home_screen();
        $this->object->add_item('Foo', 'http://example.com/', array(), array(), 'foo_index');
        $this->object->add_item('Bar', 'http://musicroutes.com/', array(), array(), 'bar_index');
        $this->assertRegExp('/\bmwf\.full\.customizableMenu\(\"home_screen_layout"\)\.render\(/', $this->object->render());
    }

}
