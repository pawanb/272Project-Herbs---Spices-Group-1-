/* FILE: /media/com_comment/js/libraries/requirejs/require.min.js */
/*
 RequireJS 2.0.2 Copyright (c) 2010-2012, The Dojo Foundation All Rights Reserved.
 Available via the MIT or new BSD license.
 see: http://github.com/jrburke/requirejs for details
*/
var requirejs,require,define;
(function(Z){function w(b){return J.call(b)==="[object Function]"}function G(b){return J.call(b)==="[object Array]"}function q(b,d){if(b){var f;for(f=0;f<b.length;f+=1)if(b[f]&&d(b[f],f,b))break}}function N(b,d){if(b){var f;for(f=b.length-1;f>-1;f-=1)if(b[f]&&d(b[f],f,b))break}}function x(b,d){for(var f in b)if(b.hasOwnProperty(f)&&d(b[f],f))break}function K(b,d,f,g){d&&x(d,function(d,k){if(f||!b.hasOwnProperty(k))g&&typeof d!=="string"?(b[k]||(b[k]={}),K(b[k],d,f,g)):b[k]=d});return b}function s(b,
d){return function(){return d.apply(b,arguments)}}function $(b){if(!b)return b;var d=Z;q(b.split("."),function(b){d=d[b]});return d}function aa(b,d,f){return function(){var g=ga.call(arguments,0),e;if(f&&w(e=g[g.length-1]))e.__requireJsBuild=!0;g.push(d);return b.apply(null,g)}}function ba(b,d,f){q([["toUrl"],["undef"],["defined","requireDefined"],["specified","requireSpecified"]],function(g){var e=g[1]||g[0];b[g[0]]=d?aa(d[e],f):function(){var b=t[O];return b[e].apply(b,arguments)}})}function H(b,
d,f,g){d=Error(d+"\nhttp://requirejs.org/docs/errors.html#"+b);d.requireType=b;d.requireModules=g;if(f)d.originalError=f;return d}function ha(){if(I&&I.readyState==="interactive")return I;N(document.getElementsByTagName("script"),function(b){if(b.readyState==="interactive")return I=b});return I}var ia=/(\/\*([\s\S]*?)\*\/|([^:]|^)\/\/(.*)$)/mg,ja=/require\s*\(\s*["']([^'"\s]+)["']\s*\)/g,ca=/\.js$/,ka=/^\.\//,J=Object.prototype.toString,y=Array.prototype,ga=y.slice,la=y.splice,u=!!(typeof window!==
"undefined"&&navigator&&document),da=!u&&typeof importScripts!=="undefined",ma=u&&navigator.platform==="PLAYSTATION 3"?/^complete$/:/^(complete|loaded)$/,O="_",S=typeof opera!=="undefined"&&opera.toString()==="[object Opera]",t={},p={},P=[],L=!1,k,v,C,z,D,I,E,ea,fa;if(typeof define==="undefined"){if(typeof requirejs!=="undefined"){if(w(requirejs))return;p=requirejs;requirejs=void 0}typeof require!=="undefined"&&!w(require)&&(p=require,require=void 0);k=requirejs=function(b,d,f,g){var e=O,r;!G(b)&&
typeof b!=="string"&&(r=b,G(d)?(b=d,d=f,f=g):b=[]);if(r&&r.context)e=r.context;(g=t[e])||(g=t[e]=k.s.newContext(e));r&&g.configure(r);return g.require(b,d,f)};k.config=function(b){return k(b)};require||(require=k);k.version="2.0.2";k.jsExtRegExp=/^\/|:|\?|\.js$/;k.isBrowser=u;y=k.s={contexts:t,newContext:function(b){function d(a,c,l){var A=c&&c.split("/"),b=m.map,i=b&&b["*"],h,d,f,e;if(a&&a.charAt(0)===".")if(c){A=m.pkgs[c]?[c]:A.slice(0,A.length-1);c=a=A.concat(a.split("/"));for(h=0;c[h];h+=1)if(d=
c[h],d===".")c.splice(h,1),h-=1;else if(d==="..")if(h===1&&(c[2]===".."||c[0]===".."))break;else h>0&&(c.splice(h-1,2),h-=2);h=m.pkgs[c=a[0]];a=a.join("/");h&&a===c+"/"+h.main&&(a=c)}else a.indexOf("./")===0&&(a=a.substring(2));if(l&&(A||i)&&b){c=a.split("/");for(h=c.length;h>0;h-=1){f=c.slice(0,h).join("/");if(A)for(d=A.length;d>0;d-=1)if(l=b[A.slice(0,d).join("/")])if(l=l[f]){e=l;break}!e&&i&&i[f]&&(e=i[f]);if(e){c.splice(0,h,e);a=c.join("/");break}}}return a}function f(a){u&&q(document.getElementsByTagName("script"),
function(c){if(c.getAttribute("data-requiremodule")===a&&c.getAttribute("data-requirecontext")===j.contextName)return c.parentNode.removeChild(c),!0})}function g(a){var c=m.paths[a];if(c&&G(c)&&c.length>1)return f(a),c.shift(),j.undef(a),j.require([a]),!0}function e(a,c,l,b){var T=a?a.indexOf("!"):-1,i=null,h=c?c.name:null,f=a,e=!0,g="",k,m;a||(e=!1,a="_@r"+(N+=1));T!==-1&&(i=a.substring(0,T),a=a.substring(T+1,a.length));i&&(i=d(i,h,b),m=o[i]);a&&(i?g=m&&m.normalize?m.normalize(a,function(a){return d(a,
h,b)}):d(a,h,b):(g=d(a,h,b),k=j.nameToUrl(a,null,c)));a=i&&!m&&!l?"_unnormalized"+(O+=1):"";return{prefix:i,name:g,parentMap:c,unnormalized:!!a,url:k,originalName:f,isDefine:e,id:(i?i+"!"+g:g)+a}}function r(a){var c=a.id,l=n[c];l||(l=n[c]=new j.Module(a));return l}function p(a,c,l){var b=a.id,d=n[b];if(o.hasOwnProperty(b)&&(!d||d.defineEmitComplete))c==="defined"&&l(o[b]);else r(a).on(c,l)}function B(a,c){var l=a.requireModules,b=!1;if(c)c(a);else if(q(l,function(c){if(c=n[c])c.error=a,c.events.error&&
(b=!0,c.emit("error",a))}),!b)k.onError(a)}function v(){P.length&&(la.apply(F,[F.length-1,0].concat(P)),P=[])}function t(a,c,l){a=a&&a.map;c=aa(l||j.require,a,c);ba(c,j,a);c.isBrowser=u;return c}function y(a){delete n[a];q(M,function(c,l){if(c.map.id===a)return M.splice(l,1),c.defined||(j.waitCount-=1),!0})}function z(a,c){var l=a.map.id,b=a.depMaps,d;if(a.inited){if(c[l])return a;c[l]=!0;q(b,function(a){if(a=n[a.id])return!a.inited||!a.enabled?(d=null,delete c[l],!0):d=z(a,K({},c))});return d}}function C(a,
c,b){var d=a.map.id,e=a.depMaps;if(a.inited&&a.map.isDefine){if(c[d])return o[d];c[d]=a;q(e,function(i){var i=i.id,h=n[i];!Q[i]&&h&&(!h.inited||!h.enabled?b[d]=!0:(h=C(h,c,b),b[i]||a.defineDepById(i,h)))});a.check(!0);return o[d]}}function D(a){a.check()}function E(){var a=m.waitSeconds*1E3,c=a&&j.startTime+a<(new Date).getTime(),b=[],d=!1,e=!0,i,h,k;if(!U){U=!0;x(n,function(a){i=a.map;h=i.id;if(a.enabled&&!a.error)if(!a.inited&&c)g(h)?d=k=!0:(b.push(h),f(h));else if(!a.inited&&a.fetched&&i.isDefine&&
(d=!0,!i.prefix))return e=!1});if(c&&b.length)return a=H("timeout","Load timeout for modules: "+b,null,b),a.contextName=j.contextName,B(a);e&&(q(M,function(a){if(!a.defined){var a=z(a,{}),c={};a&&(C(a,c,{}),x(c,D))}}),x(n,D));if((!c||k)&&d)if((u||da)&&!V)V=setTimeout(function(){V=0;E()},50);U=!1}}function W(a){r(e(a[0],null,!0)).init(a[1],a[2])}function J(a){var a=a.currentTarget||a.srcElement,c=j.onScriptLoad;a.detachEvent&&!S?a.detachEvent("onreadystatechange",c):a.removeEventListener("load",c,
!1);c=j.onScriptError;a.detachEvent&&!S||a.removeEventListener("error",c,!1);return{node:a,id:a&&a.getAttribute("data-requiremodule")}}var m={waitSeconds:7,baseUrl:"./",paths:{},pkgs:{},shim:{}},n={},X={},F=[],o={},R={},N=1,O=1,M=[],U,Y,j,Q,V;Q={require:function(a){return t(a)},exports:function(a){a.usingExports=!0;if(a.map.isDefine)return a.exports=o[a.map.id]={}},module:function(a){return a.module={id:a.map.id,uri:a.map.url,config:function(){return m.config&&m.config[a.map.id]||{}},exports:o[a.map.id]}}};
Y=function(a){this.events=X[a.id]||{};this.map=a;this.shim=m.shim[a.id];this.depExports=[];this.depMaps=[];this.depMatched=[];this.pluginMaps={};this.depCount=0};Y.prototype={init:function(a,c,b,d){d=d||{};if(!this.inited){this.factory=c;if(b)this.on("error",b);else this.events.error&&(b=s(this,function(a){this.emit("error",a)}));this.depMaps=a&&a.slice(0);this.depMaps.rjsSkipMap=a.rjsSkipMap;this.errback=b;this.inited=!0;this.ignore=d.ignore;d.enabled||this.enabled?this.enable():this.check()}},defineDepById:function(a,
c){var b;q(this.depMaps,function(c,d){if(c.id===a)return b=d,!0});return this.defineDep(b,c)},defineDep:function(a,c){this.depMatched[a]||(this.depMatched[a]=!0,this.depCount-=1,this.depExports[a]=c)},fetch:function(){if(!this.fetched){this.fetched=!0;j.startTime=(new Date).getTime();var a=this.map;if(this.shim)t(this,!0)(this.shim.deps||[],s(this,function(){return a.prefix?this.callPlugin():this.load()}));else return a.prefix?this.callPlugin():this.load()}},load:function(){var a=this.map.url;R[a]||
(R[a]=!0,j.load(this.map.id,a))},check:function(a){if(this.enabled&&!this.enabling){var c=this.map.id,b=this.depExports,d=this.exports,e=this.factory,i;if(this.inited)if(this.error)this.emit("error",this.error);else{if(!this.defining){this.defining=!0;if(this.depCount<1&&!this.defined){if(w(e)){if(this.events.error)try{d=j.execCb(c,e,b,d)}catch(h){i=h}else d=j.execCb(c,e,b,d);if(this.map.isDefine)if((b=this.module)&&b.exports!==void 0&&b.exports!==this.exports)d=b.exports;else if(d===void 0&&this.usingExports)d=
this.exports;if(i)return i.requireMap=this.map,i.requireModules=[this.map.id],i.requireType="define",B(this.error=i)}else d=e;this.exports=d;if(this.map.isDefine&&!this.ignore&&(o[c]=d,k.onResourceLoad))k.onResourceLoad(j,this.map,this.depMaps);delete n[c];this.defined=!0;j.waitCount-=1;j.waitCount===0&&(M=[])}this.defining=!1;if(!a&&this.defined&&!this.defineEmitted)this.defineEmitted=!0,this.emit("defined",this.exports),this.defineEmitComplete=!0}}else this.fetch()}},callPlugin:function(){var a=
this.map,c=a.id,b=e(a.prefix,null,!1,!0);p(b,"defined",s(this,function(b){var l=this.map.name,i=this.map.parentMap?this.map.parentMap.name:null;if(this.map.unnormalized){if(b.normalize&&(l=b.normalize(l,function(a){return d(a,i,!0)})||""),b=e(a.prefix+"!"+l,this.map.parentMap,!1,!0),p(b,"defined",s(this,function(a){this.init([],function(){return a},null,{enabled:!0,ignore:!0})})),b=n[b.id]){if(this.events.error)b.on("error",s(this,function(a){this.emit("error",a)}));b.enable()}}else l=s(this,function(a){this.init([],
function(){return a},null,{enabled:!0})}),l.error=s(this,function(a){this.inited=!0;this.error=a;a.requireModules=[c];x(n,function(a){a.map.id.indexOf(c+"_unnormalized")===0&&y(a.map.id)});B(a)}),l.fromText=function(a,c){var b=L;b&&(L=!1);r(e(a));k.exec(c);b&&(L=!0);j.completeLoad(a)},b.load(a.name,t(a.parentMap,!0,function(a,c){a.rjsSkipMap=!0;return j.require(a,c)}),l,m)}));j.enable(b,this);this.pluginMaps[b.id]=b},enable:function(){this.enabled=!0;if(!this.waitPushed)M.push(this),j.waitCount+=
1,this.waitPushed=!0;this.enabling=!0;q(this.depMaps,s(this,function(a,c){var b,d;if(typeof a==="string"){a=e(a,this.map.isDefine?this.map:this.map.parentMap,!1,!this.depMaps.rjsSkipMap);this.depMaps[c]=a;if(b=Q[a.id]){this.depExports[c]=b(this);return}this.depCount+=1;p(a,"defined",s(this,function(a){this.defineDep(c,a);this.check()}));this.errback&&p(a,"error",this.errback)}b=a.id;d=n[b];!Q[b]&&d&&!d.enabled&&j.enable(a,this)}));x(this.pluginMaps,s(this,function(a){var c=n[a.id];c&&!c.enabled&&
j.enable(a,this)}));this.enabling=!1;this.check()},on:function(a,c){var b=this.events[a];b||(b=this.events[a]=[]);b.push(c)},emit:function(a,c){q(this.events[a],function(a){a(c)});a==="error"&&delete this.events[a]}};return j={config:m,contextName:b,registry:n,defined:o,urlFetched:R,waitCount:0,defQueue:F,Module:Y,makeModuleMap:e,configure:function(a){a.baseUrl&&a.baseUrl.charAt(a.baseUrl.length-1)!=="/"&&(a.baseUrl+="/");var c=m.pkgs,b=m.shim,d=m.paths,f=m.map;K(m,a,!0);m.paths=K(d,a.paths,!0);if(a.map)m.map=
K(f||{},a.map,!0,!0);if(a.shim)x(a.shim,function(a,c){G(a)&&(a={deps:a});if(a.exports&&!a.exports.__buildReady)a.exports=j.makeShimExports(a.exports);b[c]=a}),m.shim=b;if(a.packages)q(a.packages,function(a){a=typeof a==="string"?{name:a}:a;c[a.name]={name:a.name,location:a.location||a.name,main:(a.main||"main").replace(ka,"").replace(ca,"")}}),m.pkgs=c;x(n,function(a,c){a.map=e(c)});if(a.deps||a.callback)j.require(a.deps||[],a.callback)},makeShimExports:function(a){var c;return typeof a==="string"?
(c=function(){return $(a)},c.exports=a,c):function(){return a.apply(Z,arguments)}},requireDefined:function(a,c){var b=e(a,c,!1,!0).id;return o.hasOwnProperty(b)},requireSpecified:function(a,c){a=e(a,c,!1,!0).id;return o.hasOwnProperty(a)||n.hasOwnProperty(a)},require:function(a,c,d,f){var g;if(typeof a==="string"){if(w(c))return B(H("requireargs","Invalid require call"),d);if(k.get)return k.get(j,a,c);a=e(a,c,!1,!0);a=a.id;return!o.hasOwnProperty(a)?B(H("notloaded",'Module name "'+a+'" has not been loaded yet for context: '+
b)):o[a]}d&&!w(d)&&(f=d,d=void 0);c&&!w(c)&&(f=c,c=void 0);for(v();F.length;)if(g=F.shift(),g[0]===null)return B(H("mismatch","Mismatched anonymous define() module: "+g[g.length-1]));else W(g);r(e(null,f)).init(a,c,d,{enabled:!0});E();return j.require},undef:function(a){var c=e(a,null,!0),b=n[a];delete o[a];delete R[c.url];delete X[a];if(b){if(b.events.defined)X[a]=b.events;y(a)}},enable:function(a){n[a.id]&&r(a).enable()},completeLoad:function(a){var c=m.shim[a]||{},b=c.exports&&c.exports.exports,
d,e;for(v();F.length;){e=F.shift();if(e[0]===null){e[0]=a;if(d)break;d=!0}else e[0]===a&&(d=!0);W(e)}e=n[a];if(!d&&!o[a]&&e&&!e.inited)if(m.enforceDefine&&(!b||!$(b)))if(g(a))return;else return B(H("nodefine","No define call for "+a,null,[a]));else W([a,c.deps||[],c.exports]);E()},toUrl:function(a,b){var d=a.lastIndexOf("."),e=null;d!==-1&&(e=a.substring(d,a.length),a=a.substring(0,d));return j.nameToUrl(a,e,b)},nameToUrl:function(a,b,e){var f,g,i,h,j,a=d(a,e&&e.id,!0);if(k.jsExtRegExp.test(a))b=
a+(b||"");else{f=m.paths;g=m.pkgs;e=a.split("/");for(h=e.length;h>0;h-=1)if(j=e.slice(0,h).join("/"),i=g[j],j=f[j]){G(j)&&(j=j[0]);e.splice(0,h,j);break}else if(i){a=a===i.name?i.location+"/"+i.main:i.location;e.splice(0,h,a);break}b=e.join("/")+(b||".js");b=(b.charAt(0)==="/"||b.match(/^[\w\+\.\-]+:/)?"":m.baseUrl)+b}return m.urlArgs?b+((b.indexOf("?")===-1?"?":"&")+m.urlArgs):b},load:function(a,b){k.load(j,a,b)},execCb:function(a,b,d,e){return b.apply(e,d)},onScriptLoad:function(a){if(a.type===
"load"||ma.test((a.currentTarget||a.srcElement).readyState))I=null,a=J(a),j.completeLoad(a.id)},onScriptError:function(a){var b=J(a);if(!g(b.id))return B(H("scripterror","Script error",a,[b.id]))}}}};k({});ba(k);if(u&&(v=y.head=document.getElementsByTagName("head")[0],C=document.getElementsByTagName("base")[0]))v=y.head=C.parentNode;k.onError=function(b){throw b;};k.load=function(b,d,f){var g=b&&b.config||{},e;if(u)return e=g.xhtml?document.createElementNS("http://www.w3.org/1999/xhtml","html:script"):
document.createElement("script"),e.type=g.scriptType||"text/javascript",e.charset="utf-8",e.setAttribute("data-requirecontext",b.contextName),e.setAttribute("data-requiremodule",d),e.attachEvent&&!(e.attachEvent.toString&&e.attachEvent.toString().indexOf("[native code")<0)&&!S?(L=!0,e.attachEvent("onreadystatechange",b.onScriptLoad)):(e.addEventListener("load",b.onScriptLoad,!1),e.addEventListener("error",b.onScriptError,!1)),e.src=f,E=e,C?v.insertBefore(e,C):v.appendChild(e),E=null,e;else da&&(importScripts(f),
b.completeLoad(d))};u&&N(document.getElementsByTagName("script"),function(b){if(!v)v=b.parentNode;if(z=b.getAttribute("data-main")){D=z.split("/");ea=D.pop();fa=D.length?D.join("/")+"/":"./";if(!p.baseUrl)p.baseUrl=fa;z=ea.replace(ca,"");p.deps=p.deps?p.deps.concat(z):[z];return!0}});define=function(b,d,f){var g,e;typeof b!=="string"&&(f=d,d=b,b=null);G(d)||(f=d,d=[]);!d.length&&w(f)&&f.length&&(f.toString().replace(ia,"").replace(ja,function(b,e){d.push(e)}),d=(f.length===1?["require"]:["require",
"exports","module"]).concat(d));if(L&&(g=E||ha()))b||(b=g.getAttribute("data-requiremodule")),e=t[g.getAttribute("data-requirecontext")];(e?e.defQueue:P).push([b,d,f])};define.amd={jQuery:!0};k.exec=function(b){return eval(b)};k(p)}})(this);
;


