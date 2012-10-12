<?php

/*------------------------------------------------------------------------------
	External Modules
------------------------------------------------------------------------------*/

/* Add Theme Options
------------------------------------------------------------------------------*/



if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/_lib/settings/' );
	require_once dirname( __FILE__ ) . '/_lib/settings/options-framework.php';
}

/*

if ( is_admin() && is_readable( get_template_directory() . '/_lib/inc/theme-options.php' ) )
	require_once( get_template_directory() . '/_lib/inc/theme-options.php' ); */


/* Add Code Highlighting Library
------------------------------------------------------------------------------*/

require( get_template_directory() . '/_lib/codemirror/codemirror.php' );

/*------------------------------------------------------------------------------
	Actions / Filters / ShortCodes
------------------------------------------------------------------------------*/

	// Actions
	add_action('after_setup_theme','Takelage_theme_support');
	add_action('wp_enqueue_scripts', 'Takelage_scripts');
  add_action('wp_footer', 'Takelage_add_jquery_fallback'); 
  add_action('get_header', 'Takelage_enable_threaded_comments'); 
	add_action('wp_enqueue_scripts', 'Takelage_styles');
	add_action('wp_enqueue_scripts', 'options_stylesheets_color_style');
	add_action('wp_enqueue_scripts', 'options_stylesheets_typography_style');
	add_action('wp_enqueue_scripts', 'Takelage_add_custom_styles');
	add_action('after_setup_theme', 'Takelage_add_editor_styles');  
	add_action('login_head', 'Takelage_login_css');
	add_action('init', 'Takelage_register_menu');
	add_action('widgets_init', 'Takelage_widgets_init');
	add_action('init', 'takelage_register_post_type_feature');
	add_action('admin_menu', 'disable_default_dashboard_widgets');
	add_action('wp_head', 'Takelage_remove_recent_comments_style', 1); 
	add_action('widgets_init', 'Takelage_widgets_init');
	add_action('wp_before_admin_bar_render', 'Takelage_remove_adminbar_logo', 0);
	add_action('template_redirect', 'takelage_content_width');
	
	// Remove Actions
	remove_action('wp_head', 'feed_links_extra', 3);             
	remove_action('wp_head', 'feed_links', 2);                       
	remove_action('wp_head', 'rsd_link');                            
	remove_action('wp_head', 'wlwmanifest_link' );                    
	remove_action('wp_head', 'index_rel_link' );                     
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);           
	remove_action('wp_head', 'start_post_rel_link', 10, 0 );           
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'start_post_rel_link', 10, 0 );
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head',10, 0 );
  remove_action('wp_head', 'rel_canonical');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

  // Filters
	add_filter('body_class', 'takelage_body_class');
	add_filter('the_generator', 'Takelage_rss_version');
	add_filter('wp_head', 'Takelage_remove_wp_widget_recent_comments_style', 1); 
	add_filter('gallery_style', 'Takelage_gallery_style');
	add_filter('style_loader_tag', 'Takelage_ie_conditional', 10, 2);
	add_filter('the_content', 'Takelage_filter_ptags_on_images');
	add_filter('the_content', 'Takelage_wrap_images');
	add_filter('excerpt_more', 'Takelage_excerpt_more');
	add_filter('excerpt_length', 'Takelage_excerpt_length', 999);
	add_filter('mce_buttons_2', 'Takelage_add_mce_styles');
	add_filter('tiny_mce_before_init', 'Takelage_replace_mce_styles');
	add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
	add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10 );
	add_filter('the_content', 'remove_thumbnail_dimensions', 10 );
	add_filter('jpeg_quality', function($arg){return 70;});
	add_filter('widget_text', 'do_shortcode');
	add_filter('style_loader_tag', 'Takelage_style_remove');
	add_filter('login_headerurl', 'Takelage_login_url');
	add_filter('login_headertitle', 'Takelage_login_title');
	add_filter('admin_footer_text', 'Takelage_custom_admin_footer');
	add_filter( 'nav_menu_css_class', 'Takelage_nav_menu_css_class', 10, 4 );

	// Shortcodes
	add_shortcode('Takelage_shortcode', 'Takelage_shortcode');

/*------------------------------------------------------------------------------
	Theme Support
------------------------------------------------------------------------------*/

function Takelage_theme_support() {
	if ( function_exists( 'add_theme_support' ) ) {
   	add_theme_support('menus');
		add_theme_support('post-formats', array( 'gallery', 'link', 'quote', 'status' ) );	
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
		add_image_size('full-size',  9999, 9999, false );
		add_image_size('one-col',  296, 240, true );
		set_post_thumbnail_size( 616, 240, true);
  }
}

