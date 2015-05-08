<?php
/*
Plugin Name: A Moose Simple Widget
Plugin URI: http://www.shourav.info/filterPlugin/
Description: This widget brings in JSON feed and displays.
Author: Da Moose
Version: 5.0
Author URI: http://www.shourav.info/

Copyright 2015  Da Moose

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

class Messager extends WP_Widget {


    function __construct() {

        $params = array(
            'description' => 'Display Message',
            'name' => 'A Simple Fuck Messager'

        );

        parent::__construct( 'messager', '', $params );
        // parent::__construct( 'messager', 'A Good Fuck', $params );
        // parent::WP_Widget( 'messager', '', $params );
    }

    

    public function form( $instance ) {
        
        // print_r($instance);

        // echo $instance['title'];
        // echo $this->get_field_id('title');
        // echo $this->get_field_id('description');
        
        extract($instance, EXTR_SKIP);
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input 
                    class="widefat"
                    id="<?php echo $this->get_field_id('title'); ?>" 
                    name="<?php echo $this->get_field_name('title'); ?>" 
                    value="<?php if ( isset($title) ) echo esc_attr($title); ?>"
                />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('description'); ?>">Description:</label>
                <textarea 
                    class="widefat"
                    id="<?php echo $this->get_field_id('description'); ?>" 
                    name="<?php echo $this->get_field_name('description'); ?>" 
                    rows=10 ><?php if ( isset($description) ) echo esc_attr($description); ?></textarea>
            </p>
        
        <?php
    }

    public function widget( $args, $instance ) {

        // print_r($args);
        extract($args);
        extract($instance);

        $title = apply_filters( 'widget_description', $title ); //NOT SURE WHAT THIS DO
        $description = apply_filters( 'widget_title', $description ); //NOT SURE WHAT THIS DO
                                                                      //
        if (empty($title)) $title = 'Slut Status';                                                                      
        
        echo $before_widget;
            echo $before_title . $title . $after_title;
            echo "<p>$description</p>";
        echo $after_widget;

    }

}

function dm_register_widget() {

    register_widget( "Messager" );
}

add_action( 'widgets_init', 'dm_register_widget' );






























