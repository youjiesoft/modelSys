!function(t){t.widget("ui.multiselect",{_init:function(){this.element.hide(),this.id=this.element.attr("id"),this.container=t('<div class="ui-multiselect ui-helper-clearfix ui-widget"></div>').insertAfter(this.element),this.count=0,this.selectedContainer=t('<div class="selected"></div>').appendTo(this.container),this.availableContainer=t('<div class="available"></div>').appendTo(this.container),this.selectedActions=t('<div class="actions ui-widget-header ui-helper-clearfix"><span class="count">0 '+t.ui.multiselect.locale.itemsCount+'</span><a href="#" class="remove-all">'+t.ui.multiselect.locale.removeAll+"</a></div>").appendTo(this.selectedContainer),this.availableActions=t('<div class="actions ui-widget-header ui-helper-clearfix"><input type="text" class="search empty ui-widget-content ui-corner-all"/><a href="#" class="add-all">'+t.ui.multiselect.locale.addAll+"</a></div>").appendTo(this.availableContainer),this.selectedList=t('<ul class="selected connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind("selectstart",function(){return!1}).appendTo(this.selectedContainer),this.availableList=t('<ul class="available connected-list"><li class="ui-helper-hidden-accessible"></li></ul>').bind("selectstart",function(){return!1}).appendTo(this.availableContainer);var e=this;this.container.width(this.element.width()+1),this.selectedContainer.width(Math.floor(this.element.width()*this.options.dividerLocation)),this.availableContainer.width(Math.floor(this.element.width()*(1-this.options.dividerLocation))),this.selectedList.height(Math.max(this.element.height()-this.selectedActions.height(),1)),this.availableList.height(Math.max(this.element.height()-this.availableActions.height(),1)),this.options.animated||(this.options.show="show",this.options.hide="hide"),this._populateLists(this.element.find("option")),this.options.sortable&&t("ul.selected").sortable({placeholder:"ui-state-highlight",axis:"y",update:function(i,s){e.selectedList.find("li").each(function(){t(this).data("optionLink")&&t(this).data("optionLink").remove().appendTo(e.element)})},receive:function(i,s){s.item.data("optionLink").attr("selected",!0),e.count+=1,e._updateCount(),e.selectedList.children(".ui-draggable").each(function(){t(this).removeClass("ui-draggable"),t(this).data("optionLink",s.item.data("optionLink")),t(this).data("idx",s.item.data("idx")),e._applyItemState(t(this),!0)}),setTimeout(function(){s.item.remove()},1)}}),this.options.searchable?this._registerSearchEvents(this.availableContainer.find("input.search")):t(".search").hide(),t(".remove-all").click(function(){return e._populateLists(e.element.find("option").removeAttr("selected")),!1}),t(".add-all").click(function(){return e._populateLists(e.element.find("option").attr("selected","selected")),!1})},destroy:function(){this.element.show(),this.container.remove(),t.widget.prototype.destroy.apply(this,arguments)},_populateLists:function(e){this.selectedList.children(".ui-element").remove(),this.availableList.children(".ui-element").remove(),this.count=0;var i=this;t(e.map(function(t){var e=i._getOptionNode(this).appendTo(this.selected?i.selectedList:i.availableList).show();return this.selected&&(i.count+=1),i._applyItemState(e,this.selected),e.data("idx",t),e[0]}));this._updateCount()},_updateCount:function(){this.selectedContainer.find("span.count").text(this.count+" "+t.ui.multiselect.locale.itemsCount)},_getOptionNode:function(e){e=t(e);var i=t('<li class="ui-state-default ui-element" title="'+e.text()+'"><span class="ui-icon"/>'+e.text()+'<a href="#" class="action"><span class="ui-corner-all ui-icon"/></a></li>').hide();return i.data("optionLink",e),i},_cloneWithData:function(t){var e=t.clone();return e.data("optionLink",t.data("optionLink")),e.data("idx",t.data("idx")),e},_setSelected:function(e,i){if(e.data("optionLink").attr("selected",i),i){var s=this._cloneWithData(e);return e[this.options.hide](this.options.animated,function(){t(this).remove()}),s.appendTo(this.selectedList).hide()[this.options.show](this.options.animated),this._applyItemState(s,!0),s}var a=this.availableList.find("li"),n=this.options.nodeComparator,o=null,l=e.data("idx"),d=n(e,t(a[l]));if(d){for(;l>=0&&l<a.length;)if(d>0?l++:l--,d!=n(e,t(a[l]))){o=a[d>0?l:l+1];break}}else o=a[l];var h=this._cloneWithData(e);return o?h.insertBefore(t(o)):h.appendTo(this.availableList),e[this.options.hide](this.options.animated,function(){t(this).remove()}),h.hide()[this.options.show](this.options.animated),this._applyItemState(h,!1),h},_applyItemState:function(t,e){e?(this.options.sortable?t.children("span").addClass("ui-icon-arrowthick-2-n-s").removeClass("ui-helper-hidden").addClass("ui-icon"):t.children("span").removeClass("ui-icon-arrowthick-2-n-s").addClass("ui-helper-hidden").removeClass("ui-icon"),t.find("a.action span").addClass("ui-icon-minus").removeClass("ui-icon-plus"),this._registerRemoveEvents(t.find("a.action"))):(t.children("span").removeClass("ui-icon-arrowthick-2-n-s").addClass("ui-helper-hidden").removeClass("ui-icon"),t.find("a.action span").addClass("ui-icon-plus").removeClass("ui-icon-minus"),this._registerAddEvents(t.find("a.action"))),this._registerHoverEvents(t)},_filter:function(e){var i=t(this),s=e.children("li"),a=s.map(function(){return t(this).text().toLowerCase()}),n=t.trim(i.val().toLowerCase()),o=[];n?(s.hide(),a.each(function(t){this.indexOf(n)>-1&&o.push(t)}),t.each(o,function(){t(s[this]).show()})):s.show()},_registerHoverEvents:function(e){e.removeClass("ui-state-hover"),e.mouseover(function(){t(this).addClass("ui-state-hover")}),e.mouseout(function(){t(this).removeClass("ui-state-hover")})},_registerAddEvents:function(e){var i=this;e.click(function(){i._setSelected(t(this).parent(),!0);return i.count+=1,i._updateCount(),!1}).each(function(){t(this).parent().draggable({connectToSortable:"ul.selected",helper:function(){var e=i._cloneWithData(t(this)).width(t(this).width()-50);return e.width(t(this).width()),e},appendTo:".ui-multiselect",containment:".ui-multiselect",revert:"invalid"})})},_registerRemoveEvents:function(e){var i=this;e.click(function(){return i._setSelected(t(this).parent(),!1),i.count-=1,i._updateCount(),!1})},_registerSearchEvents:function(e){var i=this;e.focus(function(){t(this).addClass("ui-state-active")}).blur(function(){t(this).removeClass("ui-state-active")}).keypress(function(t){return 13==t.keyCode?!1:void 0}).keyup(function(){i._filter.apply(this,[i.availableList])})}}),t.extend(t.ui.multiselect,{defaults:{sortable:!0,searchable:!0,animated:"fast",show:"slideDown",hide:"slideUp",dividerLocation:.6,nodeComparator:function(t,e){var i=t.text(),s=e.text();return i==s?0:s>i?-1:1}},locale:{addAll:"Add all",removeAll:"Remove all",itemsCount:"items selected"}})}(jQuery);