<?php
/*
Plugin Name: JW JSON ShortCode Plugin
Plugin URI: http://www.shourav.info/filterPlugin/
Description: This plugin brings in JSON feed and displays.
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

// add_shortcode('json', function($atts){

    // print_r($atts); die();
    // if ( !isset($atts['authorname']) ) $atts['authorname'] = 'kash';

    // return '<a href="http://wp1/author/'. $atts['authorname'].'/feed/json">Follow my puss on Flickr</a>';

// } );


add_shortcode('json', function($atts, $content){

    $atts = shortcode_atts(
       
       array(
            'authorname' => 'kash',
            'content' => !empty($content) ? $content : 'Follow me on Twitter!'
       ), $atts
     );

    extract($atts);

    return "<a href='http://wp1/author/$authorname/feed/json'>$content</a>";

});


















































