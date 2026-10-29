<?php
/**
 * Whitelabel Customization for GlotPress - Admin Settings
 *
 * @package GlotPress_Whitelabel
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get plugin options with default fallbacks.
 *
 * @return array Sanitized plugin options.
 */
function gp_whitelabel_get_options() {
	$defaults = array(
		'brand_name'            => 'Backcourt Translations',
		'tagline'               => 'Translations',
		'logo_type'             => 'default_svg', // default_svg, custom_image, text_only
		'logo_url'              => '',
		'logo_height'           => '38',
		'color_preset'          => 'backcourt',
		'header_bg'             => '#003E56',
		'header_text'           => '#ffffff',
		'accent_color'          => '#00DBDB',
		'btn_primary_bg'        => '#003E56',
		'btn_primary_text'      => '#ffffff',
		'btn_primary_hover_bg'  => '#00DBDB',
		'btn_primary_hover_text' => '#003E56',
		'footer_powered_by'     => 'Powered by <a rel="nofollow" href="https://www.backcourt.io/">Backcourt Translations</a>',
	);

	$options = get_option( 'gp_whitelabel_options', array() );

	return wp_parse_args( $options, $defaults );
}

/**
 * Register Admin Menu for Whitelabel Settings.
 */
function gp_whitelabel_add_admin_menu() {
	add_options_page(
		__( 'Whitelabel Customization for GlotPress', 'gp-whitelabel' ),
		__( 'GlotPress Whitelabel', 'gp-whitelabel' ),
		'manage_options',
		'gp-whitelabel',
		'gp_whitelabel_render_admin_page'
	);
}
add_action( 'admin_menu', 'gp_whitelabel_add_admin_menu' );

/**
 * Register Plugin Settings.
 */
function gp_whitelabel_register_settings() {
	register_setting(
		'gp_whitelabel_options_group',
		'gp_whitelabel_options',
		'gp_whitelabel_sanitize_options'
	);
}
add_action( 'admin_init', 'gp_whitelabel_register_settings' );

/**
 * Sanitize plugin options.
 *
 * @param array $input Raw input.
 * @return array Sanitized options.
 */
function gp_whitelabel_sanitize_options( $input ) {
	$output = array();

	$output['brand_name']  = isset( $input['brand_name'] ) ? sanitize_text_field( $input['brand_name'] ) : 'Backcourt Translations';
	$output['tagline']     = isset( $input['tagline'] ) ? sanitize_text_field( $input['tagline'] ) : 'Translations';
	$output['logo_type']   = isset( $input['logo_type'] ) && in_array( $input['logo_type'], array( 'default_svg', 'custom_image', 'text_only' ), true ) ? $input['logo_type'] : 'default_svg';
	$output['logo_url']    = isset( $input['logo_url'] ) ? esc_url_raw( $input['logo_url'] ) : '';
	$output['logo_height'] = isset( $input['logo_height'] ) ? absint( $input['logo_height'] ) : 38;

	$output['color_preset']          = isset( $input['color_preset'] ) ? sanitize_key( $input['color_preset'] ) : 'backcourt';
	$output['header_bg']             = isset( $input['header_bg'] ) ? sanitize_hex_color( $input['header_bg'] ) : '#003E56';
	$output['header_text']           = isset( $input['header_text'] ) ? sanitize_hex_color( $input['header_text'] ) : '#ffffff';
	$output['accent_color']          = isset( $input['accent_color'] ) ? sanitize_hex_color( $input['accent_color'] ) : '#00DBDB';
	$output['btn_primary_bg']        = isset( $input['btn_primary_bg'] ) ? sanitize_hex_color( $input['btn_primary_bg'] ) : '#003E56';
	$output['btn_primary_text']      = isset( $input['btn_primary_text'] ) ? sanitize_hex_color( $input['btn_primary_text'] ) : '#ffffff';
	$output['btn_primary_hover_bg']  = isset( $input['btn_primary_hover_bg'] ) ? sanitize_hex_color( $input['btn_primary_hover_bg'] ) : '#00DBDB';
	$output['btn_primary_hover_text'] = isset( $input['btn_primary_hover_text'] ) ? sanitize_hex_color( $input['btn_primary_hover_text'] ) : '#003E56';

	$output['footer_powered_by'] = isset( $input['footer_powered_by'] ) ? wp_kses_post( $input['footer_powered_by'] ) : '';

	return $output;
}

/**
 * Enqueue scripts and styles for the admin customizer page.
 *
 * @param string $hook Page hook suffix.
 */
function gp_whitelabel_admin_scripts( $hook ) {
	if ( 'settings_page_glotpress-whitelabel' !== $hook ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'gp_whitelabel_admin_scripts' );

/**
 * Render the Admin Settings Customizer Page.
 */
function gp_whitelabel_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$options = gp_whitelabel_get_options();
	?>
	<div class="wrap gp-whitelabel-admin-wrap">
		<h1><?php esc_html_e( 'Whitelabel Customization for GlotPress Settings', 'gp-whitelabel' ); ?></h1>
		<p class="description"><?php esc_html_e( 'Customize your GlotPress installation logo, brand identity, and color scheme.', 'gp-whitelabel' ); ?></p>

		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'gp_whitelabel_options_group' );
			?>

			<div class="gp-whitelabel-card" style="background: #fff; padding: 20px 24px; border: 1px solid #ccd0d4; border-radius: 8px; margin-top: 20px; max-width: 800px;">
				<h2><?php esc_html_e( 'Branding & Logo', 'gp-whitelabel' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="brand_name"><?php esc_html_e( 'Brand Title', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="brand_name" name="gp_whitelabel_options[brand_name]" value="<?php echo esc_attr( $options['brand_name'] ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'Displayed in browser tab title and main header home link.', 'gp-whitelabel' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="tagline"><?php esc_html_e( 'Header Tagline', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="tagline" name="gp_whitelabel_options[tagline]" value="<?php echo esc_attr( $options['tagline'] ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'Sub-text displayed beneath logo/wordmark (e.g. "Translations" or "Localization Portal").', 'gp-whitelabel' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Logo Display Mode', 'gp-whitelabel' ); ?></th>
						<td>
							<fieldset>
								<label><input type="radio" name="gp_whitelabel_options[logo_type]" value="default_svg" <?php checked( $options['logo_type'], 'default_svg' ); ?> /> <?php esc_html_e( 'Default Backcourt Vector SVG Logo', 'gp-whitelabel' ); ?></label><br>
								<label><input type="radio" name="gp_whitelabel_options[logo_type]" value="custom_image" <?php checked( $options['logo_type'], 'custom_image' ); ?> /> <?php esc_html_e( 'Custom Uploaded Image Logo', 'gp-whitelabel' ); ?></label><br>
								<label><input type="radio" name="gp_whitelabel_options[logo_type]" value="text_only" <?php checked( $options['logo_type'], 'text_only' ); ?> /> <?php esc_html_e( 'Text-Only Brand Name', 'gp-whitelabel' ); ?></label>
							</fieldset>
						</td>
					</tr>
					<tr id="row-custom-logo" style="<?php echo 'custom_image' === $options['logo_type'] ? '' : 'display:none;'; ?>">
						<th scope="row"><label for="logo_url"><?php esc_html_e( 'Custom Logo Image', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="logo_url" name="gp_whitelabel_options[logo_url]" value="<?php echo esc_url( $options['logo_url'] ); ?>" class="regular-text" />
							<button type="button" class="button button-secondary" id="btn-upload-logo"><?php esc_html_e( 'Upload / Select Image', 'gp-whitelabel' ); ?></button>
							<div id="logo-preview-wrap" style="margin-top: 10px;">
								<?php if ( ! empty( $options['logo_url'] ) ) : ?>
									<img id="logo-preview" src="<?php echo esc_url( $options['logo_url'] ); ?>" style="max-height: 50px; width: auto; background: #003E56; padding: 6px; border-radius: 4px;" />
								<?php endif; ?>
							</div>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="logo_height"><?php esc_html_e( 'Logo Height (px)', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="number" id="logo_height" name="gp_whitelabel_options[logo_height]" value="<?php echo esc_attr( $options['logo_height'] ); ?>" min="16" max="120" class="small-text" /> px
						</td>
					</tr>
				</table>
			</div>

			<div class="gp-whitelabel-card" style="background: #fff; padding: 20px 24px; border: 1px solid #ccd0d4; border-radius: 8px; margin-top: 20px; max-width: 800px;">
				<h2><?php esc_html_e( 'Color Schemes & Theme Customizer', 'gp-whitelabel' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="color_preset"><?php esc_html_e( 'Color Preset Palette', 'gp-whitelabel' ); ?></label></th>
						<td>
							<select id="color_preset" name="gp_whitelabel_options[color_preset]">
								<option value="backcourt" <?php selected( $options['color_preset'], 'backcourt' ); ?>><?php esc_html_e( 'Backcourt Classic (Deep Blue & Teal)', 'gp-whitelabel' ); ?></option>
								<option value="midnight_emerald" <?php selected( $options['color_preset'], 'midnight_emerald' ); ?>><?php esc_html_e( 'Midnight Emerald (Navy & Emerald Green)', 'gp-whitelabel' ); ?></option>
								<option value="indigo_amber" <?php selected( $options['color_preset'], 'indigo_amber' ); ?>><?php esc_html_e( 'Indigo & Amber Gold', 'gp-whitelabel' ); ?></option>
								<option value="rose_slate" <?php selected( $options['color_preset'], 'rose_slate' ); ?>><?php esc_html_e( 'Dark Slate & Rose Pink', 'gp-whitelabel' ); ?></option>
								<option value="purple_coral" <?php selected( $options['color_preset'], 'purple_coral' ); ?>><?php esc_html_e( 'Royal Purple & Coral', 'gp-whitelabel' ); ?></option>
								<option value="custom" <?php selected( $options['color_preset'], 'custom' ); ?>><?php esc_html_e( 'Custom Colors', 'gp-whitelabel' ); ?></option>
							</select>
							<p class="description"><?php esc_html_e( 'Selecting a preset automatically fills in the color pickers below.', 'gp-whitelabel' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="header_bg"><?php esc_html_e( 'Header Background', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="header_bg" name="gp_whitelabel_options[header_bg]" value="<?php echo esc_attr( $options['header_bg'] ); ?>" class="color-field" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="header_text"><?php esc_html_e( 'Header Text / Links', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="header_text" name="gp_whitelabel_options[header_text]" value="<?php echo esc_attr( $options['header_text'] ); ?>" class="color-field" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="accent_color"><?php esc_html_e( 'Accent / Highlight Color', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="accent_color" name="gp_whitelabel_options[accent_color]" value="<?php echo esc_attr( $options['accent_color'] ); ?>" class="color-field" />
							<p class="description"><?php esc_html_e( 'Used for active link highlights, tagline, input focus rings, and secondary accents.', 'gp-whitelabel' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="btn_primary_bg"><?php esc_html_e( 'Primary Button / Table Header BG', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="btn_primary_bg" name="gp_whitelabel_options[btn_primary_bg]" value="<?php echo esc_attr( $options['btn_primary_bg'] ); ?>" class="color-field" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="btn_primary_text"><?php esc_html_e( 'Primary Button Text', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="btn_primary_text" name="gp_whitelabel_options[btn_primary_text]" value="<?php echo esc_attr( $options['btn_primary_text'] ); ?>" class="color-field" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="btn_primary_hover_bg"><?php esc_html_e( 'Primary Button Hover BG', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="btn_primary_hover_bg" name="gp_whitelabel_options[btn_primary_hover_bg]" value="<?php echo esc_attr( $options['btn_primary_hover_bg'] ); ?>" class="color-field" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="btn_primary_hover_text"><?php esc_html_e( 'Primary Button Hover Text', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="btn_primary_hover_text" name="gp_whitelabel_options[btn_primary_hover_text]" value="<?php echo esc_attr( $options['btn_primary_hover_text'] ); ?>" class="color-field" />
						</td>
					</tr>
				</table>
			</div>

			<div class="gp-whitelabel-card" style="background: #fff; padding: 20px 24px; border: 1px solid #ccd0d4; border-radius: 8px; margin-top: 20px; max-width: 800px;">
				<h2><?php esc_html_e( 'Footer & Branding Credits', 'gp-whitelabel' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row"><label for="footer_powered_by"><?php esc_html_e( 'Footer "Powered by" Text / Link', 'gp-whitelabel' ); ?></label></th>
						<td>
							<input type="text" id="footer_powered_by" name="gp_whitelabel_options[footer_powered_by]" value="<?php echo esc_attr( $options['footer_powered_by'] ); ?>" class="large-text" />
							<p class="description"><?php esc_html_e( 'Supports HTML (e.g. Powered by <a href="https://example.com">My Brand</a>)', 'gp-whitelabel' ); ?></p>
						</td>
					</tr>
				</table>
			</div>

			<?php submit_button( __( 'Save Whitelabel Settings', 'gp-whitelabel' ) ); ?>
		</form>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Initialize WP Color Pickers
			$('.color-field').wpColorPicker();

			// Toggle Custom Logo Upload Row
			$('input[name="gp_whitelabel_options[logo_type]"]').on('change', function() {
				if ($(this).val() === 'custom_image') {
					$('#row-custom-logo').show();
				} else {
					$('#row-custom-logo').hide();
				}
			});

			// Media Library Logo Upload
			$('#btn-upload-logo').on('click', function(e) {
				e.preventDefault();
				var frame = wp.media({
					title: '<?php echo esc_js( __( 'Select or Upload Logo Image', 'gp-whitelabel' ) ); ?>',
					button: { text: '<?php echo esc_js( __( 'Use this logo', 'gp-whitelabel' ) ); ?>' },
					multiple: false
				});

				frame.on('select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					$('#logo_url').val(attachment.url);
					$('#logo-preview-wrap').html('<img id="logo-preview" src="' + attachment.url + '" style="max-height: 50px; width: auto; background: #003E56; padding: 6px; border-radius: 4px;" />');
				});

				frame.open();
			});

			// Presets Handler
			var presets = {
				'backcourt': {
					'header_bg': '#003E56',
					'header_text': '#ffffff',
					'accent_color': '#00DBDB',
					'btn_primary_bg': '#003E56',
					'btn_primary_text': '#ffffff',
					'btn_primary_hover_bg': '#00DBDB',
					'btn_primary_hover_text': '#003E56'
				},
				'midnight_emerald': {
					'header_bg': '#0f172a',
					'header_text': '#ffffff',
					'accent_color': '#10b981',
					'btn_primary_bg': '#0f172a',
					'btn_primary_text': '#ffffff',
					'btn_primary_hover_bg': '#10b981',
					'btn_primary_hover_text': '#ffffff'
				},
				'indigo_amber': {
					'header_bg': '#1e1b4b',
					'header_text': '#ffffff',
					'accent_color': '#f59e0b',
					'btn_primary_bg': '#4338ca',
					'btn_primary_text': '#ffffff',
					'btn_primary_hover_bg': '#f59e0b',
					'btn_primary_hover_text': '#1e1b4b'
				},
				'rose_slate': {
					'header_bg': '#1e293b',
					'header_text': '#ffffff',
					'accent_color': '#f43f5e',
					'btn_primary_bg': '#1e293b',
					'btn_primary_text': '#ffffff',
					'btn_primary_hover_bg': '#f43f5e',
					'btn_primary_hover_text': '#ffffff'
				},
				'purple_coral': {
					'header_bg': '#2e1065',
					'header_text': '#ffffff',
					'accent_color': '#ff6b6b',
					'btn_primary_bg': '#581c87',
					'btn_primary_text': '#ffffff',
					'btn_primary_hover_bg': '#ff6b6b',
					'btn_primary_hover_text': '#ffffff'
				}
			};

			$('#color_preset').on('change', function() {
				var val = $(this).val();
				if (presets[val]) {
					$.each(presets[val], function(key, hex) {
						$('#' + key).wpColorPicker('color', hex);
					});
				}
			});
		});
	</script>
	<?php
}

