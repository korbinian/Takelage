<?php get_header(); ?>

<div id="content" class="skin" role="main">

	<?php if (function_exists('Takelage_breadcrumb')) { Takelage_breadcrumb(); } ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title"><?php printf( __( 'Suchergebnisse für: %s', 'Takelage' ), '<i>' . get_search_query() . '</i>' ); ?></h1>
	</header>

	<?php Takelage_content_nav( 'nav-above' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'search' ); ?>

	<?php endwhile; ?>

	<?php Takelage_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<?php get_template_part( 'no-results', 'search' ); ?>

<?php endif; ?>

</div>

<?php get_footer(); ?>