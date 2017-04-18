define("common:widget/dialog/dialog.js",function(i,t){var o=i("common:widget/lib/jquery.js"),e=function(i){this.settings={width:0,height:0,opacity:.6,only:!0,tpl:"",close:"",autoCenter:!0,top:"",drag:!1,dragItem:""},this.settings=this.merge(this.settings,i),this.init()};e.prototype={constructor:"dialog",version:"1.0.0",author:"jixuecong@zeegine.com",merge:function(i,t){for(var o in i)void 0!=t[o]&&(i[o]=t[o]);return i},dialogTpl:['<div class="dialog_b">',"</div>",'<div class="dialog">',"</div>"].join(""),removeOtherDialog:function(){if(!this.settings.only)return!1;var i=o(".dialog"),t=o(".dialog_b");i&&i.remove(),t&&t.remove()},init:function(){this.removeOtherDialog(),this.createDialog(),this.initDialog(),this.closeDiaog(),this.dragEvent();var i=this;o(window).on("resize",function(){i.initDialog()})},dragEvent:function(){if(!this.settings.drag)return!1;var i=this,t=o(this.settings.dragItem);t.css("cursor","move").unbind().mousedown(function(t){var e=parseInt(i.dialog.css("left"),10),s=parseInt(i.dialog.css("top"),10),n=t.pageX,a=t.pageY;o(document).mousemove(function(t){i.dialog.css({left:e+t.pageX-n,top:s+t.pageY-a})})}),o(document).mouseup(function(){o(document).unbind("mousemove")})},checkIe6:function(){var i=window.navigator.userAgent;if(!(i.indexOf("MSIE")>-1))return!1;var t=i.indexOf("MSIE")+5,o=i.substr(t,3);return 6===parseInt(o,10)?!0:void 0},createDialog:function(){var i=this,t=o(window).scrollTop(),e=this.settings.autoCenter?"fixed":"absolute";i.checkIe6()&&(e="absolute"),o("html body").append(i.dialogTpl),this.dialog=o(".dialog"),this.dialog_bg=o(".dialog_b"),this.dialog.css({position:e,width:this.settings.width,height:this.settings.height,zIndex:1e4}).append(i.settings.tpl),i.checkIe6()||(e="fixed"),this.dialog_bg.css({position:e,background:"#000",top:"absolute"===e?t:0,left:0,zIndex:9999})},initDialog:function(){var i=this,t=o(window).width(),e=o(window).height(),s=(e-this.settings.height)/2,n=(t-this.settings.width)/2;this.settings.autoCenter?this.top=s:s=this.top,this.dialog_bg.css({width:t,height:e,opacity:i.settings.opacity}),this.dialog.css({left:n,top:0>s?0:s}),this.checkIe6()&&this.scrollDialog()},scrollDialog:function(){var i=this,t=0;o(window).on("scroll",function(){t=o(window).scrollTop(),i.settings.autoCenter&&i.dialog.css({top:i.settings.top+t}),i.dialog_bg.css({top:t})})},closeDiaog:function(){var i=this,t="",e=null;if(this.settings.tpl&&this.settings.close)t=o(this.settings.close);else{if(this.settings.tpl||!this.settings.close)return!1;e=setInterval(function(){t=o(i.settings.close),t&&clearInterval(e)},10)}t.unbind().click(function(){i.removeDialog()})},removeDialog:function(){var i=this,t=document.documentElement.style,o=!1;for(var e in t)if("animation"==e){o=!0;break}if(o){var s=this.dialog.attr("style");this.dialog.attr("style",s+" animation: remove-dialog 0.3s linear");var n=setTimeout(function(){clearTimeout(n),i.dialog.remove(),i.dialog_bg.remove()},295)}else this.dialog.remove(),this.dialog_bg.remove()},removeDialogWithAnimation:function(){var i=this;this.dialog.fadeOut(),this.dialog_bg.fadeOut(function(){i.removeDialog()})},hideDialog:function(){this.dialog.hide(),this.dialog_bg.hide()},showDialog:function(){this.dialog.show(),this.dialog_bg.show()}},t.dialog=e});