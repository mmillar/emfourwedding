<?php
add_action('admin_init', 'stag_blog_setting');
function stag_blog_setting(){

  $blog_settings['description'] = __('Modify your blog settings.', 'stag');

  $blog_settings[] = array(
    'title' => __('Blog Cover', 'stag'),
    'desc'  => __('Choose a cover image for blog', 'stag'),
    'type'  => 'file',
    'id'    => 'blog_cover_image',
    'val'   => 'Choose Cover Image'
  );

  $blog_settings[] = array(
    'title' => __('Blog Title', 'stag'),
    'desc'  => __('Choose the title for blog page', 'stag'),
    'type'  => 'text',
    'id'    => 'blog_title',
  );

  $blog_settings[] = array(
    'title' => __('Blog Subitle', 'stag'),
    'desc'  => __('Choose the subtitle for blog page', 'stag'),
    'type'  => 'text',
    'id'    => 'blog_subtitle',
  );

  $blog_settings[] = array(
    'title' => __('Blog Footer', 'stag'),
    'desc'  => __('Enter the blog footer text', 'stag'),
    'type'  => 'wysiwyg',
    'id'    => 'blog_footer',
    'val'   => sprintf( __( 'A WordPress Theme by <a href="%s">Codestag</a>', 'stag' ), esc_url('https://codestag.com') )
  );

  stag_add_framework_page( __('Blog Settings', 'stag'), $blog_settings, 40 );
}
