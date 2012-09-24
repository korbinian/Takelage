<?php
/*
Template Name: Full Width
*/
?>


<?php get_header(); ?>

<div id="content" role="main" class="skin">

	<?php if (function_exists('Takelage_breadcrumb')) {Takelage_breadcrumb();} ?>

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<hgroup>
				<h1 class="entry-title url xl"><?php the_title(); ?></h1>
			</hgroup>
		</header>

		<?php Takelage_submenu() ?>

		<div class="entry postContent entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Takelage' ), 'after' => '</div>' ) ); ?>
		</div>

		<footer class="entry-footer postmetadata">
			<?php edit_post_link('editieren','',' '); ?>
		</footer>
		
	</article>

		<?php endwhile; ?>

		<?php Takelage_content_nav( 'nav-top' ); ?>

	<?php elseif ( current_user_can( 'edit_posts' ) ) : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; ?>

</div>

<?php get_footer(); ?>