!function(){var e={703:function(e,t,n){"use strict";var r=n(414);function o(){}function a(){}a.resetWarningCache=o,e.exports=function(){function e(e,t,n,o,a,s){if(s!==r){var i=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw i.name="Invariant Violation",i}}function t(){return e}e.isRequired=e;var n={array:e,bigint:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:t,element:e,elementType:e,instanceOf:t,node:e,objectOf:t,oneOf:t,oneOfType:t,shape:t,exact:t,checkPropTypes:a,resetWarningCache:o};return n.PropTypes=n,n}},697:function(e,t,n){e.exports=n(703)()},414:function(e){"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"},193:function(e,t,n){e.exports=function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=1)}([function(e,t){e.exports=n(196)},function(e,t,n){"use strict";n.r(t);var r=n(0);t.default=function(e,t,n){void 0===n&&(n="click");var o=Object(r.useRef)(t);Object(r.useEffect)((function(){o.current=t})),Object(r.useEffect)((function(){var t=function(t){e&&e.current&&(t.target.shadowRoot?t.target.shadowRoot.contains(e.current)||o.current(t):e.current.contains(t.target)||o.current(t))};return document.addEventListener(n,t),document.addEventListener("touchstart",t),function(){document.removeEventListener(n,t),document.removeEventListener("touchstart",t)}}))}}])},196:function(e){"use strict";e.exports=window.React}},t={};function n(r){var o=t[r];if(void 0!==o)return o.exports;var a=t[r]={exports:{}};return e[r](a,a.exports,n),a.exports}n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,{a:t}),t},n.d=function(e,t){for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){"use strict";var e=window.wp.element,t=window.wp.plugins,r=window.wp.editPost;function o(){return o=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e},o.apply(this,arguments)}var a=window.wp.components,s=n(193),i=n.n(s);const u=t=>{let{display_name:n,onClick:r}=t;return(0,e.createElement)("div",{className:"additional-authors-author",onClick:r},n)};var c=t=>{let{i18n:n,users:r,onFound:s}=t;const[c,l]=(0,e.useState)(""),[d,p]=(0,e.useState)(!1),[f,m]=(0,e.useState)([]),h=(0,e.useRef)();return i()(h,(()=>{p(!1)})),(0,e.useEffect)((()=>{m(r.filter((e=>""===c||e.display_name.toLowerCase().includes(c.toLowerCase()))))}),[c,r]),function(t){let n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:[],r=!(arguments.length>2&&void 0!==arguments[2])||arguments[2];(0,e.useEffect)((()=>{if(!r)return;const e=e=>{let{key:n}=e;"Escape"===n&&t()};return window.addEventListener("keydown",e),()=>{window.removeEventListener("keydown",e)}}),n)}((()=>{p(!1)}),[d],d),(0,e.createElement)(a.BaseControl,{className:"additional-authors--search-author"},(0,e.createElement)("div",{ref:h},(0,e.createElement)("div",{className:"additional-authors--search-authors__input-wrapper"},(0,e.createElement)(a.TextControl,{label:n.label,value:c,onChange:e=>{p(!0),l(e)},onFocus:()=>p(!0)})),d?(0,e.createElement)(a.Popover,{focusOnMount:!1,position:"bottom center"},f.length>0?f.map((t=>(0,e.createElement)(u,o({key:t.ID},t,{onClick:()=>{p(!1),s(t)}})))):(0,e.createElement)("p",{className:"additional-authors--search-author__no-results"},n.search_404)):null))},l=window.wp.data;const d=()=>{const e=(0,l.useSelect)((e=>e("core/editor").getCurrentPost().author));return(0,l.useSelect)((e=>e("core/editor").getPostEdits().author))||e};var p=n(697),f=n.n(p);const m=t=>{let{onClick:n}=t;return(0,e.createElement)("span",{className:"author-item__delete",onClick:n},"×")},h=t=>{let{author:n}=t;const{ID:r,display_name:o}=n;return r>0?(0,e.createElement)("a",{href:`/wp-admin/user-edit.php?user_id=${r}`,target:"_blank"},o):o},v=t=>{let{author:n,index:r,onUnselect:o,onChangePosition:a}=t;return(0,e.createElement)("div",{className:"author-item "+(n.ID<0?"is-new-author":"")},(0,e.createElement)("span",{className:"autor-item__name"},(0,e.createElement)(h,{author:n}),(0,e.createElement)("span",{className:"author-item__nicename"},n.user_nicename)),(0,e.createElement)(m,{onClick:o}),(0,e.createElement)("span",{className:"author-item__move author-item__up",onClick:()=>a(r-1)},"▲"),(0,e.createElement)("span",{className:"author-item__move author-item__down",onClick:()=>a(r+1)},"▼"))};v.defaultProps={author:{ID:-1,display_name:"",user_login:""},className:""},v.propTypes={author:f().object.isRequired,index:f().number.isRequired,onUnselect:f().func.isRequired,onChangePosition:f().func.isRequired,isMainAuthor:f().bool.isRequired};var _=v,y=t=>{const{users:n,i18n:r}=t,o=d(),[a,s]=(()=>{const t=d(),n=(0,l.useSelect)((e=>e("core/editor").getCurrentPost().additional_authors)),r=(0,l.useSelect)((e=>e("core/editor").getPostEdits().additional_authors)),{editPost:o}=(0,l.useDispatch)("core/editor"),a=(r||n).filter((e=>parseInt(t)!==parseInt(e)));return(0,e.useEffect)((()=>{(a.includes(t+"")||a.includes(parseInt(t)))&&o(a.filter((e=>parseInt(e)!==parseInt(t))))}),[t,a]),[a,e=>{o({additional_authors:[t,...e]})}]})();return(0,e.createElement)("div",{style:{marginBottom:20}},(0,e.createElement)(c,{i18n:r,users:n.filter((e=>{const t=!a.includes(e.ID+"")&&!a.includes(parseInt(e.ID));return t||console.debug(e.ID,t),t&&parseInt(e.ID)!==parseInt(o)})),onFound:e=>{const t=[...new Set([...a,e.ID])];s(t),document.dispatchEvent(new CustomEvent("onAdditionalAuthorsChange",{detail:t.map((e=>n.find((t=>parseInt(t.ID)===parseInt(e)))))}))}}),(0,e.createElement)("div",null,a.filter((e=>parseInt(o)!==parseInt(e))).map(((t,r)=>(0,e.createElement)(_,{key:t,author:n.find((e=>parseInt(e.ID)===parseInt(t))),index:r,onChangePosition:e=>((e,t)=>{const n=a[e],r=a[t],o=[...a];o[e]=r,o[t]=n,s(o)})(r,e),onUnselect:()=>(e=>{s(a.filter((t=>parseInt(t)!==parseInt(e))))})(t),isMainAuthor:!1})))))};(0,t.registerPlugin)("post-status-info-test",{render:()=>(0,e.createElement)(r.PluginPostStatusInfo,null,(0,e.createElement)(y,AdditionalAuthors))})}()}();
//# sourceMappingURL=additional-authors.js.map