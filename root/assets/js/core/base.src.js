/**
 * Removes a redirection override preference, if one exists, and defines several
 * namespaces deprecated as of MWF 1.2 that are nonetheless retained for
 * backwards compatibility.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111003
 *
 * @requires mwf
 * @requires mwf.site
 * 
 * @uses document.write
 */

/**
 * On a page that contains the redirect script assets/redirect/js.php, if
 * "override_redirect" or "ovrrdr" is set in the query string, then the script
 * will not redirect and a cookie is set that retains this override preference.
 * When a mobile page is visited that includes this script, then, this override
 * preference is erased.
 * 
 * @see /root/assets/redirect/js.php
 */
document.write('<script type="text/javascript" src="'+mwf.site.asset.root+'/redirect/js_unset_override.php"></scr'+'ipt>');

/**
 * Classification-based namespaces.
 *
 * @deprecated 1.2.00
 */
mwf.desktop=new function(){};
mwf.standard=new function(){};
mwf.full=new function(){};
mwf.touch=mwf.standard;
mwf.webkit=mwf.full;
mwf.iphone=new function(){};

/**
 * Classification-based namespaces for extensions.
 * 
 * @deprecated 1.2.00
 */
mwf.ext=new function(){};
mwf.ext.desktop=new function(){};
mwf.ext.standard=new function(){};
mwf.ext.full=new function(){};
mwf.ext.touch=mwf.ext.standard;
mwf.ext.webkit=mwf.ext.full;
mwf.ext.iphone=new function(){};
