<?php

/**
 * Test class for Feed
 * 
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120301
 *
 * @uses PHPUnit_Framework_TestCase
 * @uses Feed
 */
require_once dirname(__FILE__) . '/../../../../auxiliary/feed/feed.class.php';

class FeedTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getName_name_name() {
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('Harold', $feed->get_name());
    }

    /**
     * @test
     */
    public function getPath_url_url() {
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('http://example.com/harold.rss', $feed->get_path());
    }

    /**
     * @test
     */
    public function testGet_items() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @test
     */
    public function testFetch_items() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers {className}::{origMethodName}
     * @todo Implement testGet_item().
     */
    public function testGet_item() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers {className}::{origMethodName}
     * @todo Implement testBuild_item_from_request().
     */
    public function testBuild_item_from_request() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers {className}::{origMethodName}
     * @todo Implement testGet_page().
     */
    public function testGet_page() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers {className}::{origMethodName}
     * @todo Implement testVerify_page().
     */
    public function testVerify_page() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers {className}::{origMethodName}
     * @todo Implement testBuild_page_from_request().
     */
    public function testBuild_page_from_request() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}

?>