/*------------------------------------------------------------------------------
	Add Language Support
------------------------------------------------------------------------------*/

load_theme_textdomain( 'Takelage', get_template_directory() .'/_lib/languages' );
	$locale = get_locale();
	$locale_file = get_template_directory() ."/_lib/languages/$locale.php";
if ( is_readable($locale_file) ) require_once($locale_file);

/*------------------------------------------------------------------------------
	Load Scripts 
------------------------------------------------------------------------------*/

function Takelage_scripts() {
  if (!is_admin()) {
    wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js', 'jquery', '1.8.2', true);
		wp_enqueue_script('jquery');
		wp_register_script('script', get_template_directory_uri() . '/_lib/js/script.min.js', 'jquery', '1.0.0', true );
		wp_enqueue_script('script');
  }
}

function Takelage_add_jquery_fallback() {
	echo "<script>";
	echo "window.jQuery || document.write('<script src='".get_bloginfo('template_url')."_lib/js/vendor/jquery-1.8.2.min.js'><\/script>')";
	echo "</script>";
}

function Takelage_enable_threaded_comments(){
	if (!is_admin()) {
		if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
		wp_enqueue_script('comment-reply');
	}
}

/*------------------------------------------------------------------------------
	Load Styles 
------------------------------------------------------------------------------*/

function Takelage_styles() {
  if (!is_admin()) {
    wp_register_style( 'Takelage-stylesheet', get_stylesheet_directory_uri() . '/_lib/css/style.min.css', array(), '', 'all' );
    wp_register_style( 'Takelage-ie-only', get_stylesheet_directory_uri() . '/_lib/css/style.ie.css', array(), '' );
    wp_enqueue_style( 'Takelage-stylesheet' ); 
    wp_enqueue_style( 'Takelage-ie-only' );
  }
}

function Takelage_ie_conditional( $tag, $handle ) {
	if ( 'Takelage-ie-only' == $handle )
		$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
	return $tag;
}

function options_stylesheets_color_style()   {
	if ( of_get_option('color_stylesheet') ) {
		wp_enqueue_style( 'options_stylesheets_color_style', of_get_option('color_stylesheet'), array(), null );
	}
}

function options_stylesheets_typography_style()   {
	if ( of_get_option('typography_stylesheet') ) {
		wp_enqueue_style( 'options_stylesheets_typography_style', of_get_option('typography_stylesheet'), array(), null );
	}
}

function Takelage_add_editor_styles() {  
    add_editor_style( '_lib/css/style.editor.css' ); 
}

function Takelage_add_custom_styles() {
	?>
	<style>
		* {
			<?php 
			$body_typography = of_get_option('body_typography');
			echo 'font-family:' . $body_typography['face'] . ';';
			echo 'font-weight:' . $body_typography['style'] . ';'; 
			?>
		}
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, nav a, .sidebar-front .bigtext, .sidebar-front .bigtext div, .cta .textwidget div {
			<?php 
			$display_typography = of_get_option('heading_typography');
			echo 'font-family:' . $display_typography['face'] . ';';
			echo 'font-weight:' . $display_typography['style'] . ';'; 
			?>
		}
	</style>

	<?php
}

/*	Remove 'text/css' from our enqueued stylesheet
------------------------------------------------------------------------------*/

function Takelage_style_remove($tag) {
	return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

/*------------------------------------------------------------------------------
	Anonymize Users
------------------------------------------------------------------------------*/

$_SERVER["REMOTE_ADDR"] = "0.0.0.0";
$_SERVER["HTTP_USER_AGENT"] = "";

/*------------------------------------------------------------------------------
	Customize Login Page
------------------------------------------------------------------------------*/

function Takelage_login_css() {
	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/_lib/css/style.login.css">';
}
function Takelage_login_url() { return home_url(); }
function Takelage_login_title() { return get_option('blogname'); }

/*------------------------------------------------------------------------------
	Register Menus
------------------------------------------------------------------------------*/

function Takelage_register_menu() {
	  register_nav_menus( array(
			'meta'   => __( 'Meta Menu <br><small>Other Pirate Party Portals like Wiki, Twitter &hellip;</small>', 'Takelage' ),
			'main'   => __( 'Main Menu <br><small>Static Pages</small>', 'Takelage' ),
			'footer' => __( 'Footer Menu <br><small>Minor Links</small>', 'Takelage' ),
		) );
	}

/*	Adds .has-children class to menus
------------------------------------------------------------------------------*/

function Takelage_nav_menu_css_class( $css_class, $item ) {
	global $wpdb;
	$has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM wp_postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'");
	if ($has_children > 0) {
	    array_push($css_class, 'has-subnav');
	}
	return $css_class;
}

/*	Sets Content Width
------------------------------------------------------------------------------*/

function takelage_content_width() {
	if ( ! isset( $content_width ) ) $content_width = 616;
	if ( is_page_template( 'fullwidth.php' ) ) {
		global $content_width;
		$content_width = 936;
	}
}

/*	Remove WP Version from RSS
------------------------------------------------------------------------------*/

function Takelage_rss_version() { 
	return '';
}

/*	Remove injected CSS for recent Comments Widget
------------------------------------------------------------------------------*/

function Takelage_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

/*	Clean up Comment Styles in the <head>
------------------------------------------------------------------------------*/
	
function Takelage_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

/*	Clean up Gallery Output
------------------------------------------------------------------------------*/

function Takelage_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

/*	Remove the <div> surrounding the dynamic navigation
------------------------------------------------------------------------------*/

function my_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}

/*	Remove inline width and height added to images
------------------------------------------------------------------------------*/

function remove_thumbnail_dimensions( $html ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

/*	Remove <p> around <img>s
------------------------------------------------------------------------------*/

function Takelage_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/*	Wrap <img>s in <figure>s
------------------------------------------------------------------------------*/

function Takelage_wrap_images($content){
	return preg_replace('/<img (.*) \/>\s*/iU', '<figure><img \1 /></figure>', $content);
}

/*	Remove the Wp Logo from the Adminbar
------------------------------------------------------------------------------*/

function Takelage_remove_adminbar_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}

/*	Customize Backend Footer
------------------------------------------------------------------------------*/

function Takelage_custom_admin_footer() {
	echo '<i>Developed by</i> <b><a href="http://www.korbinian-polk.de">Korbinian Polk</a></b> ';
}

/*	Change the Read More Link after the Excerpt
------------------------------------------------------------------------------*/

function Takelage_excerpt_more($more) {
	global $post;
	return '  <span class="readon">[<a href="'. get_permalink($post->ID) . '">&hellip;</a>]</span>';
}

/*	Change the Excerpt Length
------------------------------------------------------------------------------*/

function Takelage_excerpt_length( $length ) {
	return 50;
}

/*	Add Styledropdown to TinyMCE 
------------------------------------------------------------------------------*/

function Takelage_add_mce_styles( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}

/*	Replace default WP Styles in TinyMCE
------------------------------------------------------------------------------*/

function Takelage_replace_mce_styles( $settings ) {
	$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';
	$style_formats = array(
	    array( 'title' => 'Button',         'inline' => 'span',  'classes' => 'button' ),
	    array( 'title' => 'Green Button',   'inline' => 'span',  'classes' => 'button button-green' )
	);
	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}

/*------------------------------------------------------------------------------
	Add Body Classes
------------------------------------------------------------------------------*/

function takelage_body_class( $classes ) {
	global $post;
	$background_color = get_background_color();

	if ( is_page_template( 'fullwidth.php' ) )
		$classes[] = 'fullwidth';

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	if( is_home() ) {			
			$key = array_search( 'blog', $classes );
			if($key > -1) {
				unset( $classes[$key] );
			};
		} elseif( is_page() ) {
			$classes[] = sanitize_html_class( $post->post_name );
		} elseif(is_singular()) {
			$classes[] = sanitize_html_class( $post->post_name );
		};
	return $classes;
}


/*------------------------------------------------------------------------------
	Adds delete/spam links to comments
------------------------------------------------------------------------------*/

function takelage_comment_link($id) {
  if (current_user_can('edit_post')) {
    echo '/ <a href="'.admin_url("comment.php?action=cdc&c=$id").'">delete</a> ';
    echo '/ <a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">spam</a>'; } }

/*------------------------------------------------------------------------------
	Disable Dashboard Widgets
------------------------------------------------------------------------------*/

function disable_default_dashboard_widgets() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core'); 
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}

/*	Initialize Sidebar Widgets
------------------------------------------------------------------------------*/

function Takelage_widgets_init() {
	if(function_exists('register_sidebar')) {
		register_sidebar( array(
			'name'          => __( 'Sidebar Startseite', 'Takelage' ),
			'id'            => 'sidebar-front',
			'before_widget' => '<aside id="%1$s" class="widget skin %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sticker Startseite', 'Takelage' ),
			'id'            => 'sticker',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 1 Startseite', 'Takelage' ),
			'id'            => 'sidebar-1-front',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 2 Startseite', 'Takelage' ),
			'id'            => 'sidebar-2-front',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 3 Startseite', 'Takelage' ),
			'id'            => 'sidebar-3-front',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'Takelage' ),
			'id'            => 'sidebar',
			'before_widget' => '<aside id="%1$s" class="widget skin %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 1', 'Takelage' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 1', 'Takelage' ),
			'id'            => 'sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Sub 2', 'Takelage' ),
			'id'            => 'sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => "</aside>",
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );
	}
}


