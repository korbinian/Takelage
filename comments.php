
<?php
	if ( post_password_required() )
		return;
?>

<div id="comments" class="comments-area group">

<?php if ( have_comments() ) : ?>
	<div class="comments-title">


		<?php
			printf( _n( '<b>Ein</b> Kommentar zu %2$s', '%1$s Kommentare zu %2$s', get_comments_number(), 'Takelage' ),
				number_format_i18n( get_comments_number() ), '<h2 class="l">' . get_the_title() . '</h2>' );
		?>
	</div>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :?>
	<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
		<h1 class="assistive-text"><?php _e( 'Kommentarnavigation', 'Takelage' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( 'Kommentarnavigation', 'Takelage' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'neuere Kommentare &rarr;', 'Takelage' ) ); ?></div>
	</nav>
	<?php endif; ?>

	<ol class="commentlist">
		<?php wp_list_comments( array( 'callback' => 'Takelage_comment' ) ); ?>
		<?php delete_comment_link(get_comment_ID()); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
		<h1 class="assistive-text"><?php _e( 'Kommentarnavigation', 'Takelage' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; ältere Kommentare', 'Takelage' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'neuere Kommentare &rarr;', 'Takelage' ) ); ?></div>
	</nav>
	<?php endif; ?>

<?php endif; ?>

<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="nocomments"><?php _e( 'Die Kommentarfunktion ist abgeschaltet.', 'Takelage' ); ?></p>
<?php endif; ?>

<?php comment_form(array('comment_notes_after'=>'')); ?>


</div>
