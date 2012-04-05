<?php

/**
 * Test class for Config.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120125
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Config
 */
class ConfigTest extends PHPUnit_Framework_TestCase {

    public function run(PHPUnit_Framework_TestResult $result = NULL) {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }
    
    protected function setUp() {
        $_SERVER['HTTP_HOST'] = 'www.example.com:8080';
        require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/root/assets/lib/config.class.php';
    }

    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function get_siteUrl_notFalse() {
        $this->assertTrue(!!Config::get('global','site_url'));
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function get_siteAssetsUrl_notFalse() {
        $this->assertTrue(!!Config::get('global','site_assets_url'));
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function get_varDir_notFalse() {
        $this->assertTrue(!!Config::get('global','var_dir'));
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function get_gobbledygook_false() {
        $this->assertEquals(false, Config::get('global','gobbledygook'));
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function set_foo_foo() {
        $this->assertEquals(false, Config::get('foo','bar'));
        Config::set('foo','bar','baz');
        $this->assertEquals('baz', Config::get('foo','bar'));
    }
}
