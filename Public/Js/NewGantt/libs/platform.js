function nearBestPosition(e,r,t){var i=e,n=r;if("object"!=typeof e&&(i=$("#"+e)),"object"!=typeof r&&(n=$("#"+r)),i){n.css("visibility","hidden");var o=!1;n.parents().each(function(){"static"!=$(this).css("position")&&(o=!0)});var a=o?i.position().left:i.offset().left,s=o?i.position().top:i.offset().top,l=i.outerHeight(),u=parseFloat(l);if(t){var c=parseFloat(i.outerWidth()),f=parseFloat(n.outerWidth());a+=(c-f)/2}s+=parseFloat(u);var d=a,p=s,h=$.browser.msie?45:35,g=$.browser.msie?20:0;a&&s&&(n.css("left",d),n.css("top",p)),n.offset().left>=$(window).width()-n.outerWidth()&&(d=$(window).width()-n.outerWidth()-g+"px",n.css("left",d)),n.offset().left<0&&(d="0px",n.css("left",d)),n.offset().top+n.outerHeight()>=$(window).height()-h&&n.outerHeight()<$(window).height()&&n.css("margin-top",-(i.outerHeight()+n.outerHeight())+"px"),n.css("visibility","visible")}}function transformToPrintable(e){for(var r in e){var t=e[r];"string"==typeof t&&(e[r]=(t+"").replace(/\n/g,"<br>"))}return e}function isValidURL(e){var r=/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;return r.test(e)}function isValidEmail(e){var r=/^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/;return r.test(e)}function isValidInteger(e){return reg=new RegExp("^[-+]{0,1}[0-9]*$"),reg.test(e)}function isValidDouble(e){var r=Number.decimalSeparator;return reg=new RegExp("^[-+]{0,1}[0-9]*["+r+"]{0,1}[0-9]*$"),reg.test(e)}function isValidTime(e){return!isNaN(millisFromHourMinute(e))}function isValidDurationDays(e){return!isNaN(daysFromString(e))}function isValidDurationMillis(e){return!isNaN(millisFromString(e))}function isValidDurationMillis(e){return!isNaN(millisFromString(e))}function isValidCurrency(e){for(var r="",t=Number.currencyFormat+"",i=!1,n=!1,o="",a="[0-9\\"+Number.groupingSeparator+"]+[\\"+Number.decimalSeparator+"]?[0-9]*",s=0;s<t.length;s++){var l=t.charAt(s);"."==l||","==l||"0"==l?""!=o&&(r=r+"(?:"+RegExp.quote(o)+")?",o=""):"#"==l?(""!=o&&(r=r+"(?:"+RegExp.quote(o)+")?",o=""),n||(n=!0,r+=a)):"-"==l?(""!=o&&(r=r+"(?:"+RegExp.quote(o)+")?",o=""),i||(i=!0,r+="[-]?")):o+=l}i||(r="[-]?"+r),""!=o&&(r=r+"(?:"+RegExp.quote(o)+")?"),r="^"+r+"$";var u=new RegExp(r);return u.test(e)}function getCurrencyValue(e){return isValidCurrency(e)?parseFloat(e.replaceAll(Number.groupingSeparator,"").replaceAll(Number.decimalSeparator,".").replace(/[^0123456789.]/,"")):NaN}function formatCurrency(e){return formatNumber(e,Number.currencyFormat)}function formatNumber(e,r){r||(r="##0.00");for(var t=Number.decimalSeparator,i=Number.groupingSeparator,n=Number.minusSign,o=!0,a="0#-,.",s="",l=!1,u=0;u<r.length;u++)if(-1==a.indexOf(r.charAt(u)))s+=r.charAt(u);else{if(0!=u||"-"!=r.charAt(u))break;l=!0}for(var c="",u=r.length-1;u>=0&&-1==a.indexOf(r.charAt(u));u--)c=r.charAt(u)+c;r=r.substring(s.length),r=r.substring(0,r.length-c.length);var f=new Number(e),d=!1;isNaN(f)&&(f=0,d=!0),"%"==c&&(f=100*f);var p="";if(r.indexOf(".")>-1){var h=t,g=r.substring(r.lastIndexOf(".")+1);if(o)f=new Number(f.toFixed(g.length));else{var m=f.toString();m=m.substring(0,m.lastIndexOf(".")+g.length+1),f=new Number(m)}var v=f%1,b=new String(v.toFixed(g.length));b=b.substring(b.lastIndexOf(".")+1);for(var u=0;u<g.length;u++)if("#"==g.charAt(u)&&"0"!=b.charAt(u))h+=b.charAt(u);else if("#"==g.charAt(u)&&"0"==b.charAt(u)){var w=b.substring(u);if(!w.match("[1-9]"))break;h+=b.charAt(u)}else"0"==g.charAt(u)&&(h+=b.charAt(u));p+=h}else f=Math.round(f);var x=Math.floor(f);0>f&&(x=Math.ceil(f));var y="";y=-1==r.indexOf(".")?r:r.substring(0,r.indexOf("."));var $="";if(0!=x||"#"!=y.substr(y.length-1)||d){var _=new String(Math.abs(x)),k=9999;-1!=y.lastIndexOf(",")&&(k=y.length-y.lastIndexOf(",")-1);for(var I=0,u=_.length-1;u>-1;u--)$=_.charAt(u)+$,I++,I==k&&0!=u&&($=i+$,I=0);if(y.length>$.length){var A=y.indexOf("0");if(-1!=A)for(var E=y.length-A,D=y.length-$.length-1;$.length<E;){var N=y.charAt(D);","==N&&(N=i),$=N+$,D--}}}return $||-1===y.indexOf("0",y.length-1)||($="0"),p=$+p,0>f&&l&&s.length>0?s=n+s:0>f&&(p=n+p),p.lastIndexOf(t)==p.length-1&&(p=p.substring(0,p.length-1)),p=s+p+c}function pad(e,r,t){return(e+"").length<r?new Array(r-(""+e).length+1).join(t)+e:e}function getMillisInHours(e){if(!e)return"";var r=e>=0?1:-1,t=Math.floor(e/36e5);return(r>0?"":"-")+pad(t,2,"0")}function getMillisInHoursMinutes(e){if("number"!=typeof e)return"";var r=e>=0?1:-1;e=Math.abs(e);var t=Math.floor(e/36e5),i=Math.floor(e%36e5/6e4);return(r>0?"":"-")+pad(t,1,"0")+":"+pad(i,2,"0")}function getMillisInDaysHoursMinutes(e){if(!e)return"";var r=e>=0?1:-1;e=Math.abs(e);var t=Math.floor(e/millisInWorkingDay),i=Math.floor(e%millisInWorkingDay/36e5),n=Math.floor((e-t*millisInWorkingDay-36e5*i)/6e4);return(r>=0?"":"-")+(t>0?t+"  ":"")+pad(i,1,"0")+":"+pad(n,2,"0")}function millisFromHourMinute(e){var r=0;e.replace(",",".");var t=e.indexOf(":"),i=e.indexOf(".");if(0>t&&0>i&&e.length>5)return parseInt(e,10);if(i>-1){var n=parseFloat(e);r=36e5*n}else{var o=0,a=0;-1==t?o=parseInt(e,10):(o=parseInt(e.substring(0,t),10),a=parseInt(e.substring(t+1),10)),r=36e5*o+6e4*a}return"number"!=typeof r&&(r=NaN),r}function millisFromString(e,r){if(!e)return 0;var t=new RegExp("(\\d+[Yy])|(\\d+[M])|(\\d+[Ww])|(\\d+[Dd])|(\\d+[Hh])|(\\d+[m])|(\\d+[Ss])|(\\d+:\\d+)|(:\\d+)|(\\d*[\\.,]\\d+)|(\\d+)","g"),i=t.exec(e),n=0;if(!i)return NaN;for(;null!=i;){for(var o=1;o<i.length;o++){var a=i[o];if(a){var s=0;try{s=parseInt(a)}catch(l){}1==o?n+=s*(r?millisInWorkingDay*workingDaysPerWeek*52:31536e6):2==o?n+=s*(r?millisInWorkingDay*workingDaysPerWeek*4:2592e6):3==o?n+=s*(r?millisInWorkingDay*workingDaysPerWeek:6048e5):4==o?n+=s*(r?millisInWorkingDay:864e5):5==o?n+=36e5*s:6==o?n+=6e4*s:7==o?n+=1e3*s:8==o?n+=millisFromHourMinute(a):9==o?n+=millisFromHourMinute(a):10==o?n+=millisFromHourMinute(a):11==o&&(n+=36e5*s)}}i=t.exec(e)}return n}function daysFromString(e,r){if(!e)return void 0;var t=new RegExp("(\\d+[Yy])|(\\d+[Mm])|(\\d+[Ww])|(\\d+[Dd])|(\\d*[\\.,]\\d+)|(\\d+)","g"),i=t.exec(e),n=0;if(!i)return NaN;for(;null!=i;){for(var o=1;o<i.length;o++){var a=i[o];if(a){var s=0;try{s=parseInt(a)}catch(l){}1==o?n+=s*(r?52*workingDaysPerWeek:365):2==o?n+=s*(r?4*workingDaysPerWeek:30):3==o?n+=s*(r?workingDaysPerWeek:7):4==o?n+=s:5==o?n+=s:6==o&&(n+=s)}}i=t.exec(e)}return n}function stopBubble(e){return $.browser.msie&&event?(event.cancelBubble=!0,event.returnValue=!1):e&&(e.stopPropagation(),e.preventDefault()),!1}function validateField(e){var r=$(this),t=!0;r.clearErrorAlert();var i=r.val();if(i){var n=r.attr("entryType").toUpperCase();"INTEGER"==n?t=isValidInteger(i):"DOUBLE"==n?t=isValidDouble(i):"PERCENTILE"==n?t=isValidDouble(i):"URL"==n?t=isValidURL(i):"EMAIL"==n?t=isValidEmail(i):"DURATIONMILLIS"==n?t=isValidDurationMillis(i):"DURATIONDAYS"==n?t=isValidDurationDays(i):"DATE"==n?t=Date.isValid(i,r.attr("format")):"TIME"==n?t=isValidTime(i):"CURRENCY"==n&&(t=isValidCurrency(i)),t||r.createErrorAlert(i18n.ERROR_ON_FIELD,i18n.INVALID_DATA)}return t}function jsonErrorHandling(e){if(!e.ok){e.message&&alert("ERROR:\n"+e.message);for(var r in e.clientEntryErrors){var t=e.clientEntryErrors[r];$(":input[name="+t.name+"]").createErrorAlert(t.error)}}}function Profiler(e){this.startTime=(new Date).getTime(),this.name=e,this.stop=function(){__profiler[this.name]||(__profiler[this.name]={millis:0,count:0}),__profiler[this.name].millis+=(new Date).getTime()-this.startTime,__profiler[this.name].count++},this.display=function(){console.debug(__profiler[this.name])},this.reset=function(){delete __profiler[this.name]}}function openBlackPopup(e,r,t,i,n){n||(n="bwinPopup"),r||(r="900px"),t||(t="730px"),$("#__blackpopup__").remove();var o=$("<div>").attr("id","__blackpopup__");o.css({position:"fixed",top:0,left:0,width:"100%",height:"100%",textAlign:"center"}),window.name!=n&&o.css({backgroundImage:"url('"+contextPath+"/applications/teamwork/images/black_70.png')"}),o.append("<iframe id='"+n+"' name='"+n+"' frameborder='0'></iframe>"),o.bringToFront(),o.bind("close",function(){o.slideUp(300,function(){o.remove(),"function"==typeof i&&i()})}),o.bind("destroy",function(){o.remove()}),o.find("iframe:first").attr("src",e).css({width:r,height:t,top:100,border:"8px solid #909090",backgroundColor:"#ffffff"});var a=$("<div>").css({width:r,position:"relative",height:"5px",textAlign:"right",margin:"auto"});a.append("<img src=\"res/closeBig.png\" style='cursor:pointer;position:absolute;right:-40px;top:30px;'>"),a.find("img:first").click(function(){o.trigger("close")}),o.prepend(a),$("body").append(o)}function createBlackPage(e,r,t){e||(e="900px"),r||(r="730px"),$("#__blackpopup__").remove();var i=$("<div>").attr("id","__blackpopup__");i.css({position:"fixed",top:"0px",paddingTop:"50px",left:0,width:"100%",height:"100%",backgroundImage:"url('res/img/black_70.png')"}),i.append("<div id='bwinPopupd' name='bwinPopupd'></div>"),i.bringToFront();var n=i.find("#bwinPopupd");n.css({width:e,height:r,top:10,"-moz-box-shadow":"1px 1px 6px #333333",overflow:"auto","-webkit-box-shadow":"1px 1px 6px #333333",border:"8px solid #777",backgroundColor:"#fff",margin:"auto"});var o=$("<div>").css({width:e,position:"relative",height:"0px",textAlign:"right",margin:"auto"}),a=$("<img src='res/closeBig.png' style='cursor:pointer;position:absolute;right:-40px;top:5px;' title='close'>");return o.append(a),a.click(function(){i.trigger("close")}),i.prepend(o),$("body").append(i),i.bind("close",function(){i.slideUp(300,function(){i.remove(),"function"==typeof t&&t()})}),i.bind("destroy",function(){i.remove()}),n}function getBlackPopup(){var e=$("#__blackpopup__");return"undefined"!=typeof top&&(e=window.parent.$("#__blackpopup__")),e}function closeBlackPopup(){getBlackPopup().trigger("close")}function openIssueEditorInBlack(e,r,t){r||(r="ED");var i=contextPath+"/applications/teamwork/issue/issueEditor.jsp?CM="+r+"&OBJID="+e;t&&(i+=t),openBlackPopup(i,1020,$(window).height()-50,function(){$("#"+e).effect("highlight",{color:"yellow"},1500)})}function openBoardInBlack(e,r,t,i){r||(r="ED");var n=contextPath+"/applications/teamwork/board/boardEditor.jsp?CM="+r+"&OBJID="+e;t&&(n+=t),openBlackPopup(n,$(window).width()-100,$(window).height()-50,i)}window.console||(window.console=new function(){this.log=function(e){},this.debug=function(e){},this.error=function(e){}}),window.console.debug&&window.console.error&&window.console.log||(window.console=new function(){this.log=function(e){},this.debug=function(e){},this.error=function(e){}}),$.fn.bringToFront=function(e){var r=10,t=e?$(e):$("*");return t.each(function(){if("static"!=$(this).css("position")){var e=parseInt($(this).css("zIndex"));r=e>r?parseInt($(this).css("zIndex")):r}}),$(this).css("zIndex",r+=10)},String.prototype.trim=function(){return this.replace(/^\s*(\S*(\s+\S+)*)\s*$/,"$1")},String.prototype.startsWith=function(e,r){return r?e.toLowerCase()==this.substring(0,e.length).toLowerCase():e==this.substring(0,e.length)},String.prototype.endsWith=function(e,r){return r?e.toLowerCase()==this.substring(this.length-e.length).toLowerCase():e==this.substring(this.length-e.length)},String.prototype.asId=function(){return this.replace(/[^a-zA-Z0-9_]+/g,"")},String.prototype.replaceAll=function(e,r){return this.replace(new RegExp(RegExp.quote(e),"g"),r)},Array.prototype.indexOf||(Array.prototype.indexOf=function(e,r){if(null==this)throw new TypeError;var t=Object(this),i=t.length>>>0;if(0===i)return-1;var n=0;if(arguments.length>0&&(n=Number(arguments[1]),n!=n?n=0:0!=n&&n!=1/0&&n!=-(1/0)&&(n=(n>0||-1)*Math.floor(Math.abs(n)))),n>=i)return-1;for(var o=n>=0?n:Math.max(i-Math.abs(n),0);i>o;o++)if(o in t&&t[o]===e)return o;return-1}),Object.size=function(e){var r,t=0;for(r in e)e.hasOwnProperty(r)&&t++;return t},RegExp.quote=function(e){return e.replace(/([.?*+^$[\]\\(){}-])/g,"\\$1")},jQuery.fn.clearErrorAlert=function(){return this.each(function(){var e=$(this);e.removeAttr("invalid").removeClass("formElementsError"),$("#"+e.attr("id")+"error").remove()}),this},jQuery.fn.createErrorAlert=function(e,r){return this.each(function(){var t=$(this);if(t.attr("invalid","true").addClass("formElementsError"),$("#"+t.attr("id")+"error").size()<=0){var i=(e?e:"")+": "+(r?r:""),n="<img width='17' heigh='17' id=\""+t.attr("id")+"error\" error='1'";n+=" onclick=\"alert($(this).attr('title'))\" border='0' align='absmiddle'>",n=$(n),n.attr("title",i).attr("src","res/alert.gif"),t.after(n)}}),this},jQuery.fn.updateOldValue=function(){return this.each(function(){var e=$(this);e.data("_oldvalue",e.val())}),this},jQuery.fn.isValueChanged=function(){var e=!1;return this.each(function(){var r=$(this);return r.val()+""!=r.data("_oldvalue")+""?(e=!0,!1):void 0}),e},jQuery.fn.getOldValue=function(){return $(this).data("_oldvalue")},$.fn.unselectable=function(){return this.each(function(){$(this).addClass("unselectable").attr("unselectable","on")}),$(this)},$.fn.clearUnselectable=function(){return this.each(function(){$(this).removeClass("unselectable").removeAttr("unselectable")}),$(this)};var __profiler={};Profiler.reset=function(){__profiler={}},Profiler.displayAll=function(){var e="",r=0;for(var t in __profiler){var i=__profiler[t],n="                          ".substr(0,30-t.length);e+=t+n+"	 millis:"+i.millis+"	 count:"+i.count+"\n",r+=i.millis}console.debug(e)},$(document).ready(function(){$(":input[oldValue]").livequery(function(){$(this).updateOldValue()}),$(".validated").livequery("blur",validateField)});