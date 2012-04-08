<?php
/**
 * Test class for Classification.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111116
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Classification
 * @uses Config
 */

class ClassificationTest extends PHPUnit_Framework_TestCase {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $_SERVER['HTTP_HOST']="localhost:80";
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/config.class.php';
        Config::set('global','cookie_prefix','mwftest_');
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
     * @runInSeparateProcess
     */
    public function isFull_isFull_True() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":true,"full":true,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertTrue(Classification::is_full());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isFull_notFull_False() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":true,"full":false,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_full());
    }
 
    /**
     * @test
     * @runInSeparateProcess
     */
    public function isStandard_isStandard_True() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":true,"full":true,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertTrue(Classification::is_standard());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isStandard_notStandard_False() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":false,"full":false,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_standard());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isBasic_isBasic_True() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":true,"full":true,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertTrue(Classification::is_basic());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isMobile_isMobile_True() {
        $_COOKIE['mwftest_classification']='{"mobile":true,"basic":true,"standard":true,"full":true,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertTrue(Classification::is_mobile());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isMobile_notMobile_False() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":false,"full":false,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_standard());
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function isNative_isNative_True() {
        $_COOKIE['mwftest_classification']='{"mobile":true,"basic":true,"standard":true,"full":true,"native":true}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertTrue(Classification::is_native());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function isNative_notNative_False() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":false,"full":false,"native":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_native());
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function isNative_notSet_False() {
        $_COOKIE['mwftest_classification']='{"mobile":false,"basic":true,"standard":false,"full":false}';
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_native());
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function isNative_noCookie_False() {
        $_COOKIE=array();
        require_once dirname(__FILE__) . '/../../../../../root/assets/lib/classification.class.php';
        $this->assertFalse(Classification::is_native());
    }
}

?>
