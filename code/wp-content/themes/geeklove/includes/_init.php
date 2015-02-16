<?php
/*--------------------------------------------------*/
/* Include Theme Options
/*--------------------------------------------------*/
include_once('options/blog-settings.php');
include_once('options/general-settings.php');
include_once('options/styling-options.php');
include_once('options/wedding-options.php');


/*--------------------------------------------------*/
/* Include Widgets
/*--------------------------------------------------*/
include_once('widgets/homepage-blog.php');
include_once('widgets/homepage-countdown.php');
include_once('widgets/homepage-divider.php');
include_once('widgets/homepage-event.php');
include_once('widgets/homepage-gallery.php');
include_once('widgets/homepage-rsvp.php');
include_once('widgets/homepage-tweets.php');
include_once('widgets/homepage-wedding-intro.php');
include_once('widgets/static-content.php');


/*--------------------------------------------------*/
/* Include Meta Boxes
/*--------------------------------------------------*/
if(stag_get_option('general_disable_seo_settings') == 'off'){
  include_once('metaboxes/seo.php');
}
include_once('metaboxes/event-metabox.php');
include_once('metaboxes/contact-metabox.php');
include_once('metaboxes/gallery-metabox.php');
include_once('metaboxes/page-metabox.php');
include_once('metaboxes/rsvp-metabox.php');

/*--------------------------------------------------*/
/* Include Custom Post Types
/*--------------------------------------------------*/
include_once('cpt/events.php');
include_once('cpt/gallery.php');
include_once('cpt/guestbook.php');
include_once('cpt/rsvp.php');
