<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<hgroup>
			<h1 class="entry-title xl"><?php the_title(); ?></h1>
		</hgroup>
		<?php Takelage_posted_on() ?>
		<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
	</header>

	<div class="entry postContent entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Takelage' ), 'after' => '</div>' ) ); ?>
	</div>

	<footer class="entry-footer postmetadata">
		<?php Takelage_authorinfo(); ?> 		
	</footer>

</article>