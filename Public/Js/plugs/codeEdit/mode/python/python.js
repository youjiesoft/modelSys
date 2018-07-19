!function(e){"object"==typeof exports&&"object"==typeof module?e(require("../../lib/codemirror")):"function"==typeof define&&define.amd?define(["../../lib/codemirror"],e):e(CodeMirror)}(function(e){"use strict";e.defineMode("python",function(t,n){function r(e){return new RegExp("^(("+e.join(")|(")+"))\\b")}function i(e,t){if(e.sol()){var n=t.scopes[0].offset;if(e.eatSpace()){var r=e.indentation();return r>n?z="indent":n>r&&(z="dedent"),null}n>0&&s(e,t)}if(e.eatSpace())return null;var i=e.peek();if("#"===i)return e.skipToEnd(),"comment";if(e.match(/^[0-9\.]/,!1)){var a=!1;if(e.match(/^\d*\.\d+(e[\+\-]?\d+)?/i)&&(a=!0),e.match(/^\d+\.\d*/)&&(a=!0),e.match(/^\.\d+/)&&(a=!0),a)return e.eat(/J/i),"number";var l=!1;if(e.match(/^0x[0-9a-f]+/i)&&(l=!0),e.match(/^0b[01]+/i)&&(l=!0),e.match(/^0o[0-7]+/i)&&(l=!0),e.match(/^[1-9]\d*(e[\+\-]?\d+)?/)&&(e.eat(/J/i),l=!0),e.match(/^0(?![\dx])/i)&&(l=!0),l)return e.eat(/L/i),"number"}return e.match(w)?(t.tokenize=o(e.current()),t.tokenize(e,t)):e.match(m)||e.match(u)?null:e.match(f)||e.match(p)||e.match(y)?"operator":e.match(d)?null:e.match(E)?"keyword":e.match(_)?"builtin":e.match(/^(self|cls)\b/)?"variable-2":e.match(b)?"def"==t.lastToken||"class"==t.lastToken?"def":"variable":(e.next(),c)}function o(e){function t(t,a){for(;!t.eol();)if(t.eatWhile(/[^'"\\]/),t.eat("\\")){if(t.next(),r&&t.eol())return o}else{if(t.match(e))return a.tokenize=i,o;t.eat(/['"]/)}if(r){if(n.singleLineStringErrors)return c;a.tokenize=i}return o}for(;"rub".indexOf(e.charAt(0).toLowerCase())>=0;)e=e.substr(1);var r=1==e.length,o="string";return t.isString=!0,t}function a(e,n,r){r=r||"py";var i=0;if("py"===r){if("py"!==n.scopes[0].type)return void(n.scopes[0].offset=e.indentation());for(var o=0;o<n.scopes.length;++o)if("py"===n.scopes[o].type){i=n.scopes[o].offset+t.indentUnit;break}}else i=e.match(/\s*($|#)/,!1)?e.indentation()+h:e.column()+e.current().length;n.scopes.unshift({offset:i,type:r})}function s(e,t,n){if(n=n||"py",1!=t.scopes.length){if("py"===t.scopes[0].type){for(var r=e.indentation(),i=-1,o=0;o<t.scopes.length;++o)if(r===t.scopes[o].offset){i=o;break}if(-1===i)return!0;for(;t.scopes[0].offset!==r;)t.scopes.shift();return!1}return"py"===n?(t.scopes[0].offset=e.indentation(),!1):t.scopes[0].type!=n?!0:(t.scopes.shift(),!1)}}function l(e,t){z=null;var n=t.tokenize(e,t),r=e.current();if("."===r)return n=e.match(b,!1)?null:c,null===n&&"meta"===t.lastStyle&&(n="meta"),n;if("@"===r)return e.match(b,!1)?"meta":c;"variable"!==n&&"builtin"!==n||"meta"!==t.lastStyle||(n="meta"),("pass"===r||"return"===r)&&(t.dedent+=1),"lambda"===r&&(t.lambda=!0),(":"===r&&!t.lambda&&"py"==t.scopes[0].type||"indent"===z)&&a(e,t);var i="[({".indexOf(r);return-1!==i&&a(e,t,"])}".slice(i,i+1)),"dedent"===z&&s(e,t)?c:(i="])}".indexOf(r),-1!==i&&s(e,t,r)?c:(t.dedent>0&&e.eol()&&"py"==t.scopes[0].type&&(t.scopes.length>1&&t.scopes.shift(),t.dedent-=1),n))}var c="error",p=n.singleOperators||new RegExp("^[\\+\\-\\*/%&|\\^~<>!]"),d=n.singleDelimiters||new RegExp("^[\\(\\)\\[\\]\\{\\}@,:`=;\\.]"),f=n.doubleOperators||new RegExp("^((==)|(!=)|(<=)|(>=)|(<>)|(<<)|(>>)|(//)|(\\*\\*))"),u=n.doubleDelimiters||new RegExp("^((\\+=)|(\\-=)|(\\*=)|(%=)|(/=)|(&=)|(\\|=)|(\\^=))"),m=n.tripleDelimiters||new RegExp("^((//=)|(>>=)|(<<=)|(\\*\\*=))"),b=n.identifiers||new RegExp("^[_A-Za-z][_A-Za-z0-9]*"),h=n.hangingIndent||n.indentUnit,y=r(["and","or","not","is","in"]),x=["as","assert","break","class","continue","def","del","elif","else","except","finally","for","from","global","if","import","lambda","pass","raise","return","try","while","with","yield"],g=["abs","all","any","bin","bool","bytearray","callable","chr","classmethod","compile","complex","delattr","dict","dir","divmod","enumerate","eval","filter","float","format","frozenset","getattr","globals","hasattr","hash","help","hex","id","input","int","isinstance","issubclass","iter","len","list","locals","map","max","memoryview","min","next","object","oct","open","ord","pow","property","range","repr","reversed","round","set","setattr","slice","sorted","staticmethod","str","sum","super","tuple","type","vars","zip","__import__","NotImplemented","Ellipsis","__debug__"],v={builtins:["apply","basestring","buffer","cmp","coerce","execfile","file","intern","long","raw_input","reduce","reload","unichr","unicode","xrange","False","True","None"],keywords:["exec","print"]},k={builtins:["ascii","bytes","exec","print"],keywords:["nonlocal","False","True","None"]};if(void 0!=n.extra_keywords&&(x=x.concat(n.extra_keywords)),void 0!=n.extra_builtins&&(g=g.concat(n.extra_builtins)),n.version&&3===parseInt(n.version,10)){x=x.concat(k.keywords),g=g.concat(k.builtins);var w=new RegExp("^(([rb]|(br))?('{3}|\"{3}|['\"]))","i")}else{x=x.concat(v.keywords),g=g.concat(v.builtins);var w=new RegExp("^(([rub]|(ur)|(br))?('{3}|\"{3}|['\"]))","i")}var E=r(x),_=r(g),z=null,S={startState:function(e){return{tokenize:i,scopes:[{offset:e||0,type:"py"}],lastStyle:null,lastToken:null,lambda:!1,dedent:0}},token:function(e,t){var n=l(e,t);t.lastStyle=n;var r=e.current();return r&&n&&(t.lastToken=r),e.eol()&&t.lambda&&(t.lambda=!1),n},indent:function(t){return t.tokenize!=i?t.tokenize.isString?e.Pass:0:t.scopes[0].offset},lineComment:"#",fold:"indent"};return S}),e.defineMIME("text/x-python","python");var t=function(e){return e.split(" ")};e.defineMIME("text/x-cython",{name:"python",extra_keywords:t("by cdef cimport cpdef ctypedef enum exceptextern gil include nogil property publicreadonly struct union DEF IF ELIF ELSE")})});