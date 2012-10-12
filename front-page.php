<?php get_header(); ?>
<div id="content" role="main">

	<?php get_template_part( 'slider' ) ?>
	<?php get_template_part( 'news' ) ?>

</div>

<div id="aside" >
	<div class="sidebar-front">
		<div class="sticker">
		<?php if ( ! dynamic_sidebar( 'sticker' ) ) : ?>
		<?php endif; ?>
		</div>
		<?php if ( ! dynamic_sidebar( 'sidebar-front' ) ) : ?>

		<?php endif; ?>

	</div>

</div>
</div>

<?php get_footer(); ?>