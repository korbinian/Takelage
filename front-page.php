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
		<aside class="widget"><img src="http://placehold.it/296x240"></aside>
		<aside class="widget"><img src="http://placehold.it/296x120"></aside>
		<?php endif; ?>

	</div>

</div>
</div>

<?php get_footer(); ?>