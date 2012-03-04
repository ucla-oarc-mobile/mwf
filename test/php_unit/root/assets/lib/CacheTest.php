<?php

/**
 * Test class for Cache
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120303
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Config
 * @uses Cache
 */
class CacheTest extends PHPUnit_Framework_TestCase {

    public function run(PHPUnit_Framework_TestResult $result = NULL) {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function setUp() {
        require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/root/assets/lib/cache.class.php';
    }

    /**
     * @runInSeparateProcess
     * @test
     */
    public function getCacheDir_test_varCacheTest() {
        $cache = new Cache('test');
        $cache_dir = $cache->get_cache_dir();
        $this->assertEquals(Config::get('global', 'var_dir') . '/cache/test', $cache_dir);
        rmdir($cache_dir);
    }

}