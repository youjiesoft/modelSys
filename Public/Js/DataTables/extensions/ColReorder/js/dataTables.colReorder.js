!function(t,e,o){function s(t){for(var e=[],o=0,s=t.length;s>o;o++)e[t[o]]=o;return e}function a(t,e,o){var s=t.splice(e,1)[0];t.splice(o,0,s)}function n(t,e,o){for(var s=[],a=0,n=t.childNodes.length;n>a;a++)1==t.childNodes[a].nodeType&&s.push(t.childNodes[a]);var i=s[e];null!==o?t.insertBefore(i,s[o]):t.appendChild(i)}$.fn.dataTableExt.oApi.fnColReorder=function(t,e,o){var i,r,l,d,f,h,u=$.fn.dataTable.Api?!0:!1,c=t.aoColumns.length,g=function(t,e,o){if(t[e]){var s=t[e].split("."),a=s.shift();isNaN(1*a)||(t[e]=o[1*a]+"."+s.join("."))}};if(e!=o){if(0>e||e>=c)return void this.oApi._fnLog(t,1,"ColReorder 'from' index is out of bounds: "+e);if(0>o||o>=c)return void this.oApi._fnLog(t,1,"ColReorder 'to' index is out of bounds: "+o);var m=[];for(i=0,r=c;r>i;i++)m[i]=i;a(m,e,o);var C=s(m);for(i=0,r=t.aaSorting.length;r>i;i++)t.aaSorting[i][0]=C[t.aaSorting[i][0]];if(null!==t.aaSortingFixed)for(i=0,r=t.aaSortingFixed.length;r>i;i++)t.aaSortingFixed[i][0]=C[t.aaSortingFixed[i][0]];for(i=0,r=c;r>i;i++){for(h=t.aoColumns[i],l=0,d=h.aDataSort.length;d>l;l++)h.aDataSort[l]=C[h.aDataSort[l]];u&&(h.idx=C[h.idx])}for(u&&$.each(t.aLastSort,function(e,o){t.aLastSort[e].src=C[o.src]}),i=0,r=c;r>i;i++)h=t.aoColumns[i],"number"==typeof h.mData?(h.mData=C[h.mData],t.oApi._fnColumnOptions(t,i,{})):$.isPlainObject(h.mData)&&(g(h.mData,"_",C),g(h.mData,"filter",C),g(h.mData,"sort",C),g(h.mData,"type",C),t.oApi._fnColumnOptions(t,i,{}));if(t.aoColumns[e].bVisible){var p=this.oApi._fnColumnIndexToVisible(t,e),b=null;for(i=e>o?o:o+1;null===b&&c>i;)b=this.oApi._fnColumnIndexToVisible(t,i),i++;for(f=t.nTHead.getElementsByTagName("tr"),i=0,r=f.length;r>i;i++)n(f[i],p,b);if(null!==t.nTFoot)for(f=t.nTFoot.getElementsByTagName("tr"),i=0,r=f.length;r>i;i++)n(f[i],p,b);for(i=0,r=t.aoData.length;r>i;i++)null!==t.aoData[i].nTr&&n(t.aoData[i].nTr,p,b)}for(a(t.aoColumns,e,o),a(t.aoPreSearchCols,e,o),i=0,r=t.aoData.length;r>i;i++){var T=t.aoData[i];u?(T.anCells&&a(T.anCells,e,o),"dom"!==T.src&&$.isArray(T._aData)&&a(T._aData,e,o)):($.isArray(T._aData)&&a(T._aData,e,o),a(T._anHidden,e,o))}for(i=0,r=t.aoHeader.length;r>i;i++)a(t.aoHeader[i],e,o);if(null!==t.aoFooter)for(i=0,r=t.aoFooter.length;r>i;i++)a(t.aoFooter[i],e,o);if(u){var _=new $.fn.dataTable.Api(t);_.rows().invalidate()}for(i=0,r=c;r>i;i++)$(t.aoColumns[i].nTh).off("click.DT"),this.oApi._fnSortAttachListener(t,t.aoColumns[i].nTh,i);$(t.oInstance).trigger("column-reorder",[t,{iFrom:e,iTo:o,aiInvertMapping:C}])}};var i=function(t,n){"use strict";var i=function(e,o){var s;t.fn.dataTable.Api?s=new t.fn.dataTable.Api(e).settings()[0]:e.fnSettings?s=e.fnSettings():"string"==typeof e?t.fn.dataTable.fnIsDataTable(t(e)[0])&&(s=t(e).eq(0).dataTable().fnSettings()):e.nodeName&&"table"===e.nodeName.toLowerCase()?t.fn.dataTable.fnIsDataTable(e.nodeName)&&(s=t(e.nodeName).dataTable().fnSettings()):e instanceof jQuery?t.fn.dataTable.fnIsDataTable(e[0])&&(s=e.eq(0).dataTable().fnSettings()):s=e;var a=t.fn.dataTable.camelToHungarian;return a&&(a(i.defaults,i.defaults,!0),a(i.defaults,o||{})),this.s={dt:null,init:t.extend(!0,{},i.defaults,o),fixed:0,fixedRight:0,dropCallback:null,mouse:{startX:-1,startY:-1,offsetX:-1,offsetY:-1,target:-1,targetIndex:-1,fromIndex:-1},aoTargets:[]},this.dom={drag:null,pointer:null},this.s.dt=s.oInstance.fnSettings(),this.s.dt._colReorder=this,this._fnConstruct(),s.oApi._fnCallbackReg(s,"aoDestroyCallback",t.proxy(this._fnDestroy,this),"ColReorder"),this};return i.prototype={fnReset:function(){for(var t=[],e=0,o=this.s.dt.aoColumns.length;o>e;e++)t.push(this.s.dt.aoColumns[e]._ColReorder_iOrigCol);return this._fnOrderColumns(t),this},fnGetCurrentOrder:function(){return this.fnOrder()},fnOrder:function(t){if(t===o){for(var e=[],a=0,n=this.s.dt.aoColumns.length;n>a;a++)e.push(this.s.dt.aoColumns[a]._ColReorder_iOrigCol);return e}return this._fnOrderColumns(s(t)),this},_fnConstruct:function(){var t,e=this,o=this.s.dt.aoColumns.length;for(this.s.init.iFixedColumns&&(this.s.fixed=this.s.init.iFixedColumns),this.s.fixedRight=this.s.init.iFixedColumnsRight?this.s.init.iFixedColumnsRight:0,this.s.init.fnReorderCallback&&(this.s.dropCallback=this.s.init.fnReorderCallback),t=0;o>t;t++)t>this.s.fixed-1&&t<o-this.s.fixedRight&&this._fnMouseListener(t,this.s.dt.aoColumns[t].nTh),this.s.dt.aoColumns[t]._ColReorder_iOrigCol=t;this.s.dt.oApi._fnCallbackReg(this.s.dt,"aoStateSaveParams",function(t,o){e._fnStateSave.call(e,o)},"ColReorder_State");var a=null;if(this.s.init.aiOrder&&(a=this.s.init.aiOrder.slice()),this.s.dt.oLoadedState&&"undefined"!=typeof this.s.dt.oLoadedState.ColReorder&&this.s.dt.oLoadedState.ColReorder.length==this.s.dt.aoColumns.length&&(a=this.s.dt.oLoadedState.ColReorder),a)if(e.s.dt._bInitComplete){var n=s(a);e._fnOrderColumns.call(e,n)}else{var i=!1;this.s.dt.aoDrawCallback.push({fn:function(){if(!e.s.dt._bInitComplete&&!i){i=!0;var t=s(a);e._fnOrderColumns.call(e,t)}},sName:"ColReorder_Pre"})}else this._fnSetColumnIndexes()},_fnOrderColumns:function(e){if(e.length!=this.s.dt.aoColumns.length)return void this.s.dt.oInstance.oApi._fnLog(this.s.dt,1,"ColReorder - array reorder does not match known number of columns. Skipping.");for(var o=0,s=e.length;s>o;o++){var n=t.inArray(o,e);o!=n&&(a(e,n,o),this.s.dt.oInstance.fnColReorder(n,o))}(""!==this.s.dt.oScroll.sX||""!==this.s.dt.oScroll.sY)&&this.s.dt.oInstance.fnAdjustColumnSizing(),this.s.dt.oInstance.oApi._fnSaveState(this.s.dt),this._fnSetColumnIndexes()},_fnStateSave:function(e){var o,s,a,n=this.s.dt,i=n.aoColumns;if(e.ColReorder=[],e.aaSorting){for(o=0;o<e.aaSorting.length;o++)e.aaSorting[o][0]=i[e.aaSorting[o][0]]._ColReorder_iOrigCol;var r=t.extend(!0,[],e.aoSearchCols);for(o=0,s=i.length;s>o;o++)a=i[o]._ColReorder_iOrigCol,e.aoSearchCols[a]=r[o],e.abVisCols[a]=i[o].bVisible,e.ColReorder.push(a)}else if(e.order){for(o=0;o<e.order.length;o++)e.order[o][0]=i[e.order[o][0]]._ColReorder_iOrigCol;var l=t.extend(!0,[],e.columns);for(o=0,s=i.length;s>o;o++)a=i[o]._ColReorder_iOrigCol,e.columns[a]=l[o],e.ColReorder.push(a)}},_fnMouseListener:function(e,o){var s=this;t(o).on("mousedown.ColReorder",function(t){t.preventDefault(),s._fnMouseDown.call(s,t,o)})},_fnMouseDown:function(s,a){var n=this,i=t(s.target).closest("th, td"),r=i.offset(),l=parseInt(t(a).attr("data-column-index"),10);l!==o&&(this.s.mouse.startX=s.pageX,this.s.mouse.startY=s.pageY,this.s.mouse.offsetX=s.pageX-r.left,this.s.mouse.offsetY=s.pageY-r.top,this.s.mouse.target=this.s.dt.aoColumns[l].nTh,this.s.mouse.targetIndex=l,this.s.mouse.fromIndex=l,this._fnRegions(),t(e).on("mousemove.ColReorder",function(t){n._fnMouseMove.call(n,t)}).on("mouseup.ColReorder",function(t){n._fnMouseUp.call(n,t)}))},_fnMouseMove:function(t){if(null===this.dom.drag){if(Math.pow(Math.pow(t.pageX-this.s.mouse.startX,2)+Math.pow(t.pageY-this.s.mouse.startY,2),.5)<5)return;this._fnCreateDragNode()}this.dom.drag.css({left:t.pageX-this.s.mouse.offsetX,top:t.pageY-this.s.mouse.offsetY});for(var e=!1,o=this.s.mouse.toIndex,s=1,a=this.s.aoTargets.length;a>s;s++)if(t.pageX<this.s.aoTargets[s-1].x+(this.s.aoTargets[s].x-this.s.aoTargets[s-1].x)/2){this.dom.pointer.css("left",this.s.aoTargets[s-1].x),this.s.mouse.toIndex=this.s.aoTargets[s-1].to,e=!0;break}e||(this.dom.pointer.css("left",this.s.aoTargets[this.s.aoTargets.length-1].x),this.s.mouse.toIndex=this.s.aoTargets[this.s.aoTargets.length-1].to),this.s.init.bRealtime&&o!==this.s.mouse.toIndex&&(this.s.dt.oInstance.fnColReorder(this.s.mouse.fromIndex,this.s.mouse.toIndex),this.s.mouse.fromIndex=this.s.mouse.toIndex,this._fnRegions())},_fnMouseUp:function(o){t(e).off("mousemove.ColReorder mouseup.ColReorder"),null!==this.dom.drag&&(this.dom.drag.remove(),this.dom.pointer.remove(),this.dom.drag=null,this.dom.pointer=null,this.s.dt.oInstance.fnColReorder(this.s.mouse.fromIndex,this.s.mouse.toIndex),this._fnSetColumnIndexes(),(""!==this.s.dt.oScroll.sX||""!==this.s.dt.oScroll.sY)&&this.s.dt.oInstance.fnAdjustColumnSizing(),null!==this.s.dropCallback&&this.s.dropCallback.call(this),this.s.dt.oInstance.oApi._fnSaveState(this.s.dt))},_fnRegions:function(){var e=this.s.dt.aoColumns;this.s.aoTargets.splice(0,this.s.aoTargets.length),this.s.aoTargets.push({x:t(this.s.dt.nTable).offset().left,to:0});for(var o=0,s=0,a=e.length;a>s;s++)s!=this.s.mouse.fromIndex&&o++,e[s].bVisible&&this.s.aoTargets.push({x:t(e[s].nTh).offset().left+t(e[s].nTh).outerWidth(),to:o});0!==this.s.fixedRight&&this.s.aoTargets.splice(this.s.aoTargets.length-this.s.fixedRight),0!==this.s.fixed&&this.s.aoTargets.splice(0,this.s.fixed)},_fnCreateDragNode:function(){var e=""!==this.s.dt.oScroll.sX||""!==this.s.dt.oScroll.sY,o=this.s.dt.aoColumns[this.s.mouse.targetIndex].nTh,s=o.parentNode,a=s.parentNode,n=a.parentNode,i=t(o).clone();this.dom.drag=t(n.cloneNode(!1)).addClass("DTCR_clonedTable").append(a.cloneNode(!1).appendChild(s.cloneNode(!1).appendChild(i[0]))).css({position:"absolute",top:0,left:0,width:t(o).outerWidth(),height:t(o).outerHeight()}).appendTo("body"),this.dom.pointer=t("<div></div>").addClass("DTCR_pointer").css({position:"absolute",top:e?t("div.dataTables_scroll",this.s.dt.nTableWrapper).offset().top:t(this.s.dt.nTable).offset().top,height:e?t("div.dataTables_scroll",this.s.dt.nTableWrapper).height():t(this.s.dt.nTable).height()}).appendTo("body")},_fnDestroy:function(){var e,o;for(e=0,o=this.s.dt.aoDrawCallback.length;o>e;e++)if("ColReorder_Pre"===this.s.dt.aoDrawCallback[e].sName){this.s.dt.aoDrawCallback.splice(e,1);break}t(this.s.dt.nTHead).find("*").off(".ColReorder"),t.each(this.s.dt.aoColumns,function(e,o){t(o.nTh).removeAttr("data-column-index")}),this.s.dt._colReorder=null,this.s=null},_fnSetColumnIndexes:function(){t.each(this.s.dt.aoColumns,function(e,o){t(o.nTh).attr("data-column-index",e)})}},i.defaults={aiOrder:null,bRealtime:!1,iFixedColumns:0,iFixedColumnsRight:0,fnReorderCallback:null},i.version="1.1.2",t.fn.dataTable.ColReorder=i,t.fn.DataTable.ColReorder=i,"function"==typeof t.fn.dataTable&&"function"==typeof t.fn.dataTableExt.fnVersionCheck&&t.fn.dataTableExt.fnVersionCheck("1.9.3")?t.fn.dataTableExt.aoFeatures.push({fnInit:function(t){var e=t.oInstance;if(t._colReorder)e.oApi._fnLog(t,1,"ColReorder attempted to initialise twice. Ignoring second");else{var o=t.oInit,s=o.colReorder||o.oColReorder||{};new i(t,s)}return null},cFeature:"R",sFeature:"ColReorder"}):alert("Warning: ColReorder requires DataTables 1.9.3 or greater - www.datatables.net/download"),t.fn.dataTable.Api&&(t.fn.dataTable.Api.register("colReorder.reset()",function(){return this.iterator("table",function(t){t._colReorder.fnReset()})}),t.fn.dataTable.Api.register("colReorder.order()",function(t){return t?this.iterator("table",function(e){e._colReorder.fnOrder(t)}):this.context.length?this.context[0]._colReorder.fnOrder():null})),i};"function"==typeof define&&define.amd?define(["jquery","datatables"],i):"object"==typeof exports?i(require("jquery"),require("datatables")):jQuery&&!jQuery.fn.dataTable.ColReorder&&i(jQuery,jQuery.fn.dataTable)}(window,document);