<?php
require_once(dirname(dirname(dirname(__DIR__))) . '/assets/lib/config.class.php');
require_once(dirname(dirname(dirname(dirname(__DIR__)))) . '/auxiliary/feed/feed.class.php');

$feed = new Feed('Test RSS', Config::get('global','site_assets_url') . '/test/selenium/feed_test.rss');
$feed_items = $feed->get_items();
?><!DOCTYPE html>
<html>
    <head><title>Feed API Basic Test</title></head>
    <body>
        <div class="menu-full menu-detailed menu-padded">
            <h1 class="menu-first">RSS Feed Title Menu</h1>
            <ol> 

                <?php
                foreach ($feed_items as $feed_item) {
                    echo "<li>";
                    echo "<a href='" . $feed_item->get_page() . "'>";
                    echo $feed_item->get_title() . "<br>";
                    echo "<span class='smallprint'>" . $feed_item->get_short_description() . "</span>";
                    echo "</a>";
                    echo "</li>";
                }
                ?>

            </ol>
        </div>
    </body>
</html>