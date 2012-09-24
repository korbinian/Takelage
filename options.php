<?php

function optionsframework_option_name() {

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


function optionsframework_options() {


	// Test data
	$test_array = array(
		'one' => __('One', 'Takelage'),
		'two' => __('Two', 'Takelage'),
		'three' => __('Three', 'Takelage'),
		'four' => __('Four', 'Takelage'),
		'five' => __('Five', 'Takelage')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'Takelage'),
		'two' => __('Pancake', 'Takelage'),
		'three' => __('Omelette', 'Takelage'),
		'four' => __('Crepe', 'Takelage'),
		'five' => __('Waffle', 'Takelage')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );
		
	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';

	$options = array();

	$options[] = array(
		'name' => __('Styles', 'Takelage'),
		'type' => 'heading');

	
$dev_stylesheet = options_stylesheets_get_file_list(
    get_stylesheet_directory() . '/_lib/css/skins/dev/', // $directory_path
    'css', // $filetype
    get_stylesheet_directory_uri() . '/_lib/css/skins/dev/' // $directory_uri
);
$options[] = array( "name" => "Development Stylesheet",
    "desc" => '"_lib/css/skins/dev"',
    "id" => "dev_stylesheet",
    "type" => "select",
    'class' => 'mini',
    "options" => $dev_stylesheet );

$color_stylesheet = options_stylesheets_get_file_list(
    get_stylesheet_directory() . '/_lib/css/skins/colors/', // $directory_path
    'css', // $filetype
    get_stylesheet_directory_uri() . '/_lib/css/skins/colors/' // $directory_uri
);
$options[] = array( "name" => "Colors",
    "desc" => '"_lib/css/skins/colors"',
    "id" => "color_stylesheet",
    "type" => "select",
    'class' => 'mini',
    "options" => $color_stylesheet );

$typography_stylesheet = options_stylesheets_get_file_list(
    get_stylesheet_directory() . '/_lib/css/skins/typography/', // $directory_path
    'css', // $filetype
    get_stylesheet_directory_uri() . '/_lib/css/skins/typography/' // $directory_uri
);
$options[] = array( "name" => "Typography",
    "desc" => '"_lib/css/skins/typography"',
    "id" => "typography_stylesheet",
    "type" => "select",
    'class' => 'mini',
    "options" => $typography_stylesheet );









	$options[] = array(
		'name' => __('Input Text Mini', 'Takelage'),
		'desc' => __('A mini text input field.', 'Takelage'),
		'id' => 'example_text_mini',
		'std' => 'Default',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('Input Text', 'Takelage'),
		'desc' => __('A text input field.', 'Takelage'),
		'id' => 'example_text',
		'std' => 'Default Value',
		'type' => 'text');

	$options[] = array(
		'name' => __('Textarea', 'Takelage'),
		'desc' => __('Textarea description.', 'Takelage'),
		'id' => 'example_textarea',
		'std' => 'Default Text',
		'type' => 'textarea');

	$options[] = array(
		'name' => __('Input Select Small', 'Takelage'),
		'desc' => __('Small Select Box.', 'Takelage'),
		'id' => 'example_select',
		'std' => 'three',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $test_array);

	$options[] = array(
		'name' => __('Input Select Wide', 'Takelage'),
		'desc' => __('A wider select box.', 'Takelage'),
		'id' => 'example_select_wide',
		'std' => 'two',
		'type' => 'select',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Select a Category', 'Takelage'),
		'desc' => __('Passed an array of categories with cat_ID and cat_name', 'Takelage'),
		'id' => 'example_select_categories',
		'type' => 'select',
		'options' => $options_categories);
		
	$options[] = array(
		'name' => __('Select a Tag', 'options_check'),
		'desc' => __('Passed an array of tags with term_id and term_name', 'options_check'),
		'id' => 'example_select_tags',
		'type' => 'select',
		'options' => $options_tags);

	$options[] = array(
		'name' => __('Select a Page', 'Takelage'),
		'desc' => __('Passed an pages with ID and post_title', 'Takelage'),
		'id' => 'example_select_pages',
		'type' => 'select',
		'options' => $options_pages);

	$options[] = array(
		'name' => __('Input Radio (one)', 'Takelage'),
		'desc' => __('Radio select with default options "one".', 'Takelage'),
		'id' => 'example_radio',
		'std' => 'one',
		'type' => 'radio',
		'options' => $test_array);

	$options[] = array(
		'name' => __('Example Info', 'Takelage'),
		'desc' => __('This is just some example information you can put in the panel.', 'Takelage'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Input Checkbox', 'Takelage'),
		'desc' => __('Example checkbox, defaults to true.', 'Takelage'),
		'id' => 'example_checkbox',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Advanced Settings', 'Takelage'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Check to Show a Hidden Text Input', 'Takelage'),
		'desc' => __('Click here and see what happens.', 'Takelage'),
		'id' => 'example_showhidden',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Hidden Text Input', 'Takelage'),
		'desc' => __('This option is hidden unless activated by a checkbox click.', 'Takelage'),
		'id' => 'example_text_hidden',
		'std' => 'Hello',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Uploader Test', 'Takelage'),
		'desc' => __('This creates a full size uploader that previews the image.', 'Takelage'),
		'id' => 'example_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' => "Example Image Selector",
		'desc' => "Images for layout.",
		'id' => "example_images",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'1col-fixed' => $imagepath . '1col.png',
			'2c-l-fixed' => $imagepath . '2cl.png',
			'2c-r-fixed' => $imagepath . '2cr.png')
	);

	$options[] = array(
		'name' =>  __('Example Background', 'Takelage'),
		'desc' => __('Change the background CSS.', 'Takelage'),
		'id' => 'example_background',
		'std' => $background_defaults,
		'type' => 'background' );

	$options[] = array(
		'name' => __('Multicheck', 'Takelage'),
		'desc' => __('Multicheck description.', 'Takelage'),
		'id' => 'example_multicheck',
		'std' => $multicheck_defaults, // These items get checked by default
		'type' => 'multicheck',
		'options' => $multicheck_array);

	$options[] = array(
		'name' => __('Colorpicker', 'Takelage'),
		'desc' => __('No color selected by default.', 'Takelage'),
		'id' => 'example_colorpicker',
		'std' => '',
		'type' => 'color' );
		
	$options[] = array( 'name' => __('Typography', 'Takelage'),
		'desc' => __('Example typography.', 'Takelage'),
		'id' => "example_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );
		
	$options[] = array(
		'name' => __('Custom Typography', 'Takelage'),
		'desc' => __('Custom typography options.', 'Takelage'),
		'id' => "custom_typography",
		'std' => $typography_defaults,
		'type' => 'typography',
		'options' => $typography_options );

	$options[] = array(
		'name' => __('Text Editor', 'Takelage'),
		'type' => 'heading' );

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Default Text Editor', 'Takelage'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'Takelage' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'example_editor',
		'type' => 'editor',
		'settings' => $wp_editor_settings );

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function($) {

	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});

	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}

});
</script>

<?php
}


/**
 * Returns an array of all files in $directory_path of type $filetype.
 *
 * The $directory_uri + file name is used for the key
 * The file name is the value
 */
function options_stylesheets_get_file_list( $directory_path, $filetype, $directory_uri ) {
    $alt_stylesheets = array();
    $alt_stylesheet_files = array();
    if ( is_dir( $directory_path ) ) {
        $alt_stylesheet_files = glob( $directory_path . "*.$filetype");
        foreach ( $alt_stylesheet_files as $file ) {
            $file = str_replace( $directory_path, "", $file);
            $alt_stylesheets[ $directory_uri . $file] = $file;
        }
    }
    return $alt_stylesheets;
}
