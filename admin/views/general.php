<?php
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
  die( 'No direct script access allowed' );
}
?>

<div class="wrap">

<div style="">
  <style type="text/css">

    .word_limiter_h3 .space_lg{
      padding-left: 115px;
      color: green;
    }
    .word_limiter_h3 .space_sm{
      padding-left: 20px;
    }
  </style>
  <?php

    //get all active plugins
    $apl = get_option('active_plugins');
    //get installed plugins
    $plugins = get_plugins();
    //init empty array for plugins
    $activated_plugins = array();
    //loop through plugins
    foreach ($apl as $p){
        if(isset($plugins[$p])){
             //push active plugin details to array
             array_push($activated_plugins, $plugins[$p]);
        }

    }

    //support for snax editor
    $snax = search_for_value( 'snax', $activated_plugins );

    //if snax plugin is installed and active
    if( $snax['found'] == true ) {
      //Display settings
      ?>

      <h1><?php echo esc_html ( get_admin_page_title() ); ?></h1>

      <?php
      //display notifications
      settings_errors();
      echo '<br/>';
      echo '<h3 class="word_limiter_h3">Editor in use: <span class="space_lg">'.$snax['data']['Name'].'<span class="space_sm"></span>v'.$snax['data']['Version'].'</h3><br/>';

      ?>

      <form action="options.php" method="post">
        <?php
          //output settings fields
          settings_fields('word_limiter_options');


          //output settings actions
          do_settings_sections('word-limiter');

          //submit button
          submit_button();
        ?>
      </form>

      <?php

    } else {
      //Display Message
      echo '<div class="notice notice-error is-dismissible">
                <p>Word Restricter.</p>
                <p>Sorry! No Supported Editor found. please ensure you are using snax plugin</p>
            </div>';
    }

  ?>
  </div>
</div>
