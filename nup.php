<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://pbmedia.no
 * @since             1.0.1
 * @package           Nup
 *
 * @wordpress-plugin
 * Plugin Name:       NUP - Number Update Plugin 
 * Plugin URI:        nup
 * Description:       A simple plugin that publishes and update a number (like price, telephone, etc) and add a timestamp. The number (and time) will update when you add a new number. 
* Version:           1.0.1
 * Author:            PolarBear Media
 * Author URI:        https://pbmedia.no
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nup-activator.php
 */
function activate_nup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nup-activator.php';
	Nup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nup-deactivator.php
 */
function deactivate_nup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nup-deactivator.php';
	Nup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nup' );
register_deactivation_hook( __FILE__, 'deactivate_nup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.1
 */
function run_nup() {

	$plugin = new Nup();
	$plugin->run();

}
run_nup();
