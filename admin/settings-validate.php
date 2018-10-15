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



//validate plugin settings
function word_limiter_validate_options ( $input ) {

  //default message
  if ( isset( $input['default_message'] ) ) {
    $input['default_message'] = sanitize_text_field( $input['default_message'] );
  }

  //returned message
  if ( isset ( $input['returned_message'] ) ) {
    $input['returned_message'] = wp_kses_post( $input['returned_message'] );
  }

  //Number of words
  if ( isset ( $input['number_of_words'] ) ) {
    $input['number_of_words'] = sanitize_text_field( $input['number_of_words'] );
  }

  //checkbox for entry
  $radio_options = array (
    'yes' => 'Yes, Enable',
    'no'  => 'No, Disable',
  );

  if (! isset( $input['enter_less'] ) ) {
    $input['enter_less'] = null;
  }

  if (! array_key_exists ( $input['enter_less'], $radio_options ) ) {
    $input['enter_less'] = null;
  }

  return $input;
}