/* FILE: /media/com_comment/js/dynamictextarea.js */
/*
 ---
 description: DynamicTextarea

 license: MIT-style

 authors:
 - Amadeus Demarzi (http://amadeusamade.us)

 requires:
 core/1.3: [Core/Class, Core/Element, Core/Element.Event, Core/Element.Style, Core/Element.Dimensions]

 provides: [DynamicTextarea]
 ...
 */

(function () {

// Prevent the plugin from overwriting existing variables
	if (this.DynamicTextarea) return;

	var DynamicTextarea = this.DynamicTextarea = new Class({

		Implements:[Options, Events],

		options:{
			value:'',
			minRows:1,
			delay:true,
			lineHeight:null,
			offset:0,
			padding:0

// AVAILABLE EVENTS
// onCustomLineHeight: (function) - custom ways of determining lineHeight if necessary

// onInit: (function)

// onFocus: (function)
// onBlur: (function)

// onKeyPress: (function)
// onResize: (function)

// onEnable: (function)
// onDisable: (function)

// onClean: (function)
		},

		textarea:null,

		initialize:function (textarea, options) {
			this.textarea = document.id(textarea);
			if (!this.textarea) return;

			this.setOptions(options);

			this.parentEl = new Element('div', {
				styles:{
					padding:0,
					margin:0,
					border:0,
					height:'auto',
					width:'auto'
				}
			})
				.inject(this.textarea, 'after')
				.adopt(this.textarea);

// Prebind common methods
			['focus', 'delayCheck', 'blur', 'scrollFix', 'checkSize', 'clean', 'disable', 'enable', 'getLineHeight']
				.each(function (method) {
					this[method] = this[method].bind(this);
				}, this);

// Firefox and Opera handle scroll heights differently than all other browsers
			if (window.Browser.firefox || window.Browser.opera) {
				this.options.offset =
					parseInt(this.textarea.getStyle('padding-top'), 10) +
						parseInt(this.textarea.getStyle('padding-bottom'), 10) +
						parseInt(this.textarea.getStyle('border-bottom-width'), 10) +
						parseInt(this.textarea.getStyle('border-top-width'), 10);
				this.options.padding = -10;
			} else {
				this.options.offset =
					parseInt(this.textarea.getStyle('border-bottom-width'), 10) +
						parseInt(this.textarea.getStyle('border-top-width'), 10);
				this.options.padding = 0;

			}

// Disable browser resize handles, set appropriate styles
			this.textarea.set({
				'rows':1,
				'styles':{
					'resize':'none',
					'-moz-resize':'none',
					'-webkit-resize':'none',
					'position':'relative',
					'display':'block',
					'overflow':'hidden',
					'height':'auto'
				}
			});

			this.getLineHeight();
			this.fireEvent('customLineHeight');

// Set the height of the textarea, based on content
			this.checkSize(true);
			this.textarea.addEvent('focus', this.focus);
			this.fireEvent('init', [textarea, options]);
		},

// This is the only crossbrowser method to determine ACTUAL lineHeight in a textarea (that I am aware of)
		getLineHeight:function () {
			var backupValue = this.textarea.value;
			this.textarea.value = 'M';
			this.options.lineHeight = this.textarea.getScrollSize().y - this.options.padding;
			this.textarea.value = backupValue;
			this.textarea.setStyle('height', this.options.lineHeight * this.options.minRows);
		},

// Stops a small scroll jump on some browsers
		scrollFix:function () {
			this.textarea.scrollTo(0, 0);
		},

// Add interactive events, and fire focus event
		focus:function () {
			this.textarea.addEvents({
				'keydown':this.delayCheck,
				'keypress':this.delayCheck,
				'blur':this.blur,
				'scroll':this.scrollFix
			});
			return this.fireEvent('focus');
		},

// Clean out extraneaous events, and fire blur event
		blur:function () {
			this.textarea.removeEvents({
				'keydown':this.delayCheck,
				'keypress':this.delayCheck,
				'blur':this.blur,
				'scroll':this.scrollFix
			});
			return this.fireEvent('blur');
		},

// Delay checkSize because text hasn't been injected into the textarea yet
		delayCheck:function () {
			if (this.options.delay === true)
				this.options.delay = this.checkSize.delay(1);
		},

// Determine if it needs to be resized or not, and resize if necessary
		checkSize:function (forced) {
			var oldValue = this.options.value,
				modifiedParent = false;

			this.options.value = this.textarea.value;
			this.options.delay = false;

			if (this.options.value === oldValue && forced !== true)
				return this.options.delay = true;

			if (!oldValue || this.options.value.length < oldValue.length || forced) {
				modifiedParent = true;
				this.parentEl.setStyle('height', this.parentEl.getSize().y);
				this.textarea.setStyle('height', this.options.minRows * this.options.lineHeight);
			}

			var tempHeight = this.textarea.getScrollSize().y,
				offsetHeight = this.textarea.offsetHeight,
				cssHeight = tempHeight - this.options.padding,
				scrollHeight = tempHeight + this.options.offset;

			if (scrollHeight !== offsetHeight && cssHeight > this.options.minRows * this.options.lineHeight) {
				this.textarea.setStyle('height', cssHeight);
				this.fireEvent('resize');
			}

			if (modifiedParent) this.parentEl.setStyle('height', 'auto');

			this.options.delay = true;
			if (forced !== true)
				return this.fireEvent('keyPress');
		},

// Clean out this textarea's event handlers
		clean:function () {
			this.textarea.removeEvents({
				'focus':this.focus,
				'keydown':this.delayCheck,
				'keypress':this.delayCheck,
				'blur':this.blur,
				'scroll':this.scrollFix
			});
			return this.fireEvent('clean');
		},

// Disable the textarea
		disable:function () {
			this.textarea.blur();
			this.clean();
			this.textarea.set(this.options.disabled, true);
			return this.fireEvent('disable');
		},

// Enables the textarea
		enable:function () {
			this.textarea.addEvents({
				'focus':this.focus,
				'scroll':this.scrollFix
			});
			this.textarea.set(this.options.disabled, false);
			return this.fireEvent('enable');
		}
	});

})();;


/* FILE: /media/com_comment/js/String.MD5.js */
/*
---
name: String.MD5
description: String MD5 hashing.
license: MIT-style
authors: [Christopher Pitt, Enrique Erne]
requires: 
  - Core/String
  - String.toUTF8
provides: [String.toMD5]
...
*/

(function(){

	var transforms = {
		'f': function(a, b, c){
			return (a & b) | ((~a) & c);
		},
		'g': function(a, b, c){
			return (a & c) | (b & (~c));
		},
		'h': function(a, b, c){
			return (a ^ b ^ c);
		},
		'i': function(a, b, c){
			return (b ^ (a | (~c)));
		},
		'rotateLeft': function(a, b){
			return (a << b) | (a >>> (32 - b));
		},
		'addUnsigned': function(a, b){
			var a8 = (a & 0x80000000),
				b8 = (b & 0x80000000),
				a4 = (a & 0x40000000),
				b4 = (b & 0x40000000),
				result = (a & 0x3FFFFFFF) + (b & 0x3FFFFFFF);

			if (a4 & b4){
				return (result ^ 0x80000000 ^ a8 ^ b8);
			}

			if (a4 | b4){
				if (result & 0x40000000){
					return (result ^ 0xC0000000 ^ a8 ^ b8);
				} else {
					return (result ^ 0x40000000 ^ a8 ^ b8);
				}
			} else {
				return (result ^ a8 ^ b8);
			}
		},
		'compound': function(a, b, c, d, e, f, g, h){
			var trans = transforms,
				add = trans.addUnsigned,
				temp = add(b, add(add(trans[a](c, d, e), g), f));

			return add(trans.rotateLeft(temp, h), c);
		}
	};

	function convertToArray(string){
		var messageLength = string.length,
			numberOfWords = (((messageLength + 8) - ((messageLength + 8) % 64)) / 64 + 1) * 16,
			wordArray = new Array(),
			wordCount = bytePosition = byteCount = 0;

		while (byteCount < messageLength){
			wordCount = (byteCount - (byteCount % 4)) / 4;
			bytePosition = (byteCount % 4) * 8;
			wordArray[wordCount] = (wordArray[wordCount] | (string.charCodeAt(byteCount) << bytePosition));
			byteCount++;
		}

		wordCount = (byteCount - (byteCount % 4)) / 4;
		bytePosition = (byteCount % 4) * 8;
		wordArray[wordCount] = wordArray[wordCount] | (0x80 << bytePosition);
		wordArray[numberOfWords - 2] = messageLength << 3;
		wordArray[numberOfWords - 1] = messageLength >>> 29;

		return wordArray;
	}

	function convertToHex(string){
		var result = temp = nibble = i = '';

		for (i = 0; i <= 3; i++){
			nibble = (string >>> (i * 8)) & 255;
			temp = "0" + nibble.toString(16);
			result = result + temp.substr(temp.length-2, 2);
		}

		return result;
	}

	function md5(string){
		var t1, t2, t3, t4,
			x = convertToArray(string.toUTF8()),
			
			a = 0x67452301, b = 0xEFCDAB89,
			c = 0x98BADCFE, d = 0x10325476,
			
			s1 = 7, s2 = 12, s3 = 17, s4 = 22,
			s5 = 5, s6 = 9, s7 = 14, s8 = 20,
			s9 = 4, s10 = 11, s11 = 16, s12 = 23,
			s13 = 6, s14 = 10, s15 = 15, s16 = 21;

		for (var k = 0; k < x.length; k += 16){
			t1 = a; t2 = b; t3 = c; t4 = d;

			a = transforms.compound('f', a, b, c, d, 0xD76AA478, x[k + 0], s1);
			d = transforms.compound('f', d, a, b, c, 0xE8C7B756, x[k + 1], s2);
			c = transforms.compound('f', c, d, a, b, 0x242070DB, x[k + 2], s3);
			b = transforms.compound('f', b, c, d, a, 0xC1BDCEEE, x[k + 3], s4);
			a = transforms.compound('f', a, b, c, d, 0xF57C0FAF, x[k + 4], s1);
			d = transforms.compound('f', d, a, b, c, 0x4787C62A, x[k + 5], s2);
			c = transforms.compound('f', c, d, a, b, 0xA8304613, x[k + 6], s3);
			b = transforms.compound('f', b, c, d, a, 0xFD469501, x[k + 7], s4);
			a = transforms.compound('f', a, b, c, d, 0x698098D8, x[k + 8], s1);
			d = transforms.compound('f', d, a, b, c, 0x8B44F7AF, x[k + 9], s2);
			c = transforms.compound('f', c, d, a, b, 0xFFFF5BB1, x[k + 10], s3);
			b = transforms.compound('f', b, c, d, a, 0x895CD7BE, x[k + 11], s4);
			a = transforms.compound('f', a, b, c, d, 0x6B901122, x[k + 12], s1);
			d = transforms.compound('f', d, a, b, c, 0xFD987193, x[k + 13], s2);
			c = transforms.compound('f', c, d, a, b, 0xA679438E, x[k + 14], s3);
			b = transforms.compound('f', b, c, d, a, 0x49B40821, x[k + 15], s4);
			a = transforms.compound('g', a, b, c, d, 0xF61E2562, x[k + 1], s5);
			d = transforms.compound('g', d, a, b, c, 0xC040B340, x[k + 6], s6);
			c = transforms.compound('g', c, d, a, b, 0x265E5A51, x[k + 11], s7);
			b = transforms.compound('g', b, c, d, a, 0xE9B6C7AA, x[k + 0], s8);
			a = transforms.compound('g', a, b, c, d, 0xD62F105D, x[k + 5], s5);
			d = transforms.compound('g', d, a, b, c, 0x2441453, x[k + 10], s6);
			c = transforms.compound('g', c, d, a, b, 0xD8A1E681, x[k + 15], s7);
			b = transforms.compound('g', b, c, d, a, 0xE7D3FBC8, x[k + 4], s8);
			a = transforms.compound('g', a, b, c, d, 0x21E1CDE6, x[k + 9], s5);
			d = transforms.compound('g', d, a, b, c, 0xC33707D6, x[k + 14], s6);
			c = transforms.compound('g', c, d, a, b, 0xF4D50D87, x[k + 3], s7);
			b = transforms.compound('g', b, c, d, a, 0x455A14ED, x[k + 8], s8);
			a = transforms.compound('g', a, b, c, d, 0xA9E3E905, x[k + 13], s5);
			d = transforms.compound('g', d, a, b, c, 0xFCEFA3F8, x[k + 2], s6);
			c = transforms.compound('g', c, d, a, b, 0x676F02D9, x[k + 7], s7);
			b = transforms.compound('g', b, c, d, a, 0x8D2A4C8A, x[k + 12], s8);
			a = transforms.compound('h', a, b, c, d, 0xFFFA3942, x[k + 5], s9);
			d = transforms.compound('h', d, a, b, c, 0x8771F681, x[k + 8], s10);
			c = transforms.compound('h', c, d, a, b, 0x6D9D6122, x[k + 11], s11);
			b = transforms.compound('h', b, c, d, a, 0xFDE5380C, x[k + 14], s12);
			a = transforms.compound('h', a, b, c, d, 0xA4BEEA44, x[k + 1], s9);
			d = transforms.compound('h', d, a, b, c, 0x4BDECFA9, x[k + 4], s10);
			c = transforms.compound('h', c, d, a, b, 0xF6BB4B60, x[k + 7], s11);
			b = transforms.compound('h', b, c, d, a, 0xBEBFBC70, x[k + 10], s12);
			a = transforms.compound('h', a, b, c, d, 0x289B7EC6, x[k + 13], s9);
			d = transforms.compound('h', d, a, b, c, 0xEAA127FA, x[k + 0], s10);
			c = transforms.compound('h', c, d, a, b, 0xD4EF3085, x[k + 3], s11);
			b = transforms.compound('h', b, c, d, a, 0x4881D05, x[k + 6], s12);
			a = transforms.compound('h', a, b, c, d, 0xD9D4D039, x[k + 9], s9);
			d = transforms.compound('h', d, a, b, c, 0xE6DB99E5, x[k + 12], s10);
			c = transforms.compound('h', c, d, a, b, 0x1FA27CF8, x[k + 15], s11);
			b = transforms.compound('h', b, c, d, a, 0xC4AC5665, x[k + 2], s12);
			a = transforms.compound('i', a, b, c, d, 0xF4292244, x[k + 0], s13);
			d = transforms.compound('i', d, a, b, c, 0x432AFF97, x[k + 7], s14);
			c = transforms.compound('i', c, d, a, b, 0xAB9423A7, x[k + 14], s15);
			b = transforms.compound('i', b, c, d, a, 0xFC93A039, x[k + 5], s16);
			a = transforms.compound('i', a, b, c, d, 0x655B59C3, x[k + 12], s13);
			d = transforms.compound('i', d, a, b, c, 0x8F0CCC92, x[k + 3], s14);
			c = transforms.compound('i', c, d, a, b, 0xFFEFF47D, x[k + 10], s15);
			b = transforms.compound('i', b, c, d, a, 0x85845DD1, x[k + 1], s16);
			a = transforms.compound('i', a, b, c, d, 0x6FA87E4F, x[k + 8], s13);
			d = transforms.compound('i', d, a, b, c, 0xFE2CE6E0, x[k + 15], s14);
			c = transforms.compound('i', c, d, a, b, 0xA3014314, x[k + 6], s15);
			b = transforms.compound('i', b, c, d, a, 0x4E0811A1, x[k + 13], s16);
			a = transforms.compound('i', a, b, c, d, 0xF7537E82, x[k + 4], s13);
			d = transforms.compound('i', d, a, b, c, 0xBD3AF235, x[k + 11], s14);
			c = transforms.compound('i', c, d, a, b, 0x2AD7D2BB, x[k + 2], s15);
			b = transforms.compound('i', b, c, d, a, 0xEB86D391, x[k + 9], s16);

			a = transforms.addUnsigned(a, t1);
			b = transforms.addUnsigned(b, t2);
			c = transforms.addUnsigned(c, t3);
			d = transforms.addUnsigned(d, t4);
		}

		return (convertToHex(a) + convertToHex(b) + convertToHex(c) + convertToHex(d)).toLowerCase();
	}

	String.implement({
		'toMD5': function(){
			return md5(this);
		}
	});
	
})();
;


