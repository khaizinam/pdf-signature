(()=>{function t(e){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},t(e)}function e(t,e){for(var r=0;r<e.length;r++){var o=e[r];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,n(o.key),o)}}function n(e){var n=function(e,n){if("object"!=t(e)||!e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var o=r.call(e,n||"default");if("object"!=t(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===n?String:Number)(e)}(e,"string");return"symbol"==t(n)?n:n+""}var r=function(){function t(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,t)}return n=t,o=[{key:"getStates",value:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null;$.ajax({url:t.data("url"),data:{country_id:e},type:"GET",beforeSend:function(){n&&n.prop("disabled",!0)},success:function(e){if(e.error)Apps.showError(e.message);else{var n="";$.each(e.data,(function(t,e){n+='<option value="'+(e.id||"")+'">'+e.name+"</option>"})),t.html(n)}},complete:function(){n&&n.prop("disabled",!1)}})}},{key:"getCities",value:function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:null,r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:null;$.ajax({url:t.data("url"),data:{state_id:e,country_id:r},type:"GET",beforeSend:function(){n&&n.prop("disabled",!0)},success:function(e){if(e.error)Apps.showError(e.message);else{var n="";$.each(e.data,(function(t,e){n+='<option value="'+(e.id||"")+'">'+e.name+"</option>"})),t.html(n),t.trigger("change")}},complete:function(){n&&n.prop("disabled",!1)}})}}],(r=[{key:"init",value:function(){var e='select[data-type="country"]',n='select[data-type="state"]',r='select[data-type="city"]';function o(){jQuery().select2&&$(document).find('select[data-using-select2="true"]').each((function(t,e){var r={width:"100%",minimumInputLength:0,ajax:{url:$(e).data("url"),dataType:"json",delay:250,type:"GET",data:function(t){return{state_id:$(e).closest("form").find(n).val(),k:t.term,page:t.page||1}},processResults:function(t,e){return{results:$.map(t.data[0],(function(t){return{text:t.name,id:t.id,data:t}})),pagination:{more:10*e.page<t.total}}}}},o=$(e).closest("div[data-select2-dropdown-parent]")||$(e).closest(".modal");o.length&&(r.dropdownParent=o,r.width="100%",r.minimumResultsForSearch=-1),$(e).select2(r)}))}function a(t){var e=$(document),n=t.data("form-parent");return n&&$(n).length&&(e=$(n)),e}$(document).on("change",e,(function(e){e.preventDefault();var o=a($(e.currentTarget)),i=o.find(n),u=o.find(r);i.find('option:not([value=""]):not([value="0"])').remove(),u.find('option:not([value=""]):not([value="0"])').remove();var l=$(e.currentTarget).closest("form").find("button[type=submit], input[type=submit]"),c=$(e.currentTarget).val();c&&(i.length?(t.getStates(i,c,l),t.getCities(u,null,l,c)):t.getCities(u,null,l,c))})),$(document).on("change",n,(function(n){n.preventDefault();var i=a($(n.currentTarget)),u=i.find(r);if(u.length){u.find('option:not([value=""]):not([value="0"])').remove();var l=$(n.currentTarget).val(),c=$(n.currentTarget).closest("form").find("button[type=submit], input[type=submit]");if(l)t.getCities(u,l,c);else{var s=i.find(e).val();t.getCities(u,null,c,s)}o()}})),o()}}])&&e(n.prototype,r),o&&e(n,o),Object.defineProperty(n,"prototype",{writable:!1}),n;var n,r,o}();$((function(){(new r).init()}))})();