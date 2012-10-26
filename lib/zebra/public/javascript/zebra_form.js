(function(c){c.Zebra_DatePicker=function(F,C){var da={always_show_clear:!1,always_visible:!1,days:"Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),direction:0,disabled_dates:!1,first_day_of_week:1,format:"Y-m-d",inside:!0,lang_clear_date:"Clear",months:"January February March April May June July August September October November December".split(" "),offset:[20,-5],pair:!1,readonly_element:!0,show_week_number:!1,start_date:!1,view:"days",weekend_days:[0,6],onSelect:null},s,l,w, x,z,D,E,G,S,N,U,o,n,v,p,k,O,H,I,T,P,q,r,Q,J,L,X,Y,Z,y,a=this;a.settings={};var t=c(F),aa=function(b){b||(a.settings=c.extend({},da,C));a.settings.readonly_element&&t.attr("readonly","readonly");var d={days:["d","j"],months:["F","m","M","n","t"],years:["o","Y","y"]},g=!1,f=!1,h=!1;for(type in d)c.each(d[type],function(c,b){a.settings.format.indexOf(b)>-1&&(type=="days"?g=true:type=="months"?f=true:type=="years"&&(h=true))});y=g&&f&&h?["years","months","days"]:!g&&f&&h?["years","months"]:!g&&!f&&h? ["years"]:["years","months","days"];-1==c.inArray(a.settings.view,y)&&(a.settings.view=y[y.length-1]);var d=new Date,i=!a.settings.reference_date?t.data("zdp_reference_date")?t.data("zdp_reference_date"):d:a.settings.reference_date,e,j;r=q=void 0;o=i.getMonth();S=d.getMonth();n=i.getFullYear();N=d.getFullYear();v=i.getDate();U=d.getDate();if(!0===a.settings.direction)q=i;else if(!1===a.settings.direction)r=i,L=r.getMonth(),J=r.getFullYear(),Q=r.getDate();else if(!c.isArray(a.settings.direction)&& M(a.settings.direction)&&0<m(a.settings.direction)||c.isArray(a.settings.direction)&&(!0===a.settings.direction[0]||M(a.settings.direction[0])&&0<a.settings.direction[0]||(e=R(a.settings.direction[0])))&&(!1===a.settings.direction[1]||M(a.settings.direction[1])&&0<=a.settings.direction[1]||(j=R(a.settings.direction[1]))))q=e?e:new Date(n,o,v+(!c.isArray(a.settings.direction)?m(a.settings.direction):m(!0===a.settings.direction[0]?0:a.settings.direction[0]))),o=q.getMonth(),n=q.getFullYear(),v=q.getDate(), j&&+j>+q?r=j:!j&&(!1!==a.settings.direction[1]&&c.isArray(a.settings.direction))&&(r=new Date(n,o,v+m(a.settings.direction[1]))),r&&(L=r.getMonth(),J=r.getFullYear(),Q=r.getDate());else if(!c.isArray(a.settings.direction)&&M(a.settings.direction)&&0>m(a.settings.direction)||c.isArray(a.settings.direction)&&(!1===a.settings.direction[0]||M(a.settings.direction[0])&&0>a.settings.direction[0])&&(M(a.settings.direction[1])&&0<=a.settings.direction[1]||(e=R(a.settings.direction[1]))))r=new Date(n,o,v+ (!c.isArray(a.settings.direction)?m(a.settings.direction):m(!1===a.settings.direction[0]?0:a.settings.direction[0]))),L=r.getMonth(),J=r.getFullYear(),Q=r.getDate(),e&&+e<+r?q=e:!e&&c.isArray(a.settings.direction)&&(q=new Date(J,L,Q-m(a.settings.direction[1]))),q&&(o=q.getMonth(),n=q.getFullYear(),v=q.getDate());if(q&&A(n,o,v)){for(;A(n);)q?n++:n--,o=0;for(;A(n,o);)q?o++:o--,11<o?(n++,o=0):0>o&&(n--,o=0),v=1;for(;A(n,o,v);)q?v++:v--;d=new Date(n,o,v);n=d.getFullYear();o=d.getMonth();v=d.getDate()}T= [];c.each(a.settings.disabled_dates,function(){for(var a=this.split(" "),b=0;b<4;b++){a[b]||(a[b]="*");a[b]=a[b].indexOf(",")>-1?a[b].split(","):Array(a[b]);for(var d=0;d<a[b].length;d++)if(a[b][d].indexOf("-")>-1){var e=a[b][d].match(/^([0-9]+)\-([0-9]+)/);if(null!=e){for(var f=m(e[1]);f<=m(e[2]);f++)c.inArray(f,a[b])==-1&&a[b].push(f+"");a[b].splice(d,1)}}for(d=0;d<a[b].length;d++)a[b][d]=isNaN(m(a[b][d]))?a[b][d]:m(a[b][d])}T.push(a)});(e=R(t.val()||(a.settings.start_date?a.settings.start_date: "")))&&A(e.getFullYear(),e.getMonth(),e.getDate())&&t.val("");$(e);b||(a.settings.always_visible||(b='<button type="button" class="Zebra_DatePicker_Icon'+("disabled"==t.attr("disabled")?" Zebra_DatePicker_Icon_Disabled":"")+'">Pick a date</button>',w=c(b),a.icon=w,(a.settings.readonly_element?w.add(t):w).bind("click",function(b){b.preventDefault();t.attr("disabled")||(l.css("display")!="none"?a.hide():a.show())}),w.insertAfter(F),b=c(F).position(),e=c(F).outerHeight(!0),j=c(F).outerWidth(!0),icon_width= w.outerWidth(!0),icon_height=w.outerHeight(!0),a.settings.inside?(w.addClass("Zebra_DatePicker_Icon_Inside"),w.css({left:b.left+j-icon_width,top:b.top+(e-icon_height)/2})):w.css({left:b.left+j,top:b.top+(e-icon_height)/2})),b='<div class="Zebra_DatePicker"><table class="dp_header"><tr><td class="dp_previous">&laquo;</td><td class="dp_caption">&nbsp;</td><td class="dp_next">&raquo;</td></tr></table><table class="dp_daypicker"></table><table class="dp_monthpicker"></table><table class="dp_yearpicker"></table><table class="dp_footer"><tr><td>'+ a.settings.lang_clear_date+"</td></tr></table></div>",l=c(b),a.datepicker=l,x=c("table.dp_header",l),z=c("table.dp_daypicker",l),D=c("table.dp_monthpicker",l),E=c("table.dp_yearpicker",l),G=c("table.dp_footer",l),a.settings.always_visible?t.attr("disabled")||(a.settings.always_visible.append(l),a.show()):c("body").append(l),l.delegate("td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)","mouseover",function(){c(this).addClass("dp_hover")}).delegate("td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)", "mouseout",function(){c(this).removeClass("dp_hover")}),b=c("td",x),c.browser.mozilla?b.css("MozUserSelect","none"):c.browser.msie?b.bind("selectstart",function(){return false}):b.mousedown(function(){return false}),c(".dp_previous",x).bind("click",function(){if(!c(this).hasClass("dp_blocked")){if(s=="months")k--;else if(s=="years")k=k-12;else if(--p<0){p=11;k--}K()}}),c(".dp_caption",x).bind("click",function(){s=s=="days"?c.inArray("months",y)>-1?"months":c.inArray("years",y)>-1?"years":"days":s== "months"?c.inArray("years",y)>-1?"years":c.inArray("days",y)>-1?"days":"months":c.inArray("days",y)>-1?"days":c.inArray("months",y)>-1?"months":"years";K()}),c(".dp_next",x).bind("click",function(){if(!c(this).hasClass("dp_blocked")){if(s=="months")k++;else if(s=="years")k=k+12;else if(++p==12){p=0;k++}K()}}),z.delegate("td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_week_number)","click",function(){V(k,p,m(c(this).html()),"days",c(this))}),D.delegate("td:not(.dp_disabled)","click", function(){var b=c(this).attr("class").match(/dp\_month\_([0-9]+)/);p=m(b[1]);if(c.inArray("days",y)==-1)V(k,p,1,"months",c(this));else{s="days";a.settings.always_visible&&t.val("");K()}}),E.delegate("td:not(.dp_disabled)","click",function(){k=m(c(this).html());if(c.inArray("months",y)==-1)V(k,1,1,"years",c(this));else{s="months";a.settings.always_visible&&t.val("");K()}}),c("td",G).bind("click",function(b){b.preventDefault();t.val("");if(!a.settings.always_visible){k=p=I=H=O=null;G.css("display", "none")}a.hide()}),a.settings.always_visible||c(document).bind({mousedown:a._mousedown,keyup:a._keyup}),K())};a.hide=function(){a.settings.always_visible||(ba("hide"),l.css("display","none"))};a.show=function(){s=a.settings.view;var b=R(t.val()||(a.settings.start_date?a.settings.start_date:""));b?(H=b.getMonth(),p=b.getMonth(),I=b.getFullYear(),k=b.getFullYear(),O=b.getDate(),A(I,H,O)&&(t.val(""),p=o,k=n)):(p=o,k=n);K();if(a.settings.always_visible)l.css("display","block");else{var b=l.outerWidth(), d=l.outerHeight(),g=w.offset().left+a.settings.offset[0],f=w.offset().top-d+a.settings.offset[1],h=c(window).width(),i=c(window).height(),e=c(window).scrollTop(),j=c(window).scrollLeft();g+b>j+h&&(g=j+h-b);g<j&&(g=j);f+d>e+i&&(f=e+i-d);f<e&&(f=e);l.css({left:g,top:f});l.fadeIn(c.browser.msie&&c.browser.version.match(/^[6-8]/)?0:150,"linear");ba()}};a.update=function(b){a.original_direction&&(a.original_direction=a.direction);a.settings=c.extend(a.settings,b);aa(!0)};var R=function(b){b+="";if(""!= c.trim(b)){var d;d=a.settings.format.replace(/\s/g,"").replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1");for(var g="dDjlNSwFmMnYy".split(""),f=[],h=[],i=0;i<g.length;i++)-1<(position=d.indexOf(g[i]))&&f.push({character:g[i],position:position});f.sort(function(a,b){return a.position-b.position});c.each(f,function(a,b){switch(b.character){case "d":h.push("0[1-9]|[12][0-9]|3[01]");break;case "D":h.push("[a-z]{3}");break;case "j":h.push("[1-9]|[12][0-9]|3[01]");break;case "l":h.push("[a-z]+");break;case "N":h.push("[1-7]"); break;case "S":h.push("st|nd|rd|th");break;case "w":h.push("[0-6]");break;case "F":h.push("[a-z]+");break;case "m":h.push("0[1-9]|1[012]+");break;case "M":h.push("[a-z]{3}");break;case "n":h.push("[1-9]|1[012]");break;case "Y":h.push("[0-9]{4}");break;case "y":h.push("[0-9]{2}")}});if(h.length&&(f.reverse(),c.each(f,function(a,b){d=d.replace(b.character,"("+h[h.length-a-1]+")")}),h=RegExp("^"+d+"$","ig"),segments=h.exec(b.replace(/\s/g,"")))){var e,j,k,l="Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "), o="January February March April May June July August September October November December".split(" "),p,n=!0;f.reverse();c.each(f,function(b,d){if(!n)return!0;switch(d.character){case "m":case "n":j=m(segments[b+1]);break;case "d":case "j":e=m(segments[b+1]);break;case "D":case "l":case "F":case "M":p="D"==d.character||"l"==d.character?a.settings.days:a.settings.months;n=!1;c.each(p,function(a,c){if(n)return!0;if(segments[b+1].toLowerCase()==c.substring(0,"D"==d.character||"M"==d.character?3:c.length).toLowerCase()){switch(d.character){case "D":segments[b+ 1]=l[a].substring(0,3);break;case "l":segments[b+1]=l[a];break;case "F":segments[b+1]=o[a];j=a+1;break;case "M":segments[b+1]=o[a].substring(0,3),j=a+1}n=!0}});break;case "Y":k=m(segments[b+1]);break;case "y":k="19"+m(segments[b+1])}});if(n&&(b=new Date(k,(j||1)-1,e||1),b.getFullYear()==k&&b.getDate()==(e||1)&&b.getMonth()==(j||1)-1))return b}return!1}},ca=function(){var b=(new Date(k,p+1,0)).getDate(),d=(new Date(k,p,1)).getDay(),g=(new Date(k,p,0)).getDate(),d=d-a.settings.first_day_of_week,d=0> d?7+d:d;W(a.settings.months[p]+", "+k);var f="<tr>";a.settings.show_week_number&&(f+="<th>"+a.settings.show_week_number+"</th>");for(var h=0;7>h;h++)f+="<th>"+a.settings.days[(a.settings.first_day_of_week+h)%7].substr(0,2)+"</th>";f+="</tr><tr>";for(h=0;42>h;h++){0<h&&0==h%7&&(f+="</tr><tr>");if(0==h%7&&a.settings.show_week_number){var i=new Date(k,p,h-d+1),e=new Date(k,0,1),j=e.getDay()-a.settings.first_day_of_week,e=Math.floor((i.getTime()-e.getTime()-6E4*(i.getTimezoneOffset()-e.getTimezoneOffset()))/ 864E5)+1,j=0<=j?j:j+7;4>j?(j=Math.floor((e+j-1)/7)+1,52<j+1&&(i.getFullYear(),i=nYear.getDay()-a.settings.first_day_of_week,i=0<=i?i:i+7,j=4>i?1:53)):j=Math.floor((e+j-1)/7);f+='<td class="dp_week_number">'+j+"</td>"}i=h-d+1;h<d?f+='<td class="dp_not_in_month">'+(g-d+h+1)+"</td>":i>b?f+='<td class="dp_not_in_month">'+(i-b)+"</td>":(j=(a.settings.first_day_of_week+h)%7,e="",A(k,p,i)?(e=-1<c.inArray(j,a.settings.weekend_days)?"dp_weekend_disabled":e+" dp_disabled",p==S&&(k==N&&U==i)&&(e+=" dp_disabled_current")): (-1<c.inArray(j,a.settings.weekend_days)&&(e="dp_weekend"),p==H&&(k==I&&O==i)&&(e+=" dp_selected"),p==S&&(k==N&&U==i)&&(e+=" dp_current")),f+="<td"+(""!=e?' class="'+c.trim(e)+'"':"")+">"+u(i,2)+"</td>")}z.html(c(f+"</tr>"));a.settings.always_visible&&(X=c("td:not(.dp_disabled, .dp_weekend_disabled, .dp_not_in_month, .dp_blocked, .dp_week_number)",z));z.css("display","")},ba=function(a){if(c.browser.msie&&c.browser.version.match(/^6/)){if(!P){var d=m(l.css("zIndex"))-1;P=jQuery("<iframe>",{src:'javascript:document.write("")', scrolling:"no",frameborder:0,allowtransparency:"true",css:{zIndex:d,position:"absolute",top:-1E3,left:-1E3,width:l.outerWidth(),height:l.outerHeight(),filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)",display:"none"}});c("body").append(P)}switch(a){case "hide":P.css("display","none");break;default:a=l.offset(),P.css({top:a.top,left:a.left,display:"block"})}}},A=function(b,d,g){if(c.isArray(a.settings.direction)||0!==m(a.settings.direction)){var f=m(B(b,"undefined"!=typeof d?u(d,2):"","undefined"!= typeof g?u(g,2):"")),h=(f+"").length;if(8==h&&("undefined"!=typeof q&&f<m(B(n,u(o,2),u(v,2)))||"undefined"!=typeof r&&f>m(B(J,u(L,2),u(Q,2))))||6==h&&("undefined"!=typeof q&&f<m(B(n,u(o,2)))||"undefined"!=typeof r&&f>m(B(J,u(L,2))))||4==h&&("undefined"!=typeof q&&f<n||"undefined"!=typeof r&&f>J))return!0}if(T){"undefined"!=typeof d&&(d+=1);var i=!1;c.each(T,function(){if(!i&&(-1<c.inArray(b,this[2])||-1<c.inArray("*",this[2])))if("undefined"!=typeof d&&-1<c.inArray(d,this[1])||-1<c.inArray("*",this[1]))if("undefined"!= typeof g&&-1<c.inArray(g,this[0])||-1<c.inArray("*",this[0])){if("*"==this[3])return i=!0;var a=(new Date(b,d-1,g)).getDay();if(-1<c.inArray(a,this[3]))return i=!0}});if(i)return!0}return!1},M=function(a){return(a+"").match(/^\-?[0-9]+$/)?!0:!1},W=function(b){c(".dp_caption",x).html(b);if(c.isArray(a.settings.direction)||0!==m(a.settings.direction)){var b=k,d=p,g,f;"days"==s?(f=0>d-1?B(b-1,"11"):B(b,u(d-1,2)),g=11<d+1?B(b+1,"00"):B(b,u(d+1,2))):"months"==s?(f=b-1,g=b+1):"years"==s&&(f=b-7,g=b+7); A(f)?(c(".dp_previous",x).addClass("dp_blocked"),c(".dp_previous",x).removeClass("dp_hover")):c(".dp_previous",x).removeClass("dp_blocked");A(g)?(c(".dp_next",x).addClass("dp_blocked"),c(".dp_next",x).removeClass("dp_hover")):c(".dp_next",x).removeClass("dp_blocked")}},K=function(){if(""==z.text()||"days"==s){if(""==z.text()){a.settings.always_visible||l.css("left",-1E3);l.css({display:"block"});ca();var b=z.outerWidth(),d=z.outerHeight();x.css("width",b);D.css({width:b,height:d});E.css({width:b, height:d});G.css("width",b);l.css({display:"none"})}else ca();D.css("display","none");E.css("display","none")}else if("months"==s){W(k);b="<tr>";for(d=0;12>d;d++){0<d&&0==d%3&&(b+="</tr><tr>");var g="dp_month_"+d;A(k,d)?g+=" dp_disabled":!1!==H&&H==d?g+=" dp_selected":S==d&&N==k&&(g+=" dp_current");b+='<td class="'+c.trim(g)+'">'+a.settings.months[d].substr(0,3)+"</td>"}D.html(c(b+"</tr>"));a.settings.always_visible&&(Y=c("td:not(.dp_disabled)",D));D.css("display","");z.css("display","none");E.css("display", "none")}else if("years"==s){W(k-7+" - "+(k+4));b="<tr>";for(d=0;12>d;d++)0<d&&0==d%3&&(b+="</tr><tr>"),g="",A(k-7+d)?g+=" dp_disabled":I&&I==k-7+d?g+=" dp_selected":N==k-7+d&&(g+=" dp_current"),b+="<td"+(""!=c.trim(g)?' class="'+c.trim(g)+'"':"")+">"+(k-7+d)+"</td>";E.html(c(b+"</tr>"));a.settings.always_visible&&(Z=c("td:not(.dp_disabled)",E));E.css("display","");z.css("display","none");D.css("display","none")}(a.settings.always_show_clear||a.settings.always_visible||""!=t.val())&&"block"!=G.css("display")? G.css("display",""):G.css("display","none")},V=function(b,c,g,f,h){var i=new Date(b,c,g),f="days"==f?X:"months"==f?Y:Z,e;e="";for(var j=i.getDate(),l=i.getDay(),n=a.settings.days[l],m=i.getMonth()+1,o=a.settings.months[m-1],q=i.getFullYear()+"",r=0;r<a.settings.format.length;r++){var s=a.settings.format.charAt(r);switch(s){case "y":q=q.substr(2);case "Y":e+=q;break;case "m":m=u(m,2);case "n":e+=m;break;case "M":o=o.substr(0,3);case "F":e+=o;break;case "d":j=u(j,2);case "j":e+=j;break;case "D":n=n.substr(0, 3);case "l":e+=n;break;case "N":l++;case "w":e+=l;break;case "S":e=1==j%10&&"11"!=j?e+"st":2==j%10&&"12"!=j?e+"nd":3==j%10&&"13"!=j?e+"rd":e+"th";break;default:e+=s}}t.val(e);a.settings.always_visible&&(H=i.getMonth(),p=i.getMonth(),I=i.getFullYear(),k=i.getFullYear(),O=i.getDate(),f.removeClass("dp_selected"),h.addClass("dp_selected"));a.hide();$(i);if(a.settings.onSelect&&"function"==typeof a.settings.onSelect)a.settings.onSelect(e,b+"-"+u(c+1,2)+"-"+u(g,2),new Date(b,c,g))},B=function(){for(var a= "",c=0;c<arguments.length;c++)a+=arguments[c]+"";return a},u=function(a,c){for(a+="";a.length<c;)a="0"+a;return a},m=function(a){return parseInt(a,10)},$=function(b){if(a.settings.pair)if(!a.settings.pair.data||!a.settings.pair.data("Zebra_DatePicker"))a.settings.pair.data("zdp_reference_date",b);else{var c=a.settings.pair.data("Zebra_DatePicker");c.update({reference_date:b});c.settings.always_visible&&c.show()}};a._keyup=function(b){("block"==l.css("display")||27==b.which)&&a.hide();return!0};a._mousedown= function(b){if("block"==l.css("display")){if(c(b.target).get(0)===w.get(0))return!0;0==c(b.target).parents().filter(".Zebra_DatePicker").length&&a.hide()}return!0};aa()};c.fn.Zebra_DatePicker=function(F){return this.each(function(){if(void 0!=c(this).data("Zebra_DatePicker")){var C=c(this).data("Zebra_DatePicker");C.icon.remove();C.datepicker.remove();c(document).unbind("keyup",C._keyup);c(document).unbind("mousedown",C._mousedown)}C=new c.Zebra_DatePicker(this,F);c(this).data("Zebra_DatePicker", C)})}})(jQuery);(function(b){b.Zebra_Form=function(r,u){var f=this,I={scroll_to_error:!0,tips_position:"left",close_tips:!0,validate_on_the_fly:!1,validate_all:!1,assets_path:null};f.settings={};var n={},E={},s={},t=[],v=!1,z=!1,k=b(r);f.filter_input=function(a,c,d){var b,f="";if(window.event)b=window.event.keyCode,c=window.event;else if(c)b=c.which;else return!0;switch(a){case "alphabet":f="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";break;case "digits":case "number":case "float":f="0123456789";break; case "alphanumeric":f="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";break;default:return!0}d&&(f+=d);c=c.srcElement?c.srcElement:c.target||c.currentTarget;if(null==b||0==b||8==b||9==b||13==b||27==b)return!0;b=String.fromCharCode(b);return-1<f.indexOf(b)||"number"==a&&"-"==b&&0==w(c)||"float"==a&&("-"==b&&0==w(c)||"."==b&&0!=w(c)&&null==c.value.match(/\./))?!0:!1};f.init=function(){f.settings=b.extend({},I,u);k.find("option.dummy").remove();b("div.error",k).each(function(){b("div.close a", b(this)).bind("click",function(a){a.preventDefault();b(this).closest("div.error").animate({height:0,opacity:0},250,function(){b(this).remove()})})});b(".control",k).each(function(){var a=b(this),c={id:a.attr("id"),type:D(a)},d=a.closest(".row");d.length&&a.bind({focus:function(){d.addClass("highlight")},blur:function(){d.removeClass("highlight")}});if(a.hasClass("inner-label")&&("text"==c.type||"password"==c.type||"textarea"==c.type)){var e=a.position(),g="text"==c.type||"password"==c.type?jQuery("<input>").attr({type:"text", "class":"Zebra_Form_Placeholder",autocomplete:"off",value:a.attr("title")}):jQuery("<textarea>").attr({"class":"Zebra_Form_Placeholder",autocomplete:"off"}).html(a.attr("title"));g.css({display:"none",fontFamily:a.css("fontFamily"),fontSize:a.css("fontSize"),fontStyle:a.css("fontStyle"),fontWeight:a.css("fontWeight"),left:e.left,top:e.top,width:a.width()+(parseInt(a.css("borderLeftWidth"),10)||0)+(parseInt(a.css("borderRightWidth"),10)||0),height:a.height()+(parseInt(a.css("borderTopWidth"),10)|| 0)+(parseInt(a.css("borderBottomWidth"),10)||0),paddingTop:parseInt(a.css("paddingTop"),10)||0,paddingRight:parseInt(a.css("paddingRight"),10)||0,paddingBottom:parseInt(a.css("paddingBottom"),10)||0,paddingLeft:parseInt(a.css("paddingLeft"),10)||0}).insertAfter(a);a.removeAttr("title");g.bind("focus",function(){a.focus()});a.bind({focus:function(){g.css("display","none")},blur:function(){""==b(this).val()&&g.css("display","block")}});a.data("Zebra_Form_Placeholder",g);t.push(a)}else a.hasClass("other")&& "select-one"==c.type&&(A(a),a.change(function(){A(a)}));void 0!=f.settings.error_messages&&void 0!=typeof f.settings.error_messages[c.id]&&f.register(a,!1);if(("text"==c.type||"textarea"==c.type||"password"==c.type)&&a.attr("maxlength"))if(a.data("maxlength",a.attr("maxlength")),a.bind("keyup",function(){var a=b(this),c=a.data("maxlength"),d=F(a);a.attr("maxlength",c-d);a.hasClass("show-character-counter")&&(a=c-d-a.val().length,m.html(0>a?"<span>"+a+"</span>":a))}),a.hasClass("show-character-counter")){var e= a.position(),m=jQuery("<div>",{"class":"Zebra_Character_Counter",css:{visibility:"hidden"}}).html(a.data("maxlength")).insertAfter(a);width=m.outerWidth();height=m.outerHeight();m.css({top:e.top+a.outerHeight()-height/1.5,left:e.left+a.outerWidth()-width/1.5,width:m.width(),visibility:"visible"});a.trigger("keyup")}});k.bind("submit",function(a){!1==v&&(void 0!=f.settings.error_messages&&!z)&&(f.validate()||a.preventDefault());z=!1});0<t.length&&setInterval(J,50)};f.attach_tip=function(a,b){var d= a.attr("id");n[d].message=b;f.show_errors(a)};f.clear_errors=function(){b(".Zebra_Form_error_iFrameShim").remove();b(".Zebra_Form_error_message").remove();s=[]};f.end_file_upload=function(a,c){var d=b("#"+a);if(d.length&&(f.clear_errors(),k.removeAttr("target"),b("#"+a+"_iframe").remove(),b("#"+a+"_spinner").remove(),void 0!=n[a]))if(void 0!=c&&("object"==typeof c&&void 0!=c[0]&&void 0!=c[1]&&void 0!=c[2]&&void 0!=c[3])&&d.data("file_info",c),!0!==f.validate_control(d))d.val(""),d.css("visibility", "visible"),f.show_errors(d);else{var e=d.offset(),g=jQuery("<div>",{"class":"Zebra_Form_filename",css:{left:e.left,top:e.top,width:d.outerWidth(),opacity:0}}).html(c[0]),e=jQuery("<a>",{href:"javascript:void(0)"}).html("x").bind("click",function(a){a.preventDefault();g.remove();d.val("");d.data("file_info")&&d.removeData("file_info");d.css("visibility","visible")});b("body").append(g.append(e));g.css({top:parseInt(g.css("top"),10)+(d.outerHeight()-g.outerHeight())/2,opacity:1})}};f.hide_error=function(a, c){var d=b("#"+a);if(void 0==c&&f.settings.validate_on_the_fly&&!0!==f.validate_control(d))f.show_errors(d,!1);else{var e=b("#Zebra_Form_error_message_"+a);0<e.length&&e.animate({opacity:0},250,function(){var b=e.data("shim");void 0!=b&&b.remove();e.remove();delete s[a]})}};f.register=function(a,c){var d={id:a.attr("id"),name:a.attr("name"),type:D(a)};d.name=d.name.replace(/\[\]$/,"");switch(d.type){case "radio":case "checkbox":a.bind({click:function(){f.hide_error(d.name)},blur:function(){f.hide_error(d.name)}}); void 0==E[d.id]&&(E[d.id]=k.find("input[name^="+d.name+"]"));break;case "file":var e=a.clone(!0);e.attr("value","");a.replaceWith(e);e.bind({keypress:function(a){a.preventDefault();e.attr("value","")},change:function(){if(void 0!=n[d.name].rules.upload){f.hide_error(d.name);e.data("file_info")&&e.removeData("file_info");var c=jQuery('<iframe id="'+d.id+'_iframe" name="'+d.id+'_iframe">',{src:"javascript:void(0)",scrolling:"no",marginwidth:0,marginheight:0,width:0,height:0,frameborder:0,allowTransparency:"true"}); b("body").append(c);c=k.attr("action");k.attr("action",decodeURIComponent(f.settings.assets_path)+"process.php?form="+k.attr("id")+"&control="+d.id+"&path="+encodeURIComponent(decodeURIComponent(n[d.name].rules.upload))+"&nocache="+(new Date).getTime());k.attr("target",d.id+"_iframe");a.css("visibility","hidden");var h=a.offset(),h=jQuery("<div>",{id:d.id+"_spinner","class":"Zebra_Form_spinner",css:{left:h.left,top:h.top}});b("body").append(h);v=!0;k.trigger("submit");k.attr("action",c);v=!1}},blur:function(){f.hide_error(d.name)}}); a=e;break;case "select-one":case "select-multiple":a.bind({change:function(){f.hide_error(d.name)},blur:function(){f.hide_error(d.name)}});break;default:a.blur(function(){f.hide_error(d.name)})}var g=a.attr("class").match(/validate\[(.+)\]/);if(null!=g){for(var m=/([^\,]*\(.*?\)|[^\,]+)/g,h={};matches=m.exec(g[1]);){var l=matches[1].match(/^([^\(]+)/),i=matches[1].match(/\((.*?)\)/);i?(i=i[1].split(","),b.each(i,function(a){i[a]=i[a].replace(/lsqb\;/g,"[");i[a]=i[a].replace(/rsqb\;/g,"]");i[a]=i[a].replace(/comma\;/g, ",");i[a]=i[a].replace(/lsb\;/g,"(");i[a]=i[a].replace(/rsb\;/g,")")})):i=null;h[l[1]]=i}if(void 0==c){var G=k.find(".control");b.each(G,function(c,e){if(e==a.get(0)){b(e);for(var f=null,g=c-1;null==f&&void 0!=G[g];)f=b(G[g]).attr("id"),g--;if(n[f]){g={};for(c in n)g[c]=n[c],f==c&&(g[d.id]={element:a,rules:h});n=g}else f={},f[d.id]={element:a,rules:h},b.extend(n,f)}})}else if(void 0!=c&&b("#"+c).length){b("#"+c).attr("id");g={};for(index in n)g[index]=n[index],previous_element_id==index&&(g[d.id]= {element:a,rules:h});n=g}else void 0!=c&&!1===c&&(n[d.id]={element:a,rules:h})}};f.show_errors=function(a,c){void 0!=c&&!1===c||f.clear_errors();var d=0;for(index in n){var e=n[index],g=e.element,m={id:g.attr("id"),name:g.attr("name"),type:D(g)},h="radio"==m.type||"checkbox"==m.type?m.name:m.id;m.name=m.name.replace(/\[\]$/,"");if(!(void 0!=a&&a.get(0)!=g.get(0))&&void 0!=e.message&&void 0==s[h]){"none"!=g.css("display")&&(!(void 0!=c&&!1===c)&&!(f.settings.validate_all&&0<d))&&g.focus();var l=b.extend(g.offset()), l=b.extend(l,{right:Math.floor(l.left+g.width())}),i=jQuery("<div/>",{"class":"Zebra_Form_error_message",id:"Zebra_Form_error_message_"+h,css:{opacity:0}}),e=jQuery("<div/>",{"class":"message"+(!f.settings.close_tips?" noclose":""),css:{_width:"auto"}}).html(e.message).appendTo(i);f.settings.close_tips&&jQuery("<a/>",{href:"javascript:void(0)","class":"close"+(b.browser.msie&&b.browser.version.match(/^6/)?"-ie6":"")}).html("x").appendTo(e).bind({click:function(a){a.preventDefault();f.hide_error(b(this).closest("div.Zebra_Form_error_message").attr("id").replace(/^Zebra\_Form\_error\_message\_/, ""),!0)},focus:function(){b(this).blur()}});var k=jQuery("<div/>",{"class":"arrow"}).appendTo(i);b("body").append(i);var q=i.outerWidth(),o=i.outerHeight(),o=k.outerWidth(),e=k.outerHeight(),j=("left"==f.settings.tips_position?l.left:l.right)-q/2;k.css("left",q/2-o/2-1);if("radio"==m.type||"checkbox"==m.type)j=l.right-q/2-g.outerWidth()/2+1;0>j&&(j=2);i.css("left",j);q=i.outerWidth();o=i.outerHeight();g=l.top-o+e/2-1;0>g&&(g=2);i.css({left:j+"px",top:g+"px",height:o-e/2+"px"});h=s[h]=i;b.browser.msie&& b.browser.version.match(/^6/)&&!h.data("shim")&&(g=h.offset(),m=parseInt(h.css("zIndex"),10)-1,g=jQuery("<iframe>",{src:'javascript:document.write("")',scrolling:"no",frameborder:0,allowTransparency:"true","class":"Zebra_Form_error_iFrameShim",css:{zIndex:m,position:"absolute",top:g.top,left:g.left,width:h.outerWidth(),height:h.outerHeight(),filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)",display:"block"}}),b("body").append(g),h.data("shim",g));i.animate({opacity:0.9},250);1==++d&&(f.settings.scroll_to_error&& !(void 0!=c&&!1===c))&&b("html, body").animate({scrollTop:Math.max(parseInt(i.css("top"),10)+parseInt(i.css("height"),10)/2-b(window).height()/2,0)},0);if(!f.settings.validate_all)break}}};f.submit=function(){k.trigger("submit")};f.validate_control=function(a){var c={id:a.attr("id"),type:D(a)},d=!0,e=n[c.id];if(void 0!=e&&("none"!=a.css("display")&&"hidden"!=a.css("visibility")||a.data("file_info"))){var g=null,m=null;delete e.message;for(var h in e.rules){if(!d)break;switch(h){case "alphabet":switch(c.type){case "password":case "text":case "textarea":var l= RegExp("^[a-z"+x(e.rules[h][0]).replace(/\s/,"\\s")+"]+$","ig");""!=b.trim(a.val())&&!l.test(a.val())&&(d=!1)}break;case "alphanumeric":switch(c.type){case "password":case "text":case "textarea":l=RegExp("^[a-z0-9"+x(e.rules[h][0]).replace(/\s/,"\\s")+"]+$","ig"),""!=b.trim(a.val())&&!l.test(a.val())&&(d=!1)}break;case "compare":switch(c.type){case "password":case "text":case "textarea":if(!b("#"+e.rules[h][0])||a.val()!=b("#"+e.rules[h][0]).val())d=!1}break;case "custom":var i=!1;b.each(e.rules[h], function(c,e){if(!i){var e=b.map(e.split(","),function(a){return a.replace(/mark\;/g,",")}),e=b.merge(b.merge([e.shift()],[a.val()]),e),f="function"==typeof e[0]?e[0]:"function"==typeof window[e[0]]?window[e[0]]:!1;if(!1!==f)d=f.apply(f,e.slice(1));else throw d=!1,Error('Function "'+e[0]+"\" doesn't exist!");d||(m=e[0],i=!0)}});break;case "date":switch(c.type){case "text":if(""!=b.trim(a.val())){for(var l=!1,k=a.data("Zebra_DatePicker").settings.format.replace(/\s/g,""),q="dDjlNSwFmMnYyGHghaAisU".split(""), o=[],j=[],k=x(k),r=0;r<q.length;r++)-1<(position=k.indexOf(q[r]))&&o.push({character:q[r],position:position});o.sort(function(a,b){return a.position-b.position});b.each(o,function(a,b){switch(b.character){case "d":j.push("0[1-9]|[12][0-9]|3[01]");break;case "D":j.push("[a-z]{3}");break;case "j":j.push("[1-9]|[12][0-9]|3[01]");break;case "l":j.push("[a-z]+");break;case "N":j.push("[1-7]");break;case "S":j.push("st|nd|rd|th");break;case "w":j.push("[0-6]");break;case "F":j.push("[a-z]+");break;case "m":j.push("0[1-9]|1[012]+"); break;case "M":j.push("[a-z]{3}");break;case "n":j.push("[1-9]|1[012]");break;case "Y":j.push("[0-9]{4}");break;case "y":j.push("[0-9]{2}");break;case "G":j.push("[0-9]|1[0-9]|2[0-3]");break;case "H":j.push("0[0-9]|1[0-9]|2[0-3]");break;case "g":j.push("[0-9]|1[0-2]");break;case "h":j.push("0[0-9]|1[0-2]");break;case "a":case "A":j.push("(am|pm)");break;case "i":j.push("[0-5][0-9]");break;case "s":j.push("[0-5][0-9]")}});if(0<j.length&&(o.reverse(),b.each(o,function(a,b){k=k.replace(b.character,"("+ j[j.length-a-1]+")")}),j=RegExp("^"+k+"$","ig"),segments=j.exec(a.val().replace(/\s/g,"")))){var s=null,y=null,B=null,u="Sunday Monday Tuesday Wednesday Thursday Friday Saturday".split(" "),t="January February March April May June July August September October November December".split(" "),v=null,C=!0;o.reverse();b.each(o,function(c,d){if(!C)return!0;switch(d.character){case "m":case "n":y=parseInt(segments[c+1],10);break;case "d":case "j":s=parseInt(segments[c+1],10);break;case "D":case "l":case "F":case "M":v= "D"==d.character||"l"==d.character?a.data("Zebra_DatePicker").settings.days:a.data("Zebra_DatePicker").settings.months;C=!1;b.each(v,function(a,b){if(C)return!0;if(segments[c+1].toLowerCase()==b.substring(0,"D"==d.character||"M"==d.character?3:b.length).toLowerCase()){switch(d.character){case "D":segments[c+1]=u[a].substring(0,3);break;case "l":segments[c+1]=u[a];break;case "F":segments[c+1]=t[a];y=a+1;break;case "M":segments[c+1]=t[a].substring(0,3),y=a+1}C=!0}});break;case "Y":B=parseInt(segments[c+ 1],10);break;case "y":B="19"+parseInt(segments[c+1],10)}});C&&(q=new Date(B,y-1,s),q.getFullYear()==B&&(q.getDate()==s&&q.getMonth()==y-1)&&(a.data("timestamp",Date.parse(t[y-1]+" "+s+", "+B)),l=!0))}l||(d=!1)}}break;case "datecompare":switch(c.type){case "password":case "text":case "textarea":if(void 0!=e.rules[h][0]&&void 0!=e.rules[h][1]&&b(e.rules[h][0])&&!0===f.validate_control(b(e.rules[h][0]))&&void 0!=a.data("timestamp"))switch(e.rules[h][1]){case ">":d=a.data("timestamp")>b("#"+e.rules[h][0]).data("timestamp"); break;case ">=":d=a.data("timestamp")>=b("#"+e.rules[h][0]).data("timestamp");break;case "<":d=a.data("timestamp")<b("#"+e.rules[h][0]).data("timestamp");break;case "<=":d=a.data("timestamp")<=b("#"+e.rules[h][0]).data("timestamp")}else d=!1}break;case "digits":switch(c.type){case "password":case "text":case "textarea":l=RegExp("^[0-9"+x(e.rules[h][0]).replace(/\s/,"\\s")+"]+$","ig"),""!=b.trim(a.val())&&!l.test(a.val())&&(d=!1)}break;case "email":switch(c.type){case "password":case "text":case "textarea":""!= b.trim(a.val())&&null==a.val().match(/^([a-zA-Z0-9_\-\+\~\^\{\}]+[\.]?)+@{1}([a-zA-Z0-9_\-\+\~\^\{\}]+[\.]?)+\.[A-Za-z0-9]{2,}$/)&&(d=!1)}break;case "emails":switch(c.type){case "password":case "text":case "textarea":a.val().split(",").each(function(a){""!=b.trim(a)&&null==b.trim(a).match(/^([a-zA-Z0-9_\-\+\~\^\{\}]+[\.]?)+@{1}([a-zA-Z0-9_\-\+\~\^\{\}]+[\.]?)+\.[A-Za-z0-9]{2,}$/)&&(d=!1)})}break;case "filesize":switch(c.type){case "file":var p=a.data("file_info");if(p&&(void 0==p[2]||void 0==p[3]|| 0!=p[2]||parseInt(p[3],10)>parseInt(e.rules[h][0],10)))d=!1}break;case "filetype":switch(c.type){case "file":if(p=a.data("file_info")){void 0==f.mimes&&b.ajax({url:decodeURIComponent(f.settings.assets_path)+"mimes.json",async:!1,success:function(a){f.mimes=a},dataType:"json"});var z=b.map(e.rules[h][0].split(","),function(a){return b.trim(a)}),w=[];b.each(f.mimes,function(a,c){(b.isArray(c)&&-1<b.inArray(p[1],c)||!b.isArray(c)&&c==p[1])&&w.push(a)});var A=!1;b.each(w,function(a,c){-1<b.inArray(c, z)&&(A=!0)});A||(d=!1)}}break;case "float":switch(c.type){case "password":case "text":case "textarea":if(l=RegExp("^[0-9-."+x(e.rules[h][0]).replace(/\s/,"\\s")+"]+$","ig"),""!=b.trim(a.val())&&("-"==b.trim(a.val())||"."==b.trim(a.val())||null!=a.val().match(/\-/g)&&1<a.val().match(/\-/g).length||null!=a.val().match(/\./g)&&1<a.val().match(/\./g).length||0<a.val().indexOf("-")||!l.test(a.val())))d=!1}break;case "image":switch(c.type){case "file":(p=a.data("file_info"))&&null==p[1].match(/image\/(gif|jpeg|png|pjpeg)/i)&& (d=!1)}break;case "length":switch(c.type){case "password":case "text":case "textarea":if(""!=a.val()&&void 0!=e.rules[h][0]&&a.val().length-F(a)<e.rules[h][0]||void 0!=e.rules[h][1]&&0<e.rules[h][1]&&a.val().length-F(a)>e.rules[h][1])d=!1}break;case "number":switch(c.type){case "password":case "text":case "textarea":if(l=RegExp("^[0-9-"+x(e.rules[h][0]).replace(/\s/,"\\s")+"]+$","ig"),""!=b.trim(a.val())&&("-"==b.trim(a.val())||null!=a.val().match(/\-/g)&&1<a.val().match(/\-/g).length||0<a.val().indexOf("-")|| !l.test(a.val())))d=!1}break;case "regexp":switch(c.type){case "password":case "text":case "textarea":l=RegExp(e.rules[h][0],"g"),""!=b.trim(a.val())&&null==l.exec(a.val())&&(d=!1)}break;case "required":switch(c.type){case "checkbox":case "radio":var H=!1;E[c.id].each(function(){this.checked&&(H=!0)});H||(d=!1);break;case "file":case "password":case "text":case "textarea":""==b.trim(a.val())&&(d=!1);break;case "select-one":if(a.hasClass("time")&&0==a.get(0).selectedIndex)c.id=c.id.replace(/\_(hours|minutes|seconds|ampm)$/, ""),d=!1;else if(a.hasClass("other")&&"other"==a.val()&&(!b("#"+c.id+"_other").length||""==b.trim(b("#"+c.id+"_other").val()))||0==a.get(0).selectedIndex)d=!1;break;case "select-multiple":-1==a.get(0).selectedIndex&&(d=!1)}break;case "upload":switch(c.type){case "file":if((p=a.data("file_info"))&&(!p[2]||0!=p[2]))d=!1}}d||(g=h,e.message=f.settings.error_messages[c.id]["custom"==h?"custom_"+m:g],e.value=a.val())}}return d?!0:g};f.validate=function(){var a=!0;f.clear_errors();for(index in n){if(!a&& !f.settings.validate_all)break;r=n[index].element;r.attr("id");if(!0!==(rule_not_passed=f.validate_control(r)))a=!1}a||f.show_errors();z=!0;return a};var J=function(){b.each(t,function(){var a=b(this),c=a.data("Zebra_Form_Placeholder");""==a.val()&&!a.is(":focus")?c.css("display","block"):c.css("display","none")})},x=function(a){return a.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1")},w=function(a){if(null!=a.selectionStart)return a.selectionStart;var c=document.selection.createRange(),b=c.duplicate(); if("text"==a.type)return 0-b.moveStart("character",-1E5);var e=a.value.length;b.moveToElementText(a);b.setEndPoint("StartToStart",c);return e-b.text.length},F=function(a){var a=a.val(),b=a.length;return a.replace(/(\r\n|\r|\n)/g,"\r\n").length-b},A=function(a){var c=b("#"+a.attr("id")+"_other");"other"==a.val()?c.css("display","block"):c.css("display","none")},D=function(a){var b="button input:checkbox input:file input:password input:radio input:submit input:text select textarea".split(" ");for(index in b)if(a.is(b[index]))return"select"== b[index]?a.attr("multiple")?"select-multiple":"select-one":b[index].replace(/input\:/,"")};f.init()};b.fn.Zebra_Form=function(r){return this.each(function(){var u=new b.Zebra_Form(this,r);b(this).data("Zebra_Form",u)})}})(jQuery);