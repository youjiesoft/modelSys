jQuery.fn.dataTableExt.oApi.fnPagingInfo=function(i){return{iStart:i._iDisplayStart,iEnd:i.fnDisplayEnd(),iLength:i._iDisplayLength,iTotal:i.fnRecordsTotal(),iFilteredTotal:i.fnRecordsDisplay(),iPage:-1===i._iDisplayLength?0:Math.ceil(i._iDisplayStart/i._iDisplayLength),iTotalPages:-1===i._iDisplayLength?0:Math.ceil(i.fnRecordsDisplay()/i._iDisplayLength)}};