<?php
/**
 *
 * @package mwf.demos
 *
 * @author ilin
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111114
 *
 * @uses Decorator
 * @uses Site_Decorator
 * @uses HTML_Decorator
 * @uses HTML_Start_HTML_Decorator
 * @uses Head_Site_Decorator
 * @uses Body_Start_HTML_Decorator
 * @uses Header_Site_Decorator
 * @uses Content_Full_Site_Decorator
 * @uses Button_Full_Site_Decorator
 * @uses Default_Footer_Site_Decorator
 * @uses Body_End_HTML_Decorator
 * @uses HTML_End_HTML_Decorator
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/lib/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/assets/config.php');

$submit = Site_Decorator::input()
        ->type_submit()
        ->set_param('value','Test Me');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('Forms JS Demo')
        ->add_js_handler_library('full_libs', 'forms')
        ->add_js_handler_library('full_libs', 'formsPolyfills')
        ->add_js_handler_library('standard_libs', 'tooltip')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Forms JS Demo')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Forms UI Demo')
        ->add_paragraph('The following is a demo of MWF Forms JS.')
        ->render();

/* required */
$text_input_mandatory = Site_Decorator::input('input-1', 'Text')
        ->mandatory();
$text_input_tooltip = Site_Decorator::input('input-2', 'Tooltip')
        ->mandatory()
        ->set_tooltip('tooltip text');
$checkbox_input_mandatory = Site_Decorator::input('checkbox-1', 'Checkbox')
        ->type_checkbox()
        ->mandatory();
echo Site_Decorator::form()
        ->set_padded()
        ->set_title('Required & Tooltip Form')
        ->add_paragraph('This form demonstrates client-side required validation.')
        ->add_input($text_input_mandatory)
        ->add_input($checkbox_input_mandatory)
        ->add_select('select-group-1', 'Select', array(
            array('label' => 'One', 'value' => 1),
            array('label' => 'Two', 'value' => 2),
            array('label' => 'Three', 'value' => 3)
                ), array('required' => true)
        )
        ->add_textarea('textarea-1', 'Textarea', array('required' => true))
        ->add_input($text_input_tooltip)
        ->add_textarea('textarea-2', 'Tooltip with long label', array('required' => true, 'tooltip' => 'A very very very very very very long tooltip text'))
        ->add_input($submit)
        ->render();

/* html5 */
$text_input_placeholder = Site_Decorator::input('input-10', 'Placeholder')
        ->mandatory()
        ->set_placeholder('Please enter text here');
$text_input_mandatory = Site_Decorator::input('input-11', 'Required')
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
        ->set_param('value', $now->format('Y-m-d'));
$month_input = Site_Decorator::input('month-10', 'Month')
        ->type_month()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-m'))
        ->set_param('max', $five_years_from_now->format('Y-m'))
        ->set_param('value', $now->format('Y-m'));
$week_input = Site_Decorator::input('week-10', 'Week')
        ->type_week()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-\WW'))
        ->set_param('max', $five_years_from_now->format('Y-\WW'))
        ->set_param('value', $now->format('Y-\WW'));

$datetime_local_input = Site_Decorator::input('datetime-10', 'Datetime Local')
        ->type_datetime_local()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('Y-m-d\TH:i'))
        ->set_param('max', $five_years_from_now->format('Y-m-d\TH:i'))
        ->set_param('value', $now->format('Y-m-d\TH:i'));

$time_input = Site_Decorator::input('time-10', 'Time')
        ->type_time()
        ->mandatory()
        ->set_param('min', $five_years_ago->format('H:i'))
        ->set_param('max', $five_years_from_now->format('H:i'))
        ->set_param('value', $now->format('H:i'));

echo Site_Decorator::form()
        ->set_padded()
        ->set_title('HTML5 Input Form')
        ->add_paragraph('This form demonstrates HTML5 input types, placeholder and various client side validation.')
        ->add_input($text_input_placeholder)
        ->add_input($text_input_mandatory)
        ->add_input($checkbox_input_mandatory)
        ->add_input($color_input)
        ->add_input($search_input)
        ->add_number('number-10', 'Number', 0, 10, array('step' => 2, 'selected' => 4, 'required' => true))
        ->add_range('range-10', 'Range', 0, 100, array('step' => 10, 'selected' => 40, 'required' => true))
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
?>


<form action="#" method="post" class="padded">
    <h1>HTML5 Input Form</h1>
    <label>Datetime</label>
    <div class="datetime-field">
        <select class="month" name="datetime-month-100">
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07" selected>Jul</option>
            <option value="08">Aug</option>
            <option value="09">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
        <select class="day" name="datetime-day-100">
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07" selected>7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>
        <select class="year" name="datetime-year-100">
            <option value="2011">2011</option>
            <option value="2012" selected>2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
        </select>
        <select class="hour" name="datetime-hour-100">
            <option value="00">0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13" selected>13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>:
        <select class="minute" name="datetime-minute-100">
            <option value="00">0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30" selected>30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
        </select>:
        <select class="second" name="datetime-second-100">
            <option value="00">0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30" selected>30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
        </select>
        <select class="offset" name="datetime-offset-100">
            <option value="+" selected>+</option>
            <option value="-">-</option>
        </select>
        <select class="offset-hour" name="datetime-offset-hour-100">
            <option value="00" selected>0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
        </select>:
        <select class="offset-minute" name="datetime-offset-minute-100">
            <option value="00" selected>0</option>
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
        </select>
    </div>
    <input type="submit" class="primary" value="Test Me!" />
</form>

<?php
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