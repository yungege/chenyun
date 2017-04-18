define("common:widget/ajaxpading/ajaxpading.js",function(t,i){var s=t("common:widget/lib/jquery.js"),a=t("common:widget/lazyload/lazyload.js"),n=function(t){this.options={url:"",pn:"pn",params:"",render:"",loadingClass:"",showEle:""},this.options=this.merge(this.options,t),this.init()};n.prototype={merge:function(t,i){for(var s in t)void 0!=i[s]&&(t[s]=i[s]);return t},declare:function(){this.url="",this.params="",this.cache=fisData,this.pnAttr="data-pn"},parseParmas:function(){if(this.url=this.options.url.indexOf("?")>-1?this.options.url:this.options.url+"?",!this.options.params)return!1;if("object"==typeof this.options.params){var t=[];for(var i in this.options.params)i&&t.push(i+"="+this.options.params[i]);this.params=t.length>0?t.join("&")+"&":""}else"string"==typeof this.options.params&&(this.params=this.options.params)},init:function(){this.declare(),this.parseParmas(),this.getDom(),this.getAsyncData(1),this.listenPageEvent()},listenPageEvent:function(){var t=this;this.showEle.delegate(".ajaxpading li","click",function(){var i=s(this);i.attr(t.pnAttr)&&t.getAsyncData(i.attr(t.pnAttr))})},renderTpl:function(t){if("function"==typeof this.options.render)var i=this.options.render.call(this,t);else var i="";var s=this.renderPaddingTpl(t.data.pn,t.data.page_count);this.options.loadingClass&&this.showEle.removeClass(this.options.loadingClass),this.showEle.html(i+s),i.lastIndexOf("image-loading")>-1&&new a.lazyload({picker:".image-loading",loadClass:"image-loading"}),i.lastIndexOf("header-loading")>-1&&new a.lazyload({picker:".header-loading",loadClass:"header-loading"})},renderPaddingTpl:function(t,i){var s=7,a=0,n=0,o='<div class="ajaxpading"><ul class="ajaxpading-inner">';if(1>=i)return"";i>s?(a=1===t||t<Math.floor(s/2)?1:t-Math.floor(s/2),n=a+s-1,n>i&&(n=i,a=n-s+1)):(a=1,n=i),1!=t&&1!=a&&(o+="<li "+this.pnAttr+'="1">首页</li>'),1!=t&&(o+="<li "+this.pnAttr+'="'+(t-1)+'">上一页</li>');for(var e=a;n>=e;e++)o+=e!=t?"<li "+this.pnAttr+'="'+e+'">'+e+"</li>":'<li class="current">'+e+"</li>";return t!=i&&(o+="<li "+this.pnAttr+'="'+(t+1)+'">下一页</li>'),i>t&&(o+="<li "+this.pnAttr+'="'+i+'">尾页</li>'),o+="</ul></div>"},getAsyncData:function(t){var i=this,a=this.url+this.params+this.options.pn+"="+t;this.options.loadingClass&&this.showEle.html("").addClass(this.options.loadingClass),this.cache.get(a)?i.renderTpl(this.cache.get(a)):s.getJSON(a,function(t){i.cache.set(a,t),i.renderTpl(t)})},getDom:function(){if(this.showEle=s(this.options.showEle),!this.showEle)throw new Error("unkonw showEle")}},i.ajaxpading=n});
;define("common:widget/comment/comment.js",function(t,n){var i=t("common:widget/lib/jquery.js"),s=t("common:widget/ajaxpading/ajaxpading.js"),a=function(t){this.options={url:"",params:"",showEle:"",loadingClass:""},this.options=this.merge(this.options,t),this.init()};a.prototype={merge:function(t,n){for(var i in t)void 0!=n[i]&&(t[i]=n[i]);return t},init:function(){this.w=parseInt(i(this.options.showEle).css("width"),10)-90;var t=this;new s.ajaxpading({url:this.options.url,params:this.options.params,render:function(n){return t.renderComment(n)},loadingClass:this.options.loadingClass,showEle:this.options.showEle})},parseStamp:function(t){var n=+new Date;if(n=n.toString().substring(0,10),n=parseInt(n,10),t>=n)return"刚刚";var i=Math.floor((n-t)/86400);if(0===i){var s=Math.floor((n-t)/3600);if(0===s){var a=Math.floor((n-t)/60);return 0===a?"刚刚":a+"分钟前"}return s+"小时前"}return i+"天前"},renderComment:function(t){if(!t.data.list||0===t.data.list.length)return'<p class="empty-comment">沙发空缺中，还不快抢~</p>';var n=t.data.list,i='<dl class="comment-list">';for(var s in n)i+='<dd><a href="/p/'+n[s].username+'.html">',i+='<img class="image-loading" data-origin-url="'+n[s].header_pic+'"></a>',i+='<div class="comment-context" style="width:'+this.w+'px;"><p class="comment-info">',i+='<a href="/p/'+n[s].username+'.html">'+n[s].nickname+"</a>",i+=n[s].comment+"</p>",i+='<p class="comment-satmp">'+this.parseStamp(parseInt(n[s].stamp,10))+"</p></div</dd>";return i+="</dl>"}},n.comment=a});