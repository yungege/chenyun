define("common:widget/category/category.js",function(e,t){var i=e("common:widget/lib/jquery.js"),s=function(e,t){this.list=e,this.choice=t,this.init()};s.prototype={declare:function(){this.select={}},init:function(){this.declare(),this.getDom(),this.parseChoice(),this.selectEvent(),this.listenSelect()},getCategory:function(){var e=0;for(var t in this.select){if(void 0===typeof this.select[t])break;e++}return 3!=e?!1:{first_category:this.select[0],second_category:this.select[1],third_category:this.select[2]}},closeSelect:function(){this.firstLevel.hide(),this.secondLevel.hide(),this.thirdLevel.hide(),this.arrow.removeClass("hover")},listenSelect:function(){var e=this;this.firstLevel.delegate("p","click",function(){var t=i(this),s=t.attr("data-cid");return t.hasClass("active")?!1:(e.select={},e.firstLevel.find("p").removeClass("active"),t.addClass("active"),e.select[0]=s,e.render(e.list[s].next_level,0,e.secondLevel),void e.thirdLevel.hide())}),this.secondLevel.delegate("p","click",function(){var t=i(this),s=t.attr("data-cid");return t.hasClass("active")?!1:(delete e.select[2],e.secondLevel.find("p").removeClass("active"),t.addClass("active"),e.select[1]=s,void e.render(e.list[e.select[0]].next_level[s].next_level,0,e.thirdLevel))}),this.thirdLevel.delegate("p","click",function(){var t=i(this).attr("data-cid");e.select[2]=t,e.reValueEvent(),e.closeSelect()})},selectEvent:function(){var e=this;this.startBtn.unbind().click(function(){e.arrow.addClass("hover"),e.showCategory()}),this.container.on("mouseleave",function(){i(document).on("click",function(){e.closeSelect()})}).on("mouseenter",function(){i(document).unbind("click")})},render:function(e,t,i){var s='<div class="inner">',l=0;for(var n in e)s+=n==t?'<p class="active" data-cid="'+n+'">'+e[n].name+"</p>":'<p data-cid="'+n+'">'+e[n].name+"</p>",l++;s+="</div>",s+=l>6?'<div class="wheel-bar"><span class="wheel-btn"></span></div>':'<div class="wheel-bar"></div>',this.reValueEvent(),i.html(s).show()},reValueEvent:function(){var e="";return this.select[0]&&(e+=this.list[this.select[0]].name),this.select[1]&&(e+=" > "+this.list[this.select[0]].next_level[this.select[1]].name),this.select[2]&&(e+=" > "+this.list[this.select[0]].next_level[this.select[1]].next_level[this.select[2]].name),e?void this.selectValue.html(e):!1},showCategory:function(){this.select[0]?(this.render(this.list,this.select[0],this.firstLevel),this.render(this.list[this.select[0]].next_level,this.select[1],this.secondLevel),this.render(this.list[this.select[0]].next_level[this.select[1]].next_level,this.select[2],this.thirdLevel)):this.render(this.list,0,this.firstLevel)},parseChoice:function(){var e=this.choice.split("-");if(3!=e.length)return!1;for(var t=0;3>t;t++)"number"==typeof parseInt(e[t],10)&&(this.select[t]=e[t]);this.reValueEvent()},getDom:function(){this.container=i(".category-select-warp"),this.startBtn=this.container.find(".category-select-value"),this.selectValue=this.startBtn.find("i"),this.arrow=this.container.find(".arrow"),this.firstLevel=this.container.find(".flevel"),this.secondLevel=this.container.find(".slevel"),this.thirdLevel=this.container.find(".tlevel")}},t.category=s});