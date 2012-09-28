<!DOCTYPE html>
<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php Takelage_sitetitle();?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( substr_count( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' ) ) { ob_start( "ob_gzhandler" ); } else { ob_start(); }  ?>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/_lib/images/icons/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/_lib/images/icons/apple-touch-icon-114x114-precomposed.png">
 	<?php wp_head(); ?>
	<style type="text/css">
		* {
			<?php 
			$typography = of_get_option('body_typography');         
			echo 'font-family: ' . $typography['face'] . ';';
			echo 'font-weight: ' . $typography['style'] . ';'
			?> }
		h1, h2, h3, h4, h5, h6, .cta span, h1 a, h2 a, h3 a, nav a {
			<?php 
			$typography = of_get_option('heading_typography');         
			echo 'font-family: ' . $typography['face'] . ';';
			echo 'font-weight: ' . $typography['style'] . ';'
			?> }
	</style>
	
</head>

<body <?php body_class(); if ( is_home() ) { echo 'role="homepage"'; } ?> id="page" >

	<?php do_action( 'before' ); ?>

	<header id="header" role="banner">
		
		<div class="row">

			<ul class="skiplinks">
				<li><a href="#nav" class="jump-nav"><?php _e( 'Menu', 'Takelage' ); ?></a></li>
				<li><a href="#content" class="jump-content"><?php _e( 'zum Inhalt springen', 'Takelage' ); ?></a></li>
			</ul>

			<div class="banner">
				<a href="<?php echo home_url( '/' ); ?>" rel="home" class="logo-link">
					<?php if ( of_get_option('logo_uploader') ) { ?>
          	<img src="<?php echo of_get_option('logo_uploader'); ?>" class="logo"/>
          <?php } else { ?>
        	<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="240px" height="240px" viewBox="0 0 240 240" enable-background="new 0 0 240 240" xml:space="preserve" class="logo">
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
				</a>
				<hgroup>
					<h1 class="title xl"><a href="<?php echo home_url( '/' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="tagline"><span><?php bloginfo( 'description' ); ?></span></h2>
				</hgroup>
			</div>

			<div class="cta">
				<?php if ( ! dynamic_sidebar( 'sticker-1' ) ) : ?>

				<?php endif; ?>
				<?php if ( ! dynamic_sidebar( 'sticker-2' ) ) : ?>
				
				<?php endif; ?>
			</div>
	
			<nav role="navigation" aria-label="Meta menu">
				<?php wp_nav_menu( array( 'theme_location' => 'meta', 'menu_class' => 'nav-meta group' ) ); ?>
			</nav>

			<nav role="navigation" aria-label="Main menu" id="nav">
				<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'nav nav-main group dropdown', 'container' => false, ) ); ?>
				<a href="" class="back"><?php _e( 'zurück', 'Takelage' ); ?></a>
			</nav>​	

			<?php get_search_form(); ?>

		</div>

	</header>

	<div id="main">
		<div class="row">
