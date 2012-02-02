<?php

/**
 *
 * @package mwf
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110519
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
'        To share all Derivative Works you create of the Software (the Mobile Web
        Framework itself) with the Licensor at UCLA\'s Office of Information 
        Technology\'s Education and Collaboration Technology Group so that others
        who are using the Software can benefit from improvements.',
'        That you will include the phrase "Powered by: " + the MOBILE WEB 
        FRAMEWORK logo or the text "The Mobile Web Framework" somewhere on your 
        application or website  The aforementioned logo or text (which can be 
        found at this webpage:  http://mwf.ucla.edu/attribution) should be an 
        image or textual active hyperlink to this web address:  
        http://mwf.ucla.edu and may be placed on an \'about\' page or other 
        central, descriptive page.',
'        Not remove any copyright or other notices from the Software.',
'        That you will not distribute this software or any Derivative Works of 
        this software to any party whatsoever modified or unmodified.  UCLA 
        shall be the only distributor of this software, with no exceptions.',
'        THAT THIS PRODUCT IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS 
        "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT 
        LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A 
        PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER
        OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
        EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
        PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR 
        PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
        LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING 
        NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS 
        PRODUCT, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  YOU MUST 
        PASS THIS LIMITATION OF LIABILITY ON WHENEVER YOU DISTRIBUTE THE 
        SOFTWARE OR DERIVATIVE WORKS.',
'        That if you sue anyone over patents that you think may apply to the 
        Software or anyone\'s use of the Software, your license to the Software 
        ends automatically.',
'        That your rights under the License end automatically if you breach it in
        any way.',
'        UCLA and the Regents of the University of California reserves all rights
        not expressly granted to you in this license.'
);

$ol = HTML_Decorator::tag('ol');
foreach($terms as $term)
    $ol->add_inner(HTML_Decorator::tag('li')->add_inner($term));

echo Site_Decorator::content()
            ->set_padded()
            ->add_header('License')
            ->add_paragraph('
This License governs use of the accompanying Mobile Web Framework and all 
accompanying utilities, forms, libraries, etc. (&quot;Software&quot;), and your use of the
Software, Platform, and all Utilities constitutes acceptance of this license.')
            ->add_paragraph('
The Software was originally created by UCLA\'s Office of Information Technology\'s
Education and Collaboration Technology Group (&quot;Licensor&quot;) to enable Faculty, 
Departments and Researchers to deliver their content to mobile devices easily 
and efficiently using the Mobile Web Framework.')
            ->add_paragraph('
You may use this Software WITHOUT CHARGE for any purpose, subject to the 
restrictions in this license. Some of those allowable uses or purposes which can
 be non-commercial are teaching, academic research, use in your own environment 
(whether that is a commercial, academic or non-profit company or organization) 
and personal experimentation.')
            ->add_paragraph('
You may use the software if you are a commercial entity. There are two things 
you cannot do with this Software: The first is you cannot incorporate it into a 
commercial product (&quot;Commercial Use&quot;), the second is you cannot distribute this 
software or any modifications (&quot;Derivative Work&quot;) of this software and beyond 
that, you must share your changes to the Mobile Web Framework with UCLA and the 
MWF Community. We want everyone to benefit from the use of this product, we want
it to stay free, and we want to avoid it forking (or splintering) into 
disconnected versions. Therefore; you may not use or distribute this Software or
 any Derivative Works in any form for any purpose. Examples of prohibited 
purposes would be licensing, leasing, or selling the Software, or distributing 
the Software for use with other commercial products, or incorporating the 
Software into a commercial product.')
            ->add_paragraph('
You may create Derivative Works of the software for your own use. You may modify
this Software and contribute it back to UCLA and the MWF Community, but you may 
not distribute the modified Software; all distribution must happen via UCLA\'s 
Office of Information Technology Education and Collaboration Technology Group.  
You may not grant rights to the Software or Derivative Works to this software 
under this License. For example, you may not distribute modifications of the 
Software under any terms, or sublicense this software to others.')
            ->add_paragraph('
For purposes of clarity, this license covers your institution, and all other 
institutions directly affiliated with your institution. For example, in the case
of a University, all campuses would be covered under this license and directly 
affiliated schools, such as members of a higher education consortium, would also
be covered under this license. In the case of a non-profit institution, all 
subsidiaries and directly affiliated companies or entities would be covered.')
            ->add_section(HTML_Decorator::tag('p', 'You agree:')->render() . $ol->render())
            ->render();

echo Site_Decorator::content()
        ->set_padded()
        ->add_header('Disclaimer')
        ->add_paragraph('UCLA reserves the right to modify this license at any
time. Therefore, although this represents a working copy of the UCLA Mobile
Web Framework license, the latest version exists on the MWF site.')
        ->add_paragraph(HTML_Decorator::tag('a', 'http://mwf.ucla.edu/license', array('href'=>'http://mwf.ucla.edu/license', 'rel'=>'external')), array('style'=>'text-align:center;'))
        ->render();

echo Site_Decorator::button()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
                ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
