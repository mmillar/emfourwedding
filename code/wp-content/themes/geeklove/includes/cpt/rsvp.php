<?php
/**
 * Register RSVP Post type.
 *
 * @return void
 */
function stag_create_post_type_rsvp(){
	$labels = array(
		'name'               => __( 'Attendees', 'stag' ),
		'singular_name'      => __( 'RSVP' , 'stag' ),
		'add_new'            => __( 'Add New', 'stag' ),
		'add_new_item'       => __( 'Add New RSVP', 'stag' ),
		'edit_item'          => __( 'Edit RSVP', 'stag' ),
		'new_item'           => __( 'New RSVP', 'stag' ),
		'view_item'          => __( 'View RSVP', 'stag' ),
		'search_items'       => __( 'Search RSVP', 'stag' ),
		'not_found'          => __( 'No RSVPs found', 'stag' ),
		'not_found_in_trash' => __( 'No RSVPs found in Trash', 'stag' ),
		'parent_item_colon'  => '',
	);

	$args = array(
		'labels'              => $labels,
		'public'              => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'rewrite'             => array( 'slug' => 'rsvp' ),
		'show_ui'             => true,
		'query_var'           => false,
		'capability_type'     => 'post',
		'hierarchical'        => false,
		'menu_position'       => 34,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'has_archive'         => false,
		'supports'            => array( 'title' ),
		'hierarchical'        => false,
		'show_in_nav_menus'   => false,
	);

	register_post_type( 'rsvp', $args );
}
add_action( 'init', 'stag_create_post_type_rsvp' );

function stag_rsvp_edit_columns( $columns ) {
	$columns = array(
		'cb'              => '<input type="checkbox" />',
		'title'           => __( 'RSVP Title', 'stag' ),
		'attendee_number' => __( 'Number of Attendees', 'stag' ),
		'attendee_event'  => __( 'Event Attending', 'stag' ),
		'date'            => __( 'Date Added', 'stag' ),
	);

	return $columns;
}
add_filter( 'manage_edit-rsvp_columns', 'stag_rsvp_edit_columns' );

function stag_rsvp_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'attendee_number':
		echo get_post_meta( get_the_ID(), '_stag_attendee_number', true );
		break;

		case 'attendee_event':
		echo ucwords( str_replace( '-', ' ', get_post_meta( get_the_ID(), '_stag_attendee_event', true ) ) );
		break;
	}
}
add_action( 'manage_posts_custom_column',  'stag_rsvp_custom_columns' );

function stag_rsvp_sortable_columns( $columns ) {
	$columns['attendee_event'] = '_stag_attendee_event';
	$columns['attendee_number'] = '_stag_attendee_number';

	return $columns;
}
add_filter( 'manage_edit-rsvp_sortable_columns', 'stag_rsvp_sortable_columns' );

function stag_rsvp_orderby( $query ) {
	if ( ! is_admin() )
		return;

	$orderby = $query->get( 'orderby' );

	if ( '_stag_attendee_event' == $orderby ) {
		$query->set( 'meta_key','_stag_attendee_event' );
	}
	if ( '_stag_attendee_number' == $orderby ) {
		$query->set( 'meta_key','_stag_attendee_number' );
		$query->set( 'orderby','meta_value_num' );
	}
}
add_action( 'pre_get_posts', 'stag_rsvp_orderby' );
