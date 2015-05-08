<?php
/*
Plugin Name: A Map Shortcode Plugin
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

function smp_map_it($atts,$content=null)
{	
	$address = "2657 Ashleigh Lane, Alpharetta, GA 30004";
	$map_string = "&zoom=13&size=600x300&maptype=roadmap";
	$atts = shortcode_atts( array( 'title' => 'Your Map:', 'address' => $address), $atts);

	extract($atts);
	print_r($atts);
	$base_map_url = 'http://maps.google.com/maps/api/staticmap?sensor=false&size=456x456&format=png&center=';
	return '<h2>' . $title . '</h2>
	<img width="456" height="456"
		src="' . $base_map_url . urlencode($address) . $map_string . '" />';
}
	
add_shortcode('map-it','smp_map_it');
