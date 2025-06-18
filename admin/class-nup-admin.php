<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mecum.no
 * @since      1.0.1
 *
 * @package    Nup
 * @subpackage Nup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nup
 * @subpackage Nup/admin
 * @author     Mecum <post@mecum.no>
 */
class Nup_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.1
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nup-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Nup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nup-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add a widget to the dashboard.
	 *
	 * This function is hooked into the 'wp_dashboard_setup' action below.
	 */
	public function nup_add_dashboard_widgets() {

		wp_add_dashboard_widget(
					'nup_dashboard_widget',         // Widget slug.
					'NUP',         					// Title.
					array($this, 'nup_dashboard_widget_function') // Display function.
			);	
	}

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	public function nup_dashboard_widget_function() {

		$time = 'Add price or number here';
		$time_format = '';
		$date_format = '';
		$options = [];

		if ( isset( $_POST['nup-time'] ) && check_admin_referer( 'nup-nonce') ) {
			$options['nup-time'] = ( isset( $_POST['nup-time'] ) ) ? stripslashes( $_POST['nup-time'] ) : '';
			$options['nup-time-format'] = ( isset( $_POST['nup-time-format'] ) ) ? stripslashes( $_POST['nup-time-format'] ) : '';
			$options['nup-date-format'] = ( isset( $_POST['nup-date-format'] ) ) ? stripslashes( $_POST['nup-date-format'] ) : '';
			date_default_timezone_set('Europe/Oslo');
			$options['nup-date'] = time();
			$a = update_dashboard_widget_options('nup_dashboard_widget', $options);
		}
		$options = get_dashboard_widget_options('nup_dashboard_widget');

		if ( $options ) {
			$time = $options['nup-time'];
			$time_format = $options['nup-time-format'];
			$date_format = $options['nup-date-format'];
		}
		ob_start();

		?>
		<form name="post" action="/wp-admin/" method="post" id="nup" class="initial-form hide-if-no-js" _lpchecked="1">

			<div class="" id="nup-time-wrap">
				<label class="" for="nup-time" id="nup-time-prompt-text" style="line-height: 27px;">Publish new number</label>
				<input type="text" name="nup-time" id="nup-time" placeholder="Enter number here" value="<?php echo $time; ?>" autocomplete="off" style="padding: 5px 5px 4px;">
				<br class="clear">
			</div>
			<?php if($this->options['type'] == 2 ) { ?>
			<div class="input-text-wrap" id="nup-time-format-wrap">
				<label class="" for="nup-time-format" id="nup-time-format-prompt-text">Number Format</label>
				<select name="nup-time-format" id="nup-time-format" value="<?php echo $time_format; ?>" autocomplete="off" style="padding:4px 5px; border-radius:2px;">
				<option value="G:i"<?php if( $time_format == 'G' ) { echo ' selected'; } ?>>14</option>
				<option value="G:i"<?php if( $time_format == 'G.i' ) { echo ' selected'; } ?>>14:00</option>
				<option value="g:i a"<?php if( $time_format == 'g:i a' ) { echo ' selected'; } ?>>2:00 am</option>
				<option value="g:i A"<?php if( $time_format == 'g:i A' ) { echo ' selected'; } ?>>2:00 AM</option>
				</select>
				<br class="clear">
			</div>
			<?php } ?>
			<div class="input-text-wrap" id="nup-date-format-wrap">
				<label class="" for="nup-date-format" id="nup-date-format-prompt-text">Timestamp Format</label>
				<select name="nup-date-format" id="nup-date-format" value="<?php echo $date_format; ?>" autocomplete="off" style="padding:4px 5px; border-radius:2px;">
				<option value="d.m.Y"<?php if($date_format == 'd.m.Y') { echo ' selected'; } ?>>15.01.2018</option>
				<option value="Y.m.d"<?php if($date_format == 'Y.m.d') { echo ' selected'; } ?>>2018.01.15</option>
				<option value="D d F Y"<?php if($date_format == 'D d F Y') { echo ' selected'; } ?>>Monday 15 January 2018</option>
				<option value="d F Y"<?php if($date_format == 'd F Y') { echo ' selected'; } ?>>15 January 2018</option>
				</select>
				<br class="clear">
			</div>
			<p class="submit">
				<?php wp_nonce_field('nup-nonce'); ?>
				<input type="submit" name="savenup-time" id="save-nup-time" class="button button-primary" value="<?php echo isset( $this->options['button'] ) ? esc_attr( $this->options['button']) : 'Submit' ?>">	<br class="clear">
			</p>

			<p><?php 
			// $this->options = get_option( $this->plugin_name . '_options' );
			// echo '<pre>';
			// print_r( $this->options );
			// echo '</pre>';
			
			echo $this->options['description']; ?></p>

		</form>
		<?php

		$output = ob_get_clean();
		
		echo $output;
	
	}

	/**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'NUP Settings', 
            'manage_options', 
            'nup-settings', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        // $this->options = get_option( $this->plugin_name . '_options' );
        ?>
        <div class="wrap">
            <h1>NUP Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'nup_option_group' );
                do_settings_sections( 'nup-settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {     
		   
        register_setting(
            'nup_option_group', // Option group
            $this->plugin_name . '_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'nup_settings', // ID
            'NUP Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'nup-settings' // Page
        );  

        add_settings_field(
            'type', // ID
            'Type', // Title 
            array( $this, 'type_callback' ), // Callback
            'nup-settings', // Page
            'nup_settings' // Section           
        );      
    

        add_settings_field(
            'currency', 
            'Price Currency', 
            array( $this, 'currency_callback' ), 
            'nup-settings', 
            'nup_settings'
        );      

        add_settings_field(
            'button', 
            'Widget button text', 
            array( $this, 'button_callback' ), 
            'nup-settings', 
            'nup_settings'
        );      

        add_settings_field(
            'description', 
            'Description', 
            array( $this, 'description_callback' ), 
            'nup-settings', 
            'nup_settings'
        );      
    }


    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['number_type'] ) )
            $new_input['number_type'] = absint( $input['number_type'] );

        if( isset( $input['type'] ) )
            $new_input['type'] = absint( $input['type'] );

        if( isset( $input['currency'] ) )
            $new_input['currency'] = sanitize_text_field( $input['currency'] );

        if( isset( $input['button'] ) )
            $new_input['button'] = sanitize_text_field( $input['button'] );

        if( isset( $input['description'] ) )
            $new_input['description'] = sanitize_text_field( $input['description'] );

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        echo 'This plugin let you publishes and update a number (like a price, telephone, etc.) on your webpage that need to be change often. You can also add a date and timestamp to when the number was changed updated/changes.<br>
Smart to use if you are selling gasoline and need to update the price regularly. You can then add the new "price of today", and it will automatic update the price and the timestamp.
<p>Shortcodes: Publishes the new number: [nup-number]. Add the date and time stamp for when the number was updated: [nup-date]. <p>Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function number_type_callback()
    {
        echo '<input type="text" id="number_type" name="nup_options[number_type]"';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function currency_callback()
    {
        printf(
            '<input type="text" id="currency" name="nup_options[currency]" value="%s" />',
            isset( $this->options['currency'] ) ? esc_attr( $this->options['currency']) : ''
        );
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function button_callback()
    {
        printf(
            '<input type="text" id="button" name="nup_options[button]" value="%s" />',
            isset( $this->options['button'] ) ? esc_attr( $this->options['button']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function type_callback()
    {

	  	echo '<select id="type" name="nup_options[type]">';
			printf('<option value="1"%s>Text</option>', isset( $this->options['type'] ) && $this->options['type'] == 1 ? ' selected' : '');
			printf('<option value="2"%s>Time</option>', isset( $this->options['type'] ) && $this->options['type'] == 2 ? ' selected' : '');
			printf('<option value="3"%s>Price</option>', isset( $this->options['type'] ) && $this->options['type'] == 3 ? ' selected' : '');
		echo '</select>';

    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function description_callback()
    {
        printf(
            '<textarea id="description" name="nup_options[description]">%s</textarea>',
            isset( $this->options['description'] ) ? esc_attr( $this->options['description']) : ''
        );
    }

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '_options' );
		
	}
}