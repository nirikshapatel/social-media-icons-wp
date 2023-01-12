<?php
/**
 * Manage shortcode for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Shortcode' ) ) {

	/**
	 * Class to manage shortcode for Social Media Icons.
	 */
	class Social_Media_Icons_Shortcode {

		/**
		 * Function to add hooks and filters.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public static function init() {
			/**
			 * Make shortcode for social media icons
			 */
			add_shortcode(
				'social-media-icons',
				array(
					__CLASS__,
					'social_media_icon_shortcode',
				)
			);
		}

		/**
		 * Make shortcode for social media icons
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 *
		 * @param Array $atts Attributes data as array.
		 */
		public static function social_media_icon_shortcode( $atts ) {
			ob_start();
			if ( isset( $atts['id'] ) && '' !== $atts['id'] ) {
				$_id = $atts['id'];

				$smi_icons             = get_post_meta( $_id, 'smi_icons', true );
				$column_gap            = get_post_meta( $_id, 'smi_column_gap', true );
				$row_gap               = get_post_meta( $_id, 'smi_row_gap', true );
				$font_size             = get_post_meta( $_id, 'smi_font_size', true );
				$icons_color           = get_post_meta( $_id, 'smi_icons_color', true );
				$hover_color           = get_post_meta( $_id, 'smi_hover_color', true );
				$icons_bg_color        = get_post_meta( $_id, 'smi_icons_bg_color', true );
				$icons_bg_hover_color  = get_post_meta( $_id, 'smi_icons_bg_hover_color', true );
				$border_width          = get_post_meta( $_id, 'smi_border_width', true );
				$border_color          = get_post_meta( $_id, 'smi_border_color', true );
				$border_hover_color    = get_post_meta( $_id, 'smi_border_hover_color', true );
				$border_radius         = get_post_meta( $_id, 'smi_border_radius', true );
				$padding_top           = get_post_meta( $_id, 'smi_padding_top', true );
				$padding_right         = get_post_meta( $_id, 'smi_padding_right', true );
				$padding_bottom        = get_post_meta( $_id, 'smi_padding_bottom', true );
				$padding_left          = get_post_meta( $_id, 'smi_padding_left', true );
				$horizontal_alignment  = get_post_meta( $_id, 'smi_horizontal_alignment', true );
				$hover_transition_time = get_post_meta( $_id, 'smi_hover_transition_time', true );
				$link_target           = get_post_meta( $_id, 'smi_link_target', true );
				$show_tooltip_label    = get_post_meta( $_id, 'smi_show_tooltip_label', true );
				$rel_attr              = get_post_meta( $_id, 'smi_rel_attr', true );
				$vertical_layout       = get_post_meta( $_id, 'smi_vertical_layout', true );

				$smi_icons_arr = array_filter( array_column( is_array( $smi_icons ) ? $smi_icons : array(), 'icon' ) );
				if ( is_array( $smi_icons_arr ) && count( $smi_icons_arr ) > 0 ) {
					?>
					<style type="text/css">
						.smi-preview#smi-preview-<?php echo esc_attr( $_id ); ?> {
							<?php echo esc_html( '' !== $column_gap ? '--smi-column-gap: ' . $column_gap . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $row_gap ? '--smi-row-gap: ' . $row_gap . 'px' : '' ); ?>;

							<?php echo esc_html( '' !== $icons_color ? '--smi-color: ' . $icons_color : '' ); ?>;
							<?php echo esc_html( '' !== $hover_color ? '--smi-hover-color: ' . $hover_color : '' ); ?>;
							<?php echo esc_html( '' !== $icons_bg_color ? '--smi-bg-color: ' . $icons_bg_color : '' ); ?>;
							<?php echo esc_html( '' !== $icons_bg_hover_color ? '--smi-bg-hover-color: ' . $icons_bg_hover_color : '' ); ?>;
							<?php echo esc_html( '' !== $border_width ? '--smi-border-width: ' . $border_width . 'px' : '' ); ?>;
							<?php echo esc_html( '0' !== $border_width || '' !== $icons_bg_color || '' !== $icons_bg_hover_color ? '--smi-width: ' . $font_size . 'px;' : '' ); ?>;
							<?php echo esc_html( '' !== $border_radius ? '--smi-border-radius: ' . $border_radius . '%' : '' ); ?>;
							<?php echo esc_html( '' !== $border_color ? '--smi-border-color: ' . $border_color : '' ); ?>;
							<?php echo esc_html( '' !== $border_hover_color ? '--smi-border-hover-color: ' . $border_hover_color : '' ); ?>;
							<?php echo esc_html( '' !== $padding_top ? '--smi-padding-top: ' . $padding_top . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $padding_right ? '--smi-padding-right: ' . $padding_right . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $padding_bottom ? '--smi-padding-bottom: ' . $padding_bottom . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $padding_left ? '--smi-padding-left: ' . $padding_left . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $font_size ? '--smi-font-size: ' . $font_size . 'px' : '' ); ?>;
							<?php echo esc_html( '' !== $horizontal_alignment ? '--smi-horizontal-alignment: ' . $horizontal_alignment : '' ); ?>;
							<?php echo esc_html( '' !== $hover_transition_time ? '--smi-hover-transition-time: ' . $hover_transition_time . 's' : '' ); ?>;
							<?php echo esc_html( '' !== $vertical_layout ? '--smi-layout: column; --smi-icons-wrap: no-wrap; --smi-horizontal-alignment: unset; --smi-vertical-alignment: ' . $horizontal_alignment : '' ); ?>;
						}
					</style>
					<div class="smi-preview" id="smi-preview-<?php echo esc_attr( $_id ); ?>">
						<ul>
							<?php
							foreach ( $smi_icons as $key => $smi_icon ) {
								if ( isset( $smi_icon['icon'] ) && '' !== $smi_icon['icon'] ) {
									$_rel_attr = ( '' !== $rel_attr ? 'rel="' . $rel_attr . '"' : '' );
									$target    = ( '1' === $link_target ? 'target=_blank' : '' );

									if ( isset( $smi_icon['icon_type'] ) && 'icon' === $smi_icon['icon_type'] ) {
										?>
										<li title="<?php echo esc_attr( '1' === $show_tooltip_label ? ( '' !== $smi_icon['label'] ? $smi_icon['label'] : '' ) : '' ); ?>">
											<a href="<?php echo esc_url( '' !== $smi_icon['url'] ? $smi_icon['url'] : '#' ); ?>" <?php echo esc_attr( $target ); ?> <?php echo ( $_rel_attr ); /* phpcs:ignore */ ?>><i class="<?php echo esc_attr( $smi_icon['icon'] ); ?>"></i></a>
										</li>
										<?php
									} else {
										?>
										<li class="icon-image" title="<?php echo esc_attr( '1' === $show_tooltip_label ? ( '' !== $smi_icon['label'] ? $smi_icon['label'] : '' ) : '' ); ?>">
											<a href="<?php echo esc_url( '' !== $smi_icon['url'] ? $smi_icon['url'] : '#' ); ?>" <?php echo esc_attr( $target ); ?> <?php echo ( $_rel_attr ); /* phpcs:ignore */ ?>><img src="<?php echo esc_url( $smi_icon['icon'] ); ?>"></a>
										</li>
										<?php
									}
								}
							}
							?>
						</ul>
					</div>
					<?php
				}
			}
			return ob_get_clean();
		}
	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Shortcode::init();
}