/* FILE: /media/com_comment/js/String.UTF-8.js */
/*
---
name: String.UTF-8
description: String UTF8 encoding.
license: MIT-style
authors: [Christopher Pitt, Enrique Erne]
requires: 
  - Core/String
provides: [String.toUTF8, String.fromUTF8]
...
*/

(function(){

	function toUTF8(string){
		var a = 0,
			result = '',
			code = String.fromCharCode,
			string = string.replace(/\r\n/g,"\n");

		for (a = 0; b = string.charCodeAt(a); a++){
			if (b < 128){
				result += code(b);
			} else if ((b > 127) && (b < 2048)){
				result += code((b >> 6) | 192);
				result += code((b & 63) | 128);
			} else {
				result += code((b >> 12) | 224);
				result += code(((b >> 6) & 63) | 128);
				result += code((b & 63) | 128);
			}
		}

		return result;
	}

	function fromUTF8(string){
		var a = 0,
			result = '',
			c1 = c2 = c3 = 0;

		while (a < string.length){
			c1 = string.charCodeAt(a);

			if (c1 < 128){
				result += String.fromCharCode(c1);
				a++;
			} else if ((c1 > 191) && (c1 < 224)){
				c2 = string.charCodeAt(a+1);
				result += String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
				a += 2;
			} else {
				c2 = string.charCodeAt(a + 1);
				c3 = string.charCodeAt(a + 2);
				result += String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				a += 3;
			}
		}

		return result;
	}

	String.implement({
		'toUTF8': function(){
			return toUTF8(this);
		},
		'fromUTF8': function(){
			return fromUTF8(this);
		}
	});

})();
;


/* FILE: /media/com_comment/js/libraries/placeholder/placeholder.js */
/**
description: Adds cross browser Placeholder support to inputs and textareas, which have a placholder attribute.

	license: MIT-License

authors:
	- Fabian Vogelsteller [frozeman.de]

requires:
	- core/1.3: [Class]

provides: [PlaceholderSupport]
*/
var PlaceholderSupport = new Class({
	initialize : function(els){
		if(('placeholder' in document.createElement('input')))
			return;

		var self = this;

		this.elements = (typeOf(els) === 'string') ? $$(els) : els;
		if(typeOf(this.elements) === 'null' || typeOf(this.elements[0]) === 'null') {
			this.elements = $$('input[placeholder],textarea[placeholder]');
		}

		this.elements.each(function(input){
			var textColor = input.getStyle('color');
			var lighterTextColor = self.LightenDarkenColor(textColor,80);

			if(input.getProperty('value') === '') {
				input.setProperty('value',input.getProperty('placeholder'));
				input.setStyle('color',lighterTextColor);
			}

			input.addEvents({
				focus: function(){
					if(input.getProperty('value') === input.getProperty('placeholder')) {
						input.setProperty('value','');
						input.setStyle('color',textColor);
					}
				},
				blur: function(){
					if(input.getProperty('value') === '') {
						input.setProperty('value',input.getProperty('placeholder'));
						input.setStyle('color',lighterTextColor);
					}
				}
			});
		});
	},

	LightenDarkenColor: function LightenDarkenColor(col,amt) {
		var usePound = false;
		if ( col[0] == "#" ) {
			col = col.slice(1);
			usePound = true;
		}

		var num = parseInt(col,16);

		var r = (num >> 16) + amt;

		if ( r > 255 ) r = 255;
		else if  (r < 0) r = 0;

		var b = ((num >> 8) & 0x00FF) + amt;

		if ( b > 255 ) b = 255;
		else if  (b < 0) b = 0;

		var g = (num & 0x0000FF) + amt;

		if ( g > 255 ) g = 255;
		else if  ( g < 0 ) g = 0;
		var rStr = (r.toString(16).length < 2)?'0'+r.toString(16):r.toString(16);
		var gStr = (g.toString(16).length < 2)?'0'+g.toString(16):g.toString(16);
		var bStr = (b.toString(16).length < 2)?'0'+b.toString(16):b.toString(16);

		return (usePound?"#":"") + rStr + gStr + bStr;
	}
});;


