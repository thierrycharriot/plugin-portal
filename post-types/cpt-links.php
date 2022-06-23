<?php

/**
 * Registers the `cpt_links` post type.
 */
function cpt_links_init() {
	register_post_type(
		'cpt-links',
		[
			'labels'                => [
				'name'                  => __( 'Links', 'plugin-portal' ),
				'singular_name'         => __( 'Link', 'plugin-portal' ),
				'all_items'             => __( 'All Links', 'plugin-portal' ),
				'archives'              => __( 'Link Archives', 'plugin-portal' ),
				'attributes'            => __( 'Link Attributes', 'plugin-portal' ),
				'insert_into_item'      => __( 'Insert into Link', 'plugin-portal' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Link', 'plugin-portal' ),
				'featured_image'        => _x( 'Featured Image', 'cpt-links', 'plugin-portal' ),
				'set_featured_image'    => _x( 'Set featured image', 'cpt-links', 'plugin-portal' ),
				'remove_featured_image' => _x( 'Remove featured image', 'cpt-links', 'plugin-portal' ),
				'use_featured_image'    => _x( 'Use as featured image', 'cpt-links', 'plugin-portal' ),
				'filter_items_list'     => __( 'Filter Links list', 'plugin-portal' ),
				'items_list_navigation' => __( 'Links list navigation', 'plugin-portal' ),
				'items_list'            => __( 'Links list', 'plugin-portal' ),
				'new_item'              => __( 'New Link', 'plugin-portal' ),
				'add_new'               => __( 'Add New', 'plugin-portal' ),
				'add_new_item'          => __( 'Add New Link', 'plugin-portal' ),
				'edit_item'             => __( 'Edit Link', 'plugin-portal' ),
				'view_item'             => __( 'View Link', 'plugin-portal' ),
				'view_items'            => __( 'View Links', 'plugin-portal' ),
				'search_items'          => __( 'Search Links', 'plugin-portal' ),
				'not_found'             => __( 'No Links found', 'plugin-portal' ),
				'not_found_in_trash'    => __( 'No Links found in trash', 'plugin-portal' ),
				'parent_item_colon'     => __( 'Parent Link:', 'plugin-portal' ),
				'menu_name'             => __( 'Links', 'plugin-portal' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'cpt-links',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'cpt_links_init' );

/**
 * Sets the post updated messages for the `cpt_links` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `cpt_links` post type.
 */
function cpt_links_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['cpt-links'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Link updated. <a target="_blank" href="%s">View Link</a>', 'plugin-portal' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'plugin-portal' ),
		3  => __( 'Custom field deleted.', 'plugin-portal' ),
		4  => __( 'Link updated.', 'plugin-portal' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Link restored to revision from %s', 'plugin-portal' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Link published. <a href="%s">View Link</a>', 'plugin-portal' ), esc_url( $permalink ) ),
		7  => __( 'Link saved.', 'plugin-portal' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Link submitted. <a target="_blank" href="%s">Preview Link</a>', 'plugin-portal' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Link scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Link</a>', 'plugin-portal' ), date_i18n( __( 'M j, Y @ G:i', 'plugin-portal' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Link draft updated. <a target="_blank" href="%s">Preview Link</a>', 'plugin-portal' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'cpt_links_updated_messages' );

/**
 * Sets the bulk post updated messages for the `cpt_links` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `cpt_links` post type.
 */
function cpt_links_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['cpt-links'] = [
		/* translators: %s: Number of Links. */
		'updated'   => _n( '%s Link updated.', '%s Links updated.', $bulk_counts['updated'], 'plugin-portal' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Link not updated, somebody is editing it.', 'plugin-portal' ) :
						/* translators: %s: Number of Links. */
						_n( '%s Link not updated, somebody is editing it.', '%s Links not updated, somebody is editing them.', $bulk_counts['locked'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'deleted'   => _n( '%s Link permanently deleted.', '%s Links permanently deleted.', $bulk_counts['deleted'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'trashed'   => _n( '%s Link moved to the Trash.', '%s Links moved to the Trash.', $bulk_counts['trashed'], 'plugin-portal' ),
		/* translators: %s: Number of Links. */
		'untrashed' => _n( '%s Link restored from the Trash.', '%s Links restored from the Trash.', $bulk_counts['untrashed'], 'plugin-portal' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'cpt_links_bulk_updated_messages', 10, 2 );
