jQuery.fn.dataTableExt.aTypes.unshift(function(r){var n,a="0123456789,.",t=0;"-"===r.charAt(0)&&(t=1);for(var e=t;e<r.length;e++)if(n=r.charAt(e),-1==a.indexOf(n))return null;return"numeric-comma"});