<script type="text/javascript" charset="utf-8">
  // Tabbed film class
function Film() {
  this.film;
  this.tabsList;
  this.contentList;
  this.activeTab = 0;

  this.start = function(element) {
    this.film = $(element);
    this.adjustTabs();
    this.adjustContents();
  };

  this.adjustTabs = function() {
    this.tabsList = this.film.find('.tab');
    $.each(this.tabsList, function(i, tab) {
      $(tab).hover(
        function() { $(this).addClass('selected'); },
        function() { if (!film.isActive($(this))) $(this).removeClass('selected'); }
      );
      $(tab).click(function() { film.tabClick($(this)); });
    });
  };

  this.adjustContents = function() {
    this.contentList = this.film.find('.filmitem');
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
 // Tabbed video class
function Video() {
  this.video;
  this.tabsList;
  this.contentList;
  this.activeTab = 0;

  this.start = function(element) {
    this.video = $(element);
    this.adjustTabs();
    this.adjustContents();
  };

  this.adjustTabs = function() {
    this.tabsList = this.video.find('.tab');
    $.each(this.tabsList, function(i, tab) {
      $(tab).hover(
        function() { $(this).addClass('selected'); },
        function() { if (!video.isActive($(this))) $(this).removeClass('selected'); }
      );
      $(tab).click(function() { video.tabClick($(this)); });
    });
  };

  this.adjustContents = function() {
    this.contentList = this.video.find('.gray_content_block_item');
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

var film = new Film();
var video = new Video();
$(document).ready(function()
{
   film.start('.tabbed_film');
   video.start('.bottom_tabbed_gray');
});
   </script>

</head>


<?php

if($product['trailer_link']){
	preg_match('/v\=(\w+)/i',$product['trailer_link'], $youtubeCode);
	$youtubeCode = $youtubeCode[1] ? $youtubeCode[1] : '';
}else{
	$youtubeCode = '';
}

$tabsArray = array();
$tabsArray[] = array('tabName' => __('Trailer'), 'tabId' => 'tabset02-01', 'tabContent' => $youtubeCode ?
	'<object width="571" height="348"><param name="movie" value="http://www.youtube.com/v/'.$youtubeCode.'?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$youtubeCode.'?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="571" height="348"></embed></object>' : '');
					foreach($product['ProductPictures'] as $pro) {
						 if($pro['parameter']=="default") { $pictures = $pro['file']; break; }
                      }
$tabsArray[] = array('tabName' => __('Pilt'),'tabId' => 'tabset02-02', 'tabContent' => $product['ProductPictures'][0] ?
	'<img src="'. @myPicture::getInstance($pictures)->thumbnail(571,348,'center')->url().'" alt="" />' : '' );


?>



<div style="float: left; width: 100%;">
             <div class="bottom_tabbed_gray">

              <div class="gray_content_block">
        <!-- video or image size - width: 571px; height: 348px; -->
		<?php $index = 0; ?>
		<?php foreach($tabsArray as $tab): ?>
			<?php if(!$tab['tabContent'])continue; ?>
			<div class="gray_content_block_item <?php echo $index == 0 ? '' : 'hidden' ?>" id="<?php echo $tab['tabId'] ?>" >
				<?php echo $tab['tabContent'] ?>
			</div>
			<?php $index++; ?>
		<?php endforeach; ?>

              </div>


              <div class="tabs">

                    <?php $index = 0; ?>
					<?php foreach($tabsArray as $tab): ?>
						<?php if(!$tab['tabContent'])continue; ?>
						 <div class="tab <?php echo $index == 0 ? 'selected' : '' ?>">
						 	<div class="block_left"></div>
							<div class="block_content"><h3><?php echo $tab['tabName'] ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3></div>
						    <div class="block_right"></div>
						</div>
						<?php $index++; ?>
					<?php endforeach; ?>


                <div class="separator"></div>
              </div>
              <div style="clear: both;"></div>

            </div>
            </div>
<div style="clear: both;"></div>