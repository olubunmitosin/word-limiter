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


// Add Admin Menu
function word_limiter_admin_menu ()
{

  add_menu_page(
      'Word Limiter Settings',
      'Word Limiter',
      'manage_options',
      'word-limiter',
      'word_limiter_display_settings',
      'dashicons-admin-generic',
      null
   );
}

add_action( 'admin_menu', 'word_limiter_admin_menu' );
