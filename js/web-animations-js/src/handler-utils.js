!function(n){function e(n,e){var r=n.exec(e);if(r)return r=n.ignoreCase?r[0].toLowerCase():r[0],[r,e.substr(r.length)]}function r(n,e){e=e.replace(/^\s*/,"");var r=n(e);if(r)return[r[0],r[1].replace(/^\s*/,"")]}function t(n,t,u){n=r.bind(null,n);for(var i=[];;){var o=n(u);if(!o)return[i,u];if(i.push(o[0]),u=o[1],!(o=e(t,u))||""==o[1])return[i,u];u=o[1]}}function u(n,e){for(var r=0,t=0;t<e.length&&(!/\s|,/.test(e[t])||0!=r);t++)if("("==e[t])r++;else if(")"==e[t]&&(r--,0==r&&t++,r<=0))break;var u=n(e.substr(0,t));return void 0==u?void 0:[u,e.substr(t)]}function i(n,e){for(var r=n,t=e;r&&t;)r>t?r%=t:t%=r;return r=n*e/(r+t)}function o(n){return function(e){var r=n(e);return r&&(r[0]=void 0),r}}function s(n,e){return function(r){var t=n(r);return t||[e,r]}}function f(e,r){for(var t=[],u=0;u<e.length;u++){var i=n.consumeTrimmed(e[u],r);if(!i||""==i[0])return;void 0!==i[0]&&t.push(i[0]),r=i[1]}if(""==r)return t}function a(n,e,r,t,u){for(var o=[],s=[],f=[],a=i(t.length,u.length),c=0;c<a;c++){var h=e(t[c%t.length],u[c%u.length]);if(!h)return;o.push(h[0]),s.push(h[1]),f.push(h[2])}return[o,s,function(e){var t=e.map(function(n,e){return f[e](n)}).join(r);return n?n(t):t}]}function c(n,e,r){for(var t=[],u=[],i=[],o=0,s=0;s<r.length;s++)if("function"==typeof r[s]){var f=r[s](n[o],e[o++]);t.push(f[0]),u.push(f[1]),i.push(f[2])}else!function(n){t.push(!1),u.push(!1),i.push(function(){return r[n]})}(s);return[t,u,function(n){for(var e="",r=0;r<n.length;r++)e+=i[r](n[r]);return e}]}n.consumeToken=e,n.consumeTrimmed=r,n.consumeRepeated=t,n.consumeParenthesised=u,n.ignore=o,n.optional=s,n.consumeList=f,n.mergeNestedRepeated=a.bind(null,null),n.mergeWrappedNestedRepeated=a,n.mergeList=c}(webAnimations1);