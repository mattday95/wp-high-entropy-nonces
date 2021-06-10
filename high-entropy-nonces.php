<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mattday95
 * @since             1.0.0
 * @package           High_Entropy_Nonces
 *
 * @wordpress-plugin
 * Plugin Name:       High Entropy Nonces
 * Plugin URI:        https: //github.com/mattday95/wp-high-entropy-nonces
 * Description:       Increases the Wordpress nonce length from 10->16 characters to help mitigate brute force attacks.
 * Version:           1.0.0
 * Author:            Matt Day
 * Author URI:        https://github.com/mattday95
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       high-entropy-nonces
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'HIGH_ENTROPY_NONCES_VERSION', '1.0.0' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-high-entropy-nonces.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_high_entropy_nonces() {

	$plugin = new High_Entropy_Nonces();
	$plugin->run();

}
run_high_entropy_nonces();
