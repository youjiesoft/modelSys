!function(t){"object"==typeof exports&&"object"==typeof module?t(require("../../lib/codemirror")):"function"==typeof define&&define.amd?define(["../../lib/codemirror"],t):t(CodeMirror)}(function(t){function e(t,e){for(var n=0,r=t.length;r>n;++n)e(t[n])}function n(t,e){if(!Array.prototype.indexOf){for(var n=t.length;n--;)if(t[n]===e)return!0;return!1}return-1!=t.indexOf(e)}function r(e,n,r,i){var o=e.getCursor(),s=r(e,o),l=s;if(!/\b(?:string|comment)\b/.test(s.type)){for(s.state=t.innerMode(e.getMode(),s.state).state,/^[\w$_]*$/.test(s.string)||(s=l={start:o.ch,end:o.ch,string:"",state:s.state,type:"."==s.string?"property":null});"property"==l.type;){if(l=r(e,f(o.line,l.start)),"."!=l.string)return;if(l=r(e,f(o.line,l.start)),!c)var c=[];c.push(l)}return{list:a(s,c,n,i),from:f(o.line,s.start),to:f(o.line,s.end)}}}function i(t,e){return r(t,p,function(t,e){return t.getTokenAt(e)},e)}function o(t,e){var n=t.getTokenAt(e);return e.ch==n.start+1&&"."==n.string.charAt(0)?(n.end=n.start,n.string=".",n.type="property"):/^\.[\w$_]*$/.test(n.string)&&(n.type="property",n.start++,n.string=n.string.replace(/\./,"")),n}function s(t,e){return r(t,d,o,e)}function a(t,r,i,o){function s(t){0!=t.lastIndexOf(p,0)||n(f,t)||f.push(t)}function a(t){"string"==typeof t?e(l,s):t instanceof Array?e(c,s):t instanceof Function&&e(u,s);for(var n in t)s(n)}var f=[],p=t.string;if(r&&r.length){var d,y=r.pop();for(y.type&&0===y.type.indexOf("variable")?(o&&o.additionalContext&&(d=o.additionalContext[y.string]),d=d||window[y.string]):"string"==y.type?d="":"atom"==y.type?d=1:"function"==y.type&&(null==window.jQuery||"$"!=y.string&&"jQuery"!=y.string||"function"!=typeof window.jQuery?null!=window._&&"_"==y.string&&"function"==typeof window._&&(d=window._()):d=window.jQuery());null!=d&&r.length;)d=d[r.pop().string];null!=d&&a(d)}else{for(var g=t.state.localVars;g;g=g.next)s(g.name);for(var g=t.state.globalVars;g;g=g.next)s(g.name);a(window),e(i,s)}return f}var f=t.Pos;t.registerHelper("hint","javascript",i),t.registerHelper("hint","coffeescript",s);var l="charAt charCodeAt indexOf lastIndexOf substring substr slice trim trimLeft trimRight toUpperCase toLowerCase split concat match replace search".split(" "),c="length concat join splice push pop shift unshift slice reverse sort indexOf lastIndexOf every some filter forEach map reduce reduceRight ".split(" "),u="prototype apply call bind".split(" "),p="break case catch continue debugger default delete do else false finally for function if in instanceof new null return switch throw true try typeof var void while with".split(" "),d="and break catch class continue delete do else extends false finally for if in instanceof isnt new no not null of off on or return switch then throw true try typeof until void while with yes".split(" ")});