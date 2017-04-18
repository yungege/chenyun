define("common:widget/search/search.js",function(e,s){var t=e("common:widget/lib/jquery.js"),i={declare:function(){this.keyEnter=13,this.keyLeft=37,this.keyRight=39,this.keyUp=38,this.keyDown=40,this.albumType=2,this.modelType=1,this.designerType=3,this.albumClass="album",this.designerClass="designer",this.keyChoiceClass="current",this.movePos=-1,this.hasResult=!1,this.listQuery},init:function(){this.getDom(),this.declare(),this.keyEvent(),this.listenInput(),this.listenMoveEvent(),this.enterEvent(),this.searchBtnEvent(),this.hideQueryListEvent()},hideQueryListEvent:function(){var e=this,s=!1;this.searchQueryList.mouseenter(function(){s=!0}).mouseleave(function(){s=!1}),this.searchInput.on("blur",function(){s||(e.searchQueryList.hide(),t(window).unbind("keydown"),s=!1)})},searchBtnEvent:function(){var e=this;this.searchBtn.unbind().click(function(){e.formSubmit()})},enterEvent:function(){var e=this;this.searchQueryList.mouseenter(function(){e.listQuery&&(e.listQuery.removeClass(e.keyChoiceClass),e.movePos=-1)})},keyEvent:function(){var e=this;this.searchInput.on("focus",function(){t(window).on("keydown",function(s){s.keyCode===e.keyEnter?-1===e.movePos?e.formSubmit():e.listQuery.eq(e.movePos).find("a").each(function(){this.click()}):e.listenMoveEvent(s.keyCode)})})},listenMoveEvent:function(e){e===this.keyUp?this.moveUpEvent():e===this.keyDown&&this.moveDownEvent()},moveUpEvent:function(){return this.hasResult?(this.movePos-=1,this.movePos<0&&(this.movePos=this.listQuery.length-1),this.listQuery.removeClass(this.keyChoiceClass),void this.listQuery.eq(this.movePos).addClass(this.keyChoiceClass)):!1},moveDownEvent:function(){return this.hasResult?(this.movePos+=1,this.movePos>this.listQuery.length-1&&(this.movePos=0),this.listQuery.removeClass(this.keyChoiceClass),void this.listQuery.eq(this.movePos).addClass(this.keyChoiceClass)):!1},listenInput:function(){var e,s=this;this.searchInput.on("input",function(){return t(this).val()?(e&&e.abort(),void(e=t.getJSON("/home/interface/search?words="+s.searchInput.val(),function(e){s.render(e)}))):!1})},renderAlbum:function(e){var s='<li class="'+this.albumClass+'">';return s+='<a href="/album/'+e.cid+'.html">',s+='<img src="'+e.list_pic+'">',s+='<div class="context">',s+="<h4>"+this.truncate(e.name,16)+"<span>[专辑]</span></h4>",s+='<p class="author">'+e.nickname+"</p>",s+='<p class="summary">'+this.truncate(e.summary,22)+"</p>",s+="</p></a></li>"},truncate:function(e,s){return e?e.length<s?e:e.substring(0,s)+"……":""},renderModel:function(e){return'<li><a href="/model/'+e.cid+'.html">'+this.truncate(e.name,28)+"</a></li>"},renderDesigner:function(e){var s='<li class="'+this.designerClass+'">';return s+='<a href="/p/'+e.username+'.html">',s+='<img src="'+e.header_pic+'">',s+='<div class="context">',s+="<h4>"+e.nickname+"<span>[设计师]</span></h4>",s+="<p>粉丝<em>"+e.be_cared_count+"</em><i>模型</i><em>"+e.model_view_count+"</em></p>",s+="</p></a></li>"},render:function(e){if(e=e.data.list,0===e.length)return this.searchQueryList.hide(),this.hasResult=!1,!1;var s="",t="",i="";for(var n in e)switch(e[n].type){case this.albumType:i+=this.renderAlbum(e[n]);break;case this.modelType:s+=this.renderModel(e[n]);break;case this.designerType:t+=this.renderDesigner(e[n])}var h="<ul>"+i+t+s+"</ul>";this.searchQueryList.html(h).show(),this.movePos=-1,this.listQuery=this.searchQueryList.find("li"),this.hasResult=!0},formSubmit:function(){var e=this.searchInput.val();return e?(this.searchFormWords.attr("value",e),void this.searchForm.submit()):!1},getDom:function(){this.container=t(".main-search"),this.searchInput=this.container.find(".main-search-value"),this.searchBtn=this.container.find(".main-search-btn"),this.searchForm=this.container.find("form"),this.searchFormWords=this.searchForm.find("input"),this.searchQueryList=this.container.find(".main-search-reslut")}};s.search=i});