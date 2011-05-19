<?php

/**
 * The front page when the user arrives at the mobile site on a mobile device.
 * If the user is on a non-mobile device and {'global':'site_nonmobile_url'} is
 * set in config/global.php, then they will be redirected.
 *
 * This page throws a fatal error if either {'global':'site_url'} or
 * {'global':'site_assets_url'} are not set in /config/global.php.
 *
 * @package mwf
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Content_Full_Site_Decorator
 * @uses Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 */

require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');

echo HTML_Decorator::html_start();

echo Site_Decorator::head()->set_title('About');

echo HTML_Decorator::body_start();

echo Site_Decorator::header()
        ->set_title('About');

echo Site_Decorator::content_full()
            ->set_padded()
            ->add_header('The Framework')
            ->add_paragraph('The UCLA Mobile Web Framework is a cross-platform web framework that focuses on mobile web standards, semantic markup, device agnosticism and graceful degradation, providing a robust presentation layer that allows applications to define a single set of markup optimized for iPhone and Android devices that degrades gracefully to any XHTML MP 2.0 compliant device including Blackberry, Windows Mobile and even T9 phones.');

echo Site_Decorator::content_full()
            ->set_padded()
            ->add_header('The Initiative')
            ->add_paragraph('The framework project began in early 2010 as a joint venture between the UCLA Office of Information Technology and UCLA Communications as a means to reach the vast majority of campus mobile users via a single platform in a reasonable and cost-effective manner. The framework first went into production at the beginning of Fall 2010 with the launch of UCLA Mobile.')
            ->add_paragraph('More than ten campus units are now participating at UCLA, four other campuses in the UC system have launched production mobile applications using the framework, and several other campuses both in the UC and beyond are looking at it as an option to deploy a mobile web presence.');

echo HTML_Decorator::body_end();

echo HTML_Decorator::html_end();

?>

