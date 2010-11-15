<?php 
$firstPage = $pager->getFirstPage();
$curPage = $pager->getPage();
$lastPage = $pager->getLastPage();
?>

						
						<div class="detbottom">
							<?php for($i = $firstPage; $i <= $lastPage; ++$i):?>
								<a href="<?php include_component('linker', 'searchLink', array('action' => 'detailed', 'keyword' => $sf_request->getParameter('keyword'), 'page' => $i ) )?>"><?php echo $i?></a>
							<?php endfor;?>
						</div>