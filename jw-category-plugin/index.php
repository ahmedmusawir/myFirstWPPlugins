<?php
/*
Plugin Name: JW Category Plugin
Plugin URI: http://www.shourav.info/firstPlugin/
Description: This plugin does things you never thought were possible.
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

add_filter('the_content', function($content){
    $id = get_the_id();

    if ( !is_singular('post')) {
        return $content;
    }

    $terms = get_the_terms( $id, 'category' );
    // print_r($terms);
    $cat = array();

    foreach ( $terms as $term ) {
        $cats[] = $term->cat_ID;
    }

    $loop = new WP_Query(
        array(
            'posts_per_page' => 3,
            'category__in' => $cats,
            'orderby' => 'rand',
            'post__not_in' => array($id)
        )
    );

    if ( $loop->have_posts() ) {

        $content .= '

            <h2>You Also MIght Like...</h2>
            <ul class="related-category-posts">

        ';

        while( $loop->have_posts() ){

            $loop->the_post();

            $content .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
      
        }

        $content .= '</ul>';

        wp_reset_query();
    }

    return $content;

} );










































