define("common:widget/comment/comment.js",function(t,n){var i=t("common:widget/lib/jquery.js"),s=t("common:widget/ajaxpaging/ajaxpaging.js"),a=function(t){this.options={url:"",params:"",showEle:"",loadingClass:""},this.options=this.merge(this.options,t),this.init()};a.prototype={merge:function(t,n){for(var i in t)void 0!=n[i]&&(t[i]=n[i]);return t},init:function(){this.w=parseInt(i(this.options.showEle).css("width"),10)-90;var t=this;new s.ajaxpaging({url:this.options.url,params:this.options.params,render:function(n){return t.renderComment(n)},loadingClass:this.options.loadingClass,showEle:this.options.showEle})},parseStamp:function(t){var n=+new Date;if(n=n.toString().substring(0,10),n=parseInt(n,10),t>=n)return"刚刚";var i=Math.floor((n-t)/86400);if(0===i){var s=Math.floor((n-t)/3600);if(0===s){var a=Math.floor((n-t)/60);return 0===a?"刚刚":a+"分钟前"}return s+"小时前"}return i+"天前"},renderComment:function(t){if(!t.data.list||0===t.data.list.length)return'<p class="empty-comment">沙发空缺中，还不快抢~</p>';var n=t.data.list,i='<dl class="comment-list">';for(var s in n)i+='<dd><a href="/p/'+n[s].username+'.html">',i+='<img class="image-loading" data-origin-url="'+n[s].header_pic+'"></a>',i+='<div class="comment-context" style="width:'+this.w+'px;"><p class="comment-info">',i+='<a href="/p/'+n[s].username+'.html">'+n[s].nickname+"</a>",i+=n[s].comment+"</p>",i+='<p class="comment-satmp">'+this.parseStamp(parseInt(n[s].stamp,10))+"</p></div</dd>";return i+="</dl>"}},n.comment=a});