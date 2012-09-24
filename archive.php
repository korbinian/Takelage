<?php get_header(); ?>

<div id="content" class="skin" role="main">

	<?php if (function_exists('Takelage_breadcrumb')) { Takelage_breadcrumb(); } ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title m">
			<?php
							if ( is_category() ) {
								printf( __( 'Kategorie: %s', 'Takelage' ), '<span>' . single_cat_title( '', false ) . '</span>' );

							} elseif ( is_tag() ) {
								printf( __( 'Tag(s)): %s', 'Takelage' ), '<span>' . single_tag_title( '', false ) . '</span>' );

							} elseif ( is_author() ) {
								$author = get_queried_object();
								printf( __( 'Autor: %s', 'Takelage' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author->ID ) ) . '" title="' . esc_attr( $author->display_name ) . '" rel="me">' . esc_html( $author->display_name ) . '</a></span>' );

							} elseif ( is_day() ) {
								printf( __( 'Tag: %s', 'Takelage' ), '<span>' . get_the_date() . '</span>' );

							} elseif ( is_month() ) {
								printf( __( 'Monat: %s', 'Takelage' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

							} elseif ( is_year() ) {
								printf( __( 'Jahr: %s', 'Takelage' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

							} else {
								_e( 'Archiv', 'Takelage' );

							}
						?>
		</h1>
		<?php
			if ( is_category() ) {
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

			} elseif ( is_tag() ) {
				$tag_description = tag_description();
				if ( ! empty( $tag_description ) )
					echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
			}
		?>
	</header>

	<?php rewind_posts(); ?>

	<?php Takelage_content_nav( 'nav-above' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', get_post_format() ); ?>

	<?php endwhile; ?>

	<?php Takelage_content_nav( 'nav-below' ); ?>

<?php else : ?>

	<?php get_template_part( 'no-results', 'archive' ); ?>

<?php endif; ?>

</div>

<?php get_footer(); ?>