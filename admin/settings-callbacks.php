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

//callback: text fields
function word_limiter_callback_field_text ( $args ) {
	$options = get_option ( 'word_limiter_options', word_limiter_default_options() );
	//get id from options if is isset..
	$id     = isset ( $args['id'] ) ? $args['id'] : '';
	//get label from options is isset
	$label  = isset ( $args['label'] ) ? $args['label'] : '';
	//get default value for text fields if available
	$value  = isset ($options[$id]) ? sanitize_text_field( $options[$id] ) : '';
	//echo standard html input field
	echo '<input type="text" id="word_limiter_options_'. $id .'" name="word_limiter_options['. $id .']" size="40"
        value="'.$value.'"/> <br/>';
	echo '<label for="word_limiter_options_'. $id .'">'.$label.'</label>';
}


function word_limiter_callback_field_radio ( $args ) {

	$options = get_option ( 'word_limiter_options', word_limiter_default_options() );
	//get id from options if isset
	$id     = isset ( $args['id'] ) ? $args['id'] : '';
	//get label from options if isset
	$label  = isset ( $args['label'] ) ? $args['label'] : '';
	//get default value for radio fields if available
	$selected_option  = isset ( $options[$id] ) ? sanitize_text_field ( $options[$id] ) : '';
	//default number
	$default = $options['number_of_words'];

	$radio_options = array (
		'yes' => "Yes, Users can enter words less than $default, but won't exceeds $default",
		'no'  => "No, Users can enter exactly $default words",
	);

	foreach ( $radio_options as $value => $label ) {
		//check is selected
		$checked = checked ($selected_option === $value, true, false);
		//echo standard html radio input
		echo '<label> <input name="word_limiter_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'/>';
		echo '<span>'. $label . '</span></label><br/>';
	}
}

?>
