<?php
/*
Plugin Name: A DB Info Plugin
Plugin URI: http://www.falkonproductions.com/dbinfo/
Description: This plugin tells admin stuff about the db
Author: Drew Falkman
Version: 1.0
Author URI: http://www.falkonproductions.com/
 */

function databaseinfo_dashboard_widget()
{
	global $wpdb;
	?>
	<h2>DB Info Dashboard Widget</h2>
	<?php // var_dump($wpdb); die();

	global $current_user; ?>

	<p><b>Current User: </b> <?php echo $wpdb->get_var($current_user->ID); ?></p>
	<p><b>Last Query: </b> <?php echo $wpdb->last_query ?></p>
	<p><b>Last Error: </b> <?php echo $wpdb->last_error ?></p>
	<p><b>Total Users: </b><?php echo $wpdb->query('SELECT ID FROM wp_users')?></p>
	<p><b>Last post: </b>

		<?php echo $wpdb->get_var('SELECT post_title FROM ' . $wpdb->posts . ' WHERE post_author = ' . $current_user->ID); ?>
	</p>
	<p><b>User Emails: </b>
	<pre>
		<?php $user_emails =  $wpdb->get_col('SELECT user_email FROM ' . $wpdb->users);
			echo var_dump($user_emails); ?>
	</pre></p>
	<p><b>User Fucks: </b>
	<pre>
		<?php $user_logins =  $wpdb->get_col('SELECT user_login FROM ' . $wpdb->users);
			echo var_dump($user_logins); ?>
	</pre></p>
	<p><b>Your user info: </b>
	<pre>
		<?php $my_user_data = $wpdb->get_row('SELECT * FROM ' . $wpdb->users . ' WHERE ID = ' . $current_user->ID, ARRAY_N);
			echo var_dump($my_user_data); ?>
	</pre></p>
	<p><b>All Post Terms: </b>
	<pre>
		<?php $terms = $wpdb->get_results('SELECT * FROM ' . $wpdb->terms, ARRAY_N);
			echo var_dump($terms); ?>
	</pre></p>
	<?php 
}

function databaseinfo_register_widget()
{
	wp_add_dashboard_widget('databaseinfo-dashboard-widget','Counter Dashboard Widget', 'databaseinfo_dashboard_widget');
}

add_action('wp_dashboard_setup', 'databaseinfo_register_widget');