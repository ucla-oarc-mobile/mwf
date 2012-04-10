<?php


require_once(dirname(dirname(dirname(__FILE__))).'/assets/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/assets/lib/decorator.class.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title('MWF About')->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Entities Demo')
        ->render();

echo Site_Decorator::button()
            ->add_option('Option', '#')
            ->render();

echo Site_Decorator::button()
            ->add_option('Option 1', '#')
            ->add_option('Option 2', '#')
            ->render();

echo Site_Decorator::button()
            ->add_option_light('Option Light', '#')
            ->render();

echo Site_Decorator::button()
            ->add_option_light('Option 1 Light', '#')
            ->add_option_light('Option 2 Light', '#')
            ->render();

echo Site_Decorator::button()
            ->add_option_light('Option 1 Light', '#')
            ->add_option('Option 2', '#')
            ->render();

echo Site_Decorator::content()
            ->add_header('Content')
            ->render();

echo Site_Decorator::content()
            ->add_header_light('Content Light')
            ->render();

echo Site_Decorator::content()
            ->add_header('Content with Content')
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::content()
            ->add_header_light('Content Light with Content')
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::content()
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::menu()
            ->set_title('Menu')
            ->render();

echo Site_Decorator::menu()
            ->set_title_light('Menu Light')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_title('Menu Detailed')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_title_light('Menu Light Detailed')
            ->render();

echo Site_Decorator::menu()
            ->set_title('Menu')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_title_light('Menu Light')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_center_aligned()
            ->set_title('Menu Detailed Center')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_center_aligned()
            ->set_title_light('Menu Light Detailed Center')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_left_aligned()
            ->set_title('Menu Left-Aligned')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_left_aligned()
            ->set_title_light('Menu Light Left')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_title('Menu Detailed')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_title_light('Menu Light Detailed')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->set_center_aligned()
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_left_aligned()
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_detailed()
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::button()
            ->set_not_padded()
            ->add_option('Option', '#')
            ->render();

echo Site_Decorator::button()
            ->set_not_padded()
            ->add_option('Option 1', '#')
            ->add_option('Option 2', '#')
            ->render();

echo Site_Decorator::button()
            ->set_not_padded()
            ->add_option_light('Option Light', '#')
            ->render();

echo Site_Decorator::button()
            ->set_not_padded()
            ->add_option_light('Option 1 Light', '#')
            ->add_option_light('Option 2 Light', '#')
            ->render();

echo Site_Decorator::button()
            ->set_not_padded()
            ->add_option_light('Option 1 Light', '#')
            ->add_option('Option 2', '#')
            ->render();

echo Site_Decorator::content()
            ->set_not_padded()
            ->add_header('Content Padded')
            ->render();

echo Site_Decorator::content()
            ->set_not_padded()
            ->add_header_light('Content Padded Light')
            ->render();

echo Site_Decorator::content()
            ->set_not_padded()
            ->add_header('Content Padded')
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::content()
            ->set_not_padded()
            ->add_header_light('Content Padded Light')
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::content()
            ->set_not_padded()
            ->add_paragraph('Text')
            ->add_section('Text')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_title('Menu Padded')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_title_light('Menu Padded Light')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_title('Menu Padded Detailed')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_title_light('Menu Padded Light Detailed')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_title('Menu Padded')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_title_light('Menu Padded Light')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_center_aligned()
            ->set_title('Menu Padded Detailed Centered')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_center_aligned()
            ->set_title_light('Menu Padded Light Detailed Centered')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_left_aligned()
            ->set_title('Menu Padded Left-Aligned')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_left_aligned()
            ->set_title_light('Menu Padded Light Left')
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_title('Menu Padded Detailed')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_title_light('Menu Padded Light Detailed')
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_center_aligned()
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->set_center_aligned()
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_left_aligned()
            ->add_item('Item 1', '#')
            ->add_item('Item 2', '#')
            ->render();

echo Site_Decorator::menu()
            ->set_not_padded()
            ->set_detailed()
            ->add_item('Item 1<p>Description</p>', '#')
            ->add_item('Item 2<p>Description</p>', '#')
            ->render();

echo Site_Decorator::button()
        ->set_not_padded()
        ->add_option('Back To Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();

?>