function Ticker(){this.delay=4000;this.ticker;this.viewport;this.panelsList;this.viewportThumbs;this.thumbsList;this.currentPanel;this.currentDirection=1;this.start=function(a){this.ticker=$(a);this.viewport=this.ticker.find(".viewport");this.viewportThumbs=this.ticker.find(".viewport-thumbnails");if(this.delay<1000){this.delay=1000}this.adjustThumbs();this.adjustCaptionBoxes();this.adjustPanels();this.startInterval()};this.adjustCaptionBoxes=function(){$boxes=this.viewport.find(".captionbox");$.each($boxes,function(a,b){$(b).css("opacity","0.7");$(b).css("bottom","0px")})};setOpacity=function(a){$(a).hover(function(){$(this).css("opacity","0.7")},function(){$(this).css("opacity","0.3")})};this.adjustThumbs=function(){this.thumbsList=this.viewportThumbs.find(".thumb");$.each(this.thumbsList,function(b,a){if(b>0){$(a).css("opacity","0.3");setOpacity(a)}else{if(b==0){$(a).addClass("selected")}}$(a).click(function(){ticker.manualClick(a)})})};this.adjustPanels=function(){this.panelsList=this.viewport.find(".panel")};this.startInterval=function(){$(this).everyTime(this.delay,function(a){ticker.executeOnTime()})};this.executeOnTime=function(){if(this.currentPanel==null){this.currentPanel=-1}last=this.panelsList.length;next=this.currentPanel+this.currentDirection;if(next>=0&&next<last){this.currentPanel=next}else{if(this.currentDirection==1){this.currentPanel=last-2;this.currentDirection=-1}else{if(this.currentDirection==-1){this.currentPanel=1;this.currentDirection=1}}}this.performScroll(this.currentPanel)};this.performScroll=function(a){this.currentPanel=a;this.panelsList.animate({bottom:(this.currentPanel*260)},1000,"linear");this.selectThumb()};this.resetAllThumbs=function(){$.each(this.thumbsList,function(b,a){$(a).css("opacity","0.3");if($(a).hasClass("selected")){$(a).removeClass("selected")}setOpacity(a)})};this.selectThumb=function(){selected=this.thumbsList.get(this.currentPanel);this.resetAllThumbs();$(selected).css("opacity","1");$(selected).addClass("selected");$(selected).hover(function(){$(this).css("opacity","1")},function(){$(this).css("opacity","1")})};this.endInterval=function(){$(this).stopTime()};this.manualClick=function(a){this.endInterval();this.performScroll(this.thumbsList.index($(a)))}}var ticker=new Ticker();function News(){this.news;this.tabsList;this.contentList;this.activeTab=0;this.start=function(a){this.news=$(a);this.adjustTabs();this.adjustContents()};this.adjustTabs=function(){this.tabsList=this.news.find(".tab");$.each(this.tabsList,function(a,b){$(b).hover(function(){$(this).addClass("selected")},function(){if(!news.isActive($(this))){$(this).removeClass("selected")}});$(b).click(function(){news.tabClick($(this))})})};this.adjustContents=function(){this.contentList=this.news.find(".newsitem")};this.isActive=function(a){if(this.tabsList.index($(a))==this.activeTab){return true}return false};this.tabClick=function(a){if(this.isActive(a)==false){selected=this.getTabIndex(a);this.tabsList.removeClass("selected");$(a).addClass("selected");this.activeTab=selected;this.showContent(selected)}};this.getTabIndex=function(a){return this.tabsList.index($(a))};this.showContent=function(a){this.contentList.hide();$(this.contentList.get(a)).show()}}var news=new News();function Dropdown(){this.dropdowns;this.delay=1000;this.start=function(a){this.dropdowns=$(a);this.adjustDropdowns()};this.adjustDropdowns=function(){$.each(this.dropdowns,function(a,b){$dp=$(b).next(".dropdown-selections");$dp.css("z-index","10000");$dp.css("top",($(b).offset().top+$(b).height()-7)+"px");$dp.css("left",($(b).offset().left-2)+"px");$(b).click(function(){dropdown.doDPClick($(this))});$dp.bind({mouseleave:function(){dropdown.doMouseLeave($(this))},mouseenter:function(){dropdown.doMouseEnter($(this))},click:function(){$(this).hide()}})})};this.doDPClick=function(a){$dps=a.next(".dropdown-selections");if($dps.css("display")=="none"){$dps.show()}else{$dps.hide()}};this.doMouseLeave=function(a){a.oneTime(this.delay,function(){$(this).hide()})};this.doMouseEnter=function(a){a.stopTime()}}var dropdown=new Dropdown();function Popup(){this.popup;this.overlay;this.delay=400;this.start=function(a){this.popup=$(a);this.overlay=this.popup.prev("#overlay");this.adjustPopup();this.adjustOverlay()};this.showAll=function(){this.overlay.show();this.overlay.animate({opacity:"0.7"},this.delay,function(){popup.showPopup()})};this.showPopup=function(){this.popup.show();this.popup.animate({opacity:"1"},this.delay,function(){});this.autosize();this.relocate()};this.hideAll=function(){this.popup.animate({opacity:"0"},this.delay,function(){popup.animateOveralyOut()})};this.animateOveralyOut=function(){this.popup.hide();this.overlay.animate({opacity:"0"},this.delay,function(){popup.hideOverlay()})};this.hideOverlay=function(){this.overlay.hide()};this.paddingVertical=function(){$c=this.popup.find(".center");return(parseInt($c.css("padding-top"))+parseInt($c.css("padding-bottom")))};this.paddingHorizontal=function(){$c=this.popup.find(".center");return(parseInt($c.css("padding-left"))+parseInt($c.css("padding-right")))};this.autosize=function(){$center=this.popup.find(".center");this.resize($center.width()+this.paddingHorizontal(),$center.height()+this.paddingVertical())};this.resize=function(b,a){$divs=this.popup.children("div.block");$topCenter=this.popup.find(".topcenter");$leftCenter=this.popup.find(".leftcenter");$rightCenter=this.popup.find(".rightcenter");$bottomCenter=this.popup.find(".bottomcenter");$center.css({height:a-this.paddingVertical()+"px",width:b-this.paddingHorizontal()+"px"});$topCenter.css({width:b+"px"});$leftCenter.css({height:a+"px"});$rightCenter.css({height:a+"px"});$bottomCenter.css({width:b+"px"});$divs.css("width",(b+20)+"px")};this.relocate=function(){this.popup.css({top:($(window).height()/2-this.popup.height()/2)+"px",left:($(window).width()/2-this.popup.width()/2)+"px"})};this.adjustPopup=function(){this.popup.css("opacity","0");this.popup.find(".close").bind({click:function(){popup.hideAll()}})};this.adjustOverlay=function(){this.overlay.css("opacity","0");this.overlay.bind({click:function(){popup.hideAll()}})}}var popup=new Popup();$(document).ready(function(){ticker.start(".ticker");news.start(".tabbed_news");dropdown.start(".dropdown");popup.start("#popup");$("#poff_ownprogramme").find(".register").click(function(){popup.showAll()})});