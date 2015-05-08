<?php
/*
Plugin Name: A Simple JSON Widget
Plugin URI: http://www.shourav.info/filterPlugin/
Description: This widget brings in JSON feed and displays.
Author: Da Moose
Version: 1.0
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

class Json_Widget extends WP_Widget {


    function Json_Widget() {

        $params = array(
            'description' => 'Display Message',
            'classname' => 'json-widget'

        );

        parent::WP_Widget( 'json-widget', 'A JSON Widget', $params );
    }


    

    public function form( $instance ) {
        
        // print_r($instance);

        extract($instance, EXTR_SKIP);
        ?>
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
                <input type="text"
                    class="widefat"
                    id="<?php echo $this->get_field_id('title'); ?>" 
                    name="<?php echo $this->get_field_name('title'); ?>" 
                    value="<?php if ( isset($title) ) echo esc_attr($title); ?>"
                />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('authorname'); ?>">Author Name:</label>
                <input type="text" 
                    class="widefat"
                    id="<?php echo $this->get_field_id('authorname'); ?>" 
                    name="<?php echo $this->get_field_name('authorname'); ?>" 
                    value="<?php if ( isset($title) ) echo esc_attr($authorname); ?>"
                />
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('jsons_count'); ?>">Number of JSONs to Get:</label>
                <input type="number" 
                    class="widefat"
                    id="<?php echo $this->get_field_id('jsons_count'); ?>" 
                    name="<?php echo $this->get_field_name('jsons_count'); ?>" 
                    min="1"
                    max="10"
                    value="<?php echo !empty($jsons_count) ? $jsons_count : 5; ?>"
                />
            </p>
        
        <?php
    }

    public function widget( $args, $instance ) {

        // print_r($args);
        extract($args);
        extract($instance);

        if (empty($title))  $title = 'Recent Tweets';

        $data = $this->jsons($jsons_count, $authorname);

        if (false !== $data && isset($data->jsons)) {
            // print_r($data);
            echo $before_widget;
                echo $before_title;
                    echo $title;
                echo $after_title;

                echo '<ul><li>' . implode('</li><li>', $data->jsons) . '</li></ul>';
            echo $after_widget;

        }

    }

    private function jsons($jsons_count, $authorname) {

        if (empty($authorname)) return false;

        $jsons = get_transient('simple_jsons_widget');

        if (!$jsons || $jsons->authorname !== $authorname || $jsons->jsons_count !== $jsons_count) {
    
            return  $this->get_jsons($jsons_count, $authorname);
        }

        return $jsons;
    }

    private function get_jsons($jsons_count, $authorname) {


        $jsons = wp_remote_get( "http://127.0.0.1/author/$authorname/feed/json" );
        // print_r($jsons);
        $jsons = json_decode($jsons['body']);
        // print_r($jsons); 


        //There was a problem 
        if (isset($jsons->error)) return false;

        $data = new stdClass();
        $data->authorname = $authorname;
        $data->jsons_count = $jsons_count;
        $data->jsons = array();

        foreach($jsons as $json) {
            if ( $jsons_count-- === 0 ) break;
            $data->jsons[] = $this->filter_json($json->excerpt);

        }

        // print_r($data); die();
        set_transient( 'simple_jsons_widget', $data, 60 );
        return $data;
    }

    private function filter_json($json){

        $json = preg_replace('/(http[^\s]+)/im', '<a href="$1">$1</a>', $json);
        $json = preg_replace('/(@[^\s]+)/i', '<a href="http://wp1/author/$1">$1</a>', $json);

        return $json;
    }

}

function json_register_widget() {

    register_widget( "Json_Widget" );
}

add_action( 'widgets_init', 'json_register_widget' );






























