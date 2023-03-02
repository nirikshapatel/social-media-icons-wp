<?php
/**
 * Base class for the plugin.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons' ) ) {

	/**
	 * Base class for the plugin.
	 */
	class Social_Media_Icons {
		/**
		 * Instance of the plugin base class
		 *
		 * @since 1.0.0
		 * @static
		 * @access protected
		 * @var Single instance of the class.
		 */
		protected static $instance = null;

		/**
		 * Instantiates the plugin.
		 * Include all the files needed for the plugin.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public function __construct() {
			self::load_files();
		}

		/**
		 * Function to return Social Media Icons instance.
		 * Ensures only one instance of plugin is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 *
		 * @return Return an instance of base class.
		 */
		public static function instance() {
			if ( null === self::$instance ) {
				self::$instance = new Social_Media_Icons();
			}
			return self::$instance;
		}

		/**
		 * Function to load all the plugin files.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public static function load_files() {
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-posttype.php';
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-scripts.php';
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-metabox.php';
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-postlist.php';
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-shortcode.php';
			require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons-support.php';
		}
	}
}
