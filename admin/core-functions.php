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


/**
 * @param $x
 * @return bool
 */
function is_multi_array( $x ) {
	if( count( array_filter( $x,'is_array' ) ) > 0 ) return true;
	return false;
}

/**
 *  Convert an object to an array.
 *  @param   array  $object  The object to convert
 *  @return  array  The converted array
 */
function object_to_array( $object ) {
	if( !is_object( $object ) && !is_array( $object ) ) return $object;
	return array_map( 'object_to_array', (array) $object );
}
/**
 *  Check if a value exists in the array/object.
 *
 *  @param   mixed    $needle    The value that you are searching for
 *  @param   mixed    $haystack  The array/object to search
 *  @param   boolean  $strict    Whether to use strict search or not
 *  @return  mixed             Whether the value was found or not
 */
function search_for_value( $needle, $haystack, $strict=true ) {
	$haystack = object_to_array( $haystack );
	if( is_array( $haystack ) ) {
		if( is_multi_array( $haystack ) ) {   // Multidimensional array
			foreach( $haystack as $subhaystack ) {
				if( search_for_value( $needle, $subhaystack, $strict ) ) {
					return array('found' => 'true', 'data' => $subhaystack);
				}
			}
		} elseif( array_keys( $haystack ) !== range( 0, count( $haystack ) - 1 ) ) {    // Associative array
			foreach( $haystack as $key => $val ) {
				if( $needle == $val && !$strict ) {
					return true;
				} elseif( $needle === $val && $strict ) {
					return true;
				}
			}
			return false;
		} else {    // Normal array
			if( $needle == $haystack && !$strict ) {
				return true;
			} elseif( $needle === $haystack && $strict ) {
				return true;
			}
		}
	}
	return false;
}


////////////////////////////////////////////////
//Ajax Handler
function word_limiter_ajax_get_data () {
	//Get request nonce
	$nonce  = $_REQUEST['nonce'];
	//initialize empty result array
	$result = array();
	//verify nonce
	if ( wp_verify_nonce( $nonce, 'word_limiter_ajax_verify_'. 1196 ) ) {
		//verification successful, continue logic
		//get option values
		$option = get_option ( 'word_limiter_options', word_limiter_default_options() );
		//set result values
		$result['status'] = true;
		$result['enter_less'] = $option['enter_less'];
		$result['number_of_words'] = $option['number_of_words'];
		$result['default_message'] = $option['default_message'];
		$result['returned_message'] = $option['returned_message'];

	} else {
		//nonce verification fails
		$result['status'] = false;
	}
	wp_send_json( $result );
}

//add_action( 'template_redirect','word_limiter_load_configuration');
add_action( 'wp_ajax_word_limiter_ajax_get_data', 'word_limiter_ajax_get_data' );
add_action( 'wp_ajax_nopriv_word_limiter_ajax_get_data', 'word_limiter_ajax_get_data');















?>
