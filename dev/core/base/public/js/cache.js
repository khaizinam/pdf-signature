(()=>{function t(n){return t="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},t(n)}function n(t,n){for(var r=0;r<n.length;r++){var o=n[r];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(t,e(o.key),o)}}function e(n){var e=function(n,e){if("object"!=t(n)||!n)return n;var r=n[Symbol.toPrimitive];if(void 0!==r){var o=r.call(n,e||"default");if("object"!=t(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(n)}(n,"string");return"symbol"==t(e)?e:e+""}var r=function(){return t=function t(){!function(t,n){if(!(t instanceof n))throw new TypeError("Cannot call a class as a function")}(this,t)},(e=[{key:"init",value:function(){$(document).on("click",".btn-clear-cache",(function(t){t.preventDefault();var n=$(t.currentTarget);Apps.showButtonLoading(n),$httpClient.make().post(n.data("url"),{type:n.data("type")}).then((function(t){var n=t.data;return Apps.showSuccess(n.message)})).finally((function(){return Apps.hideButtonLoading(n)}))}))}}])&&n(t.prototype,e),r&&n(t,r),Object.defineProperty(t,"prototype",{writable:!1}),t;var t,e,r}();$((function(){(new r).init()}))})();