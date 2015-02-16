<?php
add_action('admin_init', 'stag_wedding_settings');
function stag_wedding_settings(){

  $wedding_settings['description'] = __('Customize your homepage preferences.', 'stag');

  $wedding_settings[] = array(
    'title'   => __('Wedding Date', 'stag'),
    'desc'    => __('Select the wedding date in dd-mm-yyyy format', 'stag'),
    'type'    => 'text',
    'val'     => '31-12-2014',
    'id'      => 'wedding_date',
    'format'  => 'dd-mm-yyyy'
  );

  $wedding_settings[] = array(
    'title'   => __('Wedding Time', 'stag'),
    'desc'    => __('Select the wedding time in H:i:s format.<br>For example: 20:12:55; hours, minutes and seconds respectively.', 'stag'),
    'type'    => 'text',
    'id'      => 'wedding_time',
    'val'     => '0:0:0',
  );

  $wedding_settings[] = array(
    'title' => __('Bridegroom details', 'stag'),
    'type'  => 'html',
    'html'  => '',
    'id'    => 'wedding_bridegroom_title'
  );

  $wedding_settings[] = array(
    'title' => __('First Name', 'stag'),
    'desc'  => __('Enter the first name of the Bridegroom', 'stag'),
    'type'  => 'text',
    'id'    => 'wedding_bridegroom_first_name'
  );

  $wedding_settings[] = array(
    'title' => __('Last Name', 'stag'),
    'desc'  => __('Enter the Last name of the Bridegroom', 'stag'),
    'type'  => 'text',
    'id'    => 'wedding_bridegroom_last_name'
  );

  $wedding_settings[] = array(
    'title' => __('Bridegroom Avatar', 'stag'),
    'desc'  => __('Upload the avatar of Bridegroom.<br>Ideal size 115px x 115px or 230px x 230px for retina displays', 'stag'),
    'type'  => 'file',
    'id'    => 'wedding_bridegroom_avatar'
  );

  $wedding_settings[] = array(
    'title' => __('Bridegroom Short Bio', 'stag'),
    'desc'  => __('Bio text for bridegroom', 'stag'),
    'type'  => 'textarea',
    'id'    => 'wedding_bridegroom_bio'
  );


  $wedding_settings[] = array(
    'title' => __('Bride details', 'stag'),
    'type'  => 'html',
    'html'  => '',
    'id'    => 'wedding_bridegroom_title'
  );

  $wedding_settings[] = array(
    'title' => __('First Name', 'stag'),
    'desc'  => __('Enter the first name of the Bride', 'stag'),
    'type'  => 'text',
    'id'    => 'wedding_bride_first_name'
  );

  $wedding_settings[] = array(
    'title' => __('Last Name', 'stag'),
    'desc'  => __('Enter the Last name of the Bride', 'stag'),
    'type'  => 'text',
    'id'    => 'wedding_bride_last_name'
  );

  $wedding_settings[] = array(
    'title' => __('Bride Avatar', 'stag'),
    'desc'  => __('Upload the avatar of Bride.<br>Ideal size 115px x 115px or 230px x 230px for retina displays', 'stag'),
    'type'  => 'file',
    'id'    => 'wedding_bride_avatar'
  );

  $wedding_settings[] = array(
    'title' => __('Bride Short Bio', 'stag'),
    'desc'  => __('Bio text for bride', 'stag'),
    'type'  => 'textarea',
    'id'    => 'wedding_bride_bio'
  );

  $wedding_settings[] = array(
    'title' => __('Intro Section Slideshow', 'stag'),
    'type'  => 'html',
    'html'  => '',
    'id'    => 'wedding_intro_title'
  );

  $wedding_settings[] = array(
    'title' => __('Slideshow Images', 'stag'),
    'type'  => 'files',
    'id'    => 'wedding_slideshow'
  );

  $wedding_settings[] = array(
    'title' => __('Slideshow Duration', 'stag'),
    'desc'  => __('Enter the duration between slideshows.<br><em>1000 is equal to 1 second.</em>', 'stag'),
    'type'  => 'text',
    'id'    => 'wedding_slideshow_duration',
    'val'   => '3000'
  );

  $wedding_settings[] = array(
    'title' => __( 'Fade Duration', 'stag' ),
    'desc'  => __( 'Enter the duration between slideshows fade animation.<br><em>1000 is equal to 1 second.</em>', 'stag' ),
    'type'  => 'text',
    'id'    => 'wedding_fade_duration',
    'val'   => '750'
  );

  stag_add_framework_page( __('Wedding Settings', 'stag'), $wedding_settings, 11 );
}
