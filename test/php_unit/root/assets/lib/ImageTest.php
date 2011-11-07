<?php

require_once dirname(__FILE__) . '/../../../../../root/assets/lib/image.class.php';

/**
 * Test class for Image.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111106
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Image
 */
class ImageTest extends PHPUnit_Framework_TestCase {

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {

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
    public function factory_unsafePath_isNull() {
        $this->assertNull(Image::factory('../../../../../../../../../../..'));
    }

    /**
     * @test
     */
    public function factory_remotePath_isRemoteImage() {
        $this->assertEquals('Remote_Image',get_class(Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg')));
    }

    /**
     * @test
     */
    public function factory_localPath_isLocalImage() {
        $this->assertEquals('Local_Image',get_class(Image::factory('/assets/img/mwf-appicon-precomposed.png')));
    }
    
    /**
     * @test
     */
    public function image_setMaxHeightWidthTo10_is10By10Image() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $image->set_max_height(10);
        $image->set_max_width(10);
        $png = imagecreatefromstring($image->get_image_as_string());
        $this->assertEquals(10,imagesx($png));
        $this->assertEquals(10,imagesy($png));
    }
    
    /**
     * @test
     */
    public function getMimetype_RemoteJPG_isJPEG() {
        $image = Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg');
        $this->assertEquals('image/jpeg', $image->get_mimetype());
    }
    
    /**
     * @test
     */
    public function getMimetype_LocalPNG_isPNG() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $this->assertEquals('image/png', $image->get_mimetype());
    }

}
?>
