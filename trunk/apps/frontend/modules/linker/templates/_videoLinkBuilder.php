<?php echo url_for('video_page', array_merge( array(	'p0' => $node['lang'],
															'cat_slug' => $category['slug'],
															'video_slug' => $movie['id']
															), @$params ), $full_link )?>
