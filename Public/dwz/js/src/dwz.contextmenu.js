!function(i){function n(n,o,c,u){var s=h[n],r=i(DWZ.frag[s.id]);r.find("li").hoverClass(),d.html(r),i.each(s.bindings,function(n,e){i("[rel='"+n+"']",d).bind("click",function(n){t(),e(i(o),i("#"+s.id))})});var a=c.pageX,w=c.pageY;i(window).width()<a+d.width()&&(a-=d.width()),i(window).height()<w+d.height()&&(w-=d.height()),d.css({left:a,top:w}).show(),s.shadow&&e.css({width:d.width(),height:d.height(),left:a+3,top:w+3}).show(),i(document).one("click",t),i.isFunction(s.ctrSub)&&s.ctrSub(i(o),i("#"+s.id))}function t(){d.hide(),e.hide()}var d,e,h;i.fn.extend({contextMenu:function(t,o){var c=i.extend({shadow:!0,bindings:{},ctrSub:null},o);d||(d=i('<div id="contextmenu"></div>').appendTo("body").hide()),e||(e=i('<div id="contextmenuShadow"></div>').appendTo("body").hide()),h=h||[],h.push({id:t,shadow:c.shadow,bindings:c.bindings||{},ctrSub:c.ctrSub});var u=h.length-1;return i(this).bind("contextmenu",function(i){return n(u,this,i,c),!1}),this}})}(jQuery);