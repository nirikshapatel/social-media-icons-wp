<?php
/**
 * Metabox for Social Media Icons.
 *
 * @package Social_Media_Icons
 */

/**
 * Exit if file executed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Access Denied' );
}

if ( ! class_exists( 'Social_Media_Icons_Metabox' ) ) {

	/**
	 * Class to manage metabox for Social Media Icons.
	 */
	class Social_Media_Icons_Metabox {
		/**
		 * Function to add hooks and filters.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public static function init() {

			/**
			 * Add meta box.
			 */
			add_action(
				'add_meta_boxes',
				array(
					__CLASS__,
					'smi_add_meta_boxes',
				)
			);

			/**
			 * Save meta box content.
			 */
			add_action(
				'save_post',
				array(
					__CLASS__,
					'smi_save_meta_box',
				)
			);

			/**
			 * Add new social icon group.
			 */
			add_action(
				'wp_ajax_smi_add_icon',
				array(
					__CLASS__,
					'smi_add_icon',
				)
			);
		}

		/**
		 * Function to handle add_meta_boxes action.
		 * Add meta box.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public static function smi_add_meta_boxes() {
			global $post;

			if ( 'publish' === $post->post_status ) {
				add_meta_box( 'smi-shortcode-meta-id', __( 'Social Media Icon Shortcode', 'social-media-icons' ), array( __CLASS__, 'shortcode_callback' ), 'social_media_icon', 'side', 'low' );
			}

			add_meta_box( 'smi-meta-box-id', __( 'Social Media Icon Settings', 'social-media-icons' ), array( __CLASS__, 'smi_metabox_callback' ), 'social_media_icon' );
		}

		/**
		 * Meta box for display shortcode.
		 *
		 * @param WP_Post $post Current post object.
		 */
		public static function shortcode_callback( $post ) {
			if ( isset( $post->ID ) ) {
				?>
				<div class="smi-shortcode-metabox">
					<p><?php esc_html_e( 'Put this shortcode on your header, footer, sidebar, post or page to render social media icons.', 'social-media-icons' ); ?></p>
					<p><span class="shortcode"><input type="text" value="[social-media-icons id=<?php echo esc_attr( $post->ID ); ?>]" onfocus="this.select();" readonly="readonly" /></span></p>
				</div>
				<?php
			}
		}

		/**
		 * Meta box for icon settings.
		 *
		 * @param WP_Post $post Current post object.
		 */
		public static function smi_metabox_callback( $post ) {
			wp_nonce_field( 'social_media_icon_metabox', 'social_media_icon_metabox_nonce' );
			$smi_icons             = get_post_meta( $post->ID, 'smi_icons', true );
			$column_gap            = get_post_meta( $post->ID, 'smi_column_gap', true );
			$row_gap               = get_post_meta( $post->ID, 'smi_row_gap', true );
			$font_size             = get_post_meta( $post->ID, 'smi_font_size', true );
			$icons_color           = get_post_meta( $post->ID, 'smi_icons_color', true );
			$hover_color           = get_post_meta( $post->ID, 'smi_hover_color', true );
			$icons_bg_color        = get_post_meta( $post->ID, 'smi_icons_bg_color', true );
			$icons_bg_hover_color  = get_post_meta( $post->ID, 'smi_icons_bg_hover_color', true );
			$border_width          = get_post_meta( $post->ID, 'smi_border_width', true );
			$border_color          = get_post_meta( $post->ID, 'smi_border_color', true );
			$border_hover_color    = get_post_meta( $post->ID, 'smi_border_hover_color', true );
			$border_radius         = get_post_meta( $post->ID, 'smi_border_radius', true );
			$padding_top           = get_post_meta( $post->ID, 'smi_padding_top', true );
			$padding_right         = get_post_meta( $post->ID, 'smi_padding_right', true );
			$padding_bottom        = get_post_meta( $post->ID, 'smi_padding_bottom', true );
			$padding_left          = get_post_meta( $post->ID, 'smi_padding_left', true );
			$horizontal_alignment  = get_post_meta( $post->ID, 'smi_horizontal_alignment', true );
			$hover_transition_time = get_post_meta( $post->ID, 'smi_hover_transition_time', true );
			$link_target           = get_post_meta( $post->ID, 'smi_link_target', true );
			$show_tooltip_label    = get_post_meta( $post->ID, 'smi_show_tooltip_label', true );
			$rel_attr              = get_post_meta( $post->ID, 'smi_rel_attr', true );
			$vertical_layout       = get_post_meta( $post->ID, 'smi_vertical_layout', true );
			?>
			<div class="smi-preview">
				<style type="text/css">
					.smi-preview .smi-preview-wrapper {
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
				<h3 class="preview-title"><?php esc_html_e( 'Icons Preview: ', 'social-media-icons' ); ?></h3>
				<span><?php esc_html_e( '(Icons preview would be display after add icons.)', 'social-media-icons' ); ?></span>
				<div class="smi-preview-wrapper">
					<ul>
						<?php
						if ( is_array( $smi_icons ) && count( $smi_icons ) > 0 ) {
							foreach ( $smi_icons as $key => $smi_icon ) {
								if ( isset( $smi_icon['icon'] ) && '' !== $smi_icon['icon'] ) {
									if ( isset( $smi_icon['icon_type'] ) && 'icon' === $smi_icon['icon_type'] ) {
										?>
										<li data-id="<?php echo esc_attr( $key ); ?>" title="<?php echo esc_attr( '1' === $show_tooltip_label ? ( '' !== $smi_icon['label'] ? $smi_icon['label'] : '' ) : '' ); ?>">
											<i class="<?php echo esc_attr( $smi_icon['icon'] ); ?>"></i>
										</li>
										<?php
									} else {
										?>
										<li class="icon-image" data-id="<?php echo esc_attr( $key ); ?>" title="<?php echo esc_attr( '1' === $show_tooltip_label ? ( '' !== $smi_icon['label'] ? $smi_icon['label'] : '' ) : '' ); ?>">
											<img src="<?php echo esc_url( $smi_icon['icon'] ); ?>">
										</li>
										<?php
									}
								}
							}
						}
						?>
					</ul>
				</div>
			</div>
			<hr>
			<div class="smi-metabox">
				<h3><?php esc_html_e( 'Icons :', 'social-media-icons' ); ?></h3>
				<div class="field-group">
					<div class="multi-field-container">
						<?php
						if ( is_array( $smi_icons ) && count( $smi_icons ) > 0 ) {
							foreach ( $smi_icons as $key => $smi_icon ) {
								self::add_social_icon_group( $smi_icon, $key );
							}
						}
						?>
					</div>
					<div class="smi-add-icon button" data-nonce="<?php echo esc_attr( wp_create_nonce( 'smi_add_icon_nonce' ) ); ?>"><?php esc_html_e( 'Add Icon', 'social-media-icons' ); ?></div>
					<?php require_once SOCIAL_MEDIA_ICONS_DIR . 'social-media-icons.php'; ?>
				</div>
				<hr>
				<h3><?php esc_html_e( 'General Settings', 'social-media-icons' ); ?></h3>
				<div class="smi-group-wrapper">
					<div class="field-group">
						<label for="smi_link_target"><?php esc_html_e( 'Open link in new tab:', 'social-media-icons' ); ?></label>
						<div class="input-checkbox">
							<input type="checkbox" name="smi_link_target" id="smi_link_target" value="1" <?php echo esc_attr( checked( $link_target, 1 ) ); ?> ><label><?php esc_html_e( 'Yes', 'social-media-icons' ); ?></label>
						</div>
					</div>
					<div class="field-group">
						<label for="smi_show_tooltip_label"><?php esc_html_e( 'Display Icons Tooltip Label:', 'social-media-icons' ); ?></label>
						<div class="input-checkbox">
							<input type="checkbox" name="smi_show_tooltip_label" id="smi_show_tooltip_label" value="1" <?php echo esc_attr( checked( $show_tooltip_label, 1 ) ); ?> ><label><?php esc_html_e( 'Yes', 'social-media-icons' ); ?></label>
						</div>
					</div>
					<div class="field-group">
						<label for="smi_rel_attr"><?php esc_html_e( 'Add rel attribute to links:', 'social-media-icons' ); ?></label>
						<input type="text" name="smi_rel_attr" id="smi_rel_attr" value="<?php echo esc_attr( '' !== $rel_attr ? $rel_attr : '' ); ?>">
						<span class="smi-full-width"><?php esc_html_e( '(Ex.: nofollow noreferrer noopener)', 'social-media-icons' ); ?></span>
					</div>
					<div class="field-group">
						<label for="smi_vertical_layout"><?php esc_html_e( 'Vertical Layout:', 'social-media-icons' ); ?></label>
						<div class="input-checkbox">
							<input type="checkbox" name="smi_vertical_layout" id="smi_vertical_layout" value="1" <?php echo esc_attr( checked( $vertical_layout, 1 ) ); ?> ><label><?php esc_html_e( 'Yes', 'social-media-icons' ); ?></label>
						</div>
					</div>
				</div>
				<hr>
				<h3><?php esc_html_e( 'Icon Style', 'social-media-icons' ); ?></h3>
				<div class="smi-group-wrapper">
					<div class="field-group alignment-option">
						<label><?php esc_html_e( 'Alignment:', 'social-media-icons' ); ?></label>
						<div class="vertical-input" title="<?php esc_html_e( 'Left', 'social-media-icons' ); ?>">
							<input type="radio" name="smi_horizontal_alignment" value="flex-start" <?php checked( $horizontal_alignment, 'flex-start' ); ?> class="smi_horizontal_alignment" />
							<label><i class="fa fa-align-left"></i></label>
						</div>
						<div class="vertical-input" title="<?php esc_html_e( 'Center', 'social-media-icons' ); ?>">
							<input type="radio" name="smi_horizontal_alignment" value="center" <?php echo esc_attr( '' === $horizontal_alignment ? 'checked' : '' ); ?><?php checked( $horizontal_alignment, 'center' ); ?> class="smi_horizontal_alignment" />
							<label><i class="fa fa-align-center"></i></label>
						</div>
						<div class="vertical-input" title="<?php esc_html_e( 'Right', 'social-media-icons' ); ?>">
							<input type="radio" name="smi_horizontal_alignment" value="flex-end" <?php checked( $horizontal_alignment, 'flex-end' ); ?> class="smi_horizontal_alignment" />
							<label><i class="fa fa-align-right"></i></label>
						</div>
					</div>
					<div class="field-group">
						<label for="smi_font_size"><?php esc_html_e( 'Icon Size:', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_font_size" id="smi_font_size" value="<?php echo esc_attr( '' !== $font_size ? $font_size : '30' ); ?>" min="0" max="100">
						<span><?php esc_html_e( '(Px)', 'social-media-icons' ); ?></span>
					</div>
					<div class="field-group">
						<label for="smi_column_gap"><?php esc_html_e( 'Column Gap:', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_column_gap" id="smi_column_gap" value="<?php echo esc_attr( '' !== $column_gap ? $column_gap : '10' ); ?>" min="0" max="200">
						<span><?php esc_html_e( '(Horizontal Space Between Icons)', 'social-media-icons' ); ?></span>
					</div>
					<div class="field-group">
						<label for="smi_row_gap"><?php esc_html_e( 'Row Gap:', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_row_gap" id="smi_row_gap" value="<?php echo esc_attr( '' !== $row_gap ? $row_gap : '15' ); ?>" min="0" max="200">
						<span><?php esc_html_e( '(Vertical Space Between Icons)', 'social-media-icons' ); ?></span>
					</div>
					<div class="field-group">
						<label for="smi_icons_color"><?php esc_html_e( 'Icons Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_icons_color" id="smi_icons_color"  value="<?php echo esc_attr( '' !== $icons_color ? $icons_color : '#3c434a' ); ?>"/>
					</div>
					<div class="field-group">
						<label for="smi_hover_color"><?php esc_html_e( 'Icons Hover Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_hover_color" id="smi_hover_color"  value="<?php echo esc_attr( '' !== $hover_color ? $hover_color : '#7b7b7b' ); ?>"/>
					</div>
					<div class="field-group">
						<label for="smi_icons_bg_color"><?php esc_html_e( 'Icons Background Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_icons_bg_color" id="smi_icons_bg_color"  value="<?php echo esc_attr( '' !== $icons_bg_color ? $icons_bg_color : '' ); ?>"/>
					</div>
					<div class="field-group">
						<label for="smi_icons_bg_hover_color"><?php esc_html_e( 'Icons Background Hover Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_icons_bg_hover_color" id="smi_icons_bg_hover_color"  value="<?php echo esc_attr( '' !== $icons_bg_hover_color ? $icons_bg_hover_color : '' ); ?>"/>
					</div>
					<div class="field-group">
						<label><?php esc_html_e( 'Padding:', 'social-media-icons' ); ?></label>
						<div class="vertical-input">
							<label for="smi_padding_top"><?php esc_html_e( 'Top', 'social-media-icons' ); ?></label>
							<input type="number" name="smi_padding_top" id="smi_padding_top"  value="<?php echo esc_attr( '' !== $padding_top ? $padding_top : '5' ); ?>" min="0" max="100"/>
						</div>
						<div class="vertical-input">
							<label for="smi_padding_right"><?php esc_html_e( 'Right', 'social-media-icons' ); ?></label>
							<input type="number" name="smi_padding_right" id="smi_padding_right"  value="<?php echo esc_attr( '' !== $padding_right ? $padding_right : '5' ); ?>" min="0" max="100"/>
						</div>
						<div class="vertical-input">
						<label for="smi_padding_bottom"><?php esc_html_e( 'Bottom', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_padding_bottom" id="smi_padding_bottom"  value="<?php echo esc_attr( '' !== $padding_bottom ? $padding_bottom : '5' ); ?>" min="0" max="100"/>
						</div>
						<div class="vertical-input">
							<label for="smi_padding_left"><?php esc_html_e( 'Left', 'social-media-icons' ); ?></label>
							<input type="number" name="smi_padding_left" id="smi_padding_left"  value="<?php echo esc_attr( '' !== $padding_left ? $padding_left : '5' ); ?>" min="0" max="100"/>
						</div>
					</div>
					<div class="field-group">
						<label for="smi_border_width"><?php esc_html_e( 'Border Width:', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_border_width" id="smi_border_width"  value="<?php echo esc_attr( '' !== $border_width ? $border_width : '0' ); ?>" min="0" max="100"/>
					</div>
					<div class="field-group">
						<label for="smi_border_color"><?php esc_html_e( 'Border Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_border_color" id="smi_border_color"  value="<?php echo esc_attr( '' !== $border_color ? $border_color : '#3c434a' ); ?>"/>
					</div>
					<div class="field-group">
						<label for="smi_border_hover_color"><?php esc_html_e( 'Border Hover Color:', 'social-media-icons' ); ?></label>
						<input class="smi-color-field" type="text" name="smi_border_hover_color" id="smi_border_hover_color"  value="<?php echo esc_attr( '' !== $border_hover_color ? $border_hover_color : '#3c434a' ); ?>"/>
					</div>
					<div class="field-group">
						<label for="smi_border_radius"><?php esc_html_e( 'Icon Shape (Border Radius):', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_border_radius" id="smi_border_radius"  value="<?php echo esc_attr( '' !== $border_radius ? $border_radius : '0' ); ?>" min="0" max="100" />
						<span><?php esc_html_e( '(%)', 'social-media-icons' ); ?></span>
						<span class="smi-full-width"><?php esc_html_e( 'Most preferable shapes, 50% for round and 0% for square shape', 'social-media-icons' ); ?></span>
					</div>
					<div class="field-group">
						<label for="smi_hover_transition_time"><?php esc_html_e( 'Hover Transition Time:', 'social-media-icons' ); ?></label>
						<input type="number" name="smi_hover_transition_time" id="smi_hover_transition_time"  value="<?php echo esc_attr( '' !== $hover_transition_time ? $hover_transition_time : '1' ); ?>" step="0.1" min="0" max="10" />
						<span><?php esc_html_e( '(In Seconds)', 'social-media-icons' ); ?></span>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Function to handle add_meta_boxes action.
		 * Add meta box.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 */
		public static function smi_add_icon() {
			if ( ! wp_verify_nonce( isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '', 'smi_add_icon_nonce' ) ) {
				die();
			}
			self::add_social_icon_group( array(), isset( $_REQUEST['counter'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['counter'] ) ) : 0 );
			die();
		}

		/**
		 * Function to add social icon group html.
		 *
		 * @since 1.0.0
		 * @static
		 * @access public
		 *
		 * @param Array   $smi_icon Icon details as array.
		 * @param Integer $counter Counter as integer.
		 */
		public static function add_social_icon_group( $smi_icon = array(), $counter = 0 ) {
			?>
			<div class="multi-field-group" data-count="<?php echo esc_attr( $counter ); ?>">
				<div class="icon-selection-field">
					<div class="icon-preview"> 
						<?php
						if ( isset( $smi_icon['icon'] ) && '' !== $smi_icon['icon'] ) {
							if ( isset( $smi_icon['icon_type'] ) && 'image' !== $smi_icon['icon_type'] ) {
								?>
								<i class="<?php echo esc_html( $smi_icon['icon'] ); ?>"></i>
								<?php
							} else {
								?>
								<img src="<?php echo esc_url( $smi_icon['icon'] ); ?>">
								<?php
							}
						}
						?>
					</div>
					<div class="input-field">
						<button class="smi-select-icon"><?php esc_html_e( 'Select Icon', 'social-media-icons' ); ?></button>
						<span><?php esc_html_e( 'OR', 'social-media-icons' ); ?></span>
						<button class="smi-upload-icon-img"><?php esc_html_e( 'Upload Icon Image', 'social-media-icons' ); ?>
						</button>
						<input type="hidden" name="smi_icons[<?php echo esc_attr( $counter ); ?>][icon]" class="smi-icon" value='<?php echo esc_attr( isset( $smi_icon['icon'] ) ? $smi_icon['icon'] : '' ); ?>'>
					</div>
					<input type="hidden" name="smi_icons[<?php echo esc_attr( $counter ); ?>][icon_type]" value="<?php echo esc_attr( isset( $smi_icon['icon_type'] ) ? $smi_icon['icon_type'] : '' ); ?>" class="icon-type">
				</div>
				<div class="input-field">
					<input type="url" name="smi_icons[<?php echo esc_attr( $counter ); ?>][url]" placeholder="<?php esc_attr_e( 'Url', 'social-media-icons' ); ?>" value="<?php echo esc_attr( isset( $smi_icon['url'] ) ? $smi_icon['url'] : '' ); ?>">
				</div>
				<div class="input-field">
					<input type="text" name="smi_icons[<?php echo esc_attr( $counter ); ?>][label]" placeholder="<?php esc_attr_e( 'Icon Label', 'social-media-icons' ); ?>" value="<?php echo esc_attr( isset( $smi_icon['label'] ) ? $smi_icon['label'] : '' ); ?>">
				</div>
				<div class="input-field smi-remove-icon">
					<i class="fa fa-remove" title="<?php esc_attr_e( 'Remove Icon', 'social-media-icons' ); ?>"></i>
				</div>
			</div>
			<?php
		}

		/**
		 * Function to handle save_post action
		 * Save meta box content.
		 *
		 * @param int $post_id Post ID.
		 */
		public static function smi_save_meta_box( $post_id ) {

			if ( ! isset( $_POST['social_media_icon_metabox_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['social_media_icon_metabox_nonce'] ) ), 'social_media_icon_metabox' ) ) {
				return;
			}

			update_post_meta( $post_id, 'smi_icons', ( isset( $_POST['smi_icons'] ) && is_array( $_POST['smi_icons'] ) ) ? array_values( $_POST['smi_icons'] ) : array() ); /* phpcs:ignore */
			update_post_meta( $post_id, 'smi_column_gap', isset( $_POST['smi_column_gap'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_column_gap'] ) ) : '' );
			update_post_meta( $post_id, 'smi_row_gap', isset( $_POST['smi_row_gap'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_row_gap'] ) ) : '' );
			update_post_meta( $post_id, 'smi_font_size', isset( $_POST['smi_font_size'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_font_size'] ) ) : '' );
			update_post_meta( $post_id, 'smi_icons_color', isset( $_POST['smi_icons_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_icons_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_hover_color', isset( $_POST['smi_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_hover_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_icons_bg_color', isset( $_POST['smi_icons_bg_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_icons_bg_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_icons_bg_hover_color', isset( $_POST['smi_icons_bg_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_icons_bg_hover_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_border_width', isset( $_POST['smi_border_width'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_border_width'] ) ) : '' );
			update_post_meta( $post_id, 'smi_border_color', isset( $_POST['smi_border_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_border_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_border_hover_color', isset( $_POST['smi_border_hover_color'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_border_hover_color'] ) ) : '' );
			update_post_meta( $post_id, 'smi_border_radius', isset( $_POST['smi_border_radius'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_border_radius'] ) ) : '' );
			update_post_meta( $post_id, 'smi_padding_top', isset( $_POST['smi_padding_top'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_padding_top'] ) ) : '' );
			update_post_meta( $post_id, 'smi_padding_right', isset( $_POST['smi_padding_right'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_padding_right'] ) ) : '' );
			update_post_meta( $post_id, 'smi_padding_bottom', isset( $_POST['smi_padding_bottom'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_padding_bottom'] ) ) : '' );
			update_post_meta( $post_id, 'smi_padding_left', isset( $_POST['smi_padding_left'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_padding_left'] ) ) : '' );
			update_post_meta( $post_id, 'smi_horizontal_alignment', isset( $_POST['smi_horizontal_alignment'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_horizontal_alignment'] ) ) : '' );
			update_post_meta( $post_id, 'smi_hover_transition_time', isset( $_POST['smi_hover_transition_time'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_hover_transition_time'] ) ) : '' );
			update_post_meta( $post_id, 'smi_link_target', isset( $_POST['smi_link_target'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_link_target'] ) ) : '' );
			update_post_meta( $post_id, 'smi_show_tooltip_label', isset( $_POST['smi_show_tooltip_label'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_show_tooltip_label'] ) ) : '' );
			update_post_meta( $post_id, 'smi_rel_attr', isset( $_POST['smi_rel_attr'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_rel_attr'] ) ) : '' );
			update_post_meta( $post_id, 'smi_vertical_layout', isset( $_POST['smi_vertical_layout'] ) ? sanitize_text_field( wp_unslash( $_POST['smi_vertical_layout'] ) ) : '' );
		}
	}

	/**
	 * Call init function to activate hooks and filters.
	 */
	Social_Media_Icons_Metabox::init();
}
