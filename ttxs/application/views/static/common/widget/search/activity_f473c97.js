define("common:widget/search/activity.js",function(i,e){var t=i("common:widget/lib/jquery.js"),s=i("common:widget/login/login.js"),a=i("common:widget/dialog/dialog.js"),n=i("common:widget/alert/alert.js"),c=i("common:widget/code/code.js"),o=i("common:widget/zeroclipboard/zeroclipboard.js"),r=i("common:widget/qrcode/qrcode.js"),l={init:function(){this.getDom(),this.userInfo=fisData.get("userInfo");var i=this;this.activityBtn.unbind().click(function(){t.getJSON("/home/interface/checklogin",function(e){0===e.status.code?1==i.userInfo.is_old_user?i.inviteEvent():i.applyOldUserEvent():new s.login})})},inviteTpl:['<div class="intive-dialog">','<span class="close"></span>','<div class="top-bar">',"<h1>邀请新用户注册，积分＋10</h1>","</div>",'<div class="dg-body">','<p class="small-title">新注册的社区新人可享受同等级别的VIP特权60天哦～</p>','<div class="intive-icon first-intive-icon">','<div class="descr">','<span class="send"></span>',"<p>给小伙伴发送邀请连接</p>","</div>",'<em class="right-arrow"></em>',"</div>",'<div class="intive-icon">','<div class="descr">','<span class="intive-register"></span>',"<p>小伙伴注册成功</p>","</div>",'<em class="right-arrow"></em>',"</div>",'<div class="intive-icon last-intive-icon">','<div class="descr">','<span class="get-eggs"></span>',"<p>积分特权统统拿下</p>","</div>","</div>","<h2>您的邀请连接</h2>",'<div class="input-group">','<input type="text" value="LINK" readonly>','<button class="copy" id="copy-invite-link" data-clipboard-text="LINK">一键复制</button>',"</div>",'<div class="intive-share">','<a href="" class="jump"></a>',"<span>分享到：</span>","<ul>",'<li class="weibo"></li>','<li class="wechat"></li>','<li class="qqzone"></li>','<li class="baidu"></li>',"</ul>","</div>",'<p class="copyright">＊注：活动最终解释权归打印基所有，严禁通过违规方式获取积分和特权，否则收回所有权限</p>',"</div>","</div>"].join(""),getInviteDom:function(){var i=this.inviteTpl.replace(/LINK/g,this.linkHref);new a.dialog({width:621,height:499,close:".close",tpl:i}),this.container=t(".intive-dialog"),this.copyBtn=this.container.find(".copy"),this.shareBtn=this.container.find(".intive-share li"),this.jump=this.container.find(".jump"),this.copyEvent(),this.shareEvent()},shareEvent:function(){var i=this;this.shareBtn.unbind().click(function(){i.shareCase(t(this).attr("class"))})},weiboShare:function(){var i="http://service.weibo.com/share/share.php?";i+=this.parseParams("title","url","pic"),this.jumpShareApp(i)},qqzoneShare:function(){var i="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?";i+=this.parseParams("title","url","pics"),this.jumpShareApp(i)},wechatTpl:['<div class="share-wechat-qrcode">',"<h2>分享到微信朋友圈</h2>",'<span class="qrcode-close"></span>','<div class="wechat-qrcode"></div>',"</div>"].join(""),wechatShare:function(){this.dialog=new a.dialog({width:202,height:242,tpl:this.wechatTpl,close:".qrcode-close"}),new r.qrcode({picker:t(".wechat-qrcode"),height:160,width:160,text:window.location.href})},baiduShare:function(){var i="http://tieba.baidu.com/f/commit/share/openShareApi?url=";i+=this.parseParams("title","url","pics"),this.jumpShareApp(i)},parseParams:function(i,e,t){var s=[],a={title:"我在打印基已经成功认证为老用户，使用我的邀请码注册享特权",pic:"http://static-dayinji.oss-cn-beijing.aliyuncs.com/yaoqing.jpg",url:this.linkHref};return a.title&&s.push(i+"="+a.title),a.url&&s.push(e+"="+a.url),a.pic&&s.push(t+"="+a.pic),s.join("&")},jumpShareApp:function(i){this.jump.attr("href",i),this.jump.each(function(){this.click()})},shareCase:function(i){switch(i){case"weibo":this.weiboShare();break;case"qqzone":this.qqzoneShare();break;case"wechat":this.wechatShare();break;case"baidu":this.baiduShare()}},copyEvent:function(){var i=this,e=document.getElementById("copy-invite-link"),t=new o.ZeroClipboard(e);t.on("ready",function(){i.copyBtn.unbind().click(function(){return new n.alert({title:"已成功复制到剪贴板",type:"default",autoHide:!0})})})},inviteEvent:function(){var i=this;t.getJSON("/home/interface/makeinvitationcode",function(e){return 0!==e.status.code?new n.alert({title:c.code[e.status.code],type:"danger"}):(i.linkHref="http://www.dayinji.ren/topic/yaoqingregister?invite_code="+e.data.code,void i.getInviteDom())})},applyOldUserTpl:['<div class="apply-old-user-dialog">','<span class="close"></span>',"<h1>此次活动只针对老用户开放哦~</h1>",'<a href="/topic/laoyonghu">去申请老用户</a>',"</div>"].join(""),applyOldUserEvent:function(){new a.dialog({width:339,height:178,tpl:this.applyOldUserTpl,close:".close"})},getDom:function(){this.activityBtn=t(".invite-active")}};e.activity=l});