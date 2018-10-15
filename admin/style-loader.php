<?php
/**
 * Word Limiter.
 * Author: victor
 * Date: 10/13/18
 * Time: 4:22 PM
 */

// Prevent direct access to file
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You\'re not allowed to access this file' );
}

function loadStyles(){
    //define assets path
    $assets_path = plugin_dir_url( __FILE__ );
	//wp_enqueue_script( 'word_limiter_jquery', $assets_path . '../assets/js/jquery.min.js', array(), false, true);
	wp_enqueue_script( 'word_limiter_froala_script', $assets_path . 'assets/js/watch.js', array('jquery'), false, true);
	wp_enqueue_script( 'word_limiter_main', $assets_path . 'assets/js/main.js', array('jquery'), false, true);

	wp_enqueue_style('word_limiter_main_css', $assets_path . 'assets/css/main.css', array(), false );
	//Get the site protocol
    $protocol  = isset ( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

	// Set the ajax-url Parameter which will be displayed right before
	// our main.js file so we can use ajax-url
	$params = array (
		// Get the url to the admin-ajax.php file using admin_url()
		'ajaxurl' =>  admin_url( 'admin-ajax.php', $protocol),
		'nonce' => wp_create_nonce( 'word_limiter_ajax_verify_'. 1196),
	);
	// Print the script to our page
	wp_localize_script( 'word_limiter_main', 'word_limiter_params', $params );
}
//Attach function to action hook
add_action( 'wp_enqueue_scripts', 'loadStyles' );

