<?php slot('search_results')?>
		<div class="pad content clear">
			<div class="c-head clear"><p><?php echo __('Search results for keyword:') ." <b>". $keyword . "</b>" ?></p></div>
			<?php foreach( $searchResults as $result ):?>
				<h6><a href="<?php echo $result['link']?>"><?php echo $result['name']?></a></h6>
				<?php echo $result['desc']?>
			<?php endforeach;?>
			<br /><Br />
			<ul>
				<li>
				
				<h3>
				
				<?php for( $i = 1; $i <= $totalPages; ++$i ):?>
					<span style="padding:5px">
						<a href="<?php echo url_for('main_dispatcher', $node). '?keyword=' . $keyword . '&page=' . $i?>">
						<?php if($i == $currentPage): ?>
							<b style="color:#000"><?php echo $i?></b>
						<?php else:?>
							<?php echo $i?>
						<?php endif;?>
						</a>
					</span>
				<?php endfor;?>
				</h3>
				</li>
			</ul>
		</div>
<?php end_slot()?>