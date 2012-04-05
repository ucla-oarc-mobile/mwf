<?php

/**
 * Test class for Image.
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120328
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Disk_Cache
 * @uses Image
 * @uses Config
 */
class ImageTest extends PHPUnit_Framework_TestCase {

    public function run(PHPUnit_Framework_TestResult $result = NULL) {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {

        require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/root/assets/lib/config.class.php';
        require_once(dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/root/assets/lib/disk_cache.class.php');
        require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/root/assets/lib/image.class.php';
        $cache = new Disk_Cache(Config::get('image', 'cache_name'));
        $cache_files = glob($cache->get_cache_path() . '/*');

        foreach ($cache_files as $cache_file) {
            if (is_file($cache_file))
                unlink($cache_file);
        }
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
    public function factory_unsafePath_isNull() {
        $this->assertNull(Image::factory('../../../../../../../../../../..'));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function factory_remotePath_isRemoteImage() {
        $this->assertEquals('Remote_Image', get_class(Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg')));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function factory_localPath_isLocalImage() {
        $this->assertEquals('Local_Image', get_class(Image::factory('/assets/img/mwf-appicon-precomposed.png')));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getImageAsString_setMaxWidthTo10_widthIs10() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $image->set_max_width(10);
        $png = imagecreatefromstring($image->find_or_create_image_as_string());
        $this->assertEquals(10, imagesx($png));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getImageAsString_setMaxHeightTo12_heightIs12() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $image->set_max_height(12);
        $png = imagecreatefromstring($image->find_or_create_image_as_string());
        $this->assertEquals(12, imagesy($png));
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getImageAsString_LocalPNG_isPNG() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $png = imagecreatefromstring($image->find_or_create_image_as_string());
        ob_start();
        imagepng($png);
        $png_string = ob_get_contents();
        ob_end_flush();
        $finfo = finfo_open();
        $mime_type = finfo_buffer($finfo, $png_string, FILEINFO_MIME_TYPE);
        $this->assertEquals('image/png', $mime_type);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getMimetype_RemoteJPG_isJPEG() {
        $image = Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg');
        $this->assertEquals('image/jpeg', $image->get_mimetype());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getMimetype_LocalPNG_isPNG() {
        $image = Image::factory('/assets/img/mwf-appicon-precomposed.png');
        $this->assertEquals('image/png', $image->get_mimetype());
    }

    /**
     * @test
     * @runInSeparateProcess
     * @expectedException PHPUnit_Framework_Error
     */
    public function factory_RemoteImageTooLarge_triggersError() {
        Config::set('image', 'memory_limit', 1024);
        $image = Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg');
        $image->get_mimetype();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function factory_RemoteImageTooLarge_noImage() {
        Config::set('image', 'memory_limit', 1024);
        $image = Image::factory('http://mwf.ucla.edu/img/ucla-logo.jpg');
        $this->assertEquals('', @$image->get_mimetype());
    }
}