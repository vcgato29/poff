  <!-- OPEN NEWS SAMPLE TITLE -->
            <div class="page_title">
              <div class="box-590">
                <div class="block_top"></div>
                <div class="block_content">
                  <h1 class="alphabet">
	<?php sort($chars); foreach($chars as $char): ?>
	<?php if(!is_numeric($char['first_letter'])): ?><a class="<?php if(urldecode($sf_request->getParameter('alphabet_filter','')) == $char['first_letter'] or $char['first_letter'] == 'A' and urldecode($sf_request->getParameter('alphabet_filter','')) == '') echo 'type02'; ?>" href="<?php echo LinkGen::getInstance(LinkGen::STRUCTURE)->link($node['id'], array('alphabet_filter' => ($char['first_letter'])))  ?>"><?php echo $char['first_letter'] ?></a><?php endif; ?>
	<?php endforeach; ?>
	<?php sort($chars); foreach($chars as $char): ?>
	<?php if(is_numeric($char['first_letter'])): ?><a class="<?php echo urldecode($sf_request->getParameter('alphabet_filter','')) == $char['first_letter'] ? 'type02' : '' ?>" href="<?php echo LinkGen::getInstance(LinkGen::STRUCTURE)->link($node['id'], array('alphabet_filter' => ($char['first_letter'])))  ?>"><?php echo $char['first_letter'] ?></a><?php endif; ?>
	<?php endforeach; ?>
  </div>
                </h1>
                <div class="block_bottom"></div>
              </div>
              <div class="boxarrow"></div>
            </div>
           <br />