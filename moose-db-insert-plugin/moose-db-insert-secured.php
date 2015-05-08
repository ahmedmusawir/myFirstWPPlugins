<?php
// error_reporting(E_ALL);
/*
Plugin Name: A Secured Browser Detector Plugin
Plugin URI: http://www.falkonproductions.com/browserDetector/
Description: This plugin will store the user agents for later parsing and display
Author: Drew Falkman
Version: 1.0
Author URI: http://www.falkonproductions.com/
 */

function bdetector_activate()
{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'bdetector';
	
	// will return NULL if there isn't one
	if ( $wpdb->get_var('SHOW TABLES LIKE ' . $table_name) != $table_name )
	{
		$sql = 'CREATE TABLE ' . $table_name . '( 
				id INTEGER(10) UNSIGNED AUTO_INCREMENT,
				hit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				user_agent VARCHAR (255),
				PRIMARY KEY  (id) )';
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
		
		add_option('bdetector_database_version','1.0');
	}
}

register_activation_hook(__FILE__,'bdetector_activate');

function bdetector_insert_useragent()
{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'bdetector';
	
	// $wpdb->insert($table_name,array('user_agent'=>$_SERVER['HTTP_USER_AGENT']),array('%s'));
	$safe_sql = $wpdb->prepare('INSERT INTO ' . $table_name . ' SET user_agent = %s', $_SERVER['HTTP_USER_AGENT']);
	$wpdb->query($safe_sql);
	$wpdb->show_errors();
}

add_action('wp_footer','bdetector_insert_useragent');