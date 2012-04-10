<?php

require_once(dirname(dirname(dirname(__FILE__))).'/assets/config.php');
require_once(dirname(dirname(dirname(__FILE__))).'/assets/lib/decorator.class.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()
        ->set_title('MWF About')
        ->set_js_handler_params(array('standard_libs'=>'interactivity/expandable'))
        ->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('Entities Demo')
        ->render();

?>

<div class="button padded">
    <a href="#" class="trigger t-ele1 light">Element 1</a>
    <a href="#" class="trigger light t-ele2">Element 2</a>
</div>

<div class="content expandable padded ele1">
    <div class="">
        <h2>Target for Ele1</h2>
        <p>Some paragraph text for ele2</p>
    </div>
    <div class="ele2">
        <h2>Target for Ele2</h2>
        <p>Some paragraph text for ele2</p>
    </div>
</div>

<div class="button padded trigger light">
    <a href="#" class="t-ele3">Element 3</a>
    <a href="#" class="t-ele4">Element 4</a>
</div>

<div class="content padded expandable">
    <div class="ele3">
        <h2>Target for Ele3</h2>
        <p>Some paragraph text for ele2</p>
    </div>
    <div class="ele4">
        <h2>Target for Ele4</h2>
        <p>Some paragraph text for ele2</p>
    </div>
</div>

<?php

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();

?>