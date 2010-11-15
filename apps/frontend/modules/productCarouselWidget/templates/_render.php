<?php slot('slider')?>
<?php if( $bannersInfo ):?>
<div class="slider">
	<div class="sliderbox">									    
		<img id="slider_big_pic" src="<?php echo $firstBanner->getMediaWithSize(839, 415)?>" width="839" height="415" alt="" />
		<div id="banner_position" style="display:none"><?php echo $firstBannerPosition?></div>
		<div id="banner_count" style="display:none"><?php echo $bannersInfo->count()?></div>									
		<div id="banner_link" style="display:none"><?php echo $firstBanner['link']?></div>	
	</div>
                                        
    <div class="slidercontent">
    
	    <div class="sliderboxbottom">
	    	
		    <div class="slidertitle">
			    <h1 id="slider_title"><?php echo $firstBanner['name']?></h1>
				<p id="slider_desc"><?php echo $firstBanner['content']?></p>
			</div>
		
			
	        <div class="jcarousel-skin-tango">
	            <ul id="mycarousel">

                </ul>
		    </div>
		</div>
		
	</div>	
	
</div>

            	<?php foreach( $bannersInfo as $index => $banner ):?>
                <div id="li_container_<?php echo $index ?>" style="display:none">
				    <div class="sliderlinkbox" title="<?php echo $index?>" onclick="slideTo(<?php echo $index?>)">
				    
				        <img class="sliderthumb" src="<?php echo $banner->getMediaWithSize(134, 78)?>" width="134" height="78" alt="" />

				         <div id="pic_deactive_<?php echo $index?>"  class="shadoweffect">
				         	<img src="/vifi/img/shadoweffect.png" width="134" height="78" alt="" />
				         </div>
				         <div id="pic_active_<?php echo $index?>" style="display:none" class="effectactive">
				         	 <img src="/vifi/img/slidereffect.png" width="134" height="78" alt="" />  
				         </div>
					    
					</div>
				</div>
				<?php endforeach;?>


            	<?php foreach( $bannersInfo as $index => $banner ):?>
            		<img style="display:none" id="slider_pic_<?php echo $index?>" src="<?php echo $banner->getMediaWithSize(839, 415)?>" />
			        <div style="display:none" id="slider_title_<?php echo $index?>"><?php echo $banner['name']?></div>
			        <div style="display:none" id="slider_description_<?php echo $index?>"><?php echo $banner['content']?>&nbsp;</div>
			        <div style="display:none" id="slider_link_<?php echo $index?>"><?php echo $banner['link']?></div>
			        <div style="display:none" id="slider_position_<?php echo $index?>"><?php if( $index < 5 ):?><?php echo $index + 1 ?><?php endif;?></div>
				<?php endforeach;?>
				

<?php endif;?>
<?php end_slot()?>

