jQuery.fn.dataTableExt.oApi.fnDisplayRow=function(a,i){if(-1!=a._iDisplayLength){for(var t=-1,l=0,n=a.aiDisplay.length;n>l;l++)if(a.aoData[a.aiDisplay[l]].nTr==i){t=l;break}t>=0&&(a._iDisplayStart=Math.floor(l/a._iDisplayLength)*a._iDisplayLength,this.oApi._fnCalculateEnd&&this.oApi._fnCalculateEnd(a)),this.oApi._fnDraw(a)}};