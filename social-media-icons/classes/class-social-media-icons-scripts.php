<?php
/**
 * Scripts for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Scripts' ) ) {

	/**
	 * Class to manage scripts for Social Media Icons.
	 */
	class Social_Media_Icons_Scripts {
		/**
		 * Function to add hooks and filters.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function init() {

			/**
			 * Load scripts and styles for back end.
			 */
			add_action(
				'admin_enqueue_scripts',
				array(
					__CLASS__,
					'admin_enqueue_scripts',
				)
			);

			/**
			 * Load scripts and styles for front end.
			 */
			add_action(
				'wp_enqueue_scripts',
				array(
					__CLASS__,
					'wp_enqueue_scripts',
				)
			);
		}

		/**
		 * Function to handle admin_enqueue_scripts action.
		 * Load scripts and styles for back end.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function admin_enqueue_scripts() {

			/* For open custom media library popup */
			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'smi-font-awesome', SOCIAL_MEDIA_ICONS_URL . 'css/smi-fonts-all.min.css', array(), '6.1.1' );
			wp_enqueue_style( 'smi-admin-style', SOCIAL_MEDIA_ICONS_URL . 'css/smi-admin-style.css', array(), filemtime( SOCIAL_MEDIA_ICONS_DIR . 'css/smi-admin-style.css' ) );
			wp_enqueue_script( 'smi-admin-custom', SOCIAL_MEDIA_ICONS_URL . 'js/smi-admin-custom.js', array(), filemtime( SOCIAL_MEDIA_ICONS_DIR . 'js/smi-admin-custom.js' ), true );
			wp_localize_script(
				'smi-admin-custom',
				'smi_admin_custom',
				array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
				)
			);
		}

		/**
		 * Function to handle wp_enqueue_scripts action.
		 * Load scripts and styles for front end.
		 *
		 * @since 0.1.0
		 * @static
		 * @access public
		 */
		public static function wp_enqueue_scripts() {
			wp_enqueue_style( 'smi-font-awesome', SOCIAL_MEDIA_ICONS_URL . 'css/smi-fonts-all.min.css', array(), '6.1.1' );
			wp_enqueue_style( 'smi-front-style', SOCIAL_MEDIA_ICONS_URL . 'css/smi-front-style.css', array(), filemtime( SOCIAL_MEDIA_ICONS_DIR . 'css/smi-front-style.css' ) );
		}

	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Scripts::init();
}
