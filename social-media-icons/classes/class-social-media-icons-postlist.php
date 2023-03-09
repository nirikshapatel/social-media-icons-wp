<?php
/**
 * Manage Post list for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Postlist' ) ) {

	/**
	 * Class to manage post list for Social Media Icons.
	 */
	class Social_Media_Icons_Postlist {

		/**
		 * Function to add hooks and filters.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function init() {

			/**
			 * Add column in social media icons post list
			 */
			add_action(
				'manage_social_media_icon_posts_columns',
				array(
					__CLASS__,
					'manage_social_media_icon_posts_columns',
				)
			);

			/**
			 * Add column value in social media icons post list
			 */
			add_action(
				'manage_social_media_icon_posts_custom_column',
				array(
					__CLASS__,
					'manage_social_media_icon_posts_custom_column',
				),
				10,
				2
			);
		}

		/**
		 * Add column in social media icons post list
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 *
		 * @param Array $columns Columns data as array.
		 * @return Array $columns Columns data as array.
		 */
		public static function manage_social_media_icon_posts_columns( $columns ) {
			/* Add shortcode column */
			$columns['smi_shortcode'] = __( 'Shortcode', 'social-media-icon' );
			return $columns;
		}

		/**
		 * Add column value in social media icons post list.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 *
		 * @param String  $column Column as string.
		 * @param Integer $post_id Post Id as integer.
		 */
		public static function manage_social_media_icon_posts_custom_column( $column, $post_id ) {
			/* Display shortcode in list for social media icons */
			switch ( $column ) {
				case 'smi_shortcode':
					echo esc_html( '[social-media-icons id=' . $post_id . ']' );
					break;
			}
		}
	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Postlist::init();
}
