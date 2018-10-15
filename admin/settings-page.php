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


//display admin settings
function word_limiter_display_settings ()
{
  //check is user can manage settings
  if (! current_user_can( 'manage_options' ) ) return;
  //include form view
  include_once('views/general.php');

}


?>
