<?php

/**
 * Fired during plugin activation
 *
 * @link       miniorange
 * @since      1.0.0
 *
 * @package    Miniorange_Api_Authentication
 * @subpackage Miniorange_Api_Authentication/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Miniorange_Api_Authentication
 * @subpackage Miniorange_Api_Authentication/includes
 * @author     miniOrange 
 */
class Miniorange_Api_Authentication_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'host_name', 'https://login.xecurify.com' );

		mo_api_authentication_reset_api_protection();

	}

}
