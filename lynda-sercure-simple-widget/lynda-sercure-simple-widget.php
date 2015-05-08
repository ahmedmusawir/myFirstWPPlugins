<?php
/*
Plugin Name: A Secure Simple Widget
Plugin URI: http://www.falkonproductions.com/simpleWidget/
Description: A simple OOP widget
Author: Drew Falkman
Version: 1.0
Author URI: http://www.falkonproductions.com/
 */

class SecureSimpleWidget extends WP_Widget
{
	function SecureSimpleWidget()
	{
		$widget_options = array(
			'classname'		=>	'simple-widget',
			'description'	=>	'Just a simple widget');
		
		parent::WP_Widget('secure_simple_widget','A Secure Simple Widget', $widget_option);
	}
	
	function widget($args, $instance)
	{
		extract( $args, EXTR_SKIP );
		$title = ( $instance['title'] ) ? $instance['title'] : 'A simple widget';
		$body = ( $instance['body'] ) ? $instance['body'] : 'A simple message';
		?>
		<?php echo $before_widget; ?>
		<?php echo $before_title . $title . $after_title ?>
		<p><?php echo $body ?></p>
		<?php
	}
	
	function update($new_instance,$old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$allowed_html = array('a' => 
								array('href' => array(),
									  'title' => array()),
							'br'=> array(),
							'strong'=> array(),
							'em'=> array());
		$instance['body'] = wp_kses($new_instance['body'],$allowed_html);
		return $instance;
	}
	
	function form( $instance )
	{
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title');?>">
			Title:
			<input class="widefat" id="<?php echo $this->get_field_id('title');?>"
				name="<?php echo $this->get_field_name('title'); ?>"
				value="<?php echo esc_attr($instance['title']); ?>" />
			</label>
			<label for="<?php echo $this->get_field_id('body');?>">
		</p>
		<p>
			Body:
			<textarea class="widefat" id="<?php echo $this->get_field_id('body');?>"
				name="<?php echo $this->get_field_name('body'); ?>"><?php echo esc_attr($instance['body']);?></textarea>
			</label>
		</p>
		<?php 
	}
}

function simple_widget_init()
{
	register_widget("SecureSimpleWidget");
}
add_action('widgets_init','simple_widget_init');