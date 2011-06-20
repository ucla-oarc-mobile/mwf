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
'To share all Derivative Works you create of the Software (the Mobile Web
   Framework itself) with the Licensor at UCLA\'s Office of Information
   Technology\'s Academic Application Services so that others who are using the
   Software can benefit from improvements.',
'That you will include the phrase "Powered by: " + the UCLA MOBILE WEB
   FRAMEWORK logo somewhere on your application or website  The Logo should be
   an active hyperlink to this web address: "http://mwf.ucla.edu"',
'Not remove any copyright or other notices from the Software.',
'That you will not distribute this software or any Derivative Works of
   this software to any party whatsoever, modified or unmodified.  UCLA shall be
   the only distributor of this software, with no exceptions.',
'THAT THIS PRODUCT IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
   IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
   IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
   ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
   LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
   CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
   SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
   INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
   CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
   ARISING IN ANY WAY OUT OF THE USE OF THIS PRODUCT, EVEN IF ADVISED OF THE
   POSSIBILITY OF SUCH DAMAGE.  YOU MUST PASS THIS LIMITATION OF LIABILITY ON
   WHENEVER YOU DISTRIBUTE THE SOFTWARE OR DERIVATIVE WORKS.',
'That if you sue anyone over patents that you think may apply to the Software
   or anyone\'s use of the Software, your license to the Software ends
   automatically.',
'That your rights under the License end automatically if you breach it in any
   way.',
'UCLA and the Regents of the University of California reserves all rights not
   expressly granted to you in this license.',
'Nothing in this Agreement grants by implication, estoppel, or otherwise any
   rights to any intellectual property owned by the Regents of the University of
   California, except as explicitly set forth in this license.',
'You will hold the Regents harmless for all claims, suits, losses,
    liabilities, damages, costs, fees, and expenses resulting from their
    respective activities arising from this license.',
'You will not use any name, trade name, trademark, name of any campus, or
    other designation of the Regents of the University of California in
    advertising, publicity, or other promotional activity, except as permitted
    herein.'
);

$ol = HTML_Decorator::tag('ol');
foreach($terms as $term)
    $ol->add_inner(HTML_Decorator::tag('li')->add_inner($term));

echo Site_Decorator::content_full()
            ->set_padded()
            ->add_header('License')
            ->add_paragraph('
This License governs use of the accompanying Mobile Web Framework and all
accompanying utilities, forms, libraries, etc. ("Software"), and Licensee\'s
("You" or "Your") use of the Software, Platform, and all Utilities.  Use of the
Software constitutes acceptance of this license.')
            ->add_paragraph('
The Software was created by UCLA\'s Office of Information Technology\'s Academic
Application Services ("Licensor") to enable UCLA Faculty, Departments and
Researchers to deliver their content to mobile devices easily and efficiently
using the UCLA Mobile Web Framework.')
            ->add_paragraph('
You may use this Software WITHOUT CHARGE for any purpose, subject to the
restrictions in this license. Some of those allowable uses or purposes which can
 be non-commercial are teaching, academic research, use in your own environment
(whether that is a commercial, academic or non-profit company or organization)
and personal experimentation. You may use the software if you are a commercial
entity.')
            ->add_paragraph('
There are two things you cannot do with this Software: The first is you cannot
incorporate it into a commercial product ("Commercial Use"), the second is you
cannot distribute this software or any modifications ("Derivative Work") of this
software and beyond that, you must share your changes to the Mobile Framework
with UCLA. We want everyone to benefit from the use of this product, we want it
to stay free, and we want to avoid it forking (or splintering) into disconnected
versions. Therefore; you may not use or distribute this Software or any
Derivative Works in any form for any purpose. Examples of prohibited purposes
would be licensing, leasing, or selling the Software, or distributing the
Software for use with other commercial products, or incorporating the Software
into a commercial product.')
            ->add_paragraph('
You may create Derivative Works of the software for your own use only. You may
modify this Software and contribute it back to UCLA, but you may not distribute
the modified Software; all distribution must happen via UCLA\'s Office of
Information Technology Academic Application Architecture Group.  You may not
grant rights to the Software or Derivative Works to this software under this
License. For example, you may not distribute modifications of the Software under
any terms, or sublicense this software to others.')
            ->add_section(HTML_Decorator::tag('p', 'You agree:')->render() . $ol->render())
            ->render();

echo Site_Decorator::content_full()
        ->set_padded()
        ->add_header('Disclaimer')
        ->add_paragraph('UCLA reserves the right to modify this license at any
time. Therefore, although this represents a working copy of the UCLA Mobile
Web Framework license, the latest version exists on the MWF site.')
        ->add_paragraph(HTML_Decorator::tag('a', 'http://mwf.ucla.edu/license', array('href'=>'http://mwf.ucla.edu/license')), array('style'=>'text-align:center;'))
        ->render();

echo Site_Decorator::button_full()
                ->set_padded()
                ->add_option(Config::get('global', 'back_to_home_text'), Config::get('global', 'site_url'))
                ->render();

echo Site_Decorator::default_footer()->render();

echo HTML_Decorator::body_end()->render();

echo HTML_Decorator::html_end()->render();
