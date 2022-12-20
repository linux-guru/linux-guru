<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_GS_Thankyou_Page_Settings' ) ) :

	final class WPSC_GS_Thankyou_Page_Settings {

		/**
		 *
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {

			// User interface.
			add_action( 'wp_ajax_wpsc_get_gs_thankyou', array( __CLASS__, 'load_settings_ui' ) );
			add_action( 'wp_ajax_wpsc_set_gs_thankyou', array( __CLASS__, 'save_settings' ) );
			add_action( 'wp_ajax_wpsc_reset_gs_thankyou', array( __CLASS__, 'reset_settings' ) );
		}

		/**
		 * Reset settings
		 *
		 * @return void
		 */
		public static function reset() {

			$wpsc_thankyou_html = '<p>Thanks for reaching out, we\'ve received your request!</p><p>{{ticket_url}}</p>';
			$thank_you_page_settings = apply_filters(
				'wpsc_gs_thank_you_page_settings',
				array(
					'thankyou-html'      => $wpsc_thankyou_html,
					'thank-you-page-url' => '',
					'editor'             => 'html',
				)
			);
			update_option( 'wpsc-gs-thankyou-page-settings', $thank_you_page_settings );
			WPSC_Translations::remove( 'wpsc-thankyou-html', $thank_you_page_settings['thankyou-html'] );
		}

		/**
		 * Settings user interface
		 *
		 * @return void
		 */
		public static function load_settings_ui() {

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}
			$settings = get_option( 'wpsc-gs-thankyou-page-settings', array() );?>

			<form action="#" onsubmit="return false;" class="wpsc-frm-gs-thankyoupage">
				<div class="wpsc-dock-container">
					<?php
					printf(
						/* translators: Click here to see the documentation */
						esc_attr__( '%s to see the documentation!', 'supportcandy' ),
						'<a href="https://supportcandy.net/docs/thank-you-page/" target="_blank">' . esc_attr__( 'Click here', 'supportcandy' ) . '</a>'
					);
					?>
				</div>
				<div class="wpsc-input-group">
					<div class="label-container">
						<label for=""><?php esc_attr_e( 'Thank you text', 'supportcandy' ); ?></label>
					</div>
					<div class = "textarea-container ">
						<div class = "wpsc_tinymce_editor_btns">
							<div class="inner-container">
								<button class="visual wpsc-switch-editor <?php echo $settings['editor'] == 'html' ? 'active' : ''; ?>" type="button" onclick="wpsc_get_tinymce(this, 'thankyou-html','thankyou_body');"><?php esc_attr_e( 'Visual', 'supportcandy' ); ?></button>
								<button class="text wpsc-switch-editor <?php echo $settings['editor'] == 'text' ? 'active' : ''; ?>" type="button" onclick="wpsc_get_textarea(this, 'thankyou-html')"><?php esc_attr_e( 'Text', 'supportcandy' ); ?></button>
							</div>
						</div>
						<?php
						$thank_you = $settings['thankyou-html'] ? WPSC_Translations::get( 'wpsc-thankyou-html', stripslashes( $settings['thankyou-html'] ) ) : stripslashes( $settings['thankyou-html'] );
						?>
						<textarea name="thankyou-html" id="thankyou-html" class="wpsc_textarea"><?php echo wp_kses_post( $thank_you ); ?></textarea>
						<div class="wpsc-it-editor-action-container">
							<div class="actions">
								<div class="wpsc-editor-actions">
									<span onclick="wpsc_get_macros()"><?php esc_attr_e( 'Insert Macro', 'supportcandy' ); ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>

					<?php
					if ( $settings['editor'] == 'html' ) {
						?>
						jQuery('.wpsc-switch-editor.visual').trigger('click');
						<?php
					}
					?>

					function wpsc_get_tinymce(el, selector, body_id){
						jQuery(el).parent().find('.text').removeClass('active');
						jQuery(el).addClass('active');
						tinymce.remove('#'+selector);
						tinymce.init({ 
							selector:'#'+selector,
							body_id: body_id,
							menubar: false,
							statusbar: false,
							height : '200',
							plugins: [
							'lists link image directionality'
							],
							image_advtab: true,
							toolbar: 'bold italic underline blockquote | alignleft aligncenter alignright | bullist numlist | rtl | link image',
							directionality: '<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>',
							branding: false,
							autoresize_bottom_margin: 20,
							browser_spellcheck : true,
							relative_urls : false,
							remove_script_host : false,
							convert_urls : true,
							setup: function (editor) {
							}
						});
						jQuery('#editor').val('html');
					}

					function wpsc_get_textarea(el, selector){
						jQuery(el).parent().find('.visual').removeClass('active');
						jQuery(el).addClass('active');
						tinymce.remove('#'+selector);
						jQuery('#editor').val('text');
					}

				</script>
				<div class="wpsc-input-group">
					<div class="label-container">
						<label for=""><?php esc_attr_e( 'Thank you page url (optional)', 'supportcandy' ); ?></label>
					</div>
					<input type="text" name="thank-you-page-url" value="<?php echo esc_url( $settings['thank-you-page-url'] ); ?>" autocomplete="off"/>
				</div>
				<?php do_action( 'wpsc_gs_thankyou_page' ); ?>
				<input type="hidden" name="action" value="wpsc_set_gs_thankyou">
				<input id="editor" type="hidden" name="editor" value="<?php echo esc_attr( $settings['editor'] ); ?>">
				<input type="hidden" name="_ajax_nonce" value="<?php echo esc_attr( wp_create_nonce( 'wpsc_set_gs_thankyou' ) ); ?>">
			</form>

			<div class="setting-footer-actions">
				<button 
					class="wpsc-button normal primary margin-right"
					onclick="wpsc_set_gs_thankyou(this);">
					<?php esc_attr_e( 'Submit', 'supportcandy' ); ?></button>
				<button 
					class="wpsc-button normal secondary"
					onclick="wpsc_reset_gs_thankyou(this, '<?php echo esc_attr( wp_create_nonce( 'wpsc_reset_gs_thankyou' ) ); ?>');">
					<?php esc_attr_e( 'Reset default', 'supportcandy' ); ?></button>
			</div>
			<?php

			wp_die();
		}

		/**
		 * Save settings
		 *
		 * @return void
		 */
		public static function save_settings() {

			if ( check_ajax_referer( 'wpsc_set_gs_thankyou', '_ajax_nonce', false ) != 1 ) {
				wp_send_json_error( 'Unauthorised request!', 401 );
			}

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}

			$thankyou_page = apply_filters(
				'wpsc_set_gs_thankyou_page',
				array(
					'thankyou-html'      => isset( $_POST ) && isset( $_POST['thankyou-html'] ) ? wp_kses_post( wp_unslash( $_POST['thankyou-html'] ) ) : '',
					'thank-you-page-url' => isset( $_POST['thank-you-page-url'] ) ? sanitize_text_field( wp_unslash( $_POST['thank-you-page-url'] ) ) : '',
					'editor'             => isset( $_POST['editor'] ) ? sanitize_text_field( wp_unslash( $_POST['editor'] ) ) : 'html',
				)
			);
			update_option( 'wpsc-gs-thankyou-page-settings', $thankyou_page );

			// remove string translations.
			WPSC_Translations::remove( 'wpsc-thankyou-html' );

			// add string translations.
			WPSC_Translations::add( 'wpsc-thankyou-html', $thankyou_page['thankyou-html'] );
			wp_die();
		}

		/**
		 * Reset settings to default
		 *
		 * @return void
		 */
		public static function reset_settings() {

			if ( check_ajax_referer( 'wpsc_reset_gs_thankyou', '_ajax_nonce', false ) != 1 ) {
				wp_send_json_error( 'Unauthorised request!', 401 );
			}

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}
			self::reset();
			wp_die();
		}
	}

endif;

WPSC_GS_Thankyou_Page_Settings::init();
