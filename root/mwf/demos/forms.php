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
        ->render();
?>

<?php
echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF Demo')
        ->render();

echo Site_Decorator::content_full()
        ->set_padded()
        ->add_header('MWF Forms Demo')
        ->add_paragraph('The following is a demo of MWF Forms.')
        ->render();
?>

<!-- short form -->
<form action="#" method="post">
    <h1>Short Form</h1>
    <label for="input-0">Name</label>
    <input type="text" id="input-0" name="input-0" />
    <input type="submit" class="primary" value="Search">
</form>

<!-- left aligned full form -->
<form action="#" method="post" class="full">
    <h1>Full Form</h1>
    <label for="input-1">Name</label>
    <input type="text" id="input-1" name="input-1" />
</form>

<!-- options -->
<form action="#" method="post" class="full">
    <h1>Option Form</h1>
    <label>Checkbox</label>
    <div class="option">
        <input type="checkbox" id="checkbox-1" name="checkbox-1" />
        <label for="checkbox-1">One</label><br />
        <input type="checkbox" id="checkbox-2" name="checkbox-2" />
        <label for="checkbox-2">Two</label><br />
        <input type="checkbox" id="checkbox-3" name="checkbox-3" />
        <label for="checkbox-3">Three</label>
    </div>
    <label>Right Aligned Radio</label>
    <div class="option right">
        <label for="radio-1">One</label>
        <input type="radio" id="radio-1" name="radio-1" /><br />
        <label for="radio-2">Two</label>
        <input type="radio" id="radio-2" name="radio-2" /><br />
        <label for="radio-3">Three</label>
        <input type="radio" id="radio-3" name="radio-3" />
    </div>
    <label>Justify Aligned Radio</label>
    <div class="option justify">
        <label for="radio-4">One</label>
        <input type="radio" id="radio-4" name="radio-4" /><br />
        <label for="radio-5">Two</label>
        <input type="radio" id="radio-5" name="radio-5" /><br />
        <label for="radio-6">Three</label>
        <input type="radio" id="radio-6" name="radio-6" />
    </div>
</form>

<!-- button -->
<form action="#" method="post">
    <h1>Short Button Form</h1>
    <br />
    <input type="submit" value="Primary Button" class="primary" >
    <input type="submit" value="Secondary Button" class="secondary">
    <input type="reset" value="Neutral Button" class="neutral">
    <br />
    <br />
    <a href="#" class="button primary">Primary Link</a>
    <a href="#" class="button secondary">Secondary Link</a>
    <a href="#" class="button neutral">Neutral Link</a>
</form>

<form class="full" action="#" method="post">
    <h1>Full Button Form</h1>
    <input type="submit" value="Primary Button" class="primary" >
    <input type="submit" value="Secondary Button" class="secondary">
    <input type="reset" value="Neutral Button" class="neutral">
    <a href="#" class="button primary">Primary Link</a>
    <a href="#" class="button secondary">Secondary Link</a>
    <a href="#" class="button neutral">Neutral Link</a>
</form>

<!-- textarea -->
<form action="#" method="post" class="full">
    <h1>Textarea Form</h1>
    <label for="textarea-1">Label for Text Area 1</label>
    <textarea id="textarea-1" name="textarea-1"></textarea>
</form>

<!-- select -->
<form action="#" method="post" class="full">
    <h1>Select Form</h1>
    <label for="select-1">Label for Select 1</label>
    <select id="select-1" name="select-1">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
</form>

<!-- required -->
<form action="#" method="post" class="full">
    <h1>Required Form</h1>
    <label for="input-10" class="required">Name</label>
    <input type="text" id="input-10" name="input-10" />
    <label class="required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-10" name="checkbox-10" />
        <label for="checkbox-10">One</label><br />
        <input type="checkbox" id="checkbox-11" name="checkbox-11" />
        <label for="checkbox-11">Two</label><br />
        <input type="checkbox" id="checkbox-12" name="checkbox-12" />
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
</form>

<!-- invalid -->
<form action="#" method="post" class="full">
    <h1>Invalid Form</h1>
    <label for="input-11" class="required invalid">Name</label>
    <input type="text" id="input-11" name="input-11" class="invalid" />
    <p class="invalid">This field is required</p>
    <label class="required invalid">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-13" name="checkbox-13" class="invalid" />
        <label for="checkbox-13" class="invalid">One</label><br />
        <input type="checkbox" id="checkbox-14" name="checkbox-14" class="invalid"/>
        <label for="checkbox-14"class="invalid">Two</label><br />
        <input type="checkbox" id="checkbox-15" name="checkbox-15" class="invalid"/>
        <label for="checkbox-15"class="invalid">Three</label>
    </div>
    <p class="invalid">This field is required</p>
    <label for="select-11" class="required invalid">Status</label>
    <select id="select-11" name="select-11" class="invalid">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <p class="invalid">This field is required</p>
    <label for="textarea-11" class="required invalid">Comment</label>
    <textarea id="textarea-11" name="textarea-11" class="invalid"></textarea>
    <p class="invalid">This field is required</p>
</form>

<!-- disabled -->
<form action="#" method="post" class="full">
    <h1>Disabled Form</h1>
    <label for="input-12" class="required">Name</label>
    <input type="text" id="input-12" name="input-12" disabled="disabled"/>
    <label class="required">Choice</label>
    <div class="option">
        <input type="checkbox" id="checkbox-10" name="checkbox-10" disabled="disabled"/>
        <label for="checkbox-16">One</label><br />
        <input type="checkbox" id="checkbox-11" name="checkbox-11" disabled="disabled"/>
        <label for="checkbox-17">Two</label><br />
        <input type="checkbox" id="checkbox-12" name="checkbox-12" disabled="disabled"/>
        <label for="checkbox-18">Three</label>
    </div>
    <label for="select-12" class="required">Status</label>
    <select id="select-10" name="select-10" disabled="disabled">
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
    </select>
    <label for="textarea-12" class="required">Comment</label>
    <textarea id="textarea-12" name="textarea-10" disabled="disabled"></textarea>
    <input type="submit" class="primary" value="Disabled" disabled="disabled">
    <input type="reset" class="secondary" value="Disabled" disabled="disabled">
    <a class="button disabled">Disabled</a>
</form>

<form action="#" method="post" class="full">
    <h1>HTML5 Input Form</h1>
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
    <label>Tel</label>
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
    <input type="submit" class="primary" value="Go!" />
</form>

<!-- not-padded -->
<form class="not-padded" action="#" method="post">
    <h1 class="first">Not Padded Form</h1>
    <label for="input-99">Label 99</label>
    <input type="text" id="input-99" name="input-99">
    <input type="submit" value="Search" class="primary">
</form>

<!-- prototype 1 -->
<form class="full" action="#" method="post">
    <h1 class="first">Prototype 1</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <fieldset>
        <p>One of multiple paragraphs defined within one content box (fieldset).</p>
        <p>Another of multiple paragraphs defined within one content box (fieldset).</p>
    </fieldset>
    <fieldset>
        <label for="input-100">Label for Input 100</label>
        <input type="text" id="input-100" name="input-100">
        <label for="textarea-100">Label for Textarea 100</label>
        <textarea id="textarea-100" name="textarea-100"></textarea>
        <label for="radio-100">Label for Radio 100</label>
        <input type="radio" id="radio-100" name="radio-100"><br />
        <label for="checkbox-100">Label for Checkbox 100</label>
        <input type="checkbox" id="checkbox-100" name="checkbox-100"><br />
        <label for="select-100">Label for Select 100</label>
        <select id="select-100" name="select-100">
            <option value="value-1">Value 1</option>
            <option value="value-2">Value 2</option>
            <option value="value-3">Value 3</option>
        </select>
    </fieldset>
    <h4>Subtitle</h4>
    <fieldset class="last">
        <p>Some text that comes before the submission.</p>
        <input type="submit" class="primary">
        <input type="reset">
    </fieldset>
</form>

<!-- prototype 2 -->
<div class="content-full content-padded">
    <h1 class="light">Prototype 2</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <form class="full" action="#" method="post">
        <h4 class="first">Subtitle</h4>
        <p>A content box with paragraph content.</p>
        <div>
            <p>One of multiple paragraphs defined within one content box (div).</p>
            <p>Another of multiple paragraphs defined within one content box (div).</p>
        </div>
        <fieldset>
            <p>One of multiple paragraphs defined within one content box (fieldset).</p>
            <p>Another of multiple paragraphs defined within one content box (fieldset).</p>
        </fieldset>
        <fieldset>
            <label for="input-101">Label for Input 101</label>
            <input type="text" id="input-101" name="input-101">
            <label for="textarea-101">Label for Textarea 101</label>
            <textarea id="textarea-101" name="textarea-101"></textarea>
        </fieldset>
        <div>
            <label for="radio-101">Label for Radio 101</label>
            <input type="radio" id="radio-101" name="radio-101"><br />
            <label for="checkbox-101">Label for Checkbox 101</label>
            <input type="checkbox" id="checkbox-101" name="checkbox-101"><br />
            <label for="select-101">Label for Select 101</label>
            <select id="select-101" name="select-1">
                <option value="value-1">Value 1</option>
                <option value="value-2">Value 2</option>
                <option value="value-3">Value 3</option>
            </select>
        </div>
        <h4>Subtitle</h4>
        <fieldset class="last">
            <p>Some text that comes before the submission.</p>
            <input type="submit" class="primary">
            <input type="reset">
        </fieldset>
    </form>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
</div>

<!-- prototype 3 -->
<div class="content-full content-padded">
    <h1 class="blue">Prototype 3</h1>
    <h4>Subtitle</h4>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
    <div>
        <form class="full" action="#" method="post">
            <p class="first">This and all the below form elements should be within one content box.</p>
            <fieldset>
                <label for="input-102">Label for Input 102</label>
                <input type="text" id="input-102" name="input-102">
                <label for="textarea-102">Label for Textarea 102</label>
                <textarea id="textarea-102" name="textarea-102"></textarea>
            </fieldset>
            <fieldset>
                <label for="radio-102">Label for Radio 102</label>
                <input type="radio" id="radio-102" name="radio-102"><br />
                <label for="checkbox-102">Label for Checkbox 102</label>
                <input type="checkbox" id="checkbox-102" name="checkbox-102"><br />
                <label for="select-102">Label for Select 102</label>
                <select id="select-102" name="select-102">
                    <option value="value-1">Value 1</option>
                    <option value="value-2">Value 2</option>
                    <option value="value-3">Value 3</option>
                </select>
            </fieldset>
            <p>Some text that comes before the submission.</p>
            <input type="submit" class="primary">
            <input type="reset" class="last">
        </form>
    </div>
    <p>A content box with paragraph content.</p>
    <div>
        <p>One of multiple paragraphs defined within one content box (div).</p>
        <p>Another of multiple paragraphs defined within one content box (div).</p>
    </div>
</div>

<?php
echo Site_Decorator::button_full()
        ->set_padded()
        ->add_option('Back to Demos', Config::get('global', 'site_url') . '/mwf/demos.php')
        ->render();

echo Site_Decorator::default_footer()->render();
?>

<script type="text/javascript">
    mwf.forms.init();
</script>

<?php
echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
?>