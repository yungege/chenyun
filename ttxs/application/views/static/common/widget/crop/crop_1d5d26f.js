define("common:widget/crop/crop.js",function(e,t){var i=e("common:widget/lib/jquery.js"),n=e("common:widget/uploader/uploader.js"),o=e("common:widget/dialog/dialog.js"),r=e("common:widget/alert/alert.js"),s=e("common:widget/code/code.js"),a=function(e){this.options={width:0,height:0,picker:"",callback:""},this.options=this.merge(this.options,e),this.init()};a.prototype={merge:function(e,t){for(var i in e)void 0!=t[i]&&(e[i]=t[i]);return e},tpl:['<div class="crop-warp">','<div class="title">',"<h1>图片裁切</h1>",'<span class="crop-close"></span>',"</div>",'<div class="context">','<div class="progress-box">','<div class="progress-status">','<span class="progress-line"></span>',"</div>",'<span class="progress-notice">已上传：0%</span>',"</div>",'<div class="crop-box">','<div class="crop-select-box">',"</div>","<h4>裁切预览</h4>",'<div class="crop-view-box">','<img src="">',"</div>","</div>",'<div class="btn-box">','<button class="confirm">确认裁切</button>','<button class="cancel">取消裁切</button>',"</div>","</div>","</div>"].join(""),declare:function(){this.jCrop=null,this.cww=400,this.cwh=250,this.w=this.options.width,this.h=this.options.height,this.scale=0,this.top=0,this.left=0,this.cw=0,this.ch=0,this.fileId=0,this.uploader=null,this.dialog=null},init:function(){this.declare(),this.initUploader()},cancelEvent:function(){var e=this;this.cancelBtn.unbind().click(function(){e.dialog.removeDialog()})},confirmEvent:function(){var e=this;this.cropBtn.unbind().click(function(){e.fileId||alert("请等待图片上传完成！");var t=i(this);t.html("裁切中…"),i.ajax({url:"/home/submit/piccrop",type:"POST",data:{fileId:e.fileId,scale:e.scale,cw:e.cw,ch:e.ch,top:e.top,left:e.left,w:e.w,h:e.h},success:function(t){0===t.status.code?"function"==typeof e.options.callback&&e.options.callback.call(this,t):new r.alert({type:"danger",title:s.code[t.status.code]}),e.dialog.removeDialog()}})})},initCropDialog:function(e){this.dialog=new o.dialog({width:780,height:470,close:".crop-close",tpl:this.tpl}),this.getDom(),this.cancelEvent();var t=this,i=new FileReader;i.readAsDataURL(e),i.addEventListener("load",function(){t.appendImage(this.result)},!1)},appendImage:function(e){var t=this;i("<img>").attr("src",e).on("load",function(){var n=i(this),o=i("<div>"),r=this.width/this.height,s=this.height/this.width,a=t.cww/t.cwh;r>=a?(n.css({width:t.cww,height:t.cww*s}),o.css({width:t.cww,height:t.cww*s,top:(t.cwh-t.cww*s)/2,left:0,position:"absolute"}),t.scale=this.width/t.cww):(n.css({width:t.cwh*r,height:t.cwh}),o.css({width:t.cwh*r,height:t.cwh,top:0,left:(t.cww-t.cwh*r)/2,position:"absolute"}),t.scale=this.height/t.cwh);var c=i("<div>").addClass("jcrop-holder-warp").append(n);t.cropChoiceWarp.append(o.append(c)),t.cropViewImg.attr("src",e),t.initCrop(this.width,this.height,parseInt(n.css("height"),10))})},initCrop:function(e,t,i){var n=this,o=this.w/this.h,r=0,s=this.cropChoiceWarp.find(".jcrop-holder-warp");e>t&&o>1?(this.cropViewWarp.css("height",230/o),r=230):(r=230*o,this.cropViewWarp.css("width",r)),s.Jcrop({bgOpacity:.5,bgColor:"rgba(0, 0, 0, 0.7)",aspectRatio:o,maxSize:[o*i,i],onChange:function(i){n.top=i.y,n.left=i.x,n.cw=i.w,n.ch=i.h;var o=r/i.w;n.cropViewImg.css({left:-(i.x*o),top:-(i.y*o),width:o*e,height:o*t})}},function(){n.jCrop=this;var i=e>100?100:e;this.setSelect([0,0,i,i/o]),n.cropViewImg.css({left:0,top:0,width:e*(r/100),height:t*(r/100)})}),this.confirmEvent()},uploadPicEvent:function(e){var t=parseFloat(e.loaded/e.total,10);this.progressNotice.html("已上传："+parseInt(100*t,10)+"%"),this.progressLine.css({left:600*(t-1)})},uploadDoneEvent:function(e){this.progressNotice.html("上传完成").addClass("done"),this.fileId=e.fileId},initUploader:function(){var e=this;this.uploader=new n.uploader({picker:this.options.picker,allowType:["image/jpeg","image/jpg","image/png","image/bmp"],onUpload:function(t){e.initCropDialog(t)},multiple:!1,formDataParams:"pic",uploadUrl:"/home/submit/uploadpic",checkFileMd5:!0,checkFileMd5Url:"/home/interface/checkpicmd5",checkFileMd5Params:"md5",progress:function(t){e.uploadPicEvent(t)},success:function(t){e.uploadDoneEvent(t)},error:function(e){new r.alert({title:e.errstr,type:"danger"})}})},getDom:function(){this.container=i(".crop-warp"),this.progressLine=this.container.find(".progress-line"),this.progressNotice=this.container.find(".progress-notice"),this.cropChoiceWarp=this.container.find(".crop-select-box"),this.cropViewWarp=this.container.find(".crop-view-box"),this.cropViewImg=this.cropViewWarp.find("img"),this.cropBtn=this.container.find(".confirm"),this.cancelBtn=this.container.find(".cancel")}},!function(){i.Jcrop=function(e,t){function n(e){return Math.round(e)+"px"}function o(e){return R.baseClass+"-"+e}function r(){return i.fx.step.hasOwnProperty("backgroundColor")}function s(e){var t=i(e).offset();return[t.left,t.top]}function a(e){return[e.pageX-P[0],e.pageY-P[1]]}function c(e){"object"!=typeof e&&(e={}),R=i.extend(R,e),i.each(["onChange","onSelect","onRelease","onDblClick"],function(e,t){"function"!=typeof R[t]&&(R[t]=function(){})})}function d(e,t,i){if(P=s(L),ft.setCursor("move"===e?e:e+"-resize"),"move"===e)return ft.activateHandlers(l(t),w,i);var n=lt.getFixed(),o=h(e),r=lt.getCorner(h(o));lt.setPressed(lt.getCorner(o)),lt.setCurrent(r),ft.activateHandlers(u(e,n),w,i)}function u(e,t){return function(i){if(R.aspectRatio)switch(e){case"e":i[1]=t.y+1;break;case"w":i[1]=t.y+1;break;case"n":i[0]=t.x+1;break;case"s":i[0]=t.x+1}else switch(e){case"e":i[1]=t.y2;break;case"w":i[1]=t.y2;break;case"n":i[0]=t.x2;break;case"s":i[0]=t.x2}lt.setCurrent(i),pt.update()}}function l(e){var t=e;return gt.watchKeys(),function(e){lt.moveOffset([e[0]-t[0],e[1]-t[1]]),t=e,pt.update()}}function h(e){switch(e){case"n":return"sw";case"s":return"nw";case"e":return"nw";case"w":return"ne";case"ne":return"sw";case"nw":return"se";case"se":return"nw";case"sw":return"ne"}}function p(e){return function(t){return R.disabled?!1:"move"!==e||R.allowMove?(P=s(L),nt=!0,d(e,a(t)),t.stopPropagation(),t.preventDefault(),!1):!1}}function f(e,t,i){var n=e.width(),o=e.height();n>t&&t>0&&(n=t,o=t/e.width()*e.height()),o>i&&i>0&&(o=i,n=i/e.height()*e.width()),tt=e.width()/n,it=e.height()/o,e.width(n).height(o)}function g(e){return{x:e.x*tt,y:e.y*it,x2:e.x2*tt,y2:e.y2*it,w:e.w*tt,h:e.h*it}}function w(){var e=lt.getFixed();e.w>R.minSelect[0]&&e.h>R.minSelect[1]?(pt.enableHandles(),pt.done()):pt.release(),ft.setCursor(R.allowSelect?"crosshair":"default")}function b(e){if(R.disabled)return!1;if(!R.allowSelect)return!1;nt=!0,P=s(L),pt.disableHandles(),ft.setCursor("crosshair");var t=a(e);return lt.setPressed(t),pt.update(),ft.activateHandlers(v,w,"touch"===e.type.substring(0,5)),gt.watchKeys(),e.stopPropagation(),e.preventDefault(),!1}function v(e){lt.setCurrent(e),pt.update()}function m(){var e=i("<div></div>").addClass(o("tracker"));return J&&e.css({opacity:0,backgroundColor:"white"}),e}function y(e){q.removeClass().addClass(o("holder")).addClass(e)}function C(e,t){function i(){window.setTimeout(v,l)}var n=e[0]/tt,o=e[1]/it,r=e[2]/tt,s=e[3]/it;if(!ot){var a=lt.flipCoords(n,o,r,s),c=lt.getFixed(),d=[c.x,c.y,c.x2,c.y2],u=d,l=R.animationDelay,h=a[0]-d[0],p=a[1]-d[1],f=a[2]-d[2],g=a[3]-d[3],w=0,b=R.swingSpeed;n=u[0],o=u[1],r=u[2],s=u[3],pt.animMode(!0);var v=function(){return function(){w+=(100-w)/b,u[0]=Math.round(n+w/100*h),u[1]=Math.round(o+w/100*p),u[2]=Math.round(r+w/100*f),u[3]=Math.round(s+w/100*g),w>=99.8&&(w=100),100>w?(k(u),i()):(pt.done(),pt.animMode(!1),"function"==typeof t&&t.call(wt))}}();i()}}function x(e){k([e[0]/tt,e[1]/it,e[2]/tt,e[3]/it]),R.onSelect.call(wt,g(lt.getFixed())),pt.enableHandles()}function k(e){lt.setPressed([e[0],e[1]]),lt.setCurrent([e[2],e[3]]),pt.update()}function S(){return g(lt.getFixed())}function j(){return lt.getFixed()}function z(e){c(e),B()}function M(){R.disabled=!0,pt.disableHandles(),pt.setCursor("default"),ft.setCursor("default")}function I(){R.disabled=!1,B()}function O(){pt.done(),ft.activateHandlers(null,null)}function D(){q.remove(),W.show(),W.css("visibility","visible"),i(e).removeData("Jcrop")}function F(e,t){pt.release(),M();var i=new Image;i.onload=function(){var n=i.width,o=i.height,r=R.boxWidth,s=R.boxHeight;L.width(n).height(o),L.attr("src",e),Y.attr("src",e),f(L,r,s),U=L.width(),N=L.height(),Y.width(U).height(N),at.width(U+2*st).height(N+2*st),q.width(U).height(N),ht.resize(U,N),I(),"function"==typeof t&&t.call(wt)},i.src=e}function H(e,t,i){var n=t||R.bgColor;R.bgFade&&r()&&R.fadeTime&&!i?e.animate({backgroundColor:n},{queue:!1,duration:R.fadeTime}):e.css("backgroundColor",n)}function B(e){R.allowResize?e?pt.enableOnly():pt.enableHandles():pt.disableHandles(),ft.setCursor(R.allowSelect?"crosshair":"default"),pt.setCursor(R.allowMove?"move":"default"),R.hasOwnProperty("trueSize")&&(tt=R.trueSize[0]/U,it=R.trueSize[1]/N),R.hasOwnProperty("setSelect")&&(x(R.setSelect),pt.done(),delete R.setSelect),ht.refresh(),R.bgColor!=ct&&(H(R.shade?ht.getShades():q,R.shade?R.shadeColor||R.bgColor:R.bgColor),ct=R.bgColor),dt!=R.bgOpacity&&(dt=R.bgOpacity,R.shade?ht.refresh():pt.setBgOpacity(dt)),Z=R.maxSize[0]||0,$=R.maxSize[1]||0,_=R.minSize[0]||0,et=R.minSize[1]||0,R.hasOwnProperty("outerImage")&&(L.attr("src",R.outerImage),delete R.outerImage),pt.refresh()}var P,R=i.extend({},i.Jcrop.defaults),E=navigator.userAgent.toLowerCase(),J=/msie/.test(E),T=/msie [1-6]\./.test(E);"object"!=typeof e&&(e=i(e)[0]),"object"!=typeof t&&(t={}),c(t);var A={border:"none",visibility:"visible",margin:0,padding:0,position:"absolute",top:0,left:0},W=i(e),V=!0;if("IMG"==e.tagName){if(0!=W[0].width&&0!=W[0].height)W.width(W[0].width),W.height(W[0].height);else{var K=new Image;K.src=W[0].src,W.width(K.width),W.height(K.height)}var L=W.clone().removeAttr("id").css(A).show();L.width(W.width()),L.height(W.height()),W.after(L).hide()}else L=W.css(A).show(),V=!1,null===R.shade&&(R.shade=!0);f(L,R.boxWidth,R.boxHeight);var U=L.width(),N=L.height(),q=i("<div />").width(U).height(N).addClass(o("holder")).css({position:"relative",backgroundColor:R.bgColor}).insertAfter(W).append(L);R.addClass&&q.addClass(R.addClass);var Y=i("<div />"),X=i("<div />").width("100%").height("100%").css({zIndex:310,position:"absolute",overflow:"hidden"}),G=i("<div />").width("100%").height("100%").css("zIndex",320),Q=i("<div />").css({position:"absolute",zIndex:600}).dblclick(function(){var e=lt.getFixed();R.onDblClick.call(wt,e)}).insertBefore(L).append(X,G);V&&(Y=i("<img />").attr("src",L.attr("src")).css(A).width(U).height(N),X.append(Y)),T&&Q.css({overflowY:"hidden"});var Z,$,_,et,tt,it,nt,ot,rt,st=R.boundary,at=m().width(U+2*st).height(N+2*st).css({position:"absolute",top:n(-st),left:n(-st),zIndex:290}).mousedown(b),ct=R.bgColor,dt=R.bgOpacity;P=s(L);var ut=function(){function e(){var e,t={},i=["touchstart","touchmove","touchend"],n=document.createElement("div");try{for(e=0;e<i.length;e++){var o=i[e];o="on"+o;var r=o in n;r||(n.setAttribute(o,"return;"),r="function"==typeof n[o]),t[i[e]]=r}return t.touchstart&&t.touchend&&t.touchmove}catch(s){return!1}}function t(){return R.touchSupport===!0||R.touchSupport===!1?R.touchSupport:e()}return{createDragger:function(e){return function(t){return R.disabled?!1:"move"!==e||R.allowMove?(P=s(L),nt=!0,d(e,a(ut.cfilter(t)),!0),t.stopPropagation(),t.preventDefault(),!1):!1}},newSelection:function(e){return b(ut.cfilter(e))},cfilter:function(e){return e.pageX=e.originalEvent.changedTouches[0].pageX,e.pageY=e.originalEvent.changedTouches[0].pageY,e},isSupported:e,support:t()}}(),lt=function(){function e(e){e=s(e),f=h=e[0],g=p=e[1]}function t(e){e=s(e),u=e[0]-f,l=e[1]-g,f=e[0],g=e[1]}function i(){return[u,l]}function n(e){var t=e[0],i=e[1];0>h+t&&(t-=t+h),0>p+i&&(i-=i+p),g+i>N&&(i+=N-(g+i)),f+t>U&&(t+=U-(f+t)),h+=t,f+=t,p+=i,g+=i}function o(e){var t=r();switch(e){case"ne":return[t.x2,t.y];case"nw":return[t.x,t.y];case"se":return[t.x2,t.y2];case"sw":return[t.x,t.y2]}}function r(){if(!R.aspectRatio)return c();var e,t,i,n,o=R.aspectRatio,r=R.minSize[0]/tt,s=R.maxSize[0]/tt,u=R.maxSize[1]/it,l=f-h,w=g-p,b=Math.abs(l),v=Math.abs(w),m=b/v;return 0===s&&(s=10*U),0===u&&(u=10*N),o>m?(t=g,i=v*o,e=0>l?h-i:i+h,0>e?(e=0,n=Math.abs((e-h)/o),t=0>w?p-n:n+p):e>U&&(e=U,n=Math.abs((e-h)/o),t=0>w?p-n:n+p)):(e=f,n=b/o,t=0>w?p-n:p+n,0>t?(t=0,i=Math.abs((t-p)*o),e=0>l?h-i:i+h):t>N&&(t=N,i=Math.abs(t-p)*o,e=0>l?h-i:i+h)),e>h?(r>e-h?e=h+r:e-h>s&&(e=h+s),t=t>p?p+(e-h)/o:p-(e-h)/o):h>e&&(r>h-e?e=h-r:h-e>s&&(e=h-s),t=t>p?p+(h-e)/o:p-(h-e)/o),0>e?(h-=e,e=0):e>U&&(h-=e-U,e=U),0>t?(p-=t,t=0):t>N&&(p-=t-N,t=N),d(a(h,p,e,t))}function s(e){return e[0]<0&&(e[0]=0),e[1]<0&&(e[1]=0),e[0]>U&&(e[0]=U),e[1]>N&&(e[1]=N),[Math.round(e[0]),Math.round(e[1])]}function a(e,t,i,n){var o=e,r=i,s=t,a=n;return e>i&&(o=i,r=e),t>n&&(s=n,a=t),[o,s,r,a]}function c(){var e,t=f-h,i=g-p;return Z&&Math.abs(t)>Z&&(f=t>0?h+Z:h-Z),$&&Math.abs(i)>$&&(g=i>0?p+$:p-$),et/it&&Math.abs(i)<et/it&&(g=i>0?p+et/it:p-et/it),_/tt&&Math.abs(t)<_/tt&&(f=t>0?h+_/tt:h-_/tt),0>h&&(f-=h,h-=h),0>p&&(g-=p,p-=p),0>f&&(h-=f,f-=f),0>g&&(p-=g,g-=g),f>U&&(e=f-U,h-=e,f-=e),g>N&&(e=g-N,p-=e,g-=e),h>U&&(e=h-N,g-=e,p-=e),p>N&&(e=p-N,g-=e,p-=e),d(a(h,p,f,g))}function d(e){return{x:e[0],y:e[1],x2:e[2],y2:e[3],w:e[2]-e[0],h:e[3]-e[1]}}var u,l,h=0,p=0,f=0,g=0;return{flipCoords:a,setPressed:e,setCurrent:t,getOffset:i,moveOffset:n,getCorner:o,getFixed:r}}(),ht=function(){function e(e,t){f.left.css({height:n(t)}),f.right.css({height:n(t)})}function t(){return o(lt.getFixed())}function o(e){f.top.css({left:n(e.x),width:n(e.w),height:n(e.y)}),f.bottom.css({top:n(e.y2),left:n(e.x),width:n(e.w),height:n(N-e.y2)}),f.right.css({left:n(e.x2),width:n(U-e.x2)}),f.left.css({width:n(e.x)})}function r(){return i("<div />").css({position:"absolute",backgroundColor:R.shadeColor||R.bgColor}).appendTo(p)}function s(){h||(h=!0,p.insertBefore(L),t(),pt.setBgOpacity(1,0,1),Y.hide(),a(R.shadeColor||R.bgColor,1),pt.isAwake()?d(R.bgOpacity,1):d(1,1))}function a(e,t){H(l(),e,t)}function c(){h&&(p.remove(),Y.show(),h=!1,pt.isAwake()?pt.setBgOpacity(R.bgOpacity,1,1):(pt.setBgOpacity(1,1,1),pt.disableHandles()),H(q,0,1))}function d(e,t){h&&(R.bgFade&&!t?p.animate({opacity:1-e},{queue:!1,duration:R.fadeTime}):p.css({opacity:1-e}))}function u(){R.shade?s():c(),pt.isAwake()&&d(R.bgOpacity)}function l(){return p.children()}var h=!1,p=i("<div />").css({position:"absolute",zIndex:240,opacity:0}),f={top:r(),left:r().height(N),right:r().height(N),bottom:r()};return{update:t,updateRaw:o,getShades:l,setBgColor:a,enable:s,disable:c,resize:e,refresh:u,opacity:d}}(),pt=function(){function e(e){var t=i("<div />").css({position:"absolute",opacity:R.borderOpacity}).addClass(o(e));return X.append(t),t}function t(e,t){var n=i("<div />").mousedown(p(e)).css({cursor:e+"-resize",position:"absolute",zIndex:t}).addClass("ord-"+e);return ut.support&&n.bind("touchstart.jcrop",ut.createDragger(e)),G.append(n),n}function r(e){var i=R.handleSize,n=t(e,M++).css({opacity:R.handleOpacity}).addClass(o("handle"));return i&&n.width(i).height(i),n}function s(e){return t(e,M++).addClass("jcrop-dragbar")}function a(e){var t;for(t=0;t<e.length;t++)D[e[t]]=s(e[t])}function c(t){var i,n;for(n=0;n<t.length;n++){switch(t[n]){case"n":i="hline";break;case"s":i="hline bottom";break;case"e":i="vline right";break;case"w":i="vline"}I[t[n]]=e(i)}}function d(e){var t;for(t=0;t<e.length;t++)O[e[t]]=r(e[t])}function u(e,t){R.shade||Y.css({top:n(-t),left:n(-e)}),Q.css({top:n(t),left:n(e)})}function l(e,t){Q.width(Math.round(e)).height(Math.round(t))}function h(){var e=lt.getFixed();lt.setPressed([e.x,e.y]),lt.setCurrent([e.x2,e.y2]),f()}function f(e){return z?w(e):void 0}function w(e){var t=lt.getFixed();l(t.w,t.h),u(t.x,t.y),R.shade&&ht.updateRaw(t),z||v(),e?R.onSelect.call(wt,g(t)):R.onChange.call(wt,g(t))}function b(e,t,i){(z||t)&&(R.bgFade&&!i?L.animate({opacity:e},{queue:!1,duration:R.fadeTime}):L.css("opacity",e))}function v(){Q.show(),R.shade?ht.opacity(dt):b(dt,!0),z=!0}function y(){k(),Q.hide(),R.shade?ht.opacity(1):b(1),z=!1,R.onRelease.call(wt)}function C(){F&&G.show()}function x(){return F=!0,R.allowResize?(G.show(),!0):void 0}function k(){F=!1,G.hide()}function S(e){e?(ot=!0,k()):(ot=!1,x())}function j(){S(!1),h()}var z,M=370,I={},O={},D={},F=!1;R.dragEdges&&i.isArray(R.createDragbars)&&a(R.createDragbars),i.isArray(R.createHandles)&&d(R.createHandles),R.drawBorders&&i.isArray(R.createBorders)&&c(R.createBorders),i(document).bind("touchstart.jcrop-ios",function(e){i(e.currentTarget).hasClass("jcrop-tracker")&&e.stopPropagation()});var H=m().mousedown(p("move")).css({cursor:"move",position:"absolute",zIndex:360});return ut.support&&H.bind("touchstart.jcrop",ut.createDragger("move")),X.append(H),k(),{updateVisible:f,update:w,release:y,refresh:h,isAwake:function(){return z},setCursor:function(e){H.css("cursor",e)},enableHandles:x,enableOnly:function(){F=!0},showHandles:C,disableHandles:k,animMode:S,setBgOpacity:b,done:j}}(),ft=function(){function e(e){at.css({zIndex:450}),e?i(document).bind("touchmove.jcrop",s).bind("touchend.jcrop",c):h&&i(document).bind("mousemove.jcrop",n).bind("mouseup.jcrop",o)}function t(){at.css({zIndex:290}),i(document).unbind(".jcrop")}function n(e){return u(a(e)),!1}function o(e){return e.preventDefault(),e.stopPropagation(),nt&&(nt=!1,l(a(e)),pt.isAwake()&&R.onSelect.call(wt,g(lt.getFixed())),t(),u=function(){},l=function(){}),!1}function r(t,i,n){return nt=!0,u=t,l=i,e(n),!1}function s(e){return u(a(ut.cfilter(e))),!1}function c(e){return o(ut.cfilter(e))}function d(e){at.css("cursor",e)}var u=function(){},l=function(){},h=R.trackDocument;return h||at.mousemove(n).mouseup(o).mouseout(o),L.before(at),{activateHandlers:r,setCursor:d}}(),gt=function(){function e(){R.keySupport&&(r.show(),r.focus())}function t(){r.hide()}function n(e,t,i){R.allowMove&&(lt.moveOffset([t,i]),pt.updateVisible(!0)),e.preventDefault(),e.stopPropagation()}function o(e){if(e.ctrlKey||e.metaKey)return!0;rt=e.shiftKey?!0:!1;var t=rt?10:1;switch(e.keyCode){case 37:n(e,-t,0);break;case 39:n(e,t,0);break;case 38:n(e,0,-t);break;case 40:n(e,0,t);break;case 27:R.allowSelect&&pt.release();break;case 9:return!0}return!1}var r=i('<input type="radio" />').css({position:"fixed",left:"-120px",width:"12px"}).addClass("jcrop-keymgr"),s=i("<div />").css({position:"absolute",overflow:"hidden"}).append(r);return R.keySupport&&(r.keydown(o).blur(t),T||!R.fixedSupport?(r.css({position:"absolute",left:"-20px"}),s.append(r).insertBefore(L)):r.insertBefore(L)),{watchKeys:e}}();ut.support&&at.bind("touchstart.jcrop",ut.newSelection),G.hide(),B(!0);var wt={setImage:F,animateTo:C,setSelect:x,setOptions:z,tellSelect:S,tellScaled:j,setClass:y,disable:M,enable:I,cancel:O,release:pt.release,destroy:D,focus:gt.watchKeys,getBounds:function(){return[U*tt,N*it]},getWidgetSize:function(){return[U,N]},getScaleFactor:function(){return[tt,it]},getOptions:function(){return R},ui:{holder:q,selection:Q}};return J&&q.bind("selectstart",function(){return!1}),W.data("Jcrop",wt),wt},i.fn.Jcrop=function(e,t){var n;return this.each(function(){if(i(this).data("Jcrop")){if("api"===e)return i(this).data("Jcrop");i(this).data("Jcrop").setOptions(e)}else"IMG"==this.tagName?i.Jcrop.Loader(this,function(){i(this).css({display:"block",visibility:"hidden"}),n=i.Jcrop(this,e),i.isFunction(t)&&t.call(n)}):(i(this).css({display:"block",visibility:"hidden"}),n=i.Jcrop(this,e),i.isFunction(t)&&t.call(n))}),this},i.Jcrop.Loader=function(e,t,n){function o(){s.complete?(r.unbind(".jcloader"),i.isFunction(t)&&t.call(s)):window.setTimeout(o,50)}var r=i(e),s=r[0];r.bind("load.jcloader",o).bind("error.jcloader",function(){r.unbind(".jcloader"),i.isFunction(n)&&n.call(s)}),s.complete&&i.isFunction(t)&&(r.unbind(".jcloader"),t.call(s))},i.Jcrop.defaults={allowSelect:!0,allowMove:!0,allowResize:!0,trackDocument:!0,baseClass:"jcrop",addClass:null,bgColor:"black",bgOpacity:.6,bgFade:!1,borderOpacity:.4,handleOpacity:.5,handleSize:null,aspectRatio:0,keySupport:!0,createHandles:["n","s","e","w","nw","ne","se","sw"],createDragbars:["n","s","e","w"],createBorders:["n","s","e","w"],drawBorders:!0,dragEdges:!0,fixedSupport:!0,touchSupport:null,shade:null,boxWidth:0,boxHeight:0,boundary:2,fadeTime:400,animationDelay:20,swingSpeed:3,minSelect:[0,0],maxSize:[0,0],minSize:[0,0],onChange:function(){},onSelect:function(){},onDblClick:function(){},onRelease:function(){}}}(),t.crop=a});