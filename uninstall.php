<?php
/**
 * Word Limiter.
 * Author: victor
 * Date: 10/13/18
 * Time: 4:22 PM
 */

//exit if uninstall constant is not defined
if ( ! defined ( 'WP_UNINSTALL_PLUGIN' ) ) {
  exit;
}

//clean up the plugin options from the database
delete_option( 'word_limiter_options' );