/* FILE: /media/system/js/validate.js */
/*
		GNU General Public License version 2 or later; see LICENSE.txt
*/
Object.append(Browser.Features,{inputemail:function(){var e=document.createElement("input");e.setAttribute("type","email");return e.type!=="text"}()});var JFormValidator=new Class({initialize:function(){this.handlers=Object();this.custom=Object();this.setHandler("username",function(e){regex=new RegExp("[<|>|\"|'|%|;|(|)|&]","i");return!regex.test(e)});this.setHandler("password",function(e){regex=/^\S[\S ]{2,98}\S$/;return regex.test(e)});this.setHandler("numeric",function(e){regex=/^(\d|-)?(\d|,)*\.?\d*$/;return regex.test(e)});this.setHandler("email",function(e){regex=/^[a-zA-Z0-9.!#$%&‚Äô*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;return regex.test(e)});var e=$$("form.form-validate");e.each(function(e){this.attachToForm(e)},this)},setHandler:function(e,t,n){n=n==""?true:n;this.handlers[e]={enabled:n,exec:t}},attachToForm:function(e){e.getElements("input,textarea,select,button").each(function(e){if(e.hasClass("required")){e.set("aria-required","true");e.set("required","required")}if((document.id(e).get("tag")=="input"||document.id(e).get("tag")=="button")&&document.id(e).get("type")=="submit"){if(e.hasClass("validate")){e.onclick=function(){return document.formvalidator.isValid(this.form)}}}else{e.addEvent("blur",function(){return document.formvalidator.validate(this)});if(e.hasClass("validate-email")&&Browser.Features.inputemail){e.type="email"}}})},validate:function(e){e=document.id(e);if(e.get("disabled")&&!e.hasClass('required')){this.handleResponse(true,e);return true}if(e.hasClass("required")){if(e.get("tag")=="fieldset"&&(e.hasClass("radio")||e.hasClass("checkboxes"))){for(var t=0;;t++){if(document.id(e.get("id")+t)){if(document.id(e.get("id")+t).checked){break}}else{this.handleResponse(false,e);return false}}}else if(!e.get("value")){this.handleResponse(false,e);return false}}var n=e.className&&e.className.search(/validate-([a-zA-Z0-9\_\-]+)/)!=-1?e.className.match(/validate-([a-zA-Z0-9\_\-]+)/)[1]:"";if(n==""){this.handleResponse(true,e);return true}if(n&&n!="none"&&this.handlers[n]&&e.get("value")){if(this.handlers[n].exec(e.get("value"))!=true){this.handleResponse(false,e);return false}}this.handleResponse(true,e);return true},isValid:function(e){var t=true;var n=e.getElements("fieldset").concat(Array.from(e.elements));for(var r=0;r<n.length;r++){if(this.validate(n[r])==false){t=false}}(new Hash(this.custom)).each(function(e){if(e.exec()!=true){t=false}});if(!t){var i=Joomla.JText._("JLIB_FORM_FIELD_INVALID");var s=jQuery("label.invalid");var o=new Object;o.error=new Array;for(var r=0;r<s.length;r++){var u=jQuery(s[r]).text();if(u!="undefined"){o.error[r]=i+u.replace("*","")}}Joomla.renderMessages(o)}return t},handleResponse:function(e,t){if(!t.labelref){var n=$$("label");n.each(function(e){if(e.get("for")==t.get("id")){t.labelref=e}})}if(e==false){t.addClass("invalid");t.set("aria-invalid","true");if(t.labelref){document.id(t.labelref).addClass("invalid");document.id(t.labelref).set("aria-invalid","true")}}else{t.removeClass("invalid");t.set("aria-invalid","false");if(t.labelref){document.id(t.labelref).removeClass("invalid");document.id(t.labelref).set("aria-invalid","false")}}}});document.formvalidator=null;window.addEvent("domready",function(){document.formvalidator=new JFormValidator})
;


/* FILE: /media/system/js/caption.js */
/*
        GNU General Public License version 2 or later; see LICENSE.txt
*/
var JCaption=function(c){var e,b,a=function(f){e=jQuery.noConflict();b=f;e(b).each(function(g,h){d(h)})},d=function(i){var h=e(i),f=h.attr("title"),j=h.attr("width")||i.width,l=h.attr("align")||h.css("float")||i.style.styleFloat||"none",g=e("<p/>",{text:f,"class":b.replace(".","_")}),k=e("<div/>",{"class":b.replace(".","_")+" "+l,css:{"float":l,width:j}});h.parent().before(k,h);k.append(h);if(f!==""){k.append(g)}};a(c)};;


/* FILE: /media/system/js/highlighter.js */
/*
		GNU General Public License version 2 or later; see LICENSE.txt
*/
if(typeof(Joomla)==="undefined"){var Joomla={}}Joomla.Highlighter=function(h){var d,f,i={autoUnhighlight:true,caseSensitive:false,startElement:false,endElement:false,elements:[],className:"highlight",onlyWords:true,tag:"span"},b=function(l){if(l.constructor===String){l=[l]}if(i.autoUnhighlight){g(l)}var k=i.onlyWords?"\b"+k+"\b":"("+l.join("\\b|\\b")+")",j=new RegExp(k,i.caseSensitive?"":"i");i.elements.map(function(m){a(m,j,i.className)});return this},g=function(l){if(l.constructor===String){l=[l]}var k,j;l.map(function(m){m=(i.caseSensitive?m:m.toUpperCase());if(l[m]){k=d(l[m]);k.removeClass();k.each(function(n,o){j=document.createTextNode(d(o).text());o.parentNode.replaceChild(j,o)})}});return this},a=function(k,r,q){if(k.nodeType===3){var o=k.nodeValue.match(r),l,j,s,p,n,m;if(o){l=document.createElement(i.tag);j=d(l);j.addClass(q);s=k.splitText(o.index);s.splitText(o[0].length);p=s.cloneNode(true);j.append(p);d(s).replaceWith(l);j.attr("rel",j.text());n=j.text();if(!i.caseSensitive){n=j.text().toUpperCase()}if(!f[n]){f[n]=[]}f[n].push(l);return 1}}else{if((k.nodeType===1&&k.childNodes)&&!/(script|style|textarea|iframe)/i.test(k.tagName)&&!(k.tagName===i.tag.toUpperCase()&&k.className===q)){for(m=0;m<k.childNodes.length;m++){m+=a(k.childNodes[m],r,q)}}}return 0},e=function(l,k){var j=l.next();if(j.attr("id")!==k.attr("id")){i.elements.push(j.get(0));e(j,k)}},c=function(j){d=jQuery.noConflict();d.extend(i,j);e(d(i.startElement),d(i.endElement));f=[]};c(h);return{highlight:b,unhighlight:g}};;


/* FILE: /plugins/system/jsntplframework/assets/joomlashine/js/noconflict.js */
/**
* @author    JoomlaShine.com http://www.joomlashine.com
* @copyright Copyright (C) 2008 - 2011 JoomlaShine.com. All rights reserved.
* @license   GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
*/
if (typeof(jQuery) !== "undefined") { jQuery.noConflict(); };


/* FILE: /plugins/system/jsntplframework/assets/joomlashine/js/utils.js */
/**
* @author    JoomlaShine.com http://www.joomlashine.com
* @copyright Copyright (C) 2008 - 2011 JoomlaShine.com. All rights reserved.
* @license   GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
*/
var JSNUtils = {
	/* ============================== BROWSER ============================== */
	/**
	 * Encode double quote character to comply with Opera browser
	 * Add more rules here if needed
	 */
	encodeCookie: function(value) {
		return value.replace(/\"/g, '%22');
	},

	/**
	 * Decode double quote character back to normal
	 */
	decodeCookie: function(value) {
		return value.replace(/\%22/g, '"');
	},

	writeCookie: function (name,value,days){
		value = JSNUtils.encodeCookie(value);

		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		} else expires = "";

		document.cookie = name+"="+value+expires+"; path=/";
	},

	readCookie: function (name){
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return JSNUtils.decodeCookie(c.substring(nameEQ.length,c.length));
		}
		return null;
	},

	isIE7: function() {
		return (navigator.appVersion.indexOf("MSIE 7.")!=-1);
	},

	isDesktopViewOnMobile: function (params) {
		if (params && params.responsiveLayout) {
			if (JSNUtils.checkSmartphone() || JSNUtils.checkTablet()) {
				if (!params.responsiveLayout.contains('mobile')) {
					document.body.addClass('jsn-desktop-on-mobile');
				} else if (!params.enableMobile) {
					JSNUtils.initMenuForDesktopView(true);
				}
			}
		}

		return document.body.hasClass('jsn-mobile');
	},

	initMenuForDesktopView: function (checked) {
		if (checked) {
			var sitetools = document.id('jsn-sitetools-menu');

			if (sitetools) {
				sitetools.addClass('sitetool-desktop-on-mobile');
			}

			document.getElements('ul.menu-mainmenu').addClass('jsn-desktop-on-mobile');
		}
	},

	// Initialize scrolling effect for in-page anchor links
	initScrollToContent: function(stickyMenus) {
		if (typeof Fx != 'undefined' && typeof Fx.Scroll != 'undefined') {
			window.addEvent('load', function() {
				document.getElements('.jsn-menu-toggle + ul li.jsn-scroll > a').each(function(link) {
					link.addEvent('click', function(event) {
						event.preventDefault();

						var	target = document.getElement(this.getAttribute('href')),
							menu = document.id('jsn-menu');

						if (target) {
							var pos = target.getPosition();

							if (stickyMenus && menu) {
								if (stickyMenus.mobile == '1' && (JSNUtils.checkSmartphone() || JSNUtils.checkTablet()) && menu.hasClass('jsn-menu-sticky')) {
									pos.y -= menu.getSize().y + menu.getElement('ul.menu-mainmenu').getSize().y;
								} else if (stickyMenus.desktop == '1' && ((!JSNUtils.checkSmartphone() && !JSNUtils.checkTablet()) || document.body.hasClass('jsn-desktop-on-mobile'))) {
									pos.y -= menu.getSize().y;
								}
							}

							(this.__scrollFxObj = this.__scrollFxObj || new Fx.Scroll(window)).start(pos.x, pos.y);
						}
					});
				});
			});
		}
	},

	getBrowserInfo: function(){
		var name = '';
		var version = '';
		var ua = navigator.userAgent.toLowerCase();
		var match = ua.match(/(opera|ie|firefox|chrome|version)[\s\/:]([\w\d\.]+)?.*?(safari|version[\s\/:]([\w\d\.]+)|$)/) || [null, 'unknown', 0];
		if (match[1] == 'version')
		{
			name = match[3];
		}
		else
		{
			name = match[1];
		}
		version = parseFloat((match[1] == 'opera' && match[4]) ? match[4] : match[2]);

		return {'name': name, 'version': version};
	},

	/* ============================== DEVICE ============================== */

	checkMobile: function(){
		var uagent = navigator.userAgent.toLowerCase(), isMobile = false, mobiles = [
			"midp","240x320","blackberry","netfront","nokia","panasonic",
			"portalmmm","sharp","sie-","sonyericsson","symbian",
			"windows ce","benq","mda","mot-","opera mini",
			"philips","pocket pc","sagem","samsung","sda",
			"sgh-","vodafone","xda","palm","iphone",
			"ipod","android", "ipad"
		];

		for (var i = 0; i < mobiles.length; i++) {
			if (uagent.indexOf(mobiles[i]) != -1) {
				isMobile = true;
			}
		}

		return isMobile;
	},

	getScreenWidth: function(){
		var screenWidth;

		if( typeof( window.innerWidth ) == 'number' )
		{
			// IE 9+ and other browsers
			screenWidth = window.innerWidth;
		}
		else if (document.documentElement && document.documentElement.clientWidth)
		{
			//IE 6 - 8
			screenWidth = document.documentElement.clientWidth;
		}

		return screenWidth;
	},

	checkSmartphone: function(){
		var screenWidth = JSNUtils.getScreenWidth(), isSmartphone = false;

		if (screenWidth >= 320 && screenWidth < 480)
		{
			isSmartphone = true;
		}

		return isSmartphone;
	},

	checkTablet: function(){
		var screenWidth = JSNUtils.getScreenWidth(), isTablet = false;

		if (screenWidth >= 481 && screenWidth < 1024)
		{
			isTablet = true;
		}

		return isTablet;
	},

	getScreenType: function(){
		var screenType;

		if (JSNUtils.checkSmartphone()) {
			screenType = 'smartphone';
		} else if (JSNUtils.checkTablet()) {
			screenType = 'tablet';
		} else {
			screenType = 'desktop';
		}

		return screenType;
	},


	/* ============================== DOM - GENERAL ============================== */

	addEvent: function(target, event, func){
		if (target.addEventListener){
			target.addEventListener(event, func, false);
			return true;
		} else if (target.attachEvent){
			var result = target.attachEvent("on"+event, func);
			return result;
		} else {
			return false;
		}
	},

	getElementsByClass: function(targetParent, targetTag, targetClass, targetLevel){
		var elements, tags, tag, tagClass;

		if(targetLevel == undefined){
			tags = targetParent.getElementsByTagName(targetTag);
		}else{
			tags = JSNUtils.getChildrenAtLevel(targetParent, targetTag, targetLevel);
		}

		elements = [];

		for(var i=0;i<tags.length;i++){
			tagClass = tags[i].className;
			if(tagClass != "" && JSNUtils.checkSubstring(tagClass, targetClass, " ", false)){
				elements[elements.length] = tags[i];
			}
		}

		return elements;
	},

	getFirstChild: function(targetEl, targetTagName){
		var nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (node.tagName == targetTagName)
				return node;
		}
		return null;
	},

	getFirstChildAtLevel: function(targetEl, targetTagName, targetLevel){
		var child, nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (targetLevel == 1) {
				if(node.tagName == targetTagName) return node;
			} else {
				child = JSNUtils.getFirstChildAtLevel(node, targetTagName, targetLevel-1);
				if(child != null) return child;
			}
		}
		return null;
	},

	getChildren: function(targetEl, targetTagName){
		var nodes, node;
		var children = [];
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if(node.tagName == targetTagName)
				children.push(node);
		}
		return children;
	},

	getChildrenAtLevel: function(targetEl, targetTagName, targetLevel){
		var children = [];
		var nodes, node;
		nodes = targetEl.childNodes;
		for(var i=0;i<nodes.length;i++){
			node = nodes[i];
			if (targetLevel == 1) {
				if(node.tagName == targetTagName) children.push(node);
			} else {
				children = children.concat(JSNUtils.getChildrenAtLevel(node, targetTagName, targetLevel-1));
			}
		}
		return children;
	},

	addClass: function(targetTag, targetClass){
		if(targetTag.className == ""){
			targetTag.className = targetClass;
		} else {
			if(!JSNUtils.checkSubstring(targetTag.className, targetClass, " ")){
				targetTag.className += " " + targetClass;
			}
		}
	},

	getViewportSize: function(){
		var myWidth = 0, myHeight = 0;

		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}

		return {width:myWidth, height:myHeight };
	},

	addURLPrefix: function(targetId)
	{
		var navUrl = window.location.href;
		var targetEl = document.getElementById(targetId);
		if(targetEl != undefined && targetEl.tagName.toUpperCase() == 'A')
		{
			orgHref = targetEl.href;
			targetEl.href = navUrl + ((navUrl.indexOf(orgHref) != -1)?'':orgHref);
		}
	},

	/* ============================== DOM - GUI ============================== */
	/* ============================== DOM - GUI - MENU ============================== */

	/**
	 * Reposition submenu if it goes off screen area.
	 */
	setSubmenuPosition: function(enableRTL)
	{
		// Skip repositioning submenu if mobile menu is active
		var toggle = document.getElement('span.jsn-menu-toggle');

		if (toggle && toggle.getStyle('display') != 'none') {
			return;
		}

		// Initialize parameters
		var maxSize, parents, enableRTL = enableRTL || false;

		// Get all parents
		parents = document.getElements('ul.menu-mainmenu > li.parent');

		if (!parents.length) return;

		// Add level to all submenus
		parents.each(function(parent) {
			var submenu = parent.getChildren('ul'), level = 0;

			while (submenu.length) {
				var tmp = [];

				// Increase submenu level
				level++;

				// Add class to indicate submenu level
				submenu.each(function(ul) {
					ul.addClass('jsn-submenu-level-' + level);

					// Get nested submenus
					ul.getElements('> li.parent > ul').each(function(nested) {
						tmp.push(nested);
					});
				});

				// Set nested submenus
				submenu = tmp;
			}

			// Store max level of submenu
			parent.jsnMaxSubmenuLevel = level;
		});

		// Declare some utilities
		var placeSubmenu = function(parent, flipBack) {
			var	width = 0, submenu = parent.getElement('ul.jsn-submenu-level-' + parent.jsnMaxSubmenuLevel),
				flipBack = flipBack || false, farLeft;

			// Calculate submenu's far-left offset
			if ((enableRTL && !flipBack) || (!enableRTL && flipBack)) {
				farLeft = parent.getPosition().x + parent.getSize().x;

				// Calculate far-left position when all nested submenus are expanded
				while (!submenu.hasClass('menu-mainmenu')) {
					farLeft -= submenu.getSize().x;

					// Travel back the DOM tree
					submenu = submenu.getParent().getParent();
				}
			} else if ((!enableRTL && !flipBack) || (enableRTL && flipBack)) {
				farLeft = parent.getPosition().x;

				// Calculate total width when all nested submenus are expanded
				while (!submenu.hasClass('menu-mainmenu')) {
					width += submenu.getSize().x;

					// Travel back the DOM tree
					submenu = submenu.getParent().getParent();
				}
			}

			// Check if there is any submenu goes off screen when all nested submenus are expanded
			if (
				(((enableRTL && !flipBack) || (!enableRTL && flipBack)) && farLeft < 0)
				||
				(((!enableRTL && !flipBack) || (enableRTL && flipBack)) && farLeft + width > maxSize.x)
			) {
				if (!flipBack) {
					parent.addClass('jsn-submenu-flipback');

					// Check if there is any submenu goes off screen in the opposite side after flipping back
					placeSubmenu(parent, true);
				} else {
					parent.removeClass('jsn-submenu-flipback');
				}
			}
		},

		resizeHandler = function() {
			// Disable left-right scrolling
			document.body.setStyle('overflow-x', 'hidden');

			// Update max screen area
			maxSize = window.getSize();

			// Place all submenus
			parents.each(function(parent) {
				var submenus = parent.getElements('ul');

				// Restore original position for all submenu
				parent.removeClass('jsn-submenu-flipback');

				// Make sure all submenus is visible
				submenus.setStyle('display', 'block');

				// Place nested submenus
				placeSubmenu(parent);

				// Restore default visibility state for submenu
				submenus.setStyle('display', '');
			});

			// Restore original left-right scrolling
			document.body.setStyle('overflow-x', '');
		};

		// Handle window resize event
		window.addEvent('resize', function() {
			placeSubmenu.timer && clearTimeout(placeSubmenu.timer);
			placeSubmenu.timer = setTimeout(resizeHandler, 500);
		});

		// Place all submenus
		resizeHandler();
	},

	setMobileMenu: function(menuClass)
	{
		if (JSNUtils.mobileMenuInitialized) {
			return;
		}

		var toggle = function() {
			this.toggleClass("active");
			this.getNext("ul").toggleClass("jsn-menu-mobile");

			document.getElements("." + menuClass + " .jsn-menu-toggle").each(function (item) {
				var a = item.getPrevious(),
					size = a.getSize();

				item.setStyle('height', size.y);
			});

			window.fireEvent('toggle-mobile-menu');
		};

		// Setup toggle for main trigger
		document.getElements("ul." + menuClass).getPrevious(".jsn-menu-toggle").each(function(e) {
			e && e.addEvent('click', toggle);
		});

		// Setup toggle for children triggers
		document.getElements("ul." + menuClass + " .jsn-menu-toggle").addEvent('click', toggle);

		window.addEvent('resize', function () {
			if (window.getSize().x > 960) {
				document.getElements('ul.jsn-menu-mobile').removeClass('jsn-menu-mobile');
			}
		});

		JSNUtils.mobileMenuInitialized = true;
	},

	setDesktopSticky: function(menuId) {
		// Check if sticky menu is enabled on mobile?
		if ((JSNUtils.checkMobile() || JSNUtils.getScreenType() != 'desktop') && !document.body.hasClass('jsn-desktop-on-mobile')) {
			return;
		}

		// Initialize sticky menu on desktop
		var header = document.id(menuId ? menuId : 'jsn-menu');

		window.addEvent('load', function() {
			var	headerPosition = header.getPosition(),
				menuHeight = header.getHeight(),
				placeHolder = new Element('div', {'class': 'jsn-menu-placeholder'}),

			stickHeader = function() {
				var windowScroll = window.getScroll();

				if (windowScroll.y > headerPosition.y) {
					header.addClass('jsn-menu-sticky');	
					placeHolder.inject(header, 'after');
					placeHolder.setStyle('height', menuHeight);
				} else {
					header.removeClass('jsn-menu-sticky');
					placeHolder.destroy();
				}
			};

			window.addEvent('scroll', stickHeader);
		});
	},

	setMobileSticky: function(menuId) {
		// State that sticky menu is enabled on mobile
		JSNUtils.mobileStickyEnabled = true;

		// Get necessary elements
		var page = document.id('jsn-page'),
			menu = document.id(menuId ? menuId : 'jsn-menu'),
			menuToggler = menu.getElement('.jsn-menu-toggle'),
			mainMenu = menu.getElement('ul.menu-mainmenu'),
			menuSize = menu.getCoordinates(),
			menuPlacehoder = new Element('div', { 'id': 'jsn-menu-placeholder' }),
			menuParent = menu.getParent(),
			menuParentOffset = menuParent.getCoordinates(),
			menuLeft = menuSize.left,
			menuPaddingHorz = parseInt(menu.getStyle('padding-left')) + parseInt(menu.getStyle('padding-right')),
			menuBorderHorz = parseInt(menu.getStyle('border-left')) + parseInt(menu.getStyle('border-right')),
			isSticked = false,
			touchStartOffset = {},
			isFixedSupport = JSNUtils.isFixedSupport(),
			lastScrollTop = 0;

		menuPlacehoder.setStyles({
			height: menuSize.height,
			margin: menu.getStyle('margin')
		});

		var getMaxMenuHeight = function () { return window.innerHeight - menuSize.height; };
		var getTouchDirection = function (touchEvent) { return touchEvent.touches[0].pageY > touchStartOffset.y ? 'up' : 'down'; };

		var resetMenuPosition = function () {
			var restorePoint = menuPlacehoder.getPosition().y;

			if (restorePoint == 0) {
				var parent = menuPlacehoder.getParent();

				while (parent.nodeName != 'BODY' && parent.getStyle('position') != 'relative') {
					parent = parent.getParent();
				}

				restorePoint = parent.getPosition().y;
			}

			if (window.getScroll().y < restorePoint) {
				menu
					.removeClass('jsn-menu-sticky jsn-mobile-menu-sticky')
					.removeAttribute('style');

				menuPlacehoder.dispose();
				mainMenu.setStyles({
					'max-height': 'auto',
					'overflow-y': 'hidden'
				});

				isSticked = false;
			}
		};

		var getMenuWidth = function (forceMenuWidth) {
			var menuWidth = forceMenuWidth || menuSize.width;

			if (!isNaN(menuPaddingHorz))
				menuWidth = menuWidth - menuPaddingHorz;

			if (!isNaN(menuBorderHorz))
				menuWidth = menuWidth - menuBorderHorz;

			return menuWidth;
		};

		var fx = new Fx.Morph(menu, { transition: Fx.Transitions.Expo.easeOut });
			fx.addEvent('complete', resetMenuPosition);

		var makeMenuStick = function () {
			var scrollTop = window.getScroll().y,
				menuOffsetTop = menu.getPosition().y;

			if (mainMenu.getStyle('display') == 'block' && !menu.hasClass('jsn-mobile-menu-sticky')) {
				return menu.setStyles({
					'left' : '',
					'width' : '',
					'position' : 'relative',
					'top' : '',
					'z-index' : ''
				});
			}

			if (scrollTop > menuOffsetTop && menuParent.getElement('#jsn-menu-placeholder') == null && isSticked == false) {
				if (fx.isRunning())
					fx.cancel();

				menuSize = menu.getCoordinates();
				menuLeft = menuSize.left;

				menu.addClass('jsn-menu-sticky jsn-mobile-menu-sticky').setStyles({
					'left' : menuLeft,
					'width' : getMenuWidth(),
					'position' : isFixedSupport ? 'fixed' : 'absolute',
					'top' : isFixedSupport ? 0 : scrollTop,
					'z-index' : 9999999
				});

				menuPlacehoder.inject(menu, 'before');

				isSticked = true;
			}
		};

		var updatePosition = function () {
			// Stick menu to top
			updatePosition.longMenuFixed || makeMenuStick();

			if (mainMenu.getStyle('display') == 'block' && !menu.hasClass('jsn-mobile-menu-sticky')) {
				return menu.setStyles({
					'left' : '',
					'width' : '',
					'position' : 'relative',
					'top' : '',
					'z-index' : ''
				});
			}

			var	scrollTop = window.getScroll().y,
				placeHoderOffset = menuPlacehoder.getPosition().y;

			// Check scrolling direction
			if (scrollTop >= lastScrollTop) {
				// User is scrolling to bottom of page
				if (getMaxMenuHeight() < mainMenu.getCoordinates().height) {
					// Menu is longer than the screen height
					if (!updatePosition.longMenuFixed) {
						// Switch menu to absolute position so user can scroll down to set the rest of the menu
						menu.setStyles({
							position : 'absolute',
							top : lastScrollTop
						});
					}

					// Store last scroll top
					lastScrollTop = scrollTop;

					return (updatePosition.longMenuFixed = true);
				}
			} else if (scrollTop < lastScrollTop) {
				// User is scrolling to top of page
				if (getMaxMenuHeight() < mainMenu.getCoordinates().height) {
					// Menu is longer than the screen height
					if (scrollTop <= menu.getPosition().y && updatePosition.longMenuFixed) {
						// Re-stick the menu to top of page
						menu.setStyles({
							position : isFixedSupport ? 'fixed' : 'absolute',
							top : isFixedSupport ? 0 : scrollTop
						});
		
						updatePosition.longMenuFixed = false;
					}
				}

				// Reset menu position if necessary
				resetMenuPosition();

				if (updatePosition.longMenuFixed)
				{
					// Store last scroll top
					return (lastScrollTop = scrollTop);
				}
			}

			// Pause re-position effect
			if (fx.isRunning()) fx.pause();

			// Reset menu position
			if (isSticked == true && placeHoderOffset > scrollTop && menu.getStyle('position') == 'fixed') {
				menu.setStyles({
					position : 'absolute',
					top : scrollTop,
					left : menuPlacehoder.getCoordinates().left,
					width : getMenuWidth()
				});

				fx.start({ top: placeHoderOffset });
			}

			// Update menu position
			else if (isSticked == true && menu.getStyle('position') == 'absolute') {
				var menuTop = menu.getPosition().y;

				fx.start({
					top: (placeHoderOffset > scrollTop) ? placeHoderOffset : scrollTop,
					left: menuPlacehoder.getCoordinates().left
				});
			}

			else {
				menu.setStyle('left', menuPlacehoder.getCoordinates().left);
			}

			// Store last scroll top
			lastScrollTop = scrollTop;
		};

		var updatePositionTimeout = null,
			updateMenuSizeTimeout = null,
			isMovedToTop = false,
			backupWindowScroll = null,
			pageHeight = page.getSize().y;

		window.addEvent('load', function () {
			clearTimeout(updatePositionTimeout);
			updatePositionTimeout = setTimeout(updatePosition, 100);
	
			window.addEvent('touchmove', makeMenuStick);
			window.addEvent('scroll', updatePosition);

			window.addEvent('resize', function () {
				clearTimeout(updateMenuSizeTimeout);
				updateMenuSizeTimeout = setTimeout(function () {
					if (isSticked == true) {
						menuSize = menuPlacehoder.getCoordinates();
						menu.setStyle('width', getMenuWidth());
					}
					else {
						menuSize = menu.getCoordinates();
					}
				}, 100);
			});
	
			window.addEvent('orientationchange', updatePosition);
			window.addEvent('toggle-mobile-menu', updatePosition);
		});
	},

	setDropdownModuleEvents: function ()
	{
		document.getElements('#jsn-header div.display-dropdown.jsn-modulecontainer h3.jsn-moduletitle')
			.addEvent('click', function (e) {
				var
				elm = e.target;
				while (!elm.hasClass('jsn-modulecontainer'))
					elm = elm.getParent();

				elm.toggleClass('jsn-dropdown-active');
			});
	},

	setMobileSitetool: function()
	{
		var siteToolPanel = document.id("jsn-sitetoolspanel");

		if (siteToolPanel)
		{
			siteToolPanel.getElements("li.jsn-sitetool-control").addEvent("click", function() {
				this.toggleClass("active");
			});
		}
	},

	getSelectMenuitemIndex: function(elementID)
	{
		var childs = document.id(elementID).childNodes;
		var count = childs.length;
		var index = 0;

		for (var i = 0; i < count; i++)
		{
			if(childs[i].className != undefined && childs[i].className.indexOf('parent') != -1)
			{
				if(childs[i].className.indexOf('active') != -1)
				{
					return index;
				}
				index++;
			}
		}
		return -1;
	},

	createImageMenu: function(menuId, imageClass){
		if (!document.getElementById) return;

		var list = document.getElementById(menuId);
		var listItems;

		var listItem;

		if(list != undefined) {
			listItems = list.getElementsByTagName("LI");
			for(i=0, j=0;i<listItems.length;i++){
				listItem = listItems[i];
				if (listItem.parentNode == list) {
					listItem.className += " " + imageClass + (j+1);
					j++;
				}
			}
		}
	},

	/* Set position of side menu sub panels */
	setSidemenuLayout: function(menuClass, rtlLayout)
	{
		var sidemenus, sidemenu, smChildren, smChild, smSubmenu;
		sidemenus = JSNUtils.getElementsByClass(document, "UL", menuClass);
		if (sidemenus != undefined) {
			for(var i=0;i<sidemenus.length;i++){
				sidemenu = sidemenus[i];
				smChildren = JSNUtils.getChildren(sidemenu, "LI");
				if (smChildren != undefined) {
					for(var j=0;j<smChildren.length;j++){
						smChild = smChildren[j];
						smSubmenu = JSNUtils.getFirstChild(smChild, "UL");
						if (smSubmenu != null) {
							if(rtlLayout == true) { smSubmenu.style.marginRight = smChild.offsetWidth+"px"; }
							else { smSubmenu.style.marginLeft = smChild.offsetWidth+"px"; }
						}
					}
				}
			}
		}
	},

	/* Set position of sitetools sub panel */
	setSitetoolsLayout: function(sitetoolsId, rtlLayout)
	{
		var sitetoolsContainer, parentItem, sitetoolsPanel, neighbour;
		sitetoolsContainer = document.getElementById(sitetoolsId);
		if (sitetoolsContainer != undefined) {
			parentItem = JSNUtils.getFirstChild(sitetoolsContainer, "LI");
			sitetoolsPanel = JSNUtils.getFirstChild(parentItem, "UL");
			if (rtlLayout == true) {
				sitetoolsPanel.style.marginRight = -1*(sitetoolsPanel.offsetWidth - parentItem.offsetWidth) + "px";
			} else {
				sitetoolsPanel.style.marginLeft = -1*(sitetoolsPanel.offsetWidth - parentItem.offsetWidth) + "px";
			}
		}
	},

	/* Change template setting stored in cookie */
	setTemplateAttribute: function(templatePrefix, attribute, value)
	{
		var templateParams = JSON.parse(JSNUtils.readCookie(templatePrefix + 'params')) || {};

		templateParams[attribute] = value;

		JSNUtils.writeCookie(templatePrefix + 'params', JSON.stringify(templateParams));

		window.location.reload(true);
	},

	createExtList: function(listClass, extTag, className, includeNumber){
		if (!document.getElementById) return;

		var lists = JSNUtils.getElementsByClass(document, "UL", listClass);
		var list;
		var listItems;
		var listItem;

		if(lists != undefined) {
			for(var j=0;j<lists.length;j++){
				list = lists[j];
				listItems = JSNUtils.getChildren(list, "LI");
				for(var i=0,k=0;i<listItems.length;i++){
					listItem = listItems[i];
					if(className !=''){
						listItem.innerHTML = '<'+ extTag + ' class='+className+'>' + (includeNumber?(k+1):'') + '</'+  extTag +'>' + listItem.innerHTML;
					}else{
						listItem.innerHTML = '<'+ extTag + '>' + (includeNumber?(k+1):'') + '</'+  extTag +'>' + listItem.innerHTML;
					}
					k++;
				}
			}
		}
	},

	createGridLayout: function(containerTag, containerClass, columnClass, lastcolumnClass) {
		var gridLayouts, gridLayout, gridColumns, gridColumn, columnsNumber;
		gridLayouts = JSNUtils.getElementsByClass(document, containerTag, containerClass);
		for(var i=0;i<gridLayouts.length;i++){
			gridLayout = gridLayouts[i];
			gridColumns = JSNUtils.getChildren(gridLayout, containerTag);
			columnsNumber = gridColumns.length;
			JSNUtils.addClass(gridLayout, containerClass + columnsNumber);
			JSNUtils.addClass(gridLayout, 'clearafter');
			for(var j=0;j<columnsNumber;j++){
				gridColumn = gridColumns[j];
				JSNUtils.addClass(gridColumn, columnClass);
				if(j == gridColumns.length-1) {
					JSNUtils.addClass(gridColumn, lastcolumnClass);
				}
				gridColumn.innerHTML = '<div class="' + columnClass + '_inner">' + gridColumn.innerHTML + '</div>';
			}
		}
	},

	sfHover: function(menuId, menuDelay) {
		if(menuId == undefined) return;

		var delay = (menuDelay == undefined)?0:menuDelay;
		var pEl = document.getElementById(menuId);
		if (pEl != undefined) {
			var sfEls = pEl.getElementsByTagName("li");
			for (var i=0; i<sfEls.length; ++i) {
				sfEls[i].onmouseover=function() {
					clearTimeout(this.timer);
					if(this.className.indexOf("sfhover") == -1) {
						this.className += " sfhover";
					}
				};
				sfEls[i].onmouseout=function() {
					this.timer = setTimeout(JSNUtils.sfHoverOut.bind(this), delay);
				};
			}
		}
	},

	sfHoverOut: function() {
		clearTimeout(this.timer);
		this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
	},

	setFontSize: function (targetId, fontSize){
		var targetObj = (document.getElementById) ? document.getElementById(targetId) : document.all(targetId);
		targetObj.style.fontSize = fontSize + '%';
	},

	setVerticalPosition: function(pName, pAlignment) {
		var targetElement = document.getElementById(pName);

		if (targetElement != undefined) {
			var topDelta, vpHeight, pHeight;
			vpHeight = (JSNUtils.getViewportSize()).height;
			pHeight = targetElement.offsetHeight;
			switch(pAlignment){
				case "top":
					topDelta = 0;
				break;

				case "middle":
					topDelta = Math.floor((100 - Math.round((pHeight/vpHeight)*100))/2);
				break;

				case "bottom":
					topDelta = 100 - Math.round((pHeight/vpHeight)*100);
				break;
			}

			topDelta = (topDelta < 0)?0:topDelta;

			targetElement.style.top = topDelta + "%";

			targetElement.style.visibility = "visible";
		}
	},

	// Keep this function for backward compatible with old template released before template framework v2
	setInnerLayout:function(elements)
	{
		var root = document.getElementById(elements[0]);
		var rootWidth = root ? root.offsetWidth : 0;
		var pleftWidth = 0;
		var pinnerleftWidth = 0;
		var prightWidth = 0;
		var pinnerrightWidth = 0;

		if (document.getElementById(elements[1]) != null) {
			pleftWidth = document.getElementById(elements[1]).offsetWidth;
		}

		if (document.getElementById(elements[3]) != null) {
			pinnerleftWidth = document.getElementById(elements[3]).offsetWidth;

			if (root) {
				var resultLeft = (pleftWidth + pinnerleftWidth)*100/rootWidth;
				root.firstChild.style.right = (100 - resultLeft) + "%";
				root.firstChild.firstChild.style.left = (100 - resultLeft) + "%";
			}
		}

		if(document.getElementById(elements[2]) != null) {
			prightWidth = document.getElementById(elements[2]).offsetWidth;
		}

		if(document.getElementById(elements[4]) != null) {
			pinnerrightWidth = document.getElementById(elements[4]).offsetWidth;

			if (root) {
				var resultRight = (prightWidth + pinnerrightWidth)*100/rootWidth;
				root.firstChild.firstChild.firstChild.style.left = (100 - resultRight) + "%";
				root.firstChild.firstChild.firstChild.firstChild.style.right = (100 - resultRight) + "%";
			}
		}
	},

	setupLayout: function(mapping)
	{
		// Define relationship between columns and their visual background elements
		mapping = mapping || {
			'jsn-leftsidecontent': ['jsn-content_inner'],
			'jsn-rightsidecontent': ['jsn-content_inner2'],
			'jsn-pos-innerleft': ['jsn-maincontent_inner1', 'jsn-mainbody-content-inner1'],
			'jsn-pos-innerright': ['jsn-maincontent_inner3', 'jsn-mainbody-content-inner3']
		};

		// Position visual background elements
		var container = document.id('jsn-content'), maxWidth, innerContainer, innerMaxWidth, width, flip, isLeft, isInner, column, background;

		if (!container) {
			return;
		}

		// Get container width
		maxWidth = container.getSize().x;

		for (var i in mapping) {
			// Check if this is a column at left side
			isLeft = i.match(/-(inner)?left/);

			// Check if this is an inner column
			isInner = i.match(/-(inner)/);

			// Get column element
			column = document.id(i);

			if (column) {
				// Get container of inner column
				if (isInner && !innerContainer) {
					innerContainer = column.getParent();

					while (!innerContainer.className.match(/span\d+ order\d+/) && innerContainer != container) {
						innerContainer = innerContainer.getParent();
					}

					innerMaxWidth = innerContainer.getSize().x;
				}

				// Simply continue if there is only one column
				if (column.getParent().getChildren().length == 1) {
					continue;
				}

				// Get column by visual order
				column = column.getParent().getElement('> .order' + (isLeft ? '1' : column.getParent().getChildren().length));

				if (!column) {
					continue;
				}

				if (!column.id.match(/-(inner)?(left|right)/)) {
					column = column.getParent().getElement('> .order' + (isLeft ? '2' : column.getParent().getChildren().length - 1));
				}

				// Get associated visual background element
				for (var j = 0; j < mapping[i].length; j++) {
					background = document.id(mapping[i][j]);

					if (background) {
						break;
					}
				}

				if (background) {
					var repositionElement;

					if (result = background.id.match(/^([^\d]+)(\d+)$/)) {
						repositionElement = document.id(result[1] + (parseInt(result[2]) + 1));
					} else {
						repositionElement = document.id(background.id + '1');
					}

					if (repositionElement) {
						flip = (isInner || column.hasClass('order' + (isLeft ? '1' : column.getParent().getChildren().length))) ? false : true;
						width = isLeft
							? ((flip ? column.getPosition(isInner ? innerContainer : container).x : column.getSize().x) / (isInner ? innerMaxWidth : maxWidth)) * 100
							: ((flip ? (isInner ? innerMaxWidth : maxWidth) - column.getPosition(isInner ? innerContainer : container).x - column.getSize().x : column.getSize().x) / (isInner ? innerMaxWidth : maxWidth)) * 100;

						// Position visual background element
						if (isLeft) {
							background.setStyle(flip ? 'left' : 'right', (flip ? width : 100 - width) + '%');
							repositionElement.setStyle(flip ? 'right' : 'left', (flip ? width : 100 - width) + '%');
						} else {
							background.setStyle(flip ? 'right' : 'left', (flip ? width : 100 - width) + '%');
							repositionElement.setStyle(flip ? 'left' : 'right', (flip ? width : 100 - width) + '%');
						}

						// Add class to indicate flipping state
						flip && background.addClass('jsn-flip');
					}
				}
			}
		}
	},

	setEqualHeight: function()
	{
		var containerClass = "jsn-horizontallayout";
		var columnClass = "jsn-modulecontainer_inner";
		var horizontallayoutObjs = document.getElements('.' + containerClass);
		var maxHeight = 0;
		Array.each(horizontallayoutObjs, function(item) {
			var columns = item.getElements('.'+columnClass);
			maxHeight = 0;
			Array.each(columns, function(col) {
				var coordinates = col.getCoordinates();
				if (coordinates.height > maxHeight) maxHeight = coordinates.height;
			});
			Array.each(columns, function(col) {
				col.setStyle('height',maxHeight);
			});
		});
	},


	/* ============================== MOOTOOLS ANIMATION ============================== */

	setToTopLinkCenter: function(rtl, jquery)
	{
		/* Min distance to be away from top for the link to be displayed */
		var min = 200;

		/* Determine RTL layout or not to set margin correctly */
		var marginFrom = "margin-left";
		if (rtl === true) {
			marginFrom = "margin-right";
		}

		if (jquery) {
			var element = $j('#jsn-gotoplink');
			if (!element.length) return;
			element.hide();
			($j(window).scrollTop() >= min) ? element.fadeIn() : element.fadeOut();
		} else if (typeof(MooTools) != 'undefined') {
			var element = document.id('jsn-gotoplink');
			if (!element) return;
			var elementHeight = element.getSize().y;

			element
				.setStyle('margin-left', -(element.getSize().x/2))
				.set('opacity','0')
				.fade((window.getScroll().y >= min) ? 'in' : 'out')
				.fade((window.getScroll().y >= min) ? 1 : 0);

			if (!JSNUtils.isFixedSupport()) {
			 	element.setStyle('position', 'absolute');
			 	window.addEvent('scroll', function () {
			 		var height = window.innerHeight;
			 		element.setStyle('bottom', 'auto');
			 		element.setStyle('top', window.getScroll().y + (height - elementHeight));
			 	});
			}
		}
	},

	isFixedSupport: function () {
		var userAgent = window.navigator.userAgent + '',
			isAppleDevice = /ipod|ipad|iphone/.test(userAgent.toLowerCase()),
			isWindowPhone = /Windows Phone/.test(userAgent),
			isAndroid = /Android/.test(userAgent),
			isSupported = true;

		if (isAppleDevice || isWindowPhone || isAndroid) {
			var pattern = /AppleWebKit\/([0-9]+\.[0-9]+)\s+/;

			if (isWindowPhone)
				pattern = /IEMobile\/([0-9]+\.[0-9]+);/;

			if (pattern.test(userAgent)) {
				var result = pattern.exec(userAgent);
				var version = result[1];

				isSupported = ((isAppleDevice || isAndroid) && JSNUtils.versionCompare(version, '534.1', '>='));
			}
		}

		return isSupported;
	},

	versionCompare: function (v1, v2, operator) {
	    this.php_js = this.php_js || {};
	    this.php_js.ENV = this.php_js.ENV || {};

	    var i = 0,
	        x = 0,
	        compare = 0,
	        vm = {
	            'dev': -6,
	            'alpha': -5,
	            'a': -5,
	            'beta': -4,
	            'b': -4,
	            'RC': -3,
	            'rc': -3,
	            '#': -2,
	            'p': -1,
	            'pl': -1
	        },

	        prepVersion = function (v) {
	            v = ('' + v).replace(/[_\-+]/g, '.');
	            v = v.replace(/([^.\d]+)/g, '.$1.').replace(/\.{2,}/g, '.');
	            return (!v.length ? [-8] : v.split('.'));
	        },

	        numVersion = function (v) {
	            return !v ? 0 : (isNaN(v) ? vm[v] || -7 : parseInt(v, 10));
	        };
	    v1 = prepVersion(v1);
	    v2 = prepVersion(v2);
	    x = Math.max(v1.length, v2.length);
	    for (i = 0; i < x; i++) {
	        if (v1[i] == v2[i]) {
	            continue;
	        }
	        v1[i] = numVersion(v1[i]);
	        v2[i] = numVersion(v2[i]);
	        if (v1[i] < v2[i]) {
	            compare = -1;
	            break;
	        } else if (v1[i] > v2[i]) {
	            compare = 1;
	            break;
	        }
	    }
	    if (!operator) {
	        return compare;
	    }

	    switch (operator) {
	    case '>':
	    case 'gt':
	        return (compare > 0);
	    case '>=':
	    case 'ge':
	        return (compare >= 0);
	    case '<=':
	    case 'le':
	        return (compare <= 0);
	    case '==':
	    case '=':
	    case 'eq':
	        return (compare === 0);
	    case '<>':
	    case '!=':
	    case 'ne':
	        return (compare !== 0);
	    case '':
	    case '<':
	    case 'lt':
	        return (compare < 0);
	    default:
	        return null;
	    }
	},

	setSmoothScroll: function(jquery)
	{
		var objBrowser = JSNUtils.getBrowserInfo();

		// Setup smooth go to top link
		if (jquery) {
			$j('#jsn-gotoplink').click(function(e) {
				e.preventDefault();
				var gotoplinkOffset = $j('#top').offset().top;
				$j('html,body').animate({scrollTop: gotoplinkOffset}, 500);
				return false;
			});
		} else if (typeof Fx != 'undefined' && typeof Fx.SmoothScroll != 'undefined') {
			new Fx.SmoothScroll({
				duration: 300,
				links: '#jsn-gotoplink'		// Target to only the gotop link
			}, window);
		}
	},

	setFadeScroll: function(jquery)
	{
		var min = 200;
		if (jquery) {
			var element = $j('#jsn-gotoplink');
			if(element == null) return false;

			$j(window).scroll(function () {
				($j(window).scrollTop() >= min) ? element.fadeIn() : element.fadeOut();
			});
		} else if (typeof(MooTools) != 'undefined') {
			var element = document.id('jsn-gotoplink');
			if (element == null) return false;
			if (parseFloat(MooTools.version) < 1.2)
			{
				var fx = new Fx.Style(element, "opacity", {duration: 500});
				var inside = false;
				window.addEvent('scroll',function(e) {
					var position = window.getSize().scroll;
					var y = position.y;
					if (y >= min)
					{
						if (!inside)
						{
							inside = true;
							fx.start(0, 1);
						}
					}
					else
					{
						if (inside)
						{
							inside = false;
							fx.start(1, 0);
						}
					}
				}.bind(this));
			}
			else
			{
				window.addEvent('scroll',function(e) {
					element.fade((window.getScroll().y >= min) ? 'in' : 'out');
					element.fade((window.getScroll().y >= min) ? 1 : 0);
				}.bind(this));
			}
		}
	},

	/* ============================== TEXT ============================== */

	checkSubstring: function(targetString, targetSubstring, delimeter, wholeWord){
		if(wholeWord == undefined) wholeWord = false;
		var parts = targetString.split(delimeter);
		for (var i = 0; i < parts.length; i++){
			if (wholeWord && parts[i] == targetSubstring) return true;
			if (!wholeWord && parts[i].indexOf(targetSubstring) > -1) return true;
		}
		return false;
	},

	/* ============================== REMOVE DUPLICATE CSS3 TAG IN IE7 - CSS3 PIE ============================== */

	removeCss3Duplicate: function(className)
	{
		var element = document.getElements('.' + className);
		if (element != undefined)
		{
			element.each(function(e){
				var elementParent = e.getParent();
				var duplicateTag = elementParent.getChildren('css3-container');
				if (duplicateTag.length && duplicateTag.length > 1)
				{
					elementParent.removeChild(duplicateTag[0]);
				}
			});
		}
	}
};
;


/* FILE: /templates/jsn_boot_pro/js/jsn_template.js */
/**
* @author    JoomlaShine.com http://www.joomlashine.com
* @copyright Copyright (C) 2008 - 2011 JoomlaShine.com. All rights reserved.
* @license   GNU/GPL v2 http://www.gnu.org/licenses/gpl-2.0.html
*/

	var JSNTemplate = {
		_templateParams:		{},

		initOnDomReady: function()
		{
			// Setup HTML code for typography
			JSNUtils.createGridLayout("DIV", "grid-layout", "grid-col", "grid-lastcol");
			JSNUtils.createExtList("list-number-", "span", "jsn-listbullet", true);
			JSNUtils.createExtList("list-icon", "span", "jsn-listbullet", false);

			// Setup Go to top link settings
			if (_templateParams.enableGotopLink) {
				JSNUtils.setToTopLinkCenter(_templateParams.enableRTL, false);
				JSNUtils.setSmoothScroll(false);
				JSNUtils.setFadeScroll(false);
			}

			// General layout setup
			JSNUtils.setupLayout();

			// Setup mobile menu
			JSNUtils.setMobileMenu("menu-mainmenu");

			if (JSNUtils.isDesktopViewOnMobile(_templateParams)) {
				// Setup mobile sticky
				if (_templateParams.enableMobileMenuSticky && JSNUtils.checkMobile()) {
					JSNUtils.setMobileSticky();
				}
			}
			else {
				JSNUtils.initMenuForDesktopView();
			}

			// Setup module dropdown on mobile
			JSNUtils.setDropdownModuleEvents();

			// Setup mobile sitetool
			JSNUtils.setMobileSitetool();

			// Stick main menu to top
			if (_templateParams.enableDesktopMenuSticky) {
				var	header = document.id('jsn-menu'),
					headerPosition = header.getPosition(),
					stickHeader = function() {
						var windowScroll = window.getScroll();

						if (windowScroll.y > headerPosition.y) {
							header.addClass('jsn-menu-sticky');
						} else {
							header.removeClass('jsn-menu-sticky');
						}
					};

				window.addEvent('scroll', stickHeader);
			}
		},

		initOnLoad: function()
		{
			// Setup event to update submenu position
			JSNUtils.setSubmenuPosition(_templateParams.enableRTL);

			// Stick positions layout setup
			JSNUtils.setVerticalPosition("jsn-pos-stick-leftmiddle", 'middle');
			JSNUtils.setVerticalPosition("jsn-pos-stick-rightmiddle", 'middle');
		},

		initTemplate: function(templateParams)
		{
			// Store template parameters
			_templateParams = templateParams;

			// Init template on "domready" event
			window.addEvent('domready', JSNTemplate.initOnDomReady);
			window.addEvent('load', JSNTemplate.initOnLoad);
		}
	}; // must have ; to prevent syntax error when compress
;
