<?php

/*	Generate the Menu Tabs
------------------------------------------------------------------------------*/

function optionsframework_tabs() {

	$optionsframework_settings = get_option('optionsframework');
	$options = optionsframework_options();
	$menu = '';

	foreach ($options as $value) {
		if ($value['type'] == "heading") {
			$jquery_click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a>';
		}
	}

	return $menu;
}

/*	Generate the Option Fields
------------------------------------------------------------------------------*/

function optionsframework_fields() {

	global $allowedtags;
	$optionsframework_settings = get_option('optionsframework');

	if ( isset( $optionsframework_settings['id'] ) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	};

	$settings = get_option($option_name);
	$options = optionsframework_options();

	$counter = 0;
	$menu = '';

	foreach ( $options as $value ) {

		$counter++;
		$val = '';
		$select_value = '';
		$checked = '';
		$output = '';

		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

			$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );

			$id = 'section-' . $value['id'];

			$class = 'section ';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
			if ( isset( $value['name'] ) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['type'] != 'editor' ) {
				$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
			}
			else {
				$output .= '<div class="option">' . "\n" . '<div>' . "\n";
			}
		}

		if ( isset( $value['std'] ) ) {
			$val = $value['std'];
		}

		if ( ( $value['type'] != 'heading' ) && ( $value['type'] != 'info') ) {
			if ( isset( $settings[($value['id'])]) ) {
				$val = $settings[($value['id'])];
				if ( !is_array($val) ) {
					$val = stripslashes( $val );
				}
			}
		}

		$explain_value = '';
		if ( isset( $value['desc'] ) ) {
			$explain_value = $value['desc'];
		}

		switch ( $value['type'] ) {

		case 'text':
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '" />';
			break;

		case 'textarea':
			$rows = '8';

			if ( isset( $value['settings']['rows'] ) ) {
				$custom_rows = $value['settings']['rows'];
				if ( is_numeric( $custom_rows ) ) {
					$rows = $custom_rows;
				}
			}

			$val = stripslashes( $val );
			$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '">' . esc_textarea( $val ) . '</textarea>';
			break;

		case ($value['type'] == 'select'):
			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';

			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				if ( $val != '' ) {
					if ( $val == $key) { $selected = ' selected="selected"';}
				}
				$output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			}
			$output .= '</select>';
			break;

		case "radio":
			$name = $option_name .'['. $value['id'] .']';
			foreach ($value['options'] as $key => $option) {
				$id = $option_name . '-' . $value['id'] .'-'. $key;
				$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
			}
			break;

		case "images":
			$name = $option_name .'['. $value['id'] .']';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
				}
				$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
			}
			break;

		case "checkbox":
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
			$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags) . '</label>';
			break;

		case "multicheck":
			foreach ($value['options'] as $key => $option) {
				$checked = '';
				$label = $option;
				$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));

				$id = $option_name . '-' . $value['id'] . '-'. $option;
				$name = $option_name . '[' . $value['id'] . '][' . $option .']';

				if ( isset($val[$option]) ) {
					$checked = checked($val[$option], 1, false);
				}

				$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			}
			break;

		case "color":
			$output .= '<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
			$output .= '<input class="of-color" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
			break;

		case "upload":
			$output .= optionsframework_medialibrary_uploader( $value['id'], $val, null );
			break;

		case 'typography':
		
			unset( $font_size, $font_style, $font_face, $font_color );
		
			$typography_defaults = array(
				'face' => '',
				'style' => ''
			);
			
			$typography_stored = wp_parse_args( $val, $typography_defaults );
			
			$typography_options = array(
				'faces' => of_recognized_font_faces(),
				'styles' => of_recognized_font_styles()
			);
			
			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}


			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
				}
				$font_style .= '</select>';
			}

			$typography_fields = compact( 'font_face', 'font_style' );
			$typography_fields = apply_filters( 'of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );
			
			break;


		case 'body_typography':
		
			unset( $font_size, $font_style, $font_face, $font_color );
		
			$typography_defaults = array(
				'face' => '',
				'style' => ''
			);
			
			$typography_stored = wp_parse_args( $val, $typography_defaults );
			
			$typography_options = array(
				'faces' => of_recognized_body_font_faces(),
				'styles' => of_recognized_font_styles()
			);
			
			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}


			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
				}
				$font_style .= '</select>';
			}

			$typography_fields = compact( 'font_face', 'font_style' );
			$typography_fields = apply_filters( 'of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );
			
			break;

		case 'display_typography':
		
			unset( $font_size, $font_style, $font_face, $font_color );
		
			$typography_defaults = array(
				'face' => '',
				'style' => ''
			);
			
			$typography_stored = wp_parse_args( $val, $typography_defaults );
			
			$typography_options = array(
				'faces' => of_recognized_display_font_faces(),
				'styles' => of_recognized_font_styles()
			);
			
			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}


			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
				}
				$font_style .= '</select>';
			}

			$typography_fields = compact( 'font_face', 'font_style' );
			$typography_fields = apply_filters( 'of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );
			
			break;

		case 'background':

			$background = $val;

			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $background['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-background of-background-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $background['color'] ) . '" />';

			if (!isset($background['image'])) {
				$background['image'] = '';
			}

			$output .= optionsframework_medialibrary_uploader( $value['id'], $background['image'], null, '',0,'image');
			$class = 'of-background-properties';
			if ( '' == $background['image'] ) {
				$class .= ' hide';
			}
			$output .= '<div class="' . esc_attr( $class ) . '">';

			$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
			$repeats = of_recognized_background_repeat();

			foreach ($repeats as $key => $repeat) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';

			$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
			$positions = of_recognized_background_position();

			foreach ($positions as $key=>$position) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
			}
			$output .= '</select>';

			$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
			$attachments = of_recognized_background_attachment();

			foreach ($attachments as $key => $attachment) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
			}
			$output .= '</select>';
			$output .= '</div>';

			break;

		case 'editor':
			$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
			echo $output;
			$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );
			$default_editor_settings = array(
				'textarea_name' => $textarea_name,
				'media_buttons' => false,
				'tinymce' => array( 'plugins' => 'wordpress' )
			);
			$editor_settings = array();
			if ( isset( $value['settings'] ) ) {
				$editor_settings = $value['settings'];
			}
			$editor_settings = array_merge($editor_settings, $default_editor_settings);
			wp_editor( $val, $value['id'], $editor_settings );
			$output = '';
			break;

		case "info":
			$id = '';
			$class = 'section';
			if ( isset( $value['id'] ) ) {
				$id = 'id="' . esc_attr( $value['id'] ) . '" ';
			}
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . $value['type'];
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . $value['class'];
			}

			$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
			if ( isset($value['name']) ) {
				$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			}
			if ( $value['desc'] ) {
				$output .= apply_filters('of_sanitize_info', $value['desc'] ) . "\n";
			}
			$output .= '</div>' . "\n";
			break;

		case "heading":
			if ($counter >= 2) {
				$output .= '</div>'."\n";
			}
			$jquery_click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a>';
			$output .= '<div class="group" id="' . esc_attr( $jquery_click_hook ) . '">';

			break;
		}

		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
			$output .= '</div>';
			if ( ( $value['type'] != "checkbox" ) && ( $value['type'] != "editor" ) ) {
				$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
			}
			$output .= '</div></div>'."\n";
		}

		echo $output;
	}
	echo '</div>';
}