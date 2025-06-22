<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mecum.no
 * @since      1.0.1
 *
 * @package    Nup
 * @subpackage Nup/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.1
 * @package    Nup
 * @subpackage Nup/includes
 * @author     Mecum <post@mecum.no>
 */
public static function activate() {
		// We'll add the new function to create the table here.
		self::create_entries_table();
	}

	/**
	 * Creates a separate database table to store history.
	 */
	private static function create_entries_table() {
		global $wpdb;
		// Gets the table name with the WordPress prefix (e.g. 'wp_nup_entries')
		$table_name = $wpdb->prefix . 'nup_entries';
		$charset_collate = $wpdb->get_charset_collate();

		// SQL to create the table
		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			timestamp datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			value varchar(255) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		// We need to include this file to use dbDelta()
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

}
