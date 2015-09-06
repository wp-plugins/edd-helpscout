<?php
/*
Plugin Name: Easy Digital Downloads integration for HelpScout
Plugin URI: https://dannyvankooten.com/
Description: Easy Digital Downloads integration for HelpScout
Version: 1.1
Author: Danny van Kooten
Author URI: https://dannyvankooten.com
Text Domain: edd-helpscout
Domain Path: /languages
License: GPL v3

Easy Digital Downloads integration for HelpScout
Copyright (C) 2013-2015, Danny van Kooten, hi@dannyvankooten.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace EDD\HelpScout;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class Plugin {

	/**
	 * @const VERSION
	 */
	const VERSION = "1.1";

	/**
	 * @const FILE
	 */
	const FILE = __FILE__;

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Add hooks
	 */
	public function add_hooks() {
		add_action( 'init', array( $this, 'listen' ) );
	}

	/**
	 * Initialise the rest of the plugin
	 */
	public function listen() {

		// if this is a HelpScout Request, load the Endpoint class
		if ( $this->is_helpscout_request() && ! is_admin() ) {
			new Endpoint();
		}

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			new AJAX();
		}
	}

	/**
	 * Is this a request we should respond to?
	 *
	 * @return bool
	 */
	private function is_helpscout_request() {

		/**
		 * @since 1.1
		 */
		$trigger = stristr( $_SERVER['REQUEST_URI'], '/edd-helpscout/api' ) !== false;

		if( ! $trigger ) {
			/**
			 * @deprecated 1.1
			 * @use `/edd-helpscout/api` instead
			 */
			$trigger = stristr( $_SERVER['REQUEST_URI'], '/edd-hs-api/customer-data.json' ) !== false;

			// if trigger is not set but signature is, it might be that user is coming from old version (with greedy listening)
			if( ! $trigger && isset( $_SERVER['HTTP_X_HELPSCOUT_SIGNATURE'] ) ) {

				$greedy = get_option( 'edd_hs_greedy_listening', 1 );

				if( $greedy ) {
					$trigger = true;
				}
			}
		}

		/**
		 * @deprecated 1.1
		 * @use edd_helpscout_is_helpscout_request
		 */
		$trigger = (bool) apply_filters( 'edd_hs/is_helpscout_request', $trigger );

		/**
		 * Filter so you can set the plugin to trigger at your own URL endpoint
		 *
		 * @since 1.1
		 */
		return (bool) apply_filters( 'edd_helpscout_is_helpscout_request', $trigger );
	}

}

/**
 * Bootstrap the plugin at `plugins_loaded` (after EDD)
 */
add_action( 'plugins_loaded', function() {
	// do nothing if EDD is not activated
	if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
		return;
	}

	// Load autoloader
	require __DIR__ . '/vendor/autoload.php';

	// Register activation hook
	register_activation_hook( __FILE__, array( 'EDD_HelpScout\\Admin', 'plugin_activation' ) );

	// Instantiate plugin
	$plugin = new Plugin();
	$plugin->add_hooks();

	// Load Admin stuff
	if( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		$admin = new Admin();
		$admin->add_hooks();
	}
}, 90 );



