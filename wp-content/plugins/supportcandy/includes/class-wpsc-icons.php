<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_Icons' ) ) :

	final class WPSC_Icons {

		/**
		 * Icons to be loaded on init
		 *
		 * @var Array
		 */
		public static $icons;

		/**
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {

			add_action( 'init', array( __CLASS__, 'load_icons' ) );
		}

		/**
		 * Load SVG icons
		 *
		 * @return void
		 */
		public static function load_icons() {

			$icons       = array(
				'edit'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/edit-solid.svg' ), //phpcs:ignore
				'info-circle'          => file_get_contents( WPSC_ABSPATH . 'asset/icons/info-circle-solid.svg' ), //phpcs:ignore
				'plus-square'          => file_get_contents( WPSC_ABSPATH . 'asset/icons/plus-square-solid.svg' ), //phpcs:ignore
				'trash-alt'            => file_get_contents( WPSC_ABSPATH . 'asset/icons/trash-alt-solid.svg' ), //phpcs:ignore
				'times'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/times-solid.svg' ), //phpcs:ignore
				'times-circle'         => file_get_contents( WPSC_ABSPATH . 'asset/icons/times-circle-solid.svg' ), //phpcs:ignore
				'shopping-cart'        => file_get_contents( WPSC_ABSPATH . 'asset/icons/shopping-cart-solid.svg' ), //phpcs:ignore
				'reply'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/reply-solid.svg' ), //phpcs:ignore
				'comment'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/comment-alt-solid.svg' ), //phpcs:ignore
				'balance-scale-left'   => file_get_contents( WPSC_ABSPATH . 'asset/icons/balance-scale-left-solid.svg' ), //phpcs:ignore
				'bars'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/bars-solid.svg' ), //phpcs:ignore
				'chevron-up'           => file_get_contents( WPSC_ABSPATH . 'asset/icons/chevron-up-solid.svg' ), //phpcs:ignore
				'chevron-down'         => file_get_contents( WPSC_ABSPATH . 'asset/icons/chevron-down-solid.svg' ), //phpcs:ignore
				'chevron-left'         => file_get_contents( WPSC_ABSPATH . 'asset/icons/chevron-left-solid.svg' ), //phpcs:ignore
				'chevron-right'        => file_get_contents( WPSC_ABSPATH . 'asset/icons/chevron-right-solid.svg' ), //phpcs:ignore
				'cog'                  => file_get_contents( WPSC_ABSPATH . 'asset/icons/cog-solid.svg' ), //phpcs:ignore
				'cogs'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/cogs-solid.svg' ), //phpcs:ignore
				'history'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/history-solid.svg' ), //phpcs:ignore
				'id-card'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/id-card-solid.svg' ), //phpcs:ignore
				'list-alt'             => file_get_contents( WPSC_ABSPATH . 'asset/icons/list-alt-solid.svg' ), //phpcs:ignore
				'location-arrow'       => file_get_contents( WPSC_ABSPATH . 'asset/icons/location-arrow-solid.svg' ), //phpcs:ignore
				'search'               => file_get_contents( WPSC_ABSPATH . 'asset/icons/search-solid.svg' ), //phpcs:ignore
				'sort'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/sort-solid.svg' ), //phpcs:ignore
				'sync'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/sync-solid.svg' ), //phpcs:ignore
				'tags'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/tags-solid.svg' ), //phpcs:ignore
				'user-tag'             => file_get_contents( WPSC_ABSPATH . 'asset/icons/user-tag-solid.svg' ), //phpcs:ignore
				'users'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/users-solid.svg' ), //phpcs:ignore
				'ticket-alt'           => file_get_contents( WPSC_ABSPATH . 'asset/icons/ticket-alt-solid.svg' ), //phpcs:ignore
				'user-tie'             => file_get_contents( WPSC_ABSPATH . 'asset/icons/user-tie-solid.svg' ), //phpcs:ignore
				'headset'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/headset-solid.svg' ), //phpcs:ignore
				'file-alt'             => file_get_contents( WPSC_ABSPATH . 'asset/icons/file-alt-solid.svg' ), //phpcs:ignore
				'align-left'           => file_get_contents( WPSC_ABSPATH . 'asset/icons/align-left-solid.svg' ), //phpcs:ignore
				'envelope'             => file_get_contents( WPSC_ABSPATH . 'asset/icons/envelope-regular.svg' ), //phpcs:ignore
				'widget'               => file_get_contents( WPSC_ABSPATH . 'asset/icons/widget.svg' ), //phpcs:ignore
				'check'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/check-solid.svg' ), //phpcs:ignore
				'font'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/font-solid.svg' ), //phpcs:ignore
				'chevron-circle-right' => file_get_contents( WPSC_ABSPATH . 'asset/icons/chevron-circle-right-solid.svg' ), //phpcs:ignore
				'clipboard'            => file_get_contents( WPSC_ABSPATH . 'asset/icons/clipboard-regular.svg' ), //phpcs:ignore
				'clock'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/clock-solid.svg' ), //phpcs:ignore
				'calendar-times'       => file_get_contents( WPSC_ABSPATH . 'asset/icons/calendar-times-solid.svg' ), //phpcs:ignore
				'calendar-alt'         => file_get_contents( WPSC_ABSPATH . 'asset/icons/calendar-alt-regular.svg' ), //phpcs:ignore
				'trash-restore'        => file_get_contents( WPSC_ABSPATH . 'asset/icons/trash-restore-solid.svg' ), //phpcs:ignore
				'unlock'               => file_get_contents( WPSC_ABSPATH . 'asset/icons/unlock-solid.svg' ), //phpcs:ignore
				'link'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/link-solid.svg' ), //phpcs:ignore
				'clone'                => file_get_contents( WPSC_ABSPATH . 'asset/icons/clone-regular.svg' ), //phpcs:ignore
				'palette'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/palette-solid.svg' ), //phpcs:ignore
				'plus'                 => file_get_contents( WPSC_ABSPATH . 'asset/icons/plus-solid.svg' ), //phpcs:ignore
				'arrow-right'          => file_get_contents( WPSC_ABSPATH . 'asset/icons/arrow-right-solid.svg' ), //phpcs:ignore
				'arrow-left'           => file_get_contents( WPSC_ABSPATH . 'asset/icons/arrow-left-solid.svg' ), //phpcs:ignore
				'log-out'              => file_get_contents( WPSC_ABSPATH . 'asset/icons/log-out.svg' ), //phpcs:ignore
			);
			self::$icons = apply_filters( 'wpsc_icons', $icons );
		}

		/**
		 * Return SVG icon element
		 *
		 * @param string $name - icon name.
		 * @return void
		 */
		public static function get( $name ) {

			$allowed_tags = array(
				'svg'   => array(
					'class'           => true,
					'aria-hidden'     => true,
					'aria-labelledby' => true,
					'role'            => true,
					'xmlns'           => true,
					'width'           => true,
					'height'          => true,
					'viewbox'         => true,
				),
				'g'     => array( 'fill' => true ),
				'title' => array( 'title' => true ),
				'path'  => array(
					'd'    => true,
					'fill' => true,
				),
			);

			echo isset( self::$icons[ $name ] ) ? wp_kses( self::$icons[ $name ], $allowed_tags ) : '';
		}
	}
endif;

WPSC_Icons::init();
