<?php

require_once dirname(__FILE__) . '/../../../../../root/assets/lib/config.class.php';
Config::set('global','cookie_prefix','mwftest_');
require_once dirname(__FILE__) . '/../../../../../root/assets/lib/cookie.class.php';


/**
 * Test class for Cookie.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111111
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Cookie
 * @uses Config
 */
class CookieTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        $_COOKIE=array();
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
    public function get_doesNotExist_null() {
        $this->assertNull(Cookie::get('foo'));
    }
    
    /**
     * @test
     */
    public function get_keyExists_value() {
        $_COOKIE['mwftest_foo'] = 'some arbitrary value';
        $this->assertEquals('some arbitrary value',Cookie::get('foo'));
    }
    
    /**
     * @test
     * @runAsSeparateProcess
     */
    public function getAllNames_cookiesExist_names() {
        $_COOKIE['mwftest_foo'] = 'some arbitrary value';
        $_COOKIE['no_prefix'] = 'this cookie should not come back';
        $_COOKIE['mwftest_bar'] = 'another value';
        $cookie_names = Cookie::get_all_names();
        $this->assertContains('foo',$cookie_names);
        $this->assertContains('bar',$cookie_names);
    }

}

?>
