mwf.full.configurableMenu=new function(){this.render=function(l,j,a,b){var h=document.getElementById(l);if(h===null){return}var n="";var m=null;if(mwf.standard.preferences.isSupported()){var f=mwf.standard.preferences.get(j);if(f!==null){try{m=JSON.parse(f)}catch(g){m=null}}}if(m===null){for(var k in a){if(a.hasOwnProperty(k)){n+=a[k]}}}else{var d;if(m.hasOwnProperty("on")){for(d=0;d<m.on.length;d++){if(a.hasOwnProperty(m.on[d])){n+=a[m.on[d]];delete a[m.on[d]]}}}var c=m.hasOwnProperty("off")?m.off:[];for(d in a){if(a.hasOwnProperty(d)){if(!(c.indexOf(d)>=0||c.indexOf(+d)>=0)){n+=a[d]}}}if(b){for(d=0;d<c.length;d++){if(b.hasOwnProperty(c[d])){n+=b[c[d]]}}}}h.innerHTML=n}};