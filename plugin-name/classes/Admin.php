<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_RC_Admin
 */
class PUM_RC_Admin {

	/**
	 *
	 */
	public static function init() {
		add_action( 'pum_save_popup', array( __CLASS__, 'save_popup' ) );
	}

	/**
	 * @param int $popup_id
	 */
	public static function save_popup( $popup_id ) {
		$popup = pum_get_popup( $popup_id );

		if ( $popup->get_meta( 'pum_rc_data_ver' ) === false ) {
			$popup->update_meta( 'pum_rc_data_ver', PUM_RC::$DB_VER );
		}
	}

	/**
	 * @param int $popup_id
	 */
	public static function enqueue_popup_assets( $popup_id = 0 ) {
		$popup = pum_get_popup( $popup_id );

		if ( ! pum_is_popup( $popup ) || ! wp_script_is( 'pum-rc', 'registered' ) ) {
			return;
		}

		if ( $popup->has_trigger( 'scroll' ) || $popup->has_trigger( 'scroll_return' ) ) {
			wp_enqueue_script( 'pum-rc' );
		}
	}

}
