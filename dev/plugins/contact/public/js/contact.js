(()=>{function e(t){return e="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},e(t)}function t(e,t){for(var r=0;r<t.length;r++){var o=t[r];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,n(o.key),o)}}function n(t){var n=function(t,n){if("object"!=e(t)||!t)return t;var r=t[Symbol.toPrimitive];if(void 0!==r){var o=r.call(t,n||"default");if("object"!=e(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===n?String:Number)(t)}(t,"string");return"symbol"==e(n)?n:n+""}var r=function(){return e=function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)},(n=[{key:"init",value:function(){$(document).on("click",".answer-trigger-button",(function(e){e.preventDefault(),e.stopPropagation();var t=$(".answer-wrapper");t.is(":visible")?t.fadeOut():t.fadeIn(),window.EDITOR=(new EditorManagement).init()})),$(document).on("click",".answer-send-button",(function(e){e.preventDefault(),e.stopPropagation();var t=$(e.currentTarget);Apps.showButtonLoading(t);var n=$("#message").val();"undefined"!=typeof tinymce&&(n=tinymce.get("message").getContent()),$httpClient.make().post(t.data("url"),{message:n}).then((function(e){var t=e.data;if($(".answer-wrapper").fadeOut(),"undefined"!=typeof tinymce)tinymce.get("message").setContent("");else{$("#message").val("");var n=document.querySelector(".answer-wrapper .ck-editor__editable");if(n){var r=n.ckeditorInstance;r&&r.setData("")}}Apps.showSuccess(t.message),$("#reply-wrapper").load(window.location.href+" #reply-wrapper > *")})).finally((function(){Apps.hideButtonLoading($(e.currentTarget))}))}))}}])&&t(e.prototype,n),r&&t(e,r),Object.defineProperty(e,"prototype",{writable:!1}),e;var e,n,r}();$((function(){(new r).init()}))})();