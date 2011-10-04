/**
 * Defines methods under mwf.util as utility methods.
 *
 * @package core
 * @subpackage js
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20111003
 * 
 * @uses document.write
 */

mwf.util=new function(){
    this.importJS=function(jsFile){
        document.write('<script type="text/javascript" src="'+jsFile+'"></scr'+'ipt>');
    }
    
    this.importCSS=function(cssFile){
        document.write('<link rel="stylesheet" type="text/css" href="'+cssFile+'" media="screen">');
    }
};
