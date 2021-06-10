<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/mattday95
 * @since      1.0.0
 *
 * @package    High_Entropy_Nonces
 * @subpackage High_Entropy_Nonces/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    High_Entropy_Nonces
 * @subpackage High_Entropy_Nonces/includes
 * @author     Matt Day <mattday95@live.co.uk>
 */
class High_Entropy_Nonces {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      High_Entropy_Nonces_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'HIGH_ENTROPY_NONCES_VERSION' ) ) {
			$this->version = HIGH_ENTROPY_NONCES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'high-entropy-nonces';
	}

	public function run() {

		if (!function_exists('wp_create_nonce')) :

			function wp_create_nonce( $action = -1 ) {
				$user = wp_get_current_user();
				$uid  = (int) $user->ID;
				if ( ! $uid ) {
					/** This filter is documented in wp-includes/pluggable.php */
					$uid = apply_filters( 'nonce_user_logged_out', $uid, $action );
				}

				$token = wp_get_session_token();
				$i     = wp_nonce_tick();

				return substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -18, 16 );
			}

		endif;

		if (!function_exists('wp_verify_nonce')):

			function wp_verify_nonce( $nonce, $action = -1 ) {
				$nonce = (string) $nonce;
				$user  = wp_get_current_user();
				$uid   = (int) $user->ID;

				if ( ! $uid ) {
					$uid = apply_filters( 'nonce_user_logged_out', $uid, $action );
				}

				if ( empty( $nonce ) ) {
					return false;
				}

				$token = wp_get_session_token();
				$i     = wp_nonce_tick();

				$expected = substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -18, 16 );
				if ( hash_equals( $expected, $nonce ) ) {
					return 1;
				}

				$expected = substr( wp_hash( ( $i - 1 ) . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -18, 16 );
				if ( hash_equals( $expected, $nonce ) ) {
					return 2;
				}

				do_action( 'wp_verify_nonce_failed', $nonce, $action, $user, $token );

				return false;
			}

		endif;

	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    High_Entropy_Nonces_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
