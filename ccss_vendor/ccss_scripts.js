// loadCSS & onloadCSS: https://github.com/filamentgroup/loadCSS
function onloadCSS(e,n){function t(){!o&&n&&(o=!0,n.call(e))}var o;e.addEventListener&&e.addEventListener("load",t),e.attachEvent&&e.attachEvent("onload",t),"isApplicationInstalled"in navigator&&"onloadcssdefined"in e&&e.onloadcssdefined(t)}!function(e){"use strict";var n=function(n,t,o){function i(e){return d.body?e():void setTimeout(function(){i(e)})}var a,d=e.document,l=d.createElement("link"),r=o||"all";if(t)a=t;else{var s=(d.body||d.getElementsByTagName("head")[0]).childNodes;a=s[s.length-1]}var f=d.styleSheets;l.rel="stylesheet",l.href=n,l.media="only x",i(function(){a.parentNode.insertBefore(l,t?a:a.nextSibling)});var c=function(e){for(var n=l.href,t=f.length;t--;)if(f[t].href===n)return e();setTimeout(function(){c(e)})};return l.addEventListener&&l.addEventListener("load",function(){this.media=r}),l.onloadcssdefined=c,c(function(){l.media!==r&&(l.media=r)}),l};"undefined"!=typeof exports?exports.loadCSS=n:e.loadCSS=n}("undefined"!=typeof global?global:this);