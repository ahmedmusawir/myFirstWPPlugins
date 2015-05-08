<?php
/*
Plugin Name: Da Moose Filter Plugin
Plugin URI: http://www.shourav.info/filterPlugin/
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


    // add_filter( 'the_content', function($content) {

        // return strtoupper($content);

    // });

    add_filter('the_title', ucwords);


    add_action( 'wp_head', 'moose_custom_css' );

        function moose_custom_css() {


        ?>
            <style type="text/css">
            a {
            /*font-size: .5em;*/
            color: red;
            text-decoration: none;
            }
            a:hover {
            /*font-size: 14px;*/
            color: #FF0000;
            text-decoration: none;
            }
            </style>
        <?php

        }

    add_action('comment_post', function(){

        $email = get_bloginfo( 'admin_email' );
        // echo "email sent to " . $email;
        wp_mail(
            $email,
            'New Comment Posted',
            'A new comment has been left ...'
        );

    });

    add_filter('the_title', function($content){

        $content = str_replace("WordPress", "MoosePress", $content);
        return $content;

    });





































