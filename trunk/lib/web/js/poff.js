// Ticker class
function Ticker() {
  this.delay = 4000;
  this.ticker;
  this.viewport;
  this.panelsList;
  this.viewportThumbs;
  this.thumbsList;
  this.currentPanel;
  this.currentDirection = 1;
  
  this.start = function(element) {
    this.ticker = $(element);
    this.viewport = this.ticker.find('.viewport');
    this.viewportThumbs = this.ticker.find('.viewport-thumbnails');
    if (this.delay < 1000)
      this.delay = 1000;
    this.adjustThumbs();
    this.adjustCaptionBoxes();
    this.adjustPanels();
    this.startInterval();
  };
  
  this.adjustCaptionBoxes = function() {
    $boxes = this.viewport.find('.captionbox');
    $.each($boxes, function(i, box) {
      $(box).css('opacity', '0.7');
      $(box).css('bottom', '0px');
    });
  };
  
  setOpacity = function(thumb) {
    $(thumb).hover(
    function() { $(this).css('opacity', '0.7'); },
    function() { $(this).css('opacity', '0.3'); });
  };
  
  this.adjustThumbs = function () {
    this.thumbsList = this.viewportThumbs.find('.thumb');
    $.each(this.thumbsList, function(i, thumb) {
      if (i > 0) {
        $(thumb).css('opacity', '0.3');
        setOpacity(thumb);
      }
      else if (i == 0) {
        $(thumb).addClass('selected');
      }
      $(thumb).click(function() { ticker.manualClick(thumb); });
    });
  };
  
  this.adjustPanels = function () {
    this.panelsList = this.viewport.find('.panel');
  };
  
  this.startInterval = function () {
    $(this).everyTime(this.delay, function(i) {
      ticker.executeOnTime();
    });
  };
  
  this.executeOnTime = function () {
    if (this.currentPanel == null) {
      this.currentPanel = -1;
    }
    last = this.panelsList.length;
    next = this.currentPanel + this.currentDirection;
    if (next >= 0 && next < last) {
      this.currentPanel = next;
    }
    else if (this.currentDirection == 1) {
      this.currentPanel = last - 2;
      this.currentDirection = -1;
    }
    else if (this.currentDirection == -1) {
      this.currentPanel = 1;
      this.currentDirection = 1;
    }
    //alert('last:'+last+' current:'+this.currentPanel+' next:'+next);
    this.performScroll(this.currentPanel);
  };
  
  this.performScroll = function(i) {
    this.currentPanel = i;
    this.panelsList.animate({'bottom':(this.currentPanel * 260)}, 1000, 'linear');
    this.selectThumb();
  };
  
  this.resetAllThumbs = function() {
    $.each(this.thumbsList, function(i, thumb) {
        $(thumb).css('opacity', '0.3');
        if ($(thumb).hasClass('selected'))
          $(thumb).removeClass('selected');
        setOpacity(thumb);
    });
  };
  
  this.selectThumb = function() {
    selected = this.thumbsList.get(this.currentPanel);
    this.resetAllThumbs();
    $(selected).css('opacity', '1');
    $(selected).addClass('selected');
    $(selected).hover(
    function() { $(this).css('opacity', '1'); },
    function() { $(this).css('opacity', '1'); });
  };
  
  this.endInterval = function() {
    $(this).stopTime();
  };
  
  this.manualClick = function(thumb) {
    this.endInterval();
    this.performScroll(this.thumbsList.index($(thumb)));
  };
}
var ticker = new Ticker();
// Tabbed news class
function News() {
  this.news;
  this.tabsList;
  this.contentList;
  this.activeTab = 0;
  
  this.start = function(element) {
    this.news = $(element);
    this.adjustTabs();
    this.adjustContents();
  };
  
  this.adjustTabs = function() {
    this.tabsList = this.news.find('.tab');
    $.each(this.tabsList, function(i, tab) {
      $(tab).hover(
        function() { $(this).addClass('selected'); },
        function() { if (!news.isActive($(this))) $(this).removeClass('selected'); }
      );
      $(tab).click(function() { news.tabClick($(this)); });
    });
  };
  
  this.adjustContents = function() {
    this.contentList = this.news.find('.newsitem');
  };
  
  this.isActive = function(item) {
    if (this.tabsList.index($(item)) == this.activeTab)
      return true;
    return false;
  };
  
  this.tabClick = function(tab) {
    if (this.isActive(tab) == false) {
      selected = this.getTabIndex(tab);
      this.tabsList.removeClass('selected');
      $(tab).addClass('selected');
      this.activeTab = selected;
      this.showContent(selected);
    }
  };
  
  this.getTabIndex = function(element) {
    return this.tabsList.index($(element));
  };
  
  this.showContent = function(index) {
    this.contentList.hide();
    $(this.contentList.get(index)).show();
  };
}
var news = new News();
// Dropdown class
function Dropdown() {
  this.dropdowns;
  this.delay = 1000;
  
  this.start = function(element) {
    this.dropdowns = $(element);
    this.adjustDropdowns();
  };
  
  this.adjustDropdowns = function() {
    $.each(this.dropdowns, function(i, dp) {
      $dp = $(dp).next('.dropdown-selections');
      $dp.css('z-index', '10000');
      $dp.css('top', ($(dp).offset().top + $(dp).height() - 7) + 'px');
      $dp.css('left', ($(dp).offset().left - 2) + 'px');
      $(dp).click(function() { dropdown.doDPClick($(this)); });
      //$(dp).mouseleave(function() { dropdown.doMouseLeave($(this).next('.dropdown-selections')); });
      $dp.bind({
        mouseleave: function() {
          dropdown.doMouseLeave($(this));
        },
        mouseenter: function() {
          dropdown.doMouseEnter($(this));
        },
        click: function() {
          $(this).hide();
        }
      });
    });
  };
  
  this.doDPClick = function(obj) {
    $dps = obj.next('.dropdown-selections');
    if ($dps.css('display') == 'none')
      $dps.show();
    else
      $dps.hide();
  };
  
  this.doMouseLeave = function(obj) {
    obj.oneTime(this.delay, function() {
      $(this).hide();
    });
  };
  
  this.doMouseEnter = function(obj) {
    obj.stopTime();
  };
}
var dropdown = new Dropdown();
// Popup class
function Popup() {
  this.popup;
  this.overlay;
  this.delay = 400;
  
  this.start = function(element) {
    this.popup = $(element);
    this.overlay = this.popup.prev('#overlay');
    this.adjustPopup();
    this.adjustOverlay();
  };
  
  this.showAll = function() {
    this.overlay.show();
    this.overlay.animate({'opacity':'0.7'}, this.delay, function() { popup.showPopup(); });
  };
  
  this.showPopup = function() {
    this.popup.show();
    this.popup.animate({'opacity':'1'}, this.delay, function() { });
    this.autosize();
    this.relocate();
  };
  
  this.hideAll = function() {
    this.popup.animate({'opacity':'0'}, this.delay, function() { popup.animateOveralyOut(); });
  };
  
  this.animateOveralyOut = function() {
    this.popup.hide();
    this.overlay.animate({'opacity':'0'}, this.delay, function() { popup.hideOverlay(); });
  };
  
  this.hideOverlay = function() {
    this.overlay.hide();
  };
  
  this.paddingVertical = function() {
    $c = this.popup.find('.center');
    return (parseInt($c.css('padding-top')) + parseInt($c.css('padding-bottom')));
  };
  
  this.paddingHorizontal = function() {
    $c = this.popup.find('.center');
    return (parseInt($c.css('padding-left')) + parseInt($c.css('padding-right')));
  };
  
  this.autosize = function() {
    $center = this.popup.find('.center');
    this.resize($center.width() + this.paddingHorizontal(), $center.height() + this.paddingVertical());
  };
  
  this.resize = function(width, height) {
    $divs = this.popup.children('div.block');
    $topCenter = this.popup.find('.topcenter');
    $leftCenter = this.popup.find('.leftcenter');
    $rightCenter = this.popup.find('.rightcenter');
    $bottomCenter = this.popup.find('.bottomcenter');
    $center.css({
      'height':height - this.paddingVertical() + 'px',
      'width':width - this.paddingHorizontal() + 'px'
    });
    $topCenter.css({
      'width':width + 'px'
    });
    $leftCenter.css({
      'height':height + 'px'
    });
    $rightCenter.css({
      'height':height + 'px'
    });
    $bottomCenter.css({
      'width':width + 'px'
    });
    $divs.css('width', (width + 20) + 'px');
  };
  
  this.relocate = function() {
    this.popup.css({
      'top':($(window).height() / 2 - this.popup.height() / 2) + 'px',
      'left':($(window).width() / 2 - this.popup.width() / 2) + 'px'
    });
  };
  
  this.adjustPopup = function() {
    this.popup.css('opacity', '0');
    this.popup.find('.close').bind({
      click: function() {
        popup.hideAll();
      }
    });
  };
  
  this.adjustOverlay = function() {
    this.overlay.css('opacity', '0');
    this.overlay.bind({
      click: function() {
        popup.hideAll();
      }
    });
  };
}
var popup = new Popup();
$(document).ready(function()
{
  ticker.start('.ticker');
  news.start('.tabbed_news');
  dropdown.start('.dropdown');
  popup.start('#popup');
  $('#poff_ownprogramme').find('.register').click(function() { popup.showAll(); });
});