<?php
/*
Plugin Name: Da Moose JSON Plugin
Plugin URI: http://www.shourav.info/filterPlugin/
Description: This plugin/shorcode brings in JSON feed and displays.
Author: Da Moose
Version: 4.0
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

add_shortcode('json', function($atts, $content){

    $atts = shortcode_atts(
       
       array(
            'authorname' => 'kash',
            'content' => !empty($content) ? $content : 'Follow me on Flickr!',
            'show_json' => true,
            'json_reset_time' => 1,
            'num_json' => 5
       ), $atts
     );

    extract($atts);

    if ( $show_json ) {

        $jsons = bring_json( $num_json, $authorname, $json_reset_time );
    }

    return "$jsons <p><a href='http://wp1/author/$authorname'>$content</a></p>";

});

function bring_json( $num_json, $authorname, $json_reset_time ){

    global $id;
    $recent_jsons = get_post_meta( $id, 'dm_recent_jsons' );

    reset_data( $recent_jsons, $json_reset_time);

    // IF NO CACHE, FETCH NEW JSONS AND CACHE 
    if (empty($recent_jsons)) {

        $jsons = curl("http://127.0.0.1/author/$authorname/feed/json");
        // print_r($jsons); die();

        $data = array();

        foreach ($jsons as $json) {
            
           if ( $num_json-- === 0 ) break;
           $data[] = $json->excerpt;

        }

        $recent_jsons = array( (int)date('i', time()));
        $recent_jsons[] = '<ul class="dm_jsons"><li>' . implode('</li><li>', $data) . '</li></ul>';

        cache($recent_jsons);


    }

    
    return isset($recent_jsons[0][1]) ? $recent_jsons[0][1] : $recent_jsons[1];

}

function curl($url) {

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($c, CURLOPT_TIMEOUT, 5);

    return json_decode( curl_exec($c) );
}

function cache($recent_jsons) {

    global $id;
    // delete_post_meta($id, 'dm_recent_jsons');
    add_post_meta($id, 'dm_recent_jsons', $recent_jsons, true);
}

function reset_data($recent_jsons, $json_reset_time) {

    global $id;
    // print_r($recent_jsons);
    
    if ( isset($recent_jsons[0][0])) {

        $delay = $recent_jsons[0][0] + (int)$json_reset_time;

        if ( $delay >= 60 ) $delay -= 60;

        if ( $delay <= (int)date( 'i', time() )) {
            delete_post_meta($id, 'dm_recent_jsons');
        }
    }
}














































