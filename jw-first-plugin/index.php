<?php
/*
Plugin Name: JW First Plugin
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
add_filter( 'wp_title', function($content) {

    return strtoupper($content) . "fuck off";

});

add_filter( 'the_title', function($content) {

    return strtoupper($content);

});

add_filter('the_content', ucwords);

add_filter('the_content', function($content){

    $content = str_replace("WordPress", "dildoPress", $content);
    return strtoupper($content);

});

add_filter('the_title', function($content){

    $timestamp = time();
    // $date = date();
    $date = date('Y-m-d l  h:i:s A');

    $content = str_replace("WORDPRESS", "DildoPress", $content);
    return $content . '  ' . $date;

});

add_action( $tag, $function_to_add, $priority, $accepted_args );

add_action( 'wp_footer', function(){
    echo '<h1>What footer FUCK?</h1>';
});

add_action( 'wp_head', 'prowp_custom_css' );

function prowp_custom_css() {


?>
    <style type="text/css">
    a {
    font-size: .5em;
    color: red;
    text-decoration: none;
    }
    a:hover {
    font-size: 14px
    color: #FF0000;
    text-decoration: underline;
    }
    </style>
<?php

    echo "<h1><a>fuck the head!!</a></h1>";
}

add_action('comment_post', function(){
    $email = get_bloginfo('admin_email' );
    // echo "email sent to " . $email;
    wp_mail(
        $email,
        'New Comment Posted',
        'A new comment has been left ...'
    );

} );





































