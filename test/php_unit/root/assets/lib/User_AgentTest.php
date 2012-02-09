<?php

/**
 * Test class for User_Agent.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111116
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Config
 */
class User_AgentTest extends PHPUnit_Framework_TestCase {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $_SERVER['HTTP_HOST'] = "localhost:80";
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/config.class.php';
        Config::set('global', 'cookie_prefix', 'mwftest_');
        $_COOKIE = array();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getUserAgent_testUserAgent_testUserAgent() {
        $_COOKIE['mwftest_user_agent'] = '{"s":"My-Favorite-User-Agent-String/1.0","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("My-Favorite-User-Agent-String/1.0", User_Agent::get_user_agent());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getOS_testOS_testOS() {
        $_COOKIE['mwftest_user_agent'] = '{"s":"My-Favorite-User-Agent-String/1.0","os":"test os","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("test os", User_Agent::get_os());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getOSVersion_none_false() {
        $_COOKIE['mwftest_user_agent'] = '{"s":"Mozilla/5.0 (Macintosh\x3B Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML\x2C like Gecko) Chrome/15.0.874.120 Safari/535.2","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals(false, User_Agent::get_os_version());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getOSVersion_10_10() {
        $_COOKIE['mwftest_user_agent'] = '{"osv":"10","s":"Mozilla/5.0 (Macintosh\x3B Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML\x2C like Gecko) Chrome/15.0.874.120 Safari/535.2","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("10", User_Agent::get_os_version());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getBrowser_safari_safari() {
        $_COOKIE['mwftest_user_agent'] = '{"osv":"10","s":"Mozilla/5.0 (Macintosh\x3B Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML\x2C like Gecko) Chrome/15.0.874.120 Safari/535.2","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("safari", User_Agent::get_browser());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getBrowserEngine_webkit_webkit() {
        $_COOKIE['mwftest_user_agent'] = '{"osv":"10","s":"Mozilla/5.0 (Macintosh\x3B Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML\x2C like Gecko) Chrome/15.0.874.120 Safari/535.2","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("webkit", User_Agent::get_browser_engine());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getBrowserEngineVersion_535dot2_535dot2() {
        $_COOKIE['mwftest_user_agent'] = '{"osv":"10","s":"Mozilla/5.0 (Macintosh\x3B Intel Mac OS X 10_6_8) AppleWebKit/535.2 (KHTML\x2C like Gecko) Chrome/15.0.874.120 Safari/535.2","os":"mac os x","b":"safari","be":"webkit","bev":"535.2"}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/user_agent.class.php';
        $this->assertEquals("535.2", User_Agent::get_browser_engine_version());
    }
}

?>
