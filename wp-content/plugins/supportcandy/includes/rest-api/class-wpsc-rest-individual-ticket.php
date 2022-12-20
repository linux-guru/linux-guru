<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_REST_Individual_Ticket' ) ) :

	final class WPSC_REST_Individual_Ticket {

		/**
		 * Array of ticket slugs which we do not want to expose to REST API
		 *
		 * @var array
		 */
		public static $prevent_data = array();

		/**
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {

			add_action( 'wpsc_rest_load_ticket_prevent_data', array( __CLASS__, 'load_prevent_data' ) );
		}

		/**
		 * Load prevent data
		 *
		 * @return void
		 */
		public static function load_prevent_data() {

			$current_user = WPSC_Current_User::$current_user;
			$data = ! $current_user->is_agent ? array( 'ip_address', 'source', 'browser', 'os', 'user_type' ) : array();
			self::$prevent_data = apply_filters( 'wpsc_rest_prevent_ticket_data', $data );
		}

		/**
		 * Modify ticket response data appropreate for client side
		 *
		 * @param array $ticket - ticket response array.
		 * @return array
		 */
		public static function modify_response( $ticket ) {

			$current_user = WPSC_Current_User::$current_user;

			foreach ( $ticket as $slug => $value ) {

				// remove prevent ticket data.
				if ( in_array( $slug, self::$prevent_data ) ) {
					unset( $ticket[ $slug ] );
					continue;
				}

				// ignore agentonly fields for non-agent.
				$cf = WPSC_Custom_Field::get_cf_by_slug( $slug );
				if ( ! $current_user->is_agent && $cf && $cf->field == 'agentonly' ) {
					unset( $ticket[ $slug ] );
					continue;
				}

				// convert has multiple values to array.
				if ( WPSC_Ticket::$schema[ $slug ]['has_multiple_val'] ) {
					if ( $value ) {
						$ticket[ $slug ] = array_filter(
							array_map(
								fn( $val) => is_numeric( $val ) ? intval( $val ) : $val,
								explode( '|', $value )
							)
						);
					} else {
						$ticket[ $slug ] = array();
					}
					continue;
				}

				// empty date value.
				if ( $value == '0000-00-00 00:00:00' ) {
					$ticket[ $slug ] = '';
				}

				// cast numeric fields into integer.
				if ( is_numeric( $value ) ) {
					$ticket[ $slug ] = intval( $value );
				}
			}

			return apply_filters( 'wpsc_rest_modify_ticket_response', $ticket );
		}
	}
endif;

WPSC_REST_Individual_Ticket::init();
