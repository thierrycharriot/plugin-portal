<?php

/**
 * Registers the `links` post type.
 */
function links_init() {
	register_post_type(
		'links',
		[
			'labels'                => [
				'name'                  => __( 'Links', 'plugin-portal' ),
				'singular_name'         => __( 'Links', 'plugin-portal' ),
				'all_items'             => __( 'All Links', 'plugin-portal' ),
				'archives'              => __( 'Links Archives', 'plugin-portal' ),
				'attributes'            => __( 'Links Attributes', 'plugin-portal' ),
				'insert_into_item'      => __( 'Insert into Links', 'plugin-portal' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Links', 'plugin-portal' ),
				'featured_image'        => _x( 'Featured Image', 'links', 'plugin-portal' ),
				'set_featured_image'    => _x( 'Set featured image', 'links', 'plugin-portal' ),
				'remove_featured_image' => _x( 'Remove featured image', 'links', 'plugin-portal' ),
				'use_featured_image'    => _x( 'Use as featured image', 'links', 'plugin-portal' ),
				'filter_items_list'     => __( 'Filter Links list', 'plugin-portal' ),
				'items_list_navigation' => __( 'Links list navigation', 'plugin-portal' ),
				'items_list'            => __( 'Links list', 'plugin-portal' ),
				'new_item'              => __( 'New Links', 'plugin-portal' ),
				'add_new'               => __( 'Add New', 'plugin-portal' ),
				'add_new_item'          => __( 'Add New Links', 'plugin-portal' ),
				'edit_item'             => __( 'Edit Links', 'plugin-portal' ),
				'view_item'             => __( 'View Links', 'plugin-portal' ),
				'view_items'            => __( 'View Links', 'plugin-portal' ),
				'search_items'          => __( 'Search Links', 'plugin-portal' ),
				'not_found'             => __( 'No Links found', 'plugin-portal' ),
				'not_found_in_trash'    => __( 'No Links found in trash', 'plugin-portal' ),
				'parent_item_colon'     => __( 'Parent Links:', 'plugin-portal' ),
				'menu_name'             => __( 'Links', 'plugin-portal' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => false,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'links',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'links_init' );

/**
 * Sets the post updated messages for the `links` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `links` post type.
 */
function links_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['links'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Links updated. <a target="_blank" href="%s">View Links</a>', 'plugin-portal' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'plugin-portal' ),
		3  => __( 'Custom field deleted.', 'plugin-portal' ),
		4  => __( 'Links updated.', 'plugin-portal' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Links restored to revision from %s', 'plugin-portal' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Links published. <a href="%s">View Links</a>', 'plugin-portal' ), esc_url( $permalink ) ),
		7  => __( 'Links saved.', 'plugin-portal' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Links submitted. <a target="_blank" href="%s">Preview Links</a>', 'plugin-portal' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Links scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Links</a>', 'plugin-portal' ), date_i18n( __( 'M j, Y @ G:i', 'plugin-portal' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Links draft updated. <a target="_blank" href="%s">Preview Links</a>', 'plugin-portal' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'links_updated_messages' );

/**
 * Sets the bulk post updated messages for the `links` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `links` post type.
 */
function links_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['links'] = [
		/* translators: %s: Number of Links. */
		'updated'   => _n( '%s Links updated.', '%s Links updated.', $bulk_counts['updated'], 'plugin-portal' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Links not updated, somebody is editing it.', 'plugin-portal' ) :
						/* translators: %s: Number of Links. */
						_n( '%s Links not updated, somebody is editing it.', '%s Links not updated, somebody is editing them.', $bulk_counts['locked'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'deleted'   => _n( '%s Links permanently deleted.', '%s Links permanently deleted.', $bulk_counts['deleted'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'trashed'   => _n( '%s Links moved to the Trash.', '%s Links moved to the Trash.', $bulk_counts['trashed'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'untrashed' => _n( '%s Links restored from the Trash.', '%s Links restored from the Trash.', $bulk_counts['untrashed'], 'plugin-portal' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'links_bulk_updated_messages', 10, 2 );
