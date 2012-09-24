<?php get_header(); ?>

<div id="content" role="main">

	<?php if (function_exists('Takelage_breadcrumb')) { Takelage_breadcrumb(); } ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php Takelage_content_nav( 'nav-top' ); ?>

		<?php get_template_part( 'content', get_post_format() ); ?>

		<?php
			if ( comments_open() || '0' != get_comments_number() )
				comments_template( '', true );
		?>

	<?php endwhile; ?>

</div>

<div id="aside" >
	<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

	<?php endif; ?>
</div>

<?php get_footer(); ?>


