function tableToGrid(t,e){jQuery(t).each(function(){if(!this.grid){jQuery(this).width("99%");var t=jQuery(this).width(),i=jQuery("tr td:first-child input[type=checkbox]:first",jQuery(this)),r=jQuery("tr td:first-child input[type=radio]:first",jQuery(this)),h=i.length>0,u=!h&&r.length>0,s=h||u,l=[],j=[];jQuery("th",jQuery(this)).each(function(){0===l.length&&s?(l.push({name:"__selection__",index:"__selection__",width:0,hidden:!0}),j.push("__selection__")):(l.push({name:jQuery(this).attr("id")||jQuery.trim(jQuery.jgrid.stripHtml(jQuery(this).html())).split(" ").join("_"),index:jQuery(this).attr("id")||jQuery.trim(jQuery.jgrid.stripHtml(jQuery(this).html())).split(" ").join("_"),width:jQuery(this).width()||150}),j.push(jQuery(this).html()))});var n=[],y=[],d=[];jQuery("tbody > tr",jQuery(this)).each(function(){var t={},e=0;jQuery("td",jQuery(this)).each(function(){if(0===e&&s){var i=jQuery("input",jQuery(this)),r=i.attr("value");y.push(r||n.length),i.is(":checked")&&d.push(r),t[l[e].name]=i.attr("value")}else t[l[e].name]=jQuery(this).html();e++}),e>0&&n.push(t)}),jQuery(this).empty(),jQuery(this).addClass("scroll"),jQuery(this).jqGrid(jQuery.extend({datatype:"local",width:t,colNames:j,colModel:l,multiselect:h},e||{}));var a;for(a=0;a<n.length;a++){var Q=null;y.length>0&&(Q=y[a],Q&&Q.replace&&(Q=encodeURIComponent(Q).replace(/[.\-%]/g,"_"))),null===Q&&(Q=a+1),jQuery(this).jqGrid("addRowData",Q,n[a])}for(a=0;a<d.length;a++)jQuery(this).jqGrid("setSelection",d[a])}})}