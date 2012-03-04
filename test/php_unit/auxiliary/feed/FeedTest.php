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

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class FeedTest extends PHPUnit_Framework_TestCase {

    public function run(PHPUnit_Framework_TestResult $result = NULL) {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }
    
    public function setUp() {
        require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/auxiliary/feed/feed.class.php';
    }
    
    /**
     * @test
     * @runInSeparateProcess
     */
    public function getName_name_name() {
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('Harold', $feed->get_name());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getPath_url_url() {
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('http://example.com/harold.rss', $feed->get_path());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getItems_missingRSS_false() {
        $feed = new Feed('Harold', 'missing.rss');
        $this->assertEquals($feed->get_items(), false);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getItems_testRSS_arrayOfFeedItems() {
        $feed = new Feed('Test RSS', __DIR__ . '/test.rss');
        $items = $feed->get_items();
        $this->assertEquals('Feed_Item', get_class($items[0]));
        $this->assertEquals('Feed_Item', get_class($items[1]));
        $this->assertEquals('Feed_Item', get_class($items[2]));
        $this->assertEquals(count($items), 3);
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
