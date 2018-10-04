<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PUM_RC_Site
 */
class PUM_RC_Site {

	/**
	 *
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'assets' ) );
		add_filter( 'pum_generated_js', array( __CLASS__, 'generated_js' ) );
		add_action( 'pum_preload_popup', array( __CLASS__, 'enqueue_popup_assets' ) );
	}

	/**
	 *
	 */
	public static function assets() {
		if ( ! PUM_AssetCache::enabled() ) {
			wp_register_script( 'pum-rc', PUM_RC::$URL . '/assets/js/pum-rc-site' . PUM_Site_Assets::$suffix . '.js', array( 'jquery', 'popup-maker-site' ), PUM_RC::$VER, true );
		}
	}

	/**
	 * @param array $js
	 *
	 * @return array
	 */
	public static function generated_js( $js = array() ) {
		$js['rc'] = array(
			'content'  => file_get_contents( PUM_RC::$DIR . '/assets/js/pum-rc-site' . PUM_Site_Assets::$suffix . '.js' ),
			'priority' => 5,
		);

		return $js;
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
