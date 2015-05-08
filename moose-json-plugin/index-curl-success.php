<?php
/*
Plugin Name: Da Moose JSON Plugin
Plugin URI: http://www.shourav.info/filterPlugin/
Description: This plugin/shorcode brings in JSON feed and displays.
Author: Da Moose
Version: 2.0
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
            'num_json' => 3
       ), $atts
     );

    extract($atts);

    if ( $show_json ) {
        bring_json( $num_json, $authorname, $json_reset_time );
    }

    return "<a href='http://wp1/author/$authorname'>$content</a>";
    // return "<a href='http://wp1/author/$authorname/feed/json'>$content</a>";

});

function bring_json( $num_json, $authorname, $json_reset_time ){

    $jsons = curl("http://wp1/author/$authorname/feed/json");

    // echo '<pre>';
    // print_r($jsons);
    // echo '</pre>';
    
    echo "<ul>";
    
    foreach ($jsons as $json) {
        
        echo "<li><a href='$json->permalink'>$json->title</a></li>";
        echo "<li>$json->author</li>";
        echo "<li>$json->date</li>";

    }

    echo "</ul>";

}

function curl($url) {

    $c = curl_init($url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($c, CURLOPT_TIMEOUT, 5);

    return json_decode( curl_exec($c) );
}
















































