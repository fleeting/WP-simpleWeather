<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://simpleweatherjs.com
 * @since             1.0.0
 * @package           Simple_Weather
 *
 * @wordpress-plugin
 * Plugin Name:       simpleWeather
 * Plugin URI:        http://simpleweatherjs.com
 * Description:       A simple WordPress plugin to display current weather data for any location and doesn't get in your way. Handcrafted with love from Boston, MA by <a href="https://twitter.com/fleetingftw">James Fleeting</a>.
 * Version:           1.0.0
 * Author:            James Fleeting
 * Author URI:        http://iwasasuperhero.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-weather
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-weather-activator.php
 */
function activate_simple_weather() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-weather-activator.php';
	Simple_Weather_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-weather-deactivator.php
 */
function deactivate_simple_weather() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-weather-deactivator.php';
	Simple_Weather_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_weather' );
register_deactivation_hook( __FILE__, 'deactivate_simple_weather' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-weather.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_weather() {

	$plugin = new Simple_Weather();
	$plugin->run();

}
run_simple_weather();
