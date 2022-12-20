<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_Ticket_Conditions' ) ) :

	final class WPSC_Ticket_Conditions {

		/**
		 * Conditions list
		 *
		 * @var array
		 */
		public static $conditions = array();

		/**
		 * Ignore custom field types for ticket conditions
		 *
		 * @var array
		 */
		public static $ignore_cft = array();

		/**
		 * Init class
		 */
		public static function init() {

			add_action( 'init', array( __CLASS__, 'load_conditions' ), 11 );
			add_action( 'wp_ajax_wpsc_tc_get_operators', array( __CLASS__, 'get_operators' ) );
			add_action( 'wp_ajax_wpsc_tc_get_operand', array( __CLASS__, 'get_operands' ) );
		}

		/**
		 * Load ticket conditions
		 *
		 * @return void
		 */
		public static function load_conditions() {

			$conditions = array();

			self::$ignore_cft = apply_filters( 'wpsc_ignore_cft_ticket_conditions', array( 'cf_woo_order' ) );

			// custom fields filters.
			foreach ( WPSC_Custom_Field::$custom_fields as $cf ) {

				if ( ! (
					class_exists( $cf->type ) &&
					$cf->type::$is_filter &&
					in_array( $cf->field, array( 'ticket', 'agentonly', 'customer' ) ) &&
					! in_array( $cf->type::$slug, self::$ignore_cft )
				) ) {
					continue;
				}

				$conditions[ 'cf_' . $cf->slug ] = $cf->name;
			}

			// other ticket conditions than custom field.
			$other_conditions = apply_filters(
				'wpsc_ticket_conditions',
				array(
					'submitted_by' => esc_attr__( 'Ticket submitted by', 'supportcandy' ),
					'user_role'    => esc_attr__( 'WP user role', 'supportcandy' ),
				)
			);

			self::$conditions = array_merge( $conditions, $other_conditions );
		}

		/**
		 * Print condition input in the form
		 *
		 * @param string  $relation - relation between conditions (AND/OR).
		 * @param array   $conditions - conditions to preset.
		 * @param array   $ignore_cft - ignore custom field types.
		 * @param boolean $required - condition is required or not.
		 * @return void
		 */
		public static function print_condition_input( $relation = 'AND', $conditions = array(), $ignore_cft = array(), $required = false ) {

			$conditions = $conditions ? json_decode( html_entity_decode( $conditions ), true ) : array();

			?>
			<div class="wpsc-input-group">
				<div class="label-container">
					<label for="">
						<?php
						echo esc_attr( wpsc__( 'Conditions', 'supportcandy' ) );
						if ( $required ) {
							?>
							<span class="required-char">*</span>
							<?php
						}
						?>
					</label>
				</div>
				<select name="relation" id="relation" style="width: fit-content; margin: 10px 0px;">
					<option <?php selected( $relation, 'AND' ); ?> value="AND"><?php esc_attr_e( 'AND', 'supportcandy' ); ?></option>
					<option <?php selected( $relation, 'OR' ); ?> value="OR"><?php esc_attr_e( 'OR', 'supportcandy' ); ?></option>
				</select>
				<div class="wpsc-form-filter-container">
					<?php
					foreach ( $conditions as $slug => $filter ) {

						// check slug in conditions.
						if ( ! array_key_exists( $slug, self::$conditions ) ) {
							continue;
						}

						$flag = preg_match( '/^cf_(\w*)/', $slug, $matches );
						if ( $flag ) {
							$cf = WPSC_Custom_Field::get_cf_by_slug( $matches[1] );
							if ( ! $cf ) {
								continue;
							}
						}

						?>
						<div class="wpsc-form-filter-item">
							<div class="content">
								<div class="item">
									<select class="cf" onchange="wpsc_tc_get_operators(this, '<?php echo esc_attr( wp_create_nonce( 'wpsc_tc_get_operators' ) ); ?>');">
										<option value=""><?php esc_attr_e( 'Select field', 'supportcandy' ); ?></option>
										<?php
										foreach ( self::$conditions as $cslug => $label ) {
											$cflag = preg_match( '/^cf_(\w*)/', $cslug, $matches );
											if ( $cflag ) {
												$ccf = WPSC_Custom_Field::get_cf_by_slug( $matches[1] );
												if ( ! $ccf || in_array( $ccf->type::$slug, $ignore_cft ) ) {
													continue;
												}
											}
											?>
											<option value="<?php echo esc_attr( $cslug ); ?>" <?php selected( $slug, $cslug ); ?>><?php echo esc_attr( $label ); ?></option>
											<?php
										}
										?>
									</select>
									<script>jQuery('.wpsc-form-filter-container').last().find('.cf').selectWoo();</script>
								</div>
								<?php
								if ( $flag ) {
									$cf->type::get_operators( $cf, $filter );
									$cf->type::get_operands( $filter['operator'], $cf, $filter );
								} else {
									self::print_operators( $slug, $filter );
									self::print_operand( $slug, $filter['operator'], $filter );
								}
								?>
							</div>
							<div class="remove-container">
								<span onclick="wpsc_remove_form_filter_item(this)"><?php WPSC_Icons::get( 'times-circle' ); ?></span>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<button class="wpsc-button small secondary wpsc-form-filter-add-btn" onclick="wpsc_add_form_filter_item();">
					<?php echo esc_attr( wpsc__( 'Add new', 'supportcandy' ) ); ?>
				</button>
			</div>
			<?php
		}

		/**
		 * Print add new condition snippet
		 *
		 * @param array $ignore_cft - ignore custom field types.
		 * @return void
		 */
		public static function print_add_new_snippet( $ignore_cft = array() ) {

			?>
			<div class="wpsc-form-filter-item">
				<div class="content">
					<div class="item">
						<select class="cf" onchange="wpsc_tc_get_operators(this, '<?php echo esc_attr( wp_create_nonce( 'wpsc_tc_get_operators' ) ); ?>');">
							<option value=""><?php esc_attr_e( 'Select field', 'supportcandy' ); ?></option>
							<?php
							foreach ( self::$conditions as $slug => $label ) {
								$flag = preg_match( '/^cf_(\w*)/', $slug, $matches );
								if ( $flag ) {
									$cf = WPSC_Custom_Field::get_cf_by_slug( $matches[1] );
									if ( ! $cf || in_array( $cf->type::$slug, $ignore_cft ) ) {
										continue;
									}
								}
								?>
								<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_attr( $label ); ?></option>
								<?php
							}
							?>
						</select>
						<script>jQuery('.wpsc-form-filter-container').last().find('.cf').selectWoo();</script>
					</div>
				</div>
				<div class="remove-container">
					<span onclick="wpsc_remove_form_filter_item(this)"><?php WPSC_Icons::get( 'times-circle' ); ?></span>
				</div>
			</div>
			<?php
		}

		/**
		 * Get condition operators.
		 *
		 * @return void
		 */
		public static function get_operators() {

			if ( check_ajax_referer( 'wpsc_tc_get_operators', '_ajax_nonce', false ) != 1 ) {
				wp_send_json_error( 'Unauthorised request!', 401 );
			}

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}

			$slug = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
			if ( ! $slug || ! array_key_exists( $slug, self::$conditions ) ) {
				wp_send_json_error( __( 'Bad request!', 'supportcandy' ), 400 );
			}

			$flag = preg_match( '/^cf_(\w*)/', $slug, $matches );
			if ( $flag ) {

				$cf = WPSC_Custom_Field::get_cf_by_slug( $matches[1] );
				if ( ! $cf ) {
					wp_die();
				}
				$cf->type::get_operators( $cf );

			} else {

				self::print_operators( $slug );
			}

			wp_die();
		}

		/**
		 * Print operators for non-custom field conditions
		 *
		 * @param string $slug - condition slug.
		 * @param array  $filter - existing filter.
		 * @return void
		 */
		public static function print_operators( $slug, $filter = array() ) {

			switch ( $slug ) {

				case 'submitted_by':
					?>
					<div class="item conditional">
						<select class="operator" onchange="wpsc_tc_get_operand(this, '<?php echo esc_attr( $slug ); ?>', '<?php echo esc_attr( wp_create_nonce( 'wpsc_tc_get_operand' ) ); ?>');">
							<option value=""><?php esc_attr_e( 'Compare As', 'supportcandy' ); ?></option>
							<option <?php isset( $filter['operator'] ) && selected( $filter['operator'], '=' ); ?> value="="><?php esc_attr_e( 'Equals', 'supportcandy' ); ?></option>
						</select>
					</div>
					<?php
					break;

				case 'user_role':
					?>
					<div class="item conditional">
						<select class="operator" onchange="wpsc_tc_get_operand(this, '<?php echo esc_attr( $slug ); ?>', '<?php echo esc_attr( wp_create_nonce( 'wpsc_tc_get_operand' ) ); ?>');">
							<option value=""><?php esc_attr_e( 'Compare As', 'supportcandy' ); ?></option>
							<option <?php isset( $filter['operator'] ) && selected( $filter['operator'], '=' ); ?> value="="><?php esc_attr_e( 'Equals', 'supportcandy' ); ?></option>
							<option <?php isset( $filter['operator'] ) && selected( $filter['operator'], 'IN' ); ?> value="IN"><?php esc_attr_e( 'Matches', 'supportcandy' ); ?></option>
							<option <?php isset( $filter['operator'] ) && selected( $filter['operator'], 'NOT IN' ); ?> value="NOT IN"><?php esc_attr_e( 'Not Matches', 'supportcandy' ); ?></option>
						</select>
					</div>
					<?php
					break;

				default:
					do_action( 'wpsc_tc_print_operators', $slug, $filter );
			}
		}

		/**
		 * Get operands for non custom field conditions
		 *
		 * @return void
		 */
		public static function get_operands() {

			if ( check_ajax_referer( 'wpsc_tc_get_operand', '_ajax_nonce', false ) != 1 ) {
				wp_send_json_error( 'Unauthorised request!', 401 );
			}

			if ( ! WPSC_Functions::is_site_admin() ) {
				wp_send_json_error( __( 'Unauthorized access!', 'supportcandy' ), 401 );
			}

			$slug = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
			if ( ! $slug || ! array_key_exists( $slug, self::$conditions ) ) {
				wp_send_json_error( __( 'Bad request!', 'supportcandy' ), 400 );
			}

			$operator = isset( $_POST['operator'] ) ? sanitize_text_field( wp_unslash( $_POST['operator'] ) ) : '';
			if ( ! $operator ) {
				wp_send_json_error( __( 'Bad request!', 'supportcandy' ), 400 );
			}

			self::print_operand( $slug, $operator );

			wp_die();
		}

		/**
		 * Prit operands for non-custom field conditions
		 *
		 * @param string $slug - condition slug.
		 * @param string $operator - operator string.
		 * @param array  $filter - existing filter.
		 * @return void
		 */
		public static function print_operand( $slug, $operator, $filter = array() ) {

			global $wp_roles;

			switch ( $slug ) {

				case 'submitted_by':
					?>
					<div class="item conditional operand single">
						<select 
							class="operand_val_1">
							<option <?php isset( $filter['operand_val_1'] ) && selected( $filter['operand_val_1'], 'user' ); ?> value="user"><?php esc_attr_e( 'User', 'supportcandy' ); ?></option>
							<option <?php isset( $filter['operand_val_1'] ) && selected( $filter['operand_val_1'], 'agent' ); ?> value="agent"><?php esc_attr_e( 'Agent', 'supportcandy' ); ?></option>
						</select>
					</div>
					<?php
					break;

				case 'user_role':
					$is_multiple = $operator !== '=' ? true : false;
					$unique_id   = uniqid( 'wpsc_' );
					?>
					<div class="item conditional operand single">
						<select 
							class="operand_val_1 <?php echo esc_attr( $unique_id ); ?>" <?php echo $is_multiple ? 'multiple' : ''; ?>>
							<?php
							foreach ( $wp_roles->roles as $key => $role ) {
								$selected = '';
								if ( isset( $filter['operand_val_1'] ) && ( ( $is_multiple && in_array( $key, $filter['operand_val_1'] ) ) || ( ! $is_multiple && $key == $filter['operand_val_1'] ) ) ) {
									$selected = 'selected="selected"';
								}
								?>
								<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_attr( $role['name'] ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<script>jQuery('.operand_val_1.<?php echo esc_attr( $unique_id ); ?>').selectWoo();</script>
					<?php
					break;

				default:
					do_action( 'wpsc_tc_print_operand', $slug, $operator, $filter );
			}
		}

		/**
		 * Return whether conditions are valid for the ticket
		 *
		 * @param WPSC_Ticket $ticket - ticket object.
		 * @param string      $conditions - conditions to check.
		 * @param string      $relation - relation between conditions.
		 * @return boolean
		 */
		public static function is_valid_conditions( $ticket, $conditions, $relation ) {

			$conditions = $conditions ? json_decode( html_entity_decode( $conditions ), true ) : array();
			if ( ! $conditions ) {
				return true;
			}

			$flag = $relation == 'AND' ? true : false;

			foreach ( $conditions as $slug => $condition ) {

				if ( preg_match( '/^cf_(\w*)/', $slug, $matches ) ) {

					$cf = WPSC_Custom_Field::get_cf_by_slug( $matches[1] );
					if ( ! $cf ) {
						continue;
					}

					$is_valid = $cf->type::is_valid_ticket_condition( $condition, $cf, $ticket );

				} else {

					switch ( $slug ) {

						case 'submitted_by':
							if (
								(
									$condition['operand_val_1'] == 'agent' &&
									is_object( $ticket->agent_created )
								) ||
								(
									$condition['operand_val_1'] == 'user' &&
									! is_object( $ticket->agent_created )
								)
							) {
								$is_valid = true;
							} else {
								$is_valid = false;
							}
							break;

						case 'user_role':
							$user_roles = $ticket->customer->user->roles;
							switch ( $condition['operator'] ) {

								case '=':
									$flag = in_array( $condition['operand_val_1'], $user_roles ) ? true : false;
									break;

								case 'IN':
									$flag = false;
									foreach ( $user_roles as $id ) {
										if ( in_array( $id, $condition['operand_val_1'] ) ) {
											$flag = true;
											break;
										}
									}
									break;

								case 'NOT IN':
									foreach ( $user_roles as $id ) {
										if ( in_array( $id, $condition['operand_val_1'] ) ) {
											$flag = false;
											break;
										}
									}
									break;
							}
							break;

						default:
							$is_valid = apply_filters( 'wpsc_tc_is_valid', $is_valid, $slug, $condition, $ticket );
							break;
					}
				}

				if ( $relation == 'OR' && $is_valid ) {
					$flag = true;
					break;
				}

				if ( $relation == 'AND' && ! $is_valid ) {
					$flag = false;
					break;
				}
			}

			return $flag;
		}
	}
endif;

WPSC_Ticket_Conditions::init();
