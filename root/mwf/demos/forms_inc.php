<?php
/**
 *
 * @package mwf.demos
 *
 * @author ilin
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120410
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses Form_Site_Decorator
 * @uses Input_Site_Decorator
 */

require_once(dirname(dirname(__DIR__)) . '/assets/lib/decorator.class.php');

$submit = Site_Decorator::input()
        ->type_submit()
        ->set_value('Test Me');
?>

<!-- short form -->

<?php
$text_input = Site_Decorator::input('text-1', 'Label')->set_size(16);

echo Site_Decorator::form()
        ->set_short()
        ->set_title('Short Form')
        ->add_input($text_input)
        ->add_input(Site_Decorator::input()->type_submit())
        ->render();
?>

<!-- option form -->

<?php
echo Site_Decorator::form()
        ->set_title('Option Form')
        ->add_checkbox_group('checkbox-group-1', 'Label for Checkbox Group', array(
            Site_Decorator::input('checkbox-1', 'One')->set_param('value', 1),
            Site_Decorator::input('checkbox-2', 'Two')->set_param('value', 2),
            Site_Decorator::input('checkbox-3', 'Three')->set_param('value', 3)
                )
        )
        ->add_radio_group('radio-group-1', 'Label for Radio Group', array(
            Site_Decorator::input('radio-1', 'One')->set_param('value', 1),
            Site_Decorator::input('radio-2', 'Two')->set_param('value', 2),
            Site_Decorator::input('radio-3', 'Three')->set_param('value', 3)
                )
        )
        ->render();
?>

<!-- full button form -->

<?php
echo Site_Decorator::form()
        ->set_title('Full Button Form')
        ->add_input(Site_Decorator::input()->type_button()->primary()->set_param('value', 'Primary Button'))
        ->add_input(Site_Decorator::input()->type_button()->secondary()->set_param('value', 'Secondary Button'))
        ->add_input(Site_Decorator::input()->type_button()->set_param('value', 'Neutral Button'))
        ->add_link_button_primary('Primary Link', '#')
        ->add_link_button_secondary('Secondary Link', '#')
        ->add_link_button_neutral('Neutral Link', '#')
        ->render();
?>

<!-- Textarea Form -->

<?php
echo Site_Decorator::form()
        ->set_title('Textarea Form')
        ->add_input(Site_Decorator::input('textarea-1', 'Label for Textarea 1')->type_textarea())
        ->render();
?>

<!-- Select Form -->

<?php
$select_input = Site_Decorator::input('select-group-1', 'Label for Select')
        ->add_option('', 'Select...')
        ->add_option(1, 'One')
        ->add_option(2, 'Two')
        ->add_option(3, 'Three');

$select_input_multiple = Site_Decorator::input('select-group-2', 'Label for Multiple Select')
        ->multiple()
        ->add_option('hustle', 'The Hustle')
        ->add_option('mashedp', 'Mashed Potato')
        ->add_option('twist', 'The Twist')
        ->add_option('bunnyhop', 'Bunny Hop');

$select_input_sized = Site_Decorator::input('select-group-3', 'Label for Sized Select')
        ->set_size(5)
        ->add_option(1, 'Planet of the Apes')
        ->add_option(2, 'Beneath the Planet of the Apes')
        ->add_option(3, 'Escape from the Planet of the Apes')
        ->add_option(4, 'Conquest of the Planet of the Apes')
        ->add_option(5, 'Battle for the Planet of the Apes')
        ->add_option(6, 'Planet of the Apes (Tim Burton Reboot)')
        ->add_option(7, 'Rise of the Planet of the Apes');

echo Site_Decorator::form()
        ->set_title('Select Form')
        ->add_input($select_input)
        ->add_input($select_input_multiple)
        ->add_input($select_input_sized)
        ->render();
?>

<!-- Form with required elements -->

<?php
$text_input = Site_Decorator::input('text-10', 'Name')
        ->required();
$select_input = Site_Decorator::input('select-group-10', 'Select')
        ->add_option(false, 'Select one...')
        ->add_option(1, 'The Beatles')
        ->add_option(2, 'The Rolling Stones')
        ->add_option(3, 'The Who')
        ->add_option(4, 'The Kinks')
        ->required();
$select_multiple_input = Site_Decorator::input('select-group-15', 'Select One Or More')
        ->type_select()
        ->multiple()
        ->add_option(1, 'Belle & Sebastian')
        ->add_option(2, 'Tilly & the Wall')
        ->add_option(3, 'Angus & Julia Stone')
        ->add_option(4, 'Planets & Animals')
        ->required();
$textarea_input = Site_Decorator::input('textarea-10', 'Textarea')
        ->type_textarea()
        ->required();
$checkbox_input = Site_Decorator::input('checkbox-10', 'Checkbox')
        ->type_checkbox()
        ->required();

echo Site_Decorator::form()
        ->set_title('Required Form')
        ->add_input($text_input)
        ->add_input($select_input)
        ->add_input($select_multiple_input)
        ->add_input($textarea_input)
        ->add_input($checkbox_input)
        ->add_input($submit)
        ->render();
?>

<!-- Form with invalid submissions marked -->

<?php
$text_input = Site_Decorator::input('text-20', 'Name')
        ->invalid('Text input error message goes here');
$checkbox_input = Site_Decorator::input('checkbox-20', 'Checkbox')
        ->type_checkbox()
        ->invalid('Checkbox error message goes here');
$select_input = Site_Decorator::input('select-group-20', 'Select')
        ->add_option(1, 'One')
        ->add_option(2, 'Two')
        ->add_option(3, 'Three')
        ->invalid('Select error message goes here');
$textarea_input = Site_Decorator::input('textarea-20', 'Textarea')
        ->type_textarea()
        ->invalid('Textarea error message goes here');
echo Site_Decorator::form()
        ->set_title('Invalid Form')
        ->add_input($text_input)
        ->add_input($checkbox_input)
        ->add_input($select_input)
        ->add_input($textarea_input)
        ->render();
?>

<!-- Form with disabled elements -->

<?php
$text_input = Site_Decorator::input('text-30', 'Name')
        ->disable();
$checkbox_input = Site_Decorator::input('checkbox-30', 'Checkbox')
        ->type_checkbox()
        ->disable();
$select_input = Site_Decorator::input('select-group-30', 'Select')
        ->add_option(1, 'One')
        ->add_option(2, 'Two')
        ->add_option(3, 'Three')
        ->disable();
$textarea_input = Site_Decorator::input('textarea-30', 'Textarea')
        ->type_textarea()
        ->disable();
echo Site_Decorator::form()
        ->set_title('Disabled Form')
        ->add_input($text_input)
        ->add_input($checkbox_input)
        ->add_input($select_input)
        ->add_input($textarea_input)
        ->render();
?>

<!-- Form without padding -->

<?php
echo Site_Decorator::form()
        ->set_not_padded()
        ->set_title('Form That Is Not Padded')
        ->add_input(Site_Decorator::input('text-100', 'Label'))
        ->add_input(Site_Decorator::input()->type_submit()->set_param('value', 'Search'))
        ->render();
?>

<!-- Form with text content -->

<?php
echo Site_Decorator::form()
        ->set_title('Text content')
        ->add_subtitle('Subtitle')
        ->add_paragraph('Lorem ipsum doodah doodah.')
        ->add_input(Site_Decorator::input()->type_submit()->set_param('value', 'Submit'))
        ->render();
?>

<!-- html5 input types and attributes -->

<?php
$text_input_placeholder = Site_Decorator::input('input-10', 'Placeholder')
        ->required()
        ->set_placeholder('Please enter text here');
$text_input_required = Site_Decorator::input('input-11', 'Required')
        ->required();
$checkbox_input_required = Site_Decorator::input('checkbox-15', 'Checkbox')
        ->type_checkbox()
        ->required();
$color_input = Site_Decorator::input('color-10', 'Color')
        ->type_color()
        ->required();
$search_input = Site_Decorator::input('search-10', 'Search')
        ->type_search()
        ->required();
$telephone_input = Site_Decorator::input('tel-10', 'Telephone')
        ->type_telephone()
        ->required();
$url_input = Site_Decorator::input('url-10', 'URL')
        ->type_url()
        ->required();
$email_input = Site_Decorator::input('email-10', 'Email')
        ->type_email()
        ->required();
$now = new DateTime('now');
$five_years_ago = new DateTime("5 years ago");
$five_years_from_now = new DateTime("5 years");
$date_input = Site_Decorator::input('date-10', 'Date')
        ->type_date()
        ->required()
        ->set_param('min', $five_years_ago->format('Y-m-d'))
        ->set_param('max', $five_years_from_now->format('Y-m-d'))
        ->set_value($now->format('Y-m-d'));
$month_input = Site_Decorator::input('month-10', 'Month')
        ->type_month()
        ->required()
        ->set_param('min', $five_years_ago->format('Y-m'))
        ->set_param('max', $five_years_from_now->format('Y-m'))
        ->set_value($now->format('Y-m'));
$week_input = Site_Decorator::input('week-10', 'Week')
        ->type_week()
        ->required()
        ->set_param('min', $five_years_ago->format('Y-\WW'))
        ->set_param('max', $five_years_from_now->format('Y-\WW'))
        ->set_value($now->format('Y-\WW'));

$datetime_local_input = Site_Decorator::input('datetime-10', 'Datetime Local')
        ->type_datetime_local()
        ->required()
        ->set_param('min', $five_years_ago->format('Y-m-d\TH:i'))
        ->set_param('max', $five_years_from_now->format('Y-m-d\TH:i'))
        ->set_value($now->format('Y-m-d\TH:i'));

$time_input = Site_Decorator::input('time-10', 'Time')
        ->type_time()
        ->required()
        ->set_param('min', $five_years_ago->format('H:i'))
        ->set_param('max', $five_years_from_now->format('H:i'))
        ->set_value($now->format('H:i'));

$number_input = Site_Decorator::input('number-10', 'Number')
        ->type_number()
        ->required()
        ->set_param('min', 0)
        ->set_param('max', 10)
        ->set_param('step', 2)
        ->set_value(4);

$range_input = Site_Decorator::input('range-10', 'Range')
        ->type_range()
        ->set_param('min', 0)
        ->set_param('max', 100)
        ->set_param('step', 10)
        ->set_value(40);

echo Site_Decorator::form()
        ->set_title('HTML5 Input Form')
        ->add_paragraph('This form demonstrates HTML5 input types, placeholder and various client side validation.')
        ->add_input($text_input_placeholder)
        ->add_input($text_input_required)
        ->add_input($checkbox_input_required)
        ->add_input($color_input)
        ->add_input($search_input)
        ->add_input($number_input)
        ->add_input($range_input)
        ->add_input($telephone_input)
        ->add_input($url_input)
        ->add_input($email_input)
        ->add_input($date_input)
        ->add_input($month_input)
        ->add_input($week_input)
        ->add_input($datetime_local_input)
        ->add_input($time_input)
        ->add_input($submit)
        ->render();


