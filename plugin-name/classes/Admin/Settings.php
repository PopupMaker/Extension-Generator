<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_RC_Admin_Settings
 */
class PUM_RC_Admin_Settings {

	/**
	 *
	 */
	public static function init() {
		add_filter( 'pum_settings_tab_sections', array( __CLASS__, 'settings_tab_sections' ) );
		add_filter( 'pum_settings_fields', array( __CLASS__, 'save_popup' ) );
	}

	/**
	 * @param array $sections
	 *
	 * @return array
	 */
	public static function settings_tab_sections( $sections ) {
		$sections['extensions']['remote_content'] = __( 'Remote Content', 'popup-maker-remote-content' );

		return $sections;
	}

	/**
	 * @param array $sections
	 *
	 * @return array
	 */
	public static function settings_fields( $fields ) {
		return array_merge_recursive( $fields, array(
			'extensions' => array(
				'remote_content' => array(

				),
			),
		) );
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
