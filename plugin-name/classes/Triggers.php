<?php
/*******************************************************************************
 * Copyright (c) 2018, WP Popup Maker
 ******************************************************************************/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class PUM_RC_Triggers
 */
class PUM_RC_Triggers {

	/**
	 *
	 */
	public static function init() {
		add_filter( 'pum_registered_triggers', array( __CLASS__, 'register_triggers' ) );
	}

	/**
	 * @param array $triggers
	 *
	 * @return array
	 */
	public static function register_triggers( $triggers = array() ) {
		$current_post_id = isset( $_GET['post'] ) ? $_GET['post'] : get_the_ID();

		return array_merge( $triggers, array(
			'scroll' => array(
				'name'            => __( 'Scroll', 'popup-maker-remote-content' ),
				'modal_title'     => __( 'Scroll Trigger Settings', 'popup-maker-remote-content' ),
				'settings_column' => sprintf( '<strong>%1$s</strong>: %2$s', __( 'Trigger', 'popup-maker-remote-content' ), '{{data.trigger_type.charAt(0).toUpperCase() + data.trigger_type.slice(1)}}' ),
				'fields'          => array(
					'general' => array(
						'trigger_type'      => array(
							'label'   => __( 'What type of scroll trigger do you want to use?', 'popup-maker-remote-content' ),
							'type'    => 'select',
							'std'     => 'distance',
							'options' => array(
								'distance' => __( "Distance", 'popup-maker-remote-content' ),
								'element'  => __( "Element", 'popup-maker-remote-content' ),
							),
						),
						'distance'          => array(
							'type'         => 'measure',
							'label'        => __( 'Distance', 'popup-maker-remote-content' ),
							'desc'         => __( 'Choose how far users scroll before popup opens.', 'popup-maker-remote-content' ),
							'std'          => '75%',
							'units'        => array(
								'px'  => 'px',
								'%'   => '%',
								'rem' => 'rem',
							),
							'dependencies' => array(
								'trigger_type' => 'distance',
							),
						),
						'element_point'     => array(
							'label'        => __( 'When should the popup trigger?', 'popup-maker-remote-content' ),
							'type'         => 'radio',
							'options'      => array(
								'e_top-s_bottom'    => __( 'When the element first comes on screen.', 'popup-maker-remote-content' ),
								'e_bottom-s_bottom' => __( 'When the element has been completely revealed.', 'popup-maker-remote-content' ),
								'e_top-s_top'       => __( 'When the element begins to scroll off screen.', 'popup-maker-remote-content' ),
								'e_bottom-s_top'    => __( 'When the element has completely scrolled off screen.', 'popup-maker-remote-content' ),
							),
							'std'          => 'e_top-s_bottom',
							'dependencies' => array(
								'trigger_type' => 'element',
							),
						),
						'element_type'      => array(
							'label'        => __( 'What type of element do you want to use as a trigger point?', 'popup-maker-remote-content' ),
							'type'         => 'select',
							'options'      => array(
								'shortcode'    => __( 'Shortcode', 'popup-maker-remote-content' ),
								'css_selector' => __( 'CSS Selector', 'popup-maker-remote-content' ),
							),
							'dependencies' => array(
								'trigger_type' => 'element',
							),
						),
						'element_selector'  => array(
							'label'        => __( 'Trigger Element Selector', 'popup-maker-remote-content' ),
							'desc'         => __( 'CSS / jQuery Selector that will be used as a trigger point.', 'popup-maker-remote-content' ),
							'dependencies' => array(
								'trigger_type' => 'element',
								'element_type' => 'css_selector',
							),
						),
						'element_shortcode' => array(
							'label'        => __( 'Use this shortcode:', 'popup-maker-remote-content' ),
							'content'      => '<pre><code>[pum_scroll_trigger popup="' . $current_post_id . '"]</code></pre>',
							'type'         => 'html',
							'dependencies' => array(
								'trigger_type' => 'element',
								'element_type' => 'shortcode',
							),
						),
						'close_on_up'       => array(
							'label' => __( 'Close When Scrolling Back Up', 'popup-maker-remote-content' ),
							'desc'  => __( 'Checking this will cause popup to close when scrolling up past the trigger point.', 'popup-maker-remote-content' ),
							'type'  => 'checkbox',
						),
					),
				),
			),
		) );
	}
}
