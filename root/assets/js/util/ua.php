<?php

/**
 * Javascript file that defines the functions of mwf.user_agent.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20101021
 *
 * @uses User_Agent
 */

include_once(dirname(dirname(dirname(__FILE__))).'/lib/user_agent.class.php');

/** Defines the file to be parsed as a Javascript file and sets a max cache life. */
if(!headers_sent()){
    header('Content-Type: text/javascript');
    header("Cache-Control: max-age=3600");
}

?>

mwf.user_agent = new function() {
    this.is_mobile=function(){ return <?php echo User_agent::is_mobile() ? 1 : 0; ?>; }
    this.is_standard=function(){ return <?php echo User_agent::is_standard() ? 1 : 0; ?>; }
    this.is_full=function(){ return <?php echo User_agent::is_full() ? 1 : 0; ?>; }
    this.is_touch=function(){ return <?php echo User_agent::is_standard() ? 1 : 0; ?>; }
    this.is_webkit=function(){ return <?php echo User_agent::is_full() ? 1 : 0; ?>; }
    this.is_iphone_os=function(){ return <?php echo User_agent::is_iphone_os() ? 1 : 0; ?>; }
    this.is_overridden=function(){ return <?php echo User_agent::is_overridden() ? 1 : 0; ?>; }
    this.is_preview=function(){ return <?php echo User_agent::is_preview() ? 1 : 0; ?>; }
    this.is_webkit_engine=function(){ return <?php echo User_agent::is_webkit_engine() ? 1 : 0; ?>; }
    this.get_browser=function(){ return ""<?php echo ($b = User_agent::get_browser()) ? '+"'.$b.'"' : ''; ?> }
    this.get_browser_version=function(){ return ""<?php echo ($bv = User_agent::get_browser_version()) ? '+"'.$bv.'"' : ''; ?> }
    this.get_os=function(){ return ""<?php echo ($o = User_agent::get_os()) ? '+"'.$o.'"' : ''; ?> }
    this.get_os_version=function(){ return ""<?php echo ($ov = User_agent::get_os_version()) ? '+"'.$ov.'"' : ''; ?> }
};

(function(){
    var written = false;
    var writer = function(){
        if(written) return; written = true; var classes = document.body.className.split(' '); var i = classes.length;
        var nin = function(v){ for(p in classes) if(v == classes[p]) return false; return true; }
        <?php

        echo 'if (nin("mwf")) classes[i++] = "mwf";';

        if(User_agent::is_mobile())
            echo 'if (nin("mwf_mobile")) classes[i++] = "mwf_mobile";';
        else
            echo 'if (nin("mwf_notmobile")) classes[i++] = "mwf_notmobile";';

        if(User_agent::is_standard())
            echo 'if (nin("mwf_standard")) classes[i++] = "mwf_standard";';

        if(User_agent::is_full())
            echo 'if (nin("mwf_full")) classes[i++] = "mwf_full";';

        ?> var t,tv;
        if((t = mwf.user_agent.get_browser()).length > 0) { t = "mwf_browser_"+t.toLowerCase().replace(" ","_"); if(nin(t)) classes[i++] = t; }
        if((tv = mwf.user_agent.get_browser_version()).length > 0) { tv = t+'_'+tv.toLowerCase().replace(" ","_").replace(".","_"); if(nin(tv)) classes[i++] = tv; }
        if((t = mwf.user_agent.get_os()).length > 0) { t = "mwf_os_"+t.toLowerCase().replace(" ","_"); if(nin(t)) classes[i++] = t; }
        if((tv = mwf.user_agent.get_os_version()).length > 0) { tv = t+'_'+tv.toLowerCase().replace(" ","_").replace(".","_"); if(nin(tv)) classes[i++] = tv; }
        document.body.className = classes.join(' ');
    };
    document.addEventListener('DOMContentLoaded',writer,false);
    window.addEventListener('load',writer,false);
})();
