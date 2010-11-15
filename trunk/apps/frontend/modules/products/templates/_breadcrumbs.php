<?php if(  $category ):?>
    <div class="breadcrumbs">
	    <ul>
		    <li>
			    <div class="currentcat">
				    <a href="<?php include_component('linker', 'categoryLinkBuilder', array( 'category' => $category ) )?>"><?php if( isset( $category ) ):?><?php echo $category['view_title'] ?><?php endif;?></a>
				</div>
				<div class="currentcatarrow<?php if( $video ):?>active<?php endif;?>"></div>
			</li>
			<?php if( $video ):?>
			<li>
			    <div class="currentcat">
				    <a href="<?php include_component('linker', 'videoLinkBuilder', array('movie' => $video) )?>"><?php echo $video['view_title']?></a>
				</div>
				<div class="currentcatarrow"></div>
			</li>

			<?php endif;?>
		</ul>
	</div>
<?php endif;?>