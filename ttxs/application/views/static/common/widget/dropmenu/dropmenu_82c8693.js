define("common:widget/dropmenu/dropmenu.js",function(t,e){var i=t("common:widget/lib/jquery.js"),s=function(t){this.settings={picker:"",showEvent:"mouseenter",hideEvent:"mouseleave",showEffect:"show",hideEffect:"hide",effectTimeDelay:0,showItem:"",showTimeDelay:100,showCallBack:"",hideCallBack:""},this.settings=this.merge(this.settings,t),this.init()};s.prototype={constructor:"dropmenu",version:"1.0.0",author:"jixuecong@zeegine.com",merge:function(t,e){for(var i in t)void 0!=e[i]&&(t[i]=e[i]);return t},declare:function(){this.timer=null},init:function(){this.declare(),this.getDom(),this.coreEvent()},clearTimer:function(){clearTimeout(this.timer),this.timer=null},coreEvent:function(){if(!this.picker||!this.showItem)return!1;var t,e=this;this.picker.on(this.settings.showEvent,function(){return t=i(this),e.showItem.is(":visible")?(e.clearTimer(),!1):(e.showItem[e.settings.showEffect](e.settings.effectTimeDelay),void("function"==typeof e.settings.showCallBack&&e.settings.showCallBack.call(this,{picker:t,showItem:e.showItem})))}).on(this.settings.hideEvent,function(){t=i(this),e.timer=setTimeout(function(){e.clearTimer(),e.hide(t)},e.settings.showTimeDelay),e.showItem.on(e.settings.showEvent,function(){e.clearTimer()}).on(e.settings.hideEvent,function(){e.hide(t)})})},hide:function(t){this.showItem[this.settings.hideEffect](this.settings.effectTimeDelay),"function"==typeof this.settings.hideCallBack&&this.settings.hideCallBack.call(this,{picker:t,showItem:this.showItem})},getDom:function(){this.picker=i(this.settings.picker),this.showItem=i(this.settings.showItem)}},e.dropmenu=s});