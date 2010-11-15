<ul>
<?php foreach( $articles as $article ):?>
	<li><a href="#"><?php echo $article['title']?></a></li>
	
	<li class="articlesub">
		<ul>
		<?php foreach( $article['Structure'] as $sub_article ):?>
		    	<li><a href="<?php include_component('linker', 'articleLinkBuilder', array( 'article' => $sub_article ) )?>"><?php echo $sub_article?></a></li>
		<?php endforeach;?>
		</ul>
	</li>
<?php endforeach;?>
</ul>