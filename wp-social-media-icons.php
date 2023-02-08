<?php
/**
 * Plugin Name: Social Media Icons Wp
 * Description: This plugin is used for add social icons and upload your own icon image with your own style using settings, that allow visitors to view your social profile and connect or follow to your site. Add shortcode to render icons.
 * Version: 1.0.0
 * Author: Niriksha Patel
 * Developer: Niriksha Patel
 * Text Domain: social-media-icons
 * License: GNU General Public License v3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

/**
 * Define constants.
 */
define( 'SOCIAL_MEDIA_ICONS_DIR', plugin_dir_path( __FILE__ ) . 'social-media-icons/' );
define( 'SOCIAL_MEDIA_ICONS_URL', plugin_dir_url( __FILE__ ) . 'social-media-icons/' );

/**
 * Include core class files.
 */
require_once SOCIAL_MEDIA_ICONS_DIR . 'classes/class-social-media-icons.php';

if ( ! function_exists( 'social_media_icons_init' ) ) {
	/**
	 * Function to initialize the plugin.
	 *
	 * @since 1.0.0
	 */
	function social_media_icons_init() {
		Social_Media_Icons::instance();
	}
}
/**
 * Create the main object of the plugin when the plugins are loaded.
 */
add_action( 'plugins_loaded', 'social_media_icons_init' );