/*------------------------------------------------------------------------------
	Template Tags
------------------------------------------------------------------------------*/

/*	Generate the <title>
------------------------------------------------------------------------------*/

if ( ! function_exists( 'get_sitetitle' ) ):
function Takelage_sitetitle( ) {
	global $page, $paged;
		wp_title( '/', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " / $site_description";
		if ( $paged >= 2 || $page >= 2 )
			echo ' / ' . sprintf( __( 'Page %s', 'Takelage' ), max( $paged, $page ) );
}
endif;

/*	Display navigation to next/previous pages when applicable
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_content_nav' ) ):
function Takelage_content_nav( $nav_id ) {
	global $wp_query;
	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';
	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
	<h1 class="hidden m"><?php _e( 'Post navigation', 'Takelage' ); ?></h1>
	<?php if ( is_single() ) : ?>
		<?php previous_post_link( '<span class="nav-previous">%link</span>', '<span class="meta-nav hidden">' . _x( '&lsaquo;', 'Previous post link', 'Takelage' ) . '</span>' ); ?>
		<?php next_post_link( '<span class="nav-next">%link</span>', '<span class="meta-nav hidden">' . _x( '&rsaquo;', 'Next post link', 'Takelage' ) . '</span>' ); ?>
	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>
		<?php if ( get_next_posts_link() ) : ?>
		<span class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav hidden">&larr;</span> Older posts', 'Takelage' ) ); ?></span>
		<?php endif; ?>
		<?php if ( get_previous_posts_link() ) : ?>
		<span class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav hidden">&rarr;</span>', 'Takelage' ) ); ?></span>
		<?php endif; ?>
	<?php endif; ?>

	</nav>
	<?php
}
endif;

/*	Generate Template for author information
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_authorinfo' ) ):
function Takelage_authorinfo() {
	?>

		<div class="author-info byline vcard">
			<figure>
				<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
				<figcaption>
					<div><a class="fn n author" href="<?php the_author_meta('user_url'); ?>"><?php the_author_meta('display_name'); ?></a></div>
					<small class="post-details">
			<?php if ( 'post' == get_post_type() ) : ?>
			<?php endif; ?>
			<?php if ( 'post' == get_post_type() ) : ?>

				<?php
					$tags_list = get_the_tag_list( '', __( ', ', 'Takelage' ) );
					if ( $tags_list ) :
				?>
		
				<span class="tag-links">
					<?php printf( __( '<i>über</i> %1$s', 'Takelage' ), $tags_list ); ?>
				</span>
				<?php endif; ?>
				
			<?php endif; ?>
			</small>
				</figcaption>
			</figure>

		</div>

	<?php
}
endif;

/*	Generate Template for comments and pingbacks.
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_comment' ) ) :

function Takelage_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'Takelage' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Takelage' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 56 ); ?>
					<?php printf( __( '%s ', 'Takelage' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'Takelage' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'Takelage' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<!--<?php edit_comment_link( __( '(Edit)', 'Takelage' ), ' ' ); ?> -->
					<?php takelage_comment_link(get_comment_ID()); ?>
				</div>
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
		</article>

	<?php
			break;
	endswitch;
}
endif;


/*	Print HTML with meta information for the current post-date/time and author.
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_posted_on' ) ) :
function Takelage_posted_on() {
	printf( __( '
		<div class="date">
			<a href="%1$s" title="%2$s" rel="bookmark" class="meta">
				<time class="entry-date updated s" datetime="%3$s" pubdate>
					<div class="day">%4$s</div>
					<div class="month">%5$s</div>
					<div class="year">%6$s</div>
				</time></a>
				<span class="byline"> </span>
		</div>', 'Takelage' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'j' ) ),
		esc_html( get_the_date( 'M' ) ),
		esc_html( get_the_date( 'Y' ) )
	);
}
endif;


/*	Generate a submenu of all pages without the parent-elements 
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_submenu' ) ) :
function Takelage_submenu() {
	global $post;
	if($post->post_parent) {
		$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0"); }
	else  {
		$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0"); }
	if ($children && is_page()) {
		echo '<nav class="nav-sub group skin" role="navigation"><h1 class="m hidden">'; ?>
		<?php _e( 'Submenü', 'Takelage' ); ?> 
		<?php echo '</h1>';
		echo '<ul>' . $children . '</ul></nav>'; }
	else { }
}
endif;


/*	Generate breadcrumbs
------------------------------------------------------------------------------*/

if ( ! function_exists( 'Takelage_breadcrumb' ) ) :
function Takelage_breadcrumb() {
  $delimiter    = '<span class="delimiter"> / </span>';
  $delimiter1   = '<span class="delimiter1"> &bull; </span>';
  $main         = 'Start';
  $maxLength    = 30;
  $arc_year     = get_the_time('Y');
  $arc_month    = get_the_time('F');
  $arc_day      = get_the_time('d');
  $arc_day_full = get_the_time('l');  
  $url_year     = get_year_link($arc_year);
  $url_month    = get_month_link($arc_year,$arc_month);
  echo '<div id="breadcrumb">';
  global $post, $cat;
  $homeLink = get_option('Home'); 
  echo '<a href="' . $homeLink . '">' . $main . '</a>' . $delimiter;    
  if (is_single()) { 
      $category = get_the_category();
      $num_cat = count($category); 
      if ($num_cat <=1)  {
          echo get_category_parents($category[0],  true,' ' . $delimiter . ' ');
      }
      else {
          echo the_category( $delimiter1, 'multiple' );
      }
  }
  elseif (is_category()) { 
      echo 'Kategorie: "' . get_category_parents($cat, true,' ' . $delimiter . ' ') . '"' ;
  }
  elseif ( is_tag() ) { 
      echo 'Tag(s): "' . single_tag_title("", false) . '"';
  }
  elseif ( is_day()) { 
      echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . ' ';
      echo '<a href="' . $url_month . '">' . $arc_month . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
  }
  elseif ( is_month() ) {  
      echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . $arc_month;
  }
  elseif ( is_year() ) { 
      echo $arc_year;
  }
  elseif ( is_search() ) {  
      echo 'Suchergebnis für: "' . get_search_query() . '"';
  }
  elseif ( is_page() && $post->post_parent ) {  
      $post_array = get_post_ancestors($post);
      krsort($post_array); 
      foreach($post_array as $key=>$postid){
          $post_ids = get_post($postid);
          $title = $post_ids->post_title;
          echo '<a href="' . get_permalink($post_ids) . '">' . $title . '</a>' . $delimiter;
      }
  }
  elseif ( is_author() ) {
      global $author;
      $user_info = get_userdata($author);
      echo  'Artikel von: ' . $user_info->display_name ;
  }
  elseif ( is_404() ) {
      echo  'Fehler 404 - Nichts gefunden :(';
  }
 echo '</div>';
}
endif;

/*------------------------------------------------------------------------------
	Create Custom Post-type 'Featured Post'
------------------------------------------------------------------------------*/

function takelage_register_post_type_feature() {
	register_taxonomy_for_object_type('category','feature');
	register_taxonomy_for_object_type('post_tag','feature');
	$labels = array( 
		'name'                => __( 'Featured Posts', 'Takelage' ),
		'singular_name'       => __( 'feature', 'Takelage' ),
		'add_new'             => __( 'Add New', 'Takelage' ),
		'add_new_item'        => __( 'Add New Feature', 'Takelage' ),
		'edit_item'           => __( 'Edit Feature', 'Takelage' ),
		'new_item'            => __( 'New Feature', 'Takelage' ),
		'view_item'           => __( 'View Feature', 'Takelage' ),
		'search_items'        => __( 'Search Feature', 'Takelage' ),
		'not_found'           => __( 'No Features found', 'Takelage' ),
		'not_found_in_trash'  => __( 'No Features found in Trash', 'Takelage' ),
		'parent_item_colon'   => __( 'Parent Feature:', 'Takelage' ),
		'menu_name'           => __( 'Featured Posts', 'Takelage' ),
	);
	$args = array( 
		'labels'              => $labels,
		'hierarchical'        => true,
		'description'         => __( 'Post Type for Featured Posts', 'Takelage' ),
		'supports'            => array( 'title', 'editor', 'author',   'thumbnail', 'post-thumbnails', 'excerpt', 'trackbacks', 'custom-fields', 'comments','revisions','page-attributes'  ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'menu_position'       => 5,
		'capability_type'     => 'post',
		'taxonomies'          => array( 'post_tag', 'category')
	);
	register_post_type( 'feature', $args );
	flush_rewrite_rules(false);
}

/*------------------------------------------------------------------------------
	Add Demo Shortcodes
------------------------------------------------------------------------------*/

function Takelage_shortcode( $atts, $content = null ) {
	return '<h2 class="demo">'.$content.'</h2>';
}