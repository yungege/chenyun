define("common:widget/slider/slider.js",function(t,s){var e=t("common:widget/lib/jquery.js"),i=function(t){this.settings={showItem:"",showClass:"",effect:"opacity",pageBtn:"",pageShowClass:"",pageChangeEvent:"mouseenter",preBtn:"",nextBtn:"",timeDelay:8e3,autoPlay:!0},this.settings=this.merge(this.settings,t),this.init()};i.prototype={construcor:"slider",version:"1.0.0",author:"jixuecong@zeegine.com",merge:function(t,s){for(var e in t)void 0!=s[e]&&(t[e]=s[e]);return t},declare:function(){this.nowNumber=0,this.timer=null,this.imageCount=0,this.effectCompile=!0},init:function(){if(this.declare(),this.getDom(),!this.showItem)throw new Error("params error");return 1===this.showItem.length?(this.preBtn.hide(),this.nextBtn.hide(),this.pageBtn.hide(),!1):(this.autoPlayEvent(),this.preAndNextEvent(),void this.pageEvent())},pageEvent:function(){if(!this.pageBtn||!this.settings.pageShowClass)return!1;var t=this;this.pageBtn.on(this.settings.pageChangeEvent,function(){t.corePlay(parseInt(e(this).index(),10))})},preAndNextEvent:function(){var t=this;this.preBtn&&this.preBtn.unbind().click(function(){t.corePlay("desc")}),this.nextBtn&&this.nextBtn.unbind().click(function(){t.corePlay("asc")})},autoPlayEvent:function(){if(!this.settings.autoPlay)return!1;var t=this;this.timer=setInterval(function(){t.corePlay("asc")},this.settings.timeDelay)},corePlay:function(t){if(!this.effectCompile)return!1;var s,e=this.nowNumber;if(this.effectCompile=!1,"string"==typeof t)"asc"===t?(s=e+1,s===this.imageCount&&(s=0)):"desc"===t&&(s=e-1,0>s&&(s=this.imageCount-1));else{if("number"!=typeof t)return!1;if(t===this.nowNumber)return this.effectCompile=!0,!1;s=t}switch(this.pageBtn&&this.settings.pageShowClass&&(this.pageBtn.eq(e).removeClass(this.settings.pageShowClass),this.pageBtn.eq(s).addClass(this.settings.pageShowClass)),this.settings.effect){case"opacity":this.opacityEffect(e,s);break;case"show":this.showEffect(e,s);break;default:this.opacityEffect(e,s)}this.nowNumber=s},opacityEffect:function(t,s){var e=this;this.showItem.eq(s).css("opacity",0).stop().animate({opacity:1}),this.showItem.eq(t).stop().animate({opacity:0},function(){e.effectCompile=!0}),this.settings.showClass&&(this.showItem.eq(t).removeClass(this.settings.showClass),this.showItem.eq(s).addClass(this.settings.showClass))},showEffect:function(t,s){this.showItem.eq(t).show(),this.showItem.eq(s).hide(),this.settings.showClass&&(this.showItem.eq(t).removeClass(this.settings.showClass),this.showItem.eq(s).addClass(this.settings.showClass)),this.effectCompile=!0},getDom:function(){this.showItem=e(this.settings.showItem),this.pageBtn=e(this.settings.pageBtn),this.preBtn=e(this.settings.preBtn),this.nextBtn=e(this.settings.nextBtn),this.imageCount=this.showItem.length}},s.slider=i});