<?php get_header(); ?>

<div id="content" role="main">

	<?php if (function_exists('Takelage_breadcrumb')) {Takelage_breadcrumb();} ?>

	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'page' ); ?>
	<?php endwhile; ?>

</div>

<div id="aside" >
	<?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
		
	<?php endif; ?>
</div>

<?php get_footer(); ?>