<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_MS_Rest_API' ) ) :

	final class WPSC_MS_Rest_API {

		/**
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {

			// User interface.
			add_action( 'wp_ajax_wpsc_get_ms_rest_api', array( __CLASS__, 'load_settings_ui' ) );
			add_action( 'wp_ajax_wpsc_set_ms_rest_api', array( __CLASS__, 'save_settings' ) );
			add_action( 'wp_ajax_wpsc_reset_ms_rest_api', array( __CLASS__, 'reset_settings' ) );
		}

		/**
		 * Reset settings
		 *
		 * @return void
		 */
		public static function reset() {

			$secret_key = uniqid() . uniqid();
			$rest_api   = apply_filters(
				'wpsc_rest_api_settings',
				array(
					'allow-rest-api'      => '0',
					'rest-api-secret-key' => $secret_key,
				)
			);
			update_option( 'wpsc-rest-api-settings', $rest_api );
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
			$settings = get_option( 'wpsc-rest-api-settings', array() );?>

			<form action="#" onsubmit="return false;" class="wpsc-frm-ms-rest-api">
				<div class="wpsc-input-group">
					<div class="label-container">
						<label for=""><?php esc_attr_e( 'Enable', 'supportcandy' ); ?></label>
					</div>
					<select id="wpsc-allow-rest-api" name="allow-rest-api">
						<option <?php selected( $settings['allow-rest-api'], 1 ); ?> value="1"><?php esc_attr_e( 'Yes', 'supportcandy' ); ?></option>
						<option <?php selected( $settings['allow-rest-api'], 0 ); ?> value="0"><?php esc_attr_e( 'No', 'supportcandy' ); ?></option>
					</select>
				</div>
				<div class="wpsc-input-group">
					<div class="label-container">
						<label for=""><?php esc_attr_e( 'Secret key', 'supportcandy' ); ?></label>
					</div>
					<input type="text" id="wpsc-rest-api-secret-key" name="rest-api-secret-key" value="<?php echo esc_attr( $settings['rest-api-secret-key'] ); ?>">
				</div>   
				<?php do_action( 'wpsc_ms_rest_api' ); ?>
				<input type="hidden" name="action" value="wpsc_set_ms_rest_api">
				<input type="hidden" name="_ajax_nonce" value="<?php echo esc_attr( wp_create_nonce( 'wpsc_set_ms_rest_api' ) ); ?>">
			</form>
			<div class="setting-footer-actions">
				<button 
					class="wpsc-button normal primary margin-right"
					onclick="wpsc_set_ms_rest_api(this);">
					<?php esc_attr_e( 'Submit', 'supportcandy' ); ?></button>
				<button 
					class="wpsc-button normal secondary"
					onclick="wpsc_reset_ms_rest_api(this, '<?php echo esc_attr( wp_create_nonce( 'wpsc_reset_ms_rest_api' ) ); ?>');">
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

			if ( check_ajax_referer( 'wpsc_set_ms_rest_api', '_ajax_nonce', false ) != 1 ) {
				wp_send_json_error( 'Unauthorised request!', 401 );
			}

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}

			$rest_api = apply_filters(
				'wpsc_set_rest_api',
				array(
					'allow-rest-api'      => isset( $_POST['allow-rest-api'] ) ? intval( $_POST['allow-rest-api'] ) : '0',
					'rest-api-secret-key' => isset( $_POST['rest-api-secret-key'] ) ? sanitize_text_field( wp_unslash( $_POST['rest-api-secret-key'] ) ) : '',
				)
			);
			update_option( 'wpsc-rest-api-settings', $rest_api );
			wp_die();
		}

		/**
		 * Reset settings to default
		 *
		 * @return void
		 */
		public static function reset_settings() {

			if ( check_ajax_referer( 'wpsc_reset_ms_rest_api', '_ajax_nonce', false ) != 1 ) {
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

WPSC_MS_Rest_API::init();
