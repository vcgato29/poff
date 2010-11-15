<?php if( $pager->getNbResults() && ( $pager->getFirstPage() != $pager->getLastPage() ) ):?>
	<div class="page">
	    <div class="linkname">
		    <p><span><?php echo __('%1% of %2%', array( '%1%' => $pager->getPage(), '%2%' => $pager->getLastPage() )) ?></span></p>
		</div>
	    <div class="pages">
		    <div class="leftarrow">	
			    <a href="<?php echo url_for($linker_method, array_merge( $linker_params, array('page' => 1 ) ) )?>"><img height="16" width="15" alt="" src="/faye/img/left.png"></a>
			</div>
			
<?php 
			$width = 2;
			$total = $pager->getLastPage();
			$curPage = $pager->getPage();
			
			if( $curPage - $width > 0 && $curPage + $width <= $total ){
				$start = $curPage-$width;
			}else if( $curPage - $width < 1 && $curPage + $width <= $total ){
				$start = 1;
			}else if( $curPage - $width > 1 && $curPage + $width > $total ){
				$start = $curPage-$width-1;
			}else{
				$start = 1;
			}
			
?>
			<div class="pagenumbers">
			    <?php for($i = $start; $i <= $pager->getLastPage() && ($i - $start+1) <= ($width * 2 + 1); ++$i):?>
			    	<div class="number<?php if($i == $curPage):?>active<?php endif;?>"><p><a href="<?php echo url_for($linker_method, array_merge( $linker_params, array('page' => $i ) ))?>"><?php echo $i?></a></p></div>
			    <?php endfor;?>
			</div>
			<div class="rightarrow">
				<a href="<?php echo url_for($linker_method, array_merge( $linker_params, array('page' => $pager->getLastPage() ) ))?>"><img height="16" width="15" alt="" src="/faye/img/right.png"></a>
			</div>
		</div>
	</div>
<?php endif;?>