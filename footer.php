
			
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

			<p class="footer-text"><?php echo of_get_option('footer_text', ''); ?></p>

			<div class="footer-logo">
			<?php if ( of_get_option('logo_uploader') ) { ?>
				<img src="<?php echo of_get_option('logo_uploader'); ?>" class="logo-small"/>
				<?php } else { ?>
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 240 240" enable-background="new 0 0 240 240" xml:space="preserve" class="logo-small">
				<circle fill="#fff" cx="119.558" cy="119.557" r="118.825"/>
				<path d="M119.562,10.236c-60.382,0-109.328,48.946-109.328,109.325c0,60.38,48.945,109.323,109.328,109.328
				c60.377,0,109.323-48.947,109.323-109.328C228.887,59.184,179.939,10.236,119.562,10.236z M119.562,213.268
				c-51.752,0-93.708-41.955-93.708-93.704c0-51.754,41.956-93.708,93.708-93.708c51.754,0,93.706,41.954,93.706,93.708
				C213.266,171.314,171.316,213.268,119.562,213.268z"/>
				<path d="M118.373,53.665c-13.084,0-23.094,1.277-30.589,2.933v-14.59h-9.466v17.26c-6.875,2.447-9.652,4.771-9.652,4.771
				s3.957-0.333,9.652,0.118v89.759c-2.22,4.082-3.644,8.945-3.644,14.816c0,16.205,7.832,30.775,7.832,30.775
				s-2.369-9.109-2.325-15.48c0.14-20.609,8.572-31.56,44.93-37.512c15.578-2.551,63.551-5.826,63.185-41.694
				C188.072,83.169,174.641,53.665,118.373,53.665z M99.071,135.419c-3.217,1.974-7.344,4.36-11.287,7.539V65.546
				c14.143,3.09,30.954,11.842,30.954,36.006C118.738,111.342,117.463,124.127,99.071,135.419z"/>
				</svg>
				<?php } ?>
			</div>	

			<small>
				Code <span class="amp">&</span> Design based on the <a href="https://github.com/korbinian/Takelage">Takelage Theme</a> 
				&mdash; <a href="http://creativecommons.org/licenses/by-sa/3.0/"><abbr>CC BY-SA 3.0</abbr></a> 
				by <strong><a href="http://www.korbinian-polk.de">Korbinian Polk</a></strong>.
			</small>
			
		</div>
	</footer>


	<?php wp_footer(); ?>

</body>
</html>