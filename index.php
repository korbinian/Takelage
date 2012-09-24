<?php get_header(); ?>

<div id="content" role="main">

	<?php if (function_exists('Takelage_breadcrumb')) {Takelage_breadcrumb();} ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php endwhile; ?>

		<?php Takelage_content_nav( 'nav-top' ); ?>

	<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; ?>

</div>

<div id="aside" >
	<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
	
	<?php endif; ?>
</div>

<?php get_footer(); ?>