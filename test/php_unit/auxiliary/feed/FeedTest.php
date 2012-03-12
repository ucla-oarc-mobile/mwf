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

class FeedTest extends PHPUnit_Framework_TestCase {

    public function run(PHPUnit_Framework_TestResult $result = NULL) {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getName_name_name() {
        require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/auxiliary/feed/feed.class.php';
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('Harold', $feed->get_name());
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getPath_url_url() {
        require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/auxiliary/feed/feed.class.php';
        $feed = new Feed('Harold', 'http://example.com/harold.rss');
        $this->assertEquals('http://example.com/harold.rss', $feed->get_path());
    }

}
