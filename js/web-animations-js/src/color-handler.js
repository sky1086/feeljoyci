!function(o,r){function t(o){o=o.trim(),n.fillStyle="#000",n.fillStyle=o;var r=n.fillStyle;if(n.fillStyle="#fff",n.fillStyle=o,r==n.fillStyle){n.fillRect(0,0,1,1);var t=n.getImageData(0,0,1,1).data;n.clearRect(0,0,1,1);var e=t[3]/255;return[t[0]*e,t[1]*e,t[2]*e,e]}}function e(r,t){return[r,t,function(r){if(r[3])for(var t=0;t<3;t++)r[t]=Math.round(function(o){return Math.max(0,Math.min(255,o))}(r[t]/r[3]));return r[3]=o.numberToString(o.clamp(0,1,r[3])),"rgba("+r.join(",")+")"}]}var l=document.createElementNS("http://www.w3.org/1999/xhtml","canvas");l.width=l.height=1;var n=l.getContext("2d");o.addPropertiesHandler(t,e,["background-color","border-bottom-color","border-left-color","border-right-color","border-top-color","color","fill","flood-color","lighting-color","outline-color","stop-color","stroke","text-decoration-color"]),o.consumeColor=o.consumeParenthesised.bind(null,t),o.mergeColors=e,WEB_ANIMATIONS_TESTING&&(r.parseColor=t)}(webAnimations1,webAnimationsTesting);