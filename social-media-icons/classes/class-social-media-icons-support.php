<?php
/**
 * Supports for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Support' ) ) {

	/**
	 * Class to manage supports for Social Media Icons.
	 */
	class Social_Media_Icons_Support {

		/**
		 * Function to add hooks and filters.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function init() {

			/**
			 * Determine the real file type of a file.
			 */
			add_filter(
				'wp_check_filetype_and_ext',
				array(
					__CLASS__,
					'wp_check_filetype_and_ext',
				),
				10,
				4
			);

			/**
			 * Allow SVG
			 */
			add_filter(
				'upload_mimes',
				array(
					__CLASS__,
					'upload_mimes',
				),
			);
		}

		/**
		 * Function to handle wp_check_filetype_and_ext filter.
		 * Determine the real file type of a file.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 *
		 * @param Array  $data Data as array.
		 * @param String $file Full path to the file.
		 * @param String $filename File name.
		 * @param Array  $mimes Mimes as array.
		 * @return Array of file data
		 */
		public static function wp_check_filetype_and_ext( $data, $file, $filename, $mimes ) {
			$filetype = wp_check_filetype( $filename, $mimes );
			return array(
				'ext'             => $filetype['ext'],
				'type'            => $filetype['type'],
				'proper_filename' => $data['proper_filename'],
			);
		}

		/**
		 * Function to handle upload_mimes filter.
		 * Allow SVG
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 *
		 * @param Array $mimes Mimes data as array.
		 * @return Array $mimes Mimes data as array.
		 */
		public static function upload_mimes( $mimes ) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}
	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Support::init();
}
