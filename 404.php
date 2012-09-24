<?php get_header(); ?>

<div id="content" role="main">

	<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Meh. Nichts gefunden.', 'Takelage' ); ?></h1>
	</header>

	<div class="entry">
		<?php if ( is_home() ) : ?>

			<p><?php printf( __( 'Bereit für den ersten Post? <a href="%1$s">Hier lang</a>.', 'Takelage' ), admin_url( 'post-new.php' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Unter dem Suchbegriff konnte nichts gefunden werden.', 'Takelage' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'Es konnte nichts gefunden werden. Vielleicht hilft eine Suche weiter:', 'Takelage' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</article>

</div>

<?php get_footer(); ?>

