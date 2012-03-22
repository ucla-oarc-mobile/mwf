<?php
/**
 *
 * @package mwf.demos
 *
 * @author ilin
 * @author trott
 * @copyright Copyright (c) 2010-12 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120322
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Content_Site_Decorator
 * @uses Button_Site_Decorator
 * @uses Form_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/lib/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/config.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('Forms JS Demo')
        ->add_js_handler_library('full_libs', 'forms')
        ->add_js_handler_library('full_libs', 'formsPolyfills')
        ->add_js_handler_library('standard_libs', 'tooltip')
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Forms JS Demo')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Forms UI Demo')
        ->render();

$submit = Site_Decorator::input()
        ->type_submit()
        ->set_value('Test Me');

?>

<!-- required form elements and some tooltips -->

<?php
$text_input_mandatory = Site_Decorator::input('input-1', 'Text')
        ->mandatory();
$text_input_tooltip = Site_Decorator::input('input-2', 'Tooltip')
        ->mandatory()
        ->set_tooltip('tooltip text');
$checkbox_input_mandatory = Site_Decorator::input('checkbox-1', 'Checkbox')
        ->type_checkbox()
        ->mandatory();
$select_input_mandatory = Site_Decorator::input('select-1', 'Select')
        ->add_option(false, 'Select...')
        ->add_option(1,'One')
        ->add_option(2, 'Two')
        ->add_option(3, 'Three')
        ->mandatory();
$textarea_input_mandatory = Site_Decorator::input('textarea-1','Textarea')
        ->type_textarea()
        ->mandatory();
$textarea_input_tooltip = Site_Decorator::input('textarea-2', 'Textarea with long tooltip')
        ->type_textarea()
        ->mandatory()
        ->set_tooltip('A very very very very very very long tooltip text');
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Required & Tooltip Form')
        ->add_paragraph('This form demonstrates client-side required validation.')
        ->add_input($text_input_mandatory)
        ->add_input($checkbox_input_mandatory)
        ->add_input($select_input_mandatory)
        ->add_input($textarea_input_mandatory)
        ->add_input($text_input_tooltip)
        ->add_input($textarea_input_tooltip)
        ->add_input($submit)
        ->render();

?>

<!-- html5 input types and attributes -->

<?php
$text_input_placeholder = Site_Decorator::input('input-10', 'Placeholder')
        ->mandatory()
        ->set_placeholder('Please enter text here');
$text_input_mandatory = Site_Decorator::input('input-11', 'Required')
        ->mandatory();
$checkbox_input_mandatory = Site_Decorator::input('checkbox-10', 'Checkbox')
        ->type_checkbox()
        ->mandatory();
$color_input = Site_Decorator::input('color-10', 'Color')
        ->type_color()
        ->mandatory();
$search_input = Site_Decorator::input('search-10', 'Search')
        ->type_search()
        ->mandatory();
$telephone_input = Site_Decorator::input('tel-10', 'Telephone')
        ->type_telephone()
        ->mandatory();
$url_input = Site_Decorator::input('url-10', 'URL')
        ->type_url()
        ->mandatory();
$email_input = Site_Decorator::input('email-10', 'Email')
        ->type_email()
        ->mandatory();
$now = new DateTime('now');
$five_years_ago = new DateTime("5 years ago");
$five_years_from_now = new DateTime("5 years");
$date_input = Site_Decorator::input('date-10', 'Date')
        ->type_date()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-m-d'))
        ->set_param('max', $five_years_from_now->format('Y-m-d'))
        ->set_value($now->format('Y-m-d'));
$month_input = Site_Decorator::input('month-10', 'Month')
        ->type_month()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-m'))
        ->set_param('max', $five_years_from_now->format('Y-m'))
        ->set_value($now->format('Y-m'));
$week_input = Site_Decorator::input('week-10', 'Week')
        ->type_week()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-\WW'))
        ->set_param('max', $five_years_from_now->format('Y-\WW'))
        ->set_value($now->format('Y-\WW'));

$datetime_local_input = Site_Decorator::input('datetime-10', 'Datetime Local')
        ->type_datetime_local()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-m-d\TH:i'))
        ->set_param('max', $five_years_from_now->format('Y-m-d\TH:i'))
        ->set_value($now->format('Y-m-d\TH:i'));

$time_input = Site_Decorator::input('time-10', 'Time')
        ->type_time()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('H:i'))
        ->set_param('max', $five_years_from_now->format('H:i'))
        ->set_value($now->format('H:i'));

$number_input = Site_Decorator::input('number-10', 'Number')
        ->type_number()
        ->mandatory()
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
        ->set_padded()
        ->set_title('HTML5 Input Form')
        ->add_paragraph('This form demonstrates HTML5 input types, placeholder and various client side validation.')
        ->add_input($text_input_placeholder)
        ->add_input($text_input_mandatory)
        ->add_input($checkbox_input_mandatory)
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

echo Site_Decorator::button()
        ->set_padded()
        ->add_option('Back to Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<script type="text/javascript">
    if (mwf.classification.isStandard()) {
        mwf.tooltip();
    }
    if (mwf.classification.isFull()) {
        mwf.forms.init();
    }
</script>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>