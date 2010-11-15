
	<?php foreach($pager->getResults() as $newItem): ?>
	   <tr>
                  <td><a href="<?php if( isset($newItem['source']) and  !empty($newItem['source']) ):?><?php echo $newItem['source'] ?><?php else:?><?php include_component('linker', 'newsItem', array('newsItem' => $newItem) ) ?><?php endif;?>"><?php echo $newItem['name'] ?> <img src="/img/yellowarrowright.png" alt="" title=""></a></td>
                  <td class="datetime"><!--<?php echo $newItem['active_start'] ?>-->&nbsp;</td>
                </tr>
	<?php endforeach; ?>
