!function(t){t.pdialog={_op:{height:300,width:580,minH:40,minW:50,total:20,max:!1,mask:!1,resizable:!0,drawable:!0,maxable:!0,minable:!0,fresh:!0},_current:null,_zIndex:42,getCurrent:function(){return this._current},reload:function(i,e){var a=t.extend({data:{},dialogId:"",callback:null},e),o=a.dialogId&&t("body").data(a.dialogId)||this._current;if(o){var d=o.find(".dialogContent");d.ajaxUrl({type:"POST",url:i,data:a.data,callback:function(i){d.find("[layoutH]").layoutH(d),t(".pageContent",o).width(t(o).width()-14),t(":button.close",o).click(function(){return t.pdialog.close(o),!1}),t.isFunction(a.callback)&&a.callback(i)}})}},open:function(i,e,a,o){var d=t.extend({},t.pdialog._op,o),n=t("body").data(e);if(n){if(n.is(":hidden")&&n.show(),d.fresh||i!=t(n).data("url")){n.data("url",i),n.find(".dialogHeader").find("h1").html(a),this.switchDialog(n);var s=n.find(".dialogContent");s.loadUrl(i,{},function(){s.find("[layoutH]").layoutH(s),t(".pageContent",n).width(t(n).width()-14),t("button.close").click(function(){return t.pdialog.close(n),!1})})}}else{t("body").append(DWZ.frag.dialogFrag),n=t(">.dialog:last-child","body"),n.data("id",e),n.data("url",i),o.close&&n.data("close",o.close),o.param&&n.data("param",o.param),t.fn.bgiframe&&n.bgiframe(),n.find(".dialogHeader").find("h1").html(a),t(n).css("zIndex",t.pdialog._zIndex+=2),t("div.shadow").css("zIndex",t.pdialog._zIndex-3).show(),t.pdialog._init(n,o),t(n).click(function(){t.pdialog.switchDialog(n)}),d.resizable&&n.jresize(),d.drawable&&n.dialogDrag(),t("a.close",n).click(function(i){return t.pdialog.close(n),!1}),d.maxable?t("a.maximize",n).show().click(function(i){return t.pdialog.switchDialog(n),t.pdialog.maxsize(n),n.jresize("destroy").dialogDrag("destroy"),!1}):t("a.maximize",n).hide(),t("a.restore",n).click(function(i){return t.pdialog.restore(n),n.jresize().dialogDrag(),!1}),d.minable?t("a.minimize",n).show().click(function(i){return t.pdialog.minimize(n),!1}):t("a.minimize",n).hide(),t("div.dialogHeader a",n).mousedown(function(){return!1}),t("div.dialogHeader",n).dblclick(function(){t("a.restore",n).is(":hidden")?t("a.maximize",n).trigger("click"):t("a.restore",n).trigger("click")}),d.max&&(t.pdialog.maxsize(n),n.jresize("destroy").dialogDrag("destroy")),t("body").data(e,n),t.pdialog._current=n,t.pdialog.attachShadow(n);var s=t(".dialogContent",n);s.loadUrl(i,{},function(){s.find("[layoutH]").layoutH(s),t(".pageContent",n).width(t(n).width()-14),t("button.close").click(function(){return t.pdialog.close(n),!1})})}d.mask?(t(n).css("zIndex",1e3),t("a.minimize",n).hide(),t(n).data("mask",!0),t("#dialogBackground").show()):d.minable&&t.taskBar.addDialog(e,a)},switchDialog:function(i){var e=t(i).css("zIndex");if(t.pdialog.attachShadow(i),t.pdialog._current){var a=t(t.pdialog._current).css("zIndex");t(t.pdialog._current).css("zIndex",e),t(i).css("zIndex",a),t("div.shadow").css("zIndex",a-1),t.pdialog._current=i}t.taskBar.switchTask(i.data("id"))},attachShadow:function(i){var e=t("div.shadow");e.is(":hidden")&&e.show(),e.css({top:parseInt(t(i)[0].style.top)-2,left:parseInt(t(i)[0].style.left)-4,height:parseInt(t(i).height())+8,width:parseInt(t(i).width())+8,zIndex:parseInt(t(i).css("zIndex"))-1}),t(".shadow_c",e).children().andSelf().each(function(){t(this).css("height",t(i).outerHeight()-4)})},_init:function(i,e){var a=t.extend({},this._op,e),o=a.height>a.minH?a.height:a.minH,d=a.width>a.minW?a.width:a.minW;(isNaN(i.height())||i.height()<o)&&(t(i).height(o+"px"),t(".dialogContent",i).height(o-t(".dialogHeader",i).outerHeight()-t(".dialogFooter",i).outerHeight()-6)),(isNaN(i.css("width"))||i.width()<d)&&t(i).width(d+"px");var n=(t(window).height()-i.height())/2;i.css({left:(t(window).width()-i.width())/2,top:n>0?n:0})},initResize:function(i,e,a){t("body").css("cursor",a+"-resize"),i.css({top:t(e).css("top"),left:t(e).css("left"),height:t(e).css("height"),width:t(e).css("width")}),i.show()},repaint:function(i,e){var a=t("div.shadow");"w"!=i&&"e"!=i&&(a.css("height",a.outerHeight()+e.tmove),t(".shadow_c",a).children().andSelf().each(function(){t(this).css("height",t(this).outerHeight()+e.tmove)})),("n"==i||"nw"==i||"ne"==i)&&a.css("top",e.otop-2),!e.owidth||"n"==i&&"s"==i||a.css("width",e.owidth+8),i.indexOf("w")>=0&&a.css("left",e.oleft-4)},resizeTool:function(i,e,a){t("div[class^='resizable']",a).filter(function(){return"w"==t(this).attr("tar")||"e"==t(this).attr("tar")}).each(function(){t(this).css("height",t(this).outerHeight()+e)})},resizeDialog:function(i,e,a){var o=parseInt(i.style.left),d=parseInt(i.style.top),n=parseInt(i.style.height),s=parseInt(i.style.width);if("n"==a||"nw"==a?tmove=parseInt(t(e).css("top"))-d:tmove=n-parseInt(t(e).css("height")),t(e).css({left:o,width:s,top:d,height:n}),t(".dialogContent",e).css("width",s-12+"px"),t(".pageContent",e).css("width",s-14+"px"),"w"!=a&&"e"!=a){var r=t(".dialogContent",e);r.css({height:n-t(".dialogHeader",e).outerHeight()-t(".dialogFooter",e).outerHeight()-6}),r.find("[layoutH]").layoutH(r),t.pdialog.resizeTool(a,tmove,e)}t.pdialog.repaint(a,{oleft:o,otop:d,tmove:tmove,owidth:s}),t(window).trigger("resizeGrid")},close:function(i){"string"==typeof i&&(i=t("body").data(i));var e=i.data("close"),a=!0;if(e&&t.isFunction(e)){var o=i.data("param");if(o&&""!=o?(o=DWZ.jsonEval(o),a=e(o)):a=e(),!a)return}t.fn.xheditor&&t("textarea.editor",i).xheditor(!1),t(i).unbind("click").hide(),t("div.dialogContent",i).html(""),t("div.shadow").hide(),t(i).data("mask")?t("#dialogBackground").hide():t.taskBar.closeDialog(t(i).data("id")),t("body").removeData(t(i).data("id")),t(i).remove()},closeCurrent:function(){this.close(t.pdialog._current)},checkTimeout:function(){var i=t(".dialogContent",t.pdialog._current),e=DWZ.jsonEval(i.html());e&&e.statusCode==DWZ.statusCode.timeout&&this.closeCurrent()},maxsize:function(i){t(i).data("original",{top:t(i).css("top"),left:t(i).css("left"),width:t(i).css("width"),height:t(i).css("height")}),t("a.maximize",i).hide(),t("a.restore",i).show();var e=t(window).width(),a=t(window).height()-34;t(i).css({top:"0px",left:"0px",width:e+"px",height:a+"px"}),t.pdialog._resizeContent(i,e,a)},restore:function(i){var e=t(i).data("original"),a=parseInt(e.width),o=parseInt(e.height);t(i).css({top:e.top,left:e.left,width:a,height:o}),t.pdialog._resizeContent(i,a,o),t("a.maximize",i).show(),t("a.restore",i).hide(),t.pdialog.attachShadow(i)},minimize:function(i){t(i).hide(),t("div.shadow").hide();var e=t.taskBar.getTask(t(i).data("id"));t(".resizable").css({top:t(i).css("top"),left:t(i).css("left"),height:t(i).css("height"),width:t(i).css("width")}).show().animate({top:t(window).height()-60,left:e.position().left,width:e.outerWidth(),height:e.outerHeight()},250,function(){t(this).hide(),t.taskBar.inactive(t(i).data("id"))})},_resizeContent:function(i,e,a){var o=t(".dialogContent",i);o.css({width:e-12+"px",height:a-t(".dialogHeader",i).outerHeight()-t(".dialogFooter",i).outerHeight()-6}),o.find("[layoutH]").layoutH(o),t(".pageContent",i).css("width",e-14+"px"),t(window).trigger("resizeGrid")}}}(jQuery);