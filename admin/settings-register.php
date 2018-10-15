<?php
/**
 * Word Limiter.
 * Author: victor
 * Date: 10/13/18
 * Time: 4:22 PM
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}


//word limiter default options
function word_limiter_default_options () {
	return array (
		'default_message'   => "Maximum words allowed",
		'returned_message'  => 'You have exceeded',
		'number_of_words'   => 100,
		'enter_less'        => 'no',
	);

}


function word_limiter_callback_section_basic () {
	echo 'This section enables us to configure plugin settings';
}


//register settings options
function word_limiter_register_settings () {
	register_setting (
		'word_limiter_options',
		'word_limiter_options',
		'word_limiter_validate_options'
	);

	add_settings_section (
		'word_limiter_section_basic',
		'Basic Settings',
		'word_limiter_callback_section_basic',
		'word-limiter'
	);

	add_settings_field (
		'default_message',
		'Default message',
		'word_limiter_callback_field_text',
		'word-limiter',
		'word_limiter_section_basic',
		['id' => 'default_message', 'label' => 'Default Message']
	);

	add_settings_field (
		'returned_message',
		'Returned message',
		'word_limiter_callback_field_text',
		'word-limiter',
		'word_limiter_section_basic',
		['id' => 'returned_message', 'label' => 'Error message to show user']
	);

	add_settings_field (
		'number_of_words',
		'Number of words allowed',
		'word_limiter_callback_field_text',
		'word-limiter',
		'word_limiter_section_basic',
		['id' => 'number_of_words', 'label' => 'Enter the number of words allowed']
	);

	add_settings_field (
		'enter_less',
		'Enable input less than words allowed ?',
		'word_limiter_callback_field_radio',
		'word-limiter',
		'word_limiter_section_basic',
		['id' => 'enter_less', 'label' => 'Enable input less than words allowed']
	);


}
//Add action hook
add_action( 'admin_init', 'word_limiter_register_settings' );

//set default options for snax editor
$option = get_option('word_limiter_options', word_limiter_default_options() );
//perform soft update
update_option( 'snax_post_description_max_length',  $option['number_of_words']);
//update_option( 'snax_post_content_max_length',  0);

