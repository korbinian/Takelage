<?php get_header(); ?>
<div id="content" role="main">

	<?php get_template_part( 'slider' ) ?>
	<?php get_template_part( 'news' ) ?>

</div>

<div id="aside" >
	<div class="sidebar-front">
		<?php if ( ! dynamic_sidebar( 'sidebar-front' ) ) : ?>
		<div class="widget skin"><img src="http://placehold.it/296x240"></div>
		<div class="widget skin"><img src="http://placehold.it/296x120"></div>
		
		<?php endif; ?>
	</div>

</div>
</div>

<?php get_footer(); ?>