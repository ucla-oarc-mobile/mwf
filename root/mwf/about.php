<?php

require_once(dirname(dirname(__FILE__)).'/assets/config.php');
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

