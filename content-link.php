<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header>
		<?php _e( 'Link', 'takelage' ); ?>
	</header>

	<div class="entry postContent entry-content">
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer postmetadata">
		<?php Takelage_posted_on() ?>
	</footer>

</article>
