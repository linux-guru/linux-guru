<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       miniorange
 * @since      1.0.0
 *
 * @package    Miniorange_Api_Authentication
 * @subpackage Miniorange_Api_Authentication/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Miniorange_Api_Authentication
 * @subpackage Miniorange_Api_Authentication/includes
 * @author     miniOrange 
 */
class Miniorange_Api_Authentication_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'miniorange-api-authentication',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
