<?php
/**
 * Post types for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Posttype' ) ) {

	/**
	 * Class to manage post types for Social Media Icons.
	 */
	class Social_Media_Icons_Posttype {

		/**
		 * Function to add hooks and filters.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function init() {

			/**
			 * For register custom post types.
			 */
			add_action(
				'init',
				array(
					__CLASS__,
					'post_type_init',
				)
			);
		}

		/**
		 * For register custom post types.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function post_type_init() {

			/* Register a custom post type social media icons. */
			$labels = array(
				'name'               => __( 'Social Media Icons', 'social-media-icons' ),
				'singular_name'      => __( 'Social Media Icon', 'social-media-icons' ),
				'menu_name'          => __( 'Social Media Icons', 'social-media-icons' ),
				'name_admin_bar'     => __( 'Social Media Icon', 'social-media-icons' ),
				'add_new'            => __( 'Add New', 'social-media-icons' ),
				'add_new_item'       => __( 'Add New Social Media Icons', 'social-media-icons' ),
				'new_item'           => __( 'New Social Media Icon', 'social-media-icons' ),
				'edit_item'          => __( 'Edit Social Media Icons', 'social-media-icons' ),
				'view_item'          => __( 'View Social Media Icon', 'social-media-icons' ),
				'all_items'          => __( 'All Social Media Icons', 'social-media-icons' ),
				'search_items'       => __( 'Search Social Media Icons', 'social-media-icons' ),
				'parent_item_colon'  => __( 'Parent Social Media Icons:', 'social-media-icons' ),
				'not_found'          => __( 'No social media icons found.', 'social-media-icons' ),
				'not_found_in_trash' => __( 'No social media icons found in Trash.', 'social-media-icons' ),
			);

			$args = array(
				'labels'             => $labels,
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title' ),
				'menu_icon'          => 'dashicons-networking',
			);

			register_post_type( 'social_media_icon', $args );
		}
	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Posttype::init();
}
