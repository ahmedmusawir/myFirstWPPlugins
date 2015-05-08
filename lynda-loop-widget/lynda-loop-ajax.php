<?php
/*
Plugin Name: A Lynda Loop Ajax Widget 
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

class Lynda_Loop_Widget extends WP_Widget {


    function Lynda_Loop_Widget() {

        $params = array(
            'description' => 'Display Message',
            'classname' => 'fuck-widget'

        );

        parent::WP_Widget( 'lynda-loop-two', 'A Lynda Loop Ajax Widget', $params );
    }

    function widget( $args, $instance ) {

        extract($args);
        extract($instance);

        echo $before_widget;
                echo $before_title;
                    echo $title;
                echo $after_title;


        $tpp_posts_query = new WP_Query(array('posts_per_page' => 5, 
                                                'orderby' => 'comment_count',
                                                'order' => 'DESC') );
                                                    // 'post__in' => get_option('sticky_posts'))  );
        ?>
        <ul>
            
          <h3><?php _e('Top Posts:') ?></h3>
            <?php if ( $tpp_posts_query->have_posts()) : 
                    while ( $tpp_posts_query->have_posts()) : 
                        $tpp_posts_query->the_post();
            ?>
            <div class="tpp_posts">
            <h2>
                <a href="<?php echo the_permalink(); ?>"
                id="<?php echo the_id()?>"
                title="<?php echo the_title(); ?>"
                class="comment_link"><?php echo the_title(); ?></a>
                (<?php echo comments_number(); ?>)
            </h2>
            </div>
            <?php   endwhile; 
                  endif; 
            ?>

        </ul>

        <?php 
        
        echo $after_widget;
        
        
    }
    
    function form( $instance ) {
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
        <?php
     
    }

}

function tpp_posts_comments_return()
{
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;
    
    if ( $post_id > 0 )
    {
            $post = get_post($post_id);
        ?>
        <div class='mypost'><?php echo $post->post_excerpt; ?></div>
        <?php 
    }
    die();
}
add_action('wp_ajax_nopriv_tpp_comments','tpp_posts_comments_return');


function tpp_posts_get_scripts ( ) {
  wp_enqueue_script( "tpp-posts", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/top_posts.js"), array( 'jquery' ) );
}
add_action('wp_print_scripts', 'tpp_posts_get_scripts');


function lynda_register_widget() {

    register_widget( "Lynda_Loop_Widget" );
}

add_action( 'widgets_init', 'lynda_register_widget' );






























