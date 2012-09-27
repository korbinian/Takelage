<?php

function optionsframework_option_name() {

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}


function optionsframework_options() {


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
		'name' => __('Logo', 'Takelage'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Logo Upload', 'Takelage'),
		'desc' => __('Upload your own logo to replace it with the default Signet.', 'Takelage'),
		'id' => 'logo_uploader',
		'type' => 'upload');


		// Typography Defaults
	$typography_defaults = array(
		'face' => 'Arial',
		'style' => '400',);


	$options[] = array(
		'name' => __('Typography', 'Takelage'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Headings', 'Takelage'),
		'id' => "heading_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );

	$options[] = array(
		'name' => __('Body', 'Takelage'),
		'id' => "body_typography",
		'std' => $typography_defaults,
		'type' => 'typography' );



	$options[] = array(
		'name' => __('Colors', 'Takelage'),
		'type' => 'heading');

	$color_stylesheet = options_stylesheets_get_file_list(
	    get_stylesheet_directory() . '/_lib/css/skins/colors/', // $directory_path
	    'css', // $filetype
	    get_stylesheet_directory_uri() . '/_lib/css/skins/colors/' // $directory_uri
	);
	$options[] = array( "name" => "Colors",
	    "id" => "color_stylesheet",
	    "type" => "select",
	    'std' => '',
	    'class' => 'mini',
	    "options" => $color_stylesheet );



	$options[] = array(
		'name' => __('Footer', 'Takelage'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Footer Text', 'Takelage'),
		'desc' => __('This text will appear in the footer', 'Takelage'),
		'id' => 'footer_text',
		'std' => '',
		'type' => 'text');

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
