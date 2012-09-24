<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry postContent entry-content">
		<?php the_content(); ?>		
	</div>

	<footer class="entry-footer postmetadata">
		<?php Takelage_posted_on() ?>
		<?php Takelage_authorinfo(); ?> 		
	</footer>

</article>