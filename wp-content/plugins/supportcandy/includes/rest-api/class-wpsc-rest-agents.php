<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_REST_Agents' ) ) :

	final class WPSC_REST_Agents {

		/**
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {

			add_action( 'wpsc_rest_register_routes', array( __CLASS__, 'register_routes' ) );
		}

		/**
		 * Register routes
		 *
		 * @return void
		 */
		public static function register_routes() {

			// list categories.
			register_rest_route(
				'supportcandy/v2',
				'/agents',
				array(
					'methods'             => 'GET',
					'callback'            => array( __CLASS__, 'get_agents' ),
					'args'                => array(
						'secret_key' => array(
							'required'          => true,
							'validate_callback' => array( 'WPSC_REST_API', 'validate_secret_key' ),
						),
						'search'     => array(
							'default'           => '',
							'sanitize_callback' => 'sanitize_text_field',
						),
					),
					'permission_callback' => 'is_user_logged_in',
				),
			);

			// list individual category.
			register_rest_route(
				'supportcandy/v2',
				'/agents/(?P<id>\d+)',
				array(
					'methods'             => 'GET',
					'callback'            => array( __CLASS__, 'get_individual_agent' ),
					'args'                => array(
						'secret_key' => array(
							'required'          => true,
							'validate_callback' => array( 'WPSC_REST_API', 'validate_secret_key' ),
						),
						'id'         => array(
							'validate_callback' => array( __CLASS__, 'validate_id' ),
						),
					),
					'permission_callback' => 'is_user_logged_in',
				),
			);
		}

		/**
		 * Agengs collection
		 *
		 * @param WP_REST_Request $request - request object.
		 * @return WP_Error|WP_REST_Response
		 */
		public static function get_agents( $request ) {

			$search = $request->get_param( 'search' );
			$agents = WPSC_Agent::find(
				array(
					'items_per_page' => 0,
					'search'         => $search,
					'meta_query'     => array(
						'relation' => 'AND',
						array(
							'slug'    => 'is_active',
							'compare' => '=',
							'val'     => 1,
						),
					),
				)
			)['results'];
			$data = array();
			foreach ( $agents as $agent ) {
				$data[] = self::modify_response( $agent );
			}
			return new WP_REST_Response( $data, 200 );
		}

		/**
		 * Single agent
		 *
		 * @param WP_REST_Request $request - request object.
		 * @return WP_Error|WP_REST_Response
		 */
		public static function get_individual_agent( $request ) {

			$agent = new WPSC_Agent( $request->get_param( 'id' ) );
			$data = self::modify_response( $agent );
			return new WP_REST_Response( $data, 200 );
		}

		/**
		 * Modify response data appropreate for client side
		 *
		 * @param array $agent - response array.
		 * @return array
		 */
		public static function modify_response( $agent ) {

			return array(
				'id'               => intval( $agent->id ),
				'name'             => $agent->name,
				'unresolved_count' => intval( $agent->unresolved_count ),
				'is_agentgroup'    => intval( $agent->is_agentgroup ),
			);
		}

		/**
		 * Validate id
		 *
		 * @param string          $param - parameter value.
		 * @param WP_REST_Request $request - request object.
		 * @param string          $key - filter key.
		 * @return boolean
		 */
		public static function validate_id( $param, $request, $key ) {

			$error = new WP_Error( 'invalid_id', 'Invalid agent id', array( 'status' => 400 ) );
			$agent = new WPSC_Agent( $param );
			return $agent->id ? true : $error;
		}
	}
endif;

WPSC_REST_Agents::init();
