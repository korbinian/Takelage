
			
		</div>
	</div>

	<?php
	if (is_front_page()) { 
		get_template_part( 'sidebar', 'front' );
	} else {
    get_sidebar();
	}
	?>

	<footer id="footer" role="contentinfo">	
		<div class="row">
			<div class="toggle"><a href="#page" class="on">on</a><a href="#" class="off">off</a></div>
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-footer group' ) ); ?>
			<small class="source-org vcard copyright">
				Code <span class="amp">&</span> Design based on the <a href="korbinian-polk.de/takelage">Takelage</a> Theme &mdash; <a href="http://creativecommons.org/licenses/by-sa/3.0/"><abbr>CC BY-SA 3.0</abbr></a> by <strong><a href="http://www.korbinian-polk.de">Korbinian Polk</a></strong> <br><?php echo of_get_option('footer_text', ''); ?>
			</small>
			
		</div>
	</footer>


	<?php wp_footer(); ?>

</body>
</html>