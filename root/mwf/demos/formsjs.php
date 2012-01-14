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


echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('MWF Demos')
        ->add_js_handler_library('full_libs', 'forms')
        ->add_js_handler_library('standard_libs', 'tooltip')
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Demo')
        ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('MWF Forms Demo')
        ->add_paragraph('The following is a demo of MWF Forms JS.')
        ->render();
?>

<!-- required -->
<form action="#" method="post" class="padded" id="form1">
    <h1>Required Form</h1>
    <p>This form demonstrates client-side required validation.  Note that required validation does not work with checkbox or radio.</p>
    <label for="input-10" class="required">Name</label>
    <input type="text" id="input-10" name="input-10" />
    <label class="required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-10" name="checkbox-10" />
        <label for="checkbox-10">One</label><br />
        <input type="checkbox" id="checkbox-11" name="checkbox-10" />
        <label for="checkbox-11">Two</label><br />
        <input type="checkbox" id="checkbox-12" name="checkbox-10" />
        <label for="checkbox-12">Three</label>
    </div>
    <label for="select-10" class="required">Status</label>
    <select id="select-10" name="select-10">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <label for="textarea-10" class="required">Comment</label>
    <textarea id="textarea-10" name="textarea-10"></textarea>
    <label for="input-11" class="required">Tooltip</label><span class="tiptext">Tip text goes here</span>
    <input type="text" id="input-11" name="input-11" />
    <label for="input-12" class="required">Tooltip with a really long label</label><span class="tiptext">A very very very very very very very very very very very long text goes here</span>
    <input type="text" id="input-12" name="input-12" />
    <input type="submit" class="primary" value="Test Me!" />
</form>

<form action="#" method="post" class="padded" id="html5form">
    <h1>HTML5 Input Form</h1>
    <p>This form demonstrates HTML5 input types, placeholder, and various validation.</p>
    <label>Placeholder</label>
    <input type="text" name="placeholder" />
    <label class="required">Required</label><span class="placeholder">Please enter text here</span>
    <input type="text" name="required" />
    <label class="required">Required Div</label>
    <div class="option">
        <input type="checkbox" id="checkbox-80" name="checkbox-80" />
        <label for="checkbox-80">One</label><br />
        <input type="checkbox" id="checkbox-81" name="checkbox-81" />
        <label for="checkbox-81">Two</label><br />
        <input type="checkbox" id="checkbox-82" name="checkbox-82" />
        <label for="checkbox-82">Three</label>
    </div>
    <label>Color</label>
    <input type="text" class="color-field" name="color" />
    <label>Search</label>
    <input type="text" class="search-field" name="search" />
    <label>Number</label>
    <select class="number-field" name="number">
        <option value="0">0</option>
        <option value="2">2</option>
        <option value="4" selected>4</option>
        <option value="6">6</option>
        <option value="8">8</option>
        <option value="10">10</option>
    </select>
    <label>Range</label>
    <select class="range-field" name="range">
        <option value="0">0</option>
        <option value="2">2</option>
        <option value="4" selected>4</option>
        <option value="6">6</option>
        <option value="8">8</option>
        <option value="10">10</option>
    </select>
    <label class="required">Tel</label>
    <input type="text" class="tel-field" name="tel" />
    <label>Url</label>
    <input type="text" class="url-field" name="url" />
    <label>Email</label>
    <input type="text" class="email-field" name="email"/>
    <label>Date</label>
    <div class="date-field">
        <select class="month" name="date-month">
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08" selected>Aug</option>
            <option value="09">Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
        <select class="day" name="date-day">
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08" selected>8</option>
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
        <select class="year" name="date-year">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013" selected>2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
        </select>
    </div>
    <label for="month-1">Month</label>
    <div class="month-field">
        <select class="month" name="month-month">
            <option value="01">Jan</option>
            <option value="02">Feb</option>
            <option value="03">Mar</option>
            <option value="04">Apr</option>
            <option value="05">May</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Aug</option>
            <option value="09" selected>Sep</option>
            <option value="10">Oct</option>
            <option value="11">Nov</option>
            <option value="12">Dec</option>
        </select>
        <select class="year" name="month-year">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014" selected>2014</option>
            <option value="2015">2015</option>
        </select>
    </div>
    <label for="month-1">Week</label>
    <div class="week-field">
        <select class="week" name="week-week">
            <option value="01">1</option>
            <option value="02">2</option>
            <option value="03">3</option>
            <option value="04">4</option>
            <option value="05">5</option>
            <option value="06">6</option>
            <option value="07">7</option>
            <option value="08">8</option>
            <option value="09">9</option>
            <option value="10" selected>10</option>
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
            <option value="20">30</option>
            <option value="21">31</option>
            <option value="22">32</option>
            <option value="23">33</option>
            <option value="24">34</option>
            <option value="25">35</option>
            <option value="26">36</option>
            <option value="27">37</option>
            <option value="28">38</option>
            <option value="29">39</option>
            <option value="20">40</option>
            <option value="21">41</option>
            <option value="22">42</option>
            <option value="23">43</option>
            <option value="24">44</option>
            <option value="25">45</option>
            <option value="26">46</option>
            <option value="27">47</option>
            <option value="28">48</option>
            <option value="29">49</option>
            <option value="20">50</option>
            <option value="21">51</option>
            <option value="22">52</option>
        </select>
        <select class="year" name="week-year">
            <option value="2011">2011</option>
            <option value="2012">2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015" selected>2015</option>
        </select>
    </div>
    <label>Datetime (MMM/dd/yyyy hh:mm)</label>
    <div class="datetime-field">
        <select class="month" name="datetime-month">
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
        <select class="day" name="datetime-day">
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
        <select class="year" name="datetime-year">
            <option value="2011">2011</option>
            <option value="2012" selected>2012</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
        </select>
        <select class="hour" name="datetime-hour">
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
        </select>
        <select class="minute" name="datetime-minute">
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
    </div>
    <label>Time (hh:mm)</label>
    <div class="time-field">
        <select class="hour" name="time-hour">
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
            <option value="23" selected>23</option>
        </select>
        <select class="minute" name="time-minute">
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
            <option value="59" selected>59</option>
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