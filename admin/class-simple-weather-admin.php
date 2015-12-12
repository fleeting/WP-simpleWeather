<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://simpleweatherjs.com
 * @since      1.0.0
 *
 * @package    Simple_Weather
 * @subpackage Simple_Weather/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Weather
 * @subpackage Simple_Weather/admin
 * @author     James Fleeting <hello@jamesfleeting.com>
 */
class Simple_Weather_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'simple_weather';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Weather_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Weather_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-weather-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Weather_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Weather_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-weather-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'simpleWeather Settings', 'simple-weather' ),
			__( 'simpleWeather', 'simple-weather' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/simple-weather-admin-display.php';
	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		register_setting( $this->plugin_name, $this->option_name, array( $this, $this->option_name . '_sanitize_text' ) );

		add_settings_section(
			$this->option_name . '_options',
			__( '', 'simple-weather' ),
			array( $this, $this->option_name . '_options_cb' ),
			$this->plugin_name
		);

		add_settings_field(
			$this->option_name . '_location',
			__( 'Location', 'simple-weather' ),
			array( $this, $this->option_name . '_location_cb' ),
			$this->plugin_name,
			$this->option_name . '_options',
			array( 'label_for' => $this->option_name . '_location' )
		);

		add_settings_field(
			$this->option_name . '_unit',
			__( 'Unit', 'simple-weather' ),
			array( $this, $this->option_name . '_unit_cb' ),
			$this->plugin_name,
			$this->option_name . '_options',
			array( 'label_for' => $this->option_name . '_unit' )
		);

	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function simple_weather_options_cb() {
		echo '<p>' . __( '', 'simple-weather' ) . '</p>';
	}

	/**
	 * Render the radio input field for unit option
	 *
	 * @since  1.0.0
	 */
	public function simple_weather_unit_cb() {
		$option = get_option( $this->option_name );
		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '[unit]' ?>" id="<?php echo $this->option_name . '_unit' ?>" value="c" <?php checked( $option['unit'], 'c' ); ?>>
					<?php _e( 'Celsius', 'simple-weather' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '[unit]' ?>" value="f" <?php checked( $option['unit'], 'f' ); ?>>
					<?php _e( 'Fahrenheit', 'simple-weather' ); ?>
				</label>
			</fieldset>
		<?php
	}

	/**
	 * Render the location input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function simple_weather_location_cb() {
		$option = get_option( $this->option_name );
		echo '<input type="text" name="' . $this->option_name . '[location]' . '" id="' . $this->option_name . '_location' . '" value="' . $option['location'] . '"> ';
	}

	/**
	 * Sanitize text value before being saved to database
	 *
	 * @param  string $text $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function simple_weather_sanitize_text( $text ) {
		if (!empty($text) && is_array($text)) {
			foreach($text as &$option) {
				$option = sanitize_text_field($option);
			}
		} else {
			$text = sanitize_text_field($text);
		}

	  return $text;
	}


}
