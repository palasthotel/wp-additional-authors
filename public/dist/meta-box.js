(()=>{var e={703:(e,t,n)=>{"use strict";var r=n(414);function o(){}function i(){}i.resetWarningCache=o,e.exports=function(){function e(e,t,n,o,i,a){if(a!==r){var s=new Error("Calling PropTypes validators directly is not supported by the `prop-types` package. Use PropTypes.checkPropTypes() to call them. Read more at http://fb.me/use-check-prop-types");throw s.name="Invariant Violation",s}}function t(){return e}e.isRequired=e;var n={array:e,bool:e,func:e,number:e,object:e,string:e,symbol:e,any:e,arrayOf:t,element:e,elementType:e,instanceOf:t,node:e,objectOf:t,oneOf:t,oneOfType:t,shape:t,exact:t,checkPropTypes:i,resetWarningCache:o};return n.PropTypes=n,n}},697:(e,t,n)=>{e.exports=n(703)()},414:e=>{"use strict";e.exports="SECRET_DO_NOT_PASS_THIS_OR_YOU_WILL_BE_FIRED"}},t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={exports:{}};return e[r](o,o.exports,n),o.exports}n.n=e=>{var t=e&&e.__esModule?()=>e.default:()=>e;return n.d(t,{a:t}),t},n.d=(e,t)=>{for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{"use strict";const e=ReactDOM;var t=n.n(e);const r=React;var o=n(697),i=n.n(o);const a=_;var s=n.n(a);function u(e){return(u="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function c(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function l(e,t){return(l=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function f(e,t){return!t||"object"!==u(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function h(e){return(h=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}const p=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&l(e,t)}(a,e);var t,n,r,o,i=(r=a,o=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=h(r);if(o){var n=h(this).constructor;e=Reflect.construct(t,arguments,n)}else e=t.apply(this,arguments);return f(this,e)});function a(e){var t;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,a),(t=i.call(this)).state={over:e.isOver},t}return t=a,(n=[{key:"componentWillReceiveProps",value:function(e){this.state.over=e.isOver}},{key:"render",value:function(){var e=this.props.author.display_name;return React.createElement("div",{onMouseOver:this.onMouseOver.bind(this,!0),onMouseOut:this.onMouseOver.bind(this,!1),onClick:this.onClick.bind(this),className:"additional-authors-search-item ".concat(this.state.over?"is-over":"")},e)}},{key:"onMouseOver",value:function(e){this.setState({over:e})}},{key:"onClick",value:function(){this.props.onSelect(this.props.author)}}])&&c(t.prototype,n),a}(r.Component);function y(e){return(y="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function d(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function v(e,t){return(v=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function m(e,t){return!t||"object"!==y(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function b(e){return(b=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}const g=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&v(e,t)}(a,e);var t,n,r,o,i=(r=a,o=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=b(r);if(o){var n=b(this).constructor;e=Reflect.construct(t,arguments,n)}else e=t.apply(this,arguments);return m(this,e)});function a(e){var t;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,a),(t=i.call(this)).state={over:e.isOver},t}return t=a,(n=[{key:"componentWillReceiveProps",value:function(e){this.state.over=e.isOver}},{key:"render",value:function(){return React.createElement("div",{onMouseOver:this.onMouseOver.bind(this,!0),onMouseOut:this.onMouseOver.bind(this,!1),onClick:this.onClick.bind(this),className:"additional-authors-new-item ".concat(this.state.over?"is-over":"")},'New user "',this.props.name,'"')}},{key:"onMouseOver",value:function(e){this.setState({over:e})}},{key:"onClick",value:function(){this.props.onSelect(this.props.name)}}])&&d(t.prototype,n),a}(r.Component);function O(e){return(O="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function S(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}function R(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function w(e,t){return(w=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function E(e,t){return!t||"object"!==O(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function C(e){return(C=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var k=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&w(e,t)}(a,e);var t,n,r,o,i=(r=a,o=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=C(r);if(o){var n=C(this).constructor;e=Reflect.construct(t,arguments,n)}else e=t.apply(this,arguments);return E(this,e)});function a(e){var t;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,a),(t=i.call(this,e)).state={query:"",over_index:0,search_result:[],focus:!1},t}return t=a,(n=[{key:"render",value:function(){var e=this.state.query;return React.createElement("div",{className:"additional-authors-search",onKeyUp:this.onKeyUp.bind(this)},React.createElement("label",null,this.props.languages.label,React.createElement("br",null),React.createElement("input",{className:"additional-authors-search__input",type:"text",value:e,onKeyDown:this.onKeyDown.bind(this),onChange:this.onChange.bind(this),onFocus:this.onFocusSearch.bind(this,!0),onBlur:this.onFocusSearch.bind(this,!1)})),this.renderList())}},{key:"renderList",value:function(){var e=this,t=(this.props.selected,this.state),n=t.over_index,r=t.search_result,o=t.focus,i=t.query;if(o){var a=""!==i?React.createElement(g,{name:i,isOver:n==r.length,onSelect:this.onNewItem.bind(this)}):null;return React.createElement("div",{className:"additional-authors-search-list"},r.map((function(t,r){return React.createElement(p,{key:t.ID,author:t,onSelect:e.onSelect.bind(e,t),isOver:n==r})})),a)}return null}},{key:"onChange",value:function(e){e&&(this.state.query=e.target.value);var t=this.props,n=t.users,r=t.selected,o=this.state.query,i=[];if(""!=o){var a,s=function(e,t){var n;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(e){if("string"==typeof e)return S(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?S(e,t):void 0}}(e))||t&&e&&"number"==typeof e.length){n&&(e=n);var r=0,o=function(){};return{s:o,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,a=!0,s=!1;return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next();return a=e.done,e},e:function(e){s=!0,i=e},f:function(){try{a||null==n.return||n.return()}finally{if(s)throw i}}}}(n);try{for(s.s();!(a=s.n()).done;){var u=a.value;if(u.display_name.toLowerCase().indexOf(o.toLowerCase())>-1){if(r.indexOf(u.ID)>=0)continue;i.unshift(u)}}}catch(e){s.e(e)}finally{s.f()}}else i=[];this.setState({over_index:0,search_result:i})}},{key:"onFocusSearch",value:function(e){var t=this;clearTimeout(this.closeTimeout),e?this.setState({focus:e}):this.closeTimeout=setTimeout((function(){t.setState({focus:e})}),600)}},{key:"onSelect",value:function(e){this.props.onSelect(e),this.setState({focus:!1}),this.onChange()}},{key:"onNewItem",value:function(e){""!==e&&(this.props.onSelect({ID:0,display_name:e,user_nicename:"-"}),this.setState({query:"",search_result:[]}))}},{key:"onKeyDown",value:function(e){13==e.keyCode&&this.state.focus&&(e.preventDefault(),"undefined"!=O(this.state.search_result[this.state.over_index])&&this.onSelect(this.state.search_result[this.state.over_index]))}},{key:"onKeyUp",value:function(e){this.state.focus&&(27!=e.keyCode?(38==e.keyCode?(e.preventDefault(),this.state.over_index--):40==e.keyCode&&(e.preventDefault(),this.state.over_index++),this.state.over_index>this.state.search_result.length?this.state.over_index=this.state.search_result.length:this.state.over_index<0&&(this.state.over_index=0),this.setState({over_index:this.state.over_index})):this.setState({search_result:[]}))}}])&&R(t.prototype,n),a}(r.Component);k.defaultProps={users:[]},k.propTypes={users:i().array.isRequired,selected:i().array.isRequired,languages:i().object.isRequired,onSelect:i().func.isRequired};const j=k;var P=function(e){var t=e.onClick;return React.createElement("span",{className:"author-item__delete",onClick:t},"×")},D=function(e){var t=e.author,n=t.ID,r=t.display_name;return n>0?React.createElement("a",{href:"/wp-admin/user-edit.php?user_id=".concat(n),target:"_blank"},r):r},I=function(e){var t=e.author,n=e.isMainAuthor,r=e.index,o=e.onUnselect,i=e.onChangePosition;return React.createElement("div",{className:"author-item".concat(n?" is-main-author":"").concat(t.ID<0?" is-new-author":"")},React.createElement("span",{className:"autor-item__name"},React.createElement(D,{author:t}),React.createElement("span",{className:"author-item__nicename"},t.user_nicename)),n?null:React.createElement(P,{onClick:o}),React.createElement("span",{className:"author-item__move author-item__up",onClick:function(){return i(r-1)}},"▲"),React.createElement("span",{className:"author-item__move author-item__down",onClick:function(){return i(r+1)}},"▼"),React.createElement("input",{type:"hidden",name:"additional_authors[ids][]",value:t.ID}),React.createElement("input",{type:"hidden",name:"additional_authors[names][]",value:t.display_name}))};I.defaultProps={author:{ID:-1,display_name:"",user_login:""},className:""},I.propTypes={author:i().object.isRequired,index:i().number.isRequired,onUnselect:i().func.isRequired,onChangePosition:i().func.isRequired,isMainAuthor:i().bool.isRequired};const x=I;function T(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function A(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?T(Object(n),!0).forEach((function(t){M(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):T(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function M(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function q(e){return(q="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function U(e,t){var n;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(n=function(e,t){if(e){if("string"==typeof e)return N(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?N(e,t):void 0}}(e))||t&&e&&"number"==typeof e.length){n&&(e=n);var r=0,o=function(){};return{s:o,n:function(){return r>=e.length?{done:!0}:{done:!1,value:e[r++]}},e:function(e){throw e},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var i,a=!0,s=!1;return{s:function(){n=e[Symbol.iterator]()},n:function(){var e=n.next();return a=e.done,e},e:function(e){s=!0,i=e},f:function(){try{a||null==n.return||n.return()}finally{if(s)throw i}}}}function N(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}function L(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function K(e,t){return(K=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function B(e,t){return!t||"object"!==q(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function F(e){return(F=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var W=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&K(e,t)}(a,e);var t,n,r,o,i=(r=a,o=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}(),function(){var e,t=F(r);if(o){var n=F(this).constructor;e=Reflect.construct(t,arguments,n)}else e=t.apply(this,arguments);return B(this,e)});function a(e){var t;return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,a),(t=i.call(this,e)).state={users:e.users,selected:t.props.selected,new_user_id:-1},t}return t=a,(n=[{key:"componentDidMount",value:function(){this.dispatchChanged(),this.getMainUserControl()}},{key:"render",value:function(){var e=this,t=this.props,n=t.language,r=t.isGutenbergActive,o=this.state,i=o.selected,a=o.users,s=(o.new_users,o.main_author,null);return r&&(s=React.createElement("input",{type:"hidden",name:"additional_authors_is_gutenberg",value:"it-is"})),React.createElement("div",{className:"additional-authors"},s,React.createElement(j,{users:a,selected:i,languages:n,onSelect:this.onSelect.bind(this)}),React.createElement("hr",null),React.createElement("p",null,React.createElement("i",null,n.description)),React.createElement("div",null,i.map((function(t,n){if(r&&0===n)return null;for(var o in a)if(a.hasOwnProperty(o)){var i=a[o];if(parseInt(i.ID)===parseInt(t))return React.createElement(x,{key:t,index:n,author:i,onUnselect:e.onUnselect.bind(e,i),onChangePosition:e.onChangePosition.bind(e,i,n),isMainAuthor:0===n})}return null}))))}},{key:"onSelect",value:function(e){0==e.ID&&(e.ID=this.state.new_user_id--,this.state.users.push(e)),this.state.selected.push(e.ID),this.state.selected=s().unique(this.state.selected),this.setState({selected:this.state.selected}),this.dispatchChanged()}},{key:"onUnselect",value:function(e){var t=[];if(this.state.main_author!=e.ID){var n,r=U(this.state.selected);try{for(r.s();!(n=r.n()).done;){var o=n.value;o!=e.ID&&t.push(o)}}catch(e){r.e(e)}finally{r.f()}this.setState({selected:t}),this.dispatchChanged()}else console.log("you cannot delete main author")}},{key:"onChangePosition",value:function(e,t,n){var r=[];if(!(0==n&&e.ID<=0)){for(var o in this.state.selected)this.state.selected.hasOwnProperty(o)&&(o==t?r.push(this.state.selected[n]):o==n?r.push(this.state.selected[t]):r.push(this.state.selected[o]));this.setMainUserID(r[0]),this.setState({selected:r,main_author:this.getMainUserID()}),this.dispatchChanged()}}},{key:"onMainAuthorChanged",value:function(e){for(var t=e.target.value,n=0;n<this.state.selected.length;){if(this.state.selected[n]===t){this.state.selected.splice(n,1);break}n++}this.state.selected.unshift(t),this.setState({selected:this.state.selected})}},{key:"getMainUserControl",value:function(){if(this.props.isGutenbergActive)return null;if(null!=this._main_user_select)return this._main_user_select;var e=document.getElementById("post_author_override");return null==e&&(e=document.getElementById("post-author-selector-1")),null!=e&&(this._main_user_select=e,this._main_user_select.addEventListener("change",this.onMainAuthorChanged.bind(this))),this._main_user_select}},{key:"setMainUserID",value:function(e){var t=this.getMainUserControl();"undefined"!==q(t)&&null!=t&&(t.value=e,t.dispatchEvent(new Event("change")))}},{key:"getMainUserID",value:function(){var e=this.getMainUserControl();return"undefined"!==q(e)&&null!==e?e.value:-1}},{key:"isSelected",value:function(e){var t,n=U(this.state.selected);try{for(n.s();!(t=n.n()).done;)if(t.value===e)return!0}catch(e){n.e(e)}finally{n.f()}return!1}},{key:"dispatchChanged",value:function(){var e=this;clearTimeout(this.dispatchTimeout),this.dispatchTimeout=setTimeout((function(){var t,n=[],r=U(e.state.selected);try{for(r.s();!(t=r.n()).done;){var o,i=t.value,a=U(e.props.users);try{for(a.s();!(o=a.n()).done;){var s=o.value;parseInt(s.ID)===parseInt(i)&&n.push(A({},s))}}catch(e){a.e(e)}finally{a.f()}}}catch(e){r.e(e)}finally{r.f()}e.props.onAuthorsChange(n)}),300)}}])&&L(t.prototype,n),a}(r.Component);W.defaultProps={users:[],language:{},onAuthorsChange:function(){}},W.propTypes={isGutenbergActive:i().bool.isRequired,users:i().array.isRequired,selected:i().array.isRequired,language:i().object.isRequired,onAuthorsChange:i().func};const G=W;function $(e){return($="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}document.addEventListener("DOMContentLoaded",(function(e){var n=AdditionalAuthors,r=n.language,o=n.users,i=n.selected,a=n.root_id,s="undefined"!==$(wp.blocks);t().render(React.createElement(G,{isGutenbergActive:s,language:r,users:o,selected:i,onAuthorsChange:function(e){document.dispatchEvent(new CustomEvent("onAdditionalAuthorsChange",{detail:e}))}}),document.getElementById(a))}))})()})();
//# sourceMappingURL=meta-box.js.map