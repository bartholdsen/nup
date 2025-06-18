<?php
/**
 * Globally-accessible functions
 *
 * @since 		1.0.1
 *
 */

/**
 * Saves an array of options for a single dashboard widget to the database.
 * Can also be used to define default values for a widget.
 *
 * @param string $widget_id The name of the widget being updated
 * @param array $args An associative array of options being saved.
 * @param bool $add_only Set to true if you don't want to override any existing options.
 */
function update_dashboard_widget_options( $widget_id , $args=array(), $add_only=false )
{
	//Fetch ALL dashboard widget options from the db...
	$opts = get_option( 'dashboard_widget_options' );

	//Get just our widget's options, or set empty array
	$w_opts = ( isset( $opts[$widget_id] ) ) ? $opts[$widget_id] : array();

	if ( $add_only ) {
		//Flesh out any missing options (existing ones overwrite new ones)
		$opts[$widget_id] = array_merge($args,$w_opts);
	}
	else {
		//Merge new options with existing ones, and add it back to the widgets array
		$opts[$widget_id] = array_merge($w_opts,$args);
	}

	//Save the entire widgets array back to the db
	return update_option('dashboard_widget_options', $opts);
}

/**
 * Gets all widget options, or only options for a specified widget if a widget id is provided.
 *
 * @param string $widget_id Optional. If provided, will only get options for that widget.
 * @return array An associative array
 */
function get_dashboard_widget_options( $widget_id='' )
{
	//Fetch ALL dashboard widget options from the db...
	$opts = get_option( 'dashboard_widget_options' );

	//If no widget is specified, return everything
	if ( empty( $widget_id ) )
		return $opts;

	//If we request a widget and it exists, return it
	if ( isset( $opts[$widget_id] ) )
		return $opts[$widget_id];

	//Something went wrong...
	return false;
}

/**
 * Gets one specific option for the specified widget.
 * @param $widget_id
 * @param $option
 * @param null $default
 *
 * @return string
 */
function get_dashboard_widget_option( $widget_id, $option, $default=NULL ) {

	$opts = get_dashboard_widget_options($widget_id);

	//If widget opts dont exist, return false
	if ( ! $opts )
		return false;

	//Otherwise fetch the option or use default
	if ( isset( $opts[$option] ) && ! empty($opts[$option]) )
		return $opts[$option];
	else
		return ( isset($default) ) ? $default : false;

}