<?php

/**
 *
 * @package mwf
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20120313
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

require_once(dirname(dirname(__FILE__)).'/assets/lib/decorator.class.php');
require_once(dirname(dirname(__FILE__)).'/assets/config.php');

echo HTML_Decorator::html_start()->render();

echo Site_Decorator::head()->set_title('MWF License')->render();

echo HTML_Decorator::body_start()->render();

echo Site_Decorator::header()
        ->set_title('MWF License')
        ->render();

$terms = array(
'   Redistributions of source code must retain the above copyright notice, 
    this list of conditions and the following disclaimer.',
'   Redistributions in binary form must reproduce the above copyright notice, 
    this list of conditions and the following disclaimer in the documentation 
    and/or other materials provided with the distribution.',
'   Neither the name of the University of California nor the names of its 
    contributors may be used to endorse or promote products derived from this 
    software without specific prior written permission.'
);

$ol = HTML_Decorator::tag('ol');
foreach($terms as $term)
    $ol->add_inner(HTML_Decorator::tag('li')->add_inner($term));

echo Site_Decorator::content()
            ->set_padded()
            ->add_header('License')
            ->add_paragraph('Copyright (c) 2010-2012, Regents of the University of California
All rights reserved.')
            ->add_section(HTML_Decorator::tag('p', 
                    array('Redistribution and use in source and binary forms, 
                        with or without modification, are permitted provided 
                        that the following conditions are met:', $ol)))
            ->add_paragraph('THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES 
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON 
ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT 
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS 
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.')
            ->render();

echo Site_Decorator::button()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
                ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
