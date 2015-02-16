<?php
/**
 * Register Guestbook Post type.
 *
 * @return void
 */
function stag_create_post_type_guestbook(){
	$labels = array(
		'name'               => __( 'Guestbook', 'stag'),
		'singular_name'      => __( 'Guestbook' , 'stag'),
		'add_new'            => __('Add New', 'stag'),
		'add_new_item'       => __('Add New Guestbook', 'stag'),
		'edit_item'          => __('Edit Guestbook', 'stag'),
		'new_item'           => __('New Guestbook', 'stag'),
		'view_item'          => __('View Guestbook', 'stag'),
		'search_items'       => __('Search Guestbook', 'stag'),
		'not_found'          => __('No Guestbooks found', 'stag'),
		'not_found_in_trash' => __('No Guestbooks found in Trash', 'stag'),
		'parent_item_colon'  => ''
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => array('slug' => 'the-guestbook' ),
		'show_ui'             => true,
		'query_var'           => false,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'menu_position'       => 35,
		'menu_icon'           => 'dashicons-testimonial',
		'has_archive'         => false,
		'supports'            => array('title', 'editor'),
		'hierarchical'        => false,
		'show_in_nav_menus'   => false
	);

	register_post_type( 'the-guestbook', $args );
}
add_action('init', 'stag_create_post_type_guestbook');

function stag_guestbook_edit_columns( $columns ) {
	$columns = array(
		"cb"      => "<input type=\"checkbox\" />",
		"title"   => __( 'Name', 'stag' ),
		"message" => __( 'Message', 'stag' ),
		"date"    => __( 'Date Added', 'stag' )
	);

	return $columns;
}
add_filter("manage_edit-the-guestbook_columns", "stag_guestbook_edit_columns");

function stag_guestbook_custom_columns( $column ) {
	switch ($column){
		case 'message':
			echo get_the_content();
			break;
	}
}
add_action("manage_posts_custom_column",  "stag_guestbook_custom_columns");
