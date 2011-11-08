/*
 * jSwipe - jQuery Plugin
 * http://plugins.jquery.com/project/swipe
 * http://www.ryanscherf.com/demos/swipe/
 *
 * Copyright (c) 2009 Ryan Scherf (www.ryanscherf.com)
 * Licensed under the MIT license
 *
 * $Date: 2009-07-14 (Tue, 14 Jul 2009) $
 * $version: 0.1
 *
 * This jQuery plugin will only run on devices running Mobile Safari
 * on iPhone or iPod Touch devices running iPhone OS 2.0 or later.
 * http://developer.apple.com/iphone/library/documentation/AppleApplications/Reference/SafariWebContent/HandlingEvents/HandlingEvents.html#//apple_ref/doc/uid/TP40006511-SW5
 */

/*
 * Extended by Eric Bollens
 * $Date: 2010-07-06
 * $version 0.1(a)
 */
document.addEventListener("load",function(){(function(a){a.fn.swipe=function(b){var c={threshold:{x:140,y:200},swipeLeft:function(){alert("swiped left")},swipeRight:function(){alert("swiped right")}};var b=a.extend(c,b);if(!this){return false}return this.each(function(){var h=a(this);var f={x:0,y:0};var d={x:0,y:0};function e(k){console.log("Starting swipe gesture...");f.x=k.targetTouches[0].pageX;f.y=k.targetTouches[0].pageY}function j(k){d.x=k.targetTouches[0].pageX;d.y=k.targetTouches[0].pageY}function g(k){console.log("Ending swipe gesture...");var l=f.y-d.y;if(l<c.threshold.y&&l>(c.threshold.y*-1)){changeX=f.x-d.x;if(changeX>c.threshold.x){c.swipeLeft(k)}if(changeX<(c.threshold.x*-1)){c.swipeRight(k)}}}function i(k){console.log("Canceling swipe gesture...")}this.addEventListener("touchstart",e,false);this.addEventListener("touchmove",j,false);this.addEventListener("touchend",g,false);this.addEventListener("touchcancel",i,false)})}})(jQuery)},false);