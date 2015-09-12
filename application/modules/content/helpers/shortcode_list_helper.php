<?php
/**
 * ShortCode Grouping
 *
 * Collection of shortcode functions to be used by the shortcodes API.
 * Write and register new shortcodes here. 
 * 
 * LICENSE: 
 * 
 * @category   helper functions
 * @package    PageStudio 
 * @author     Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright  Company Name (c) 2011 http://www.cimwebdesigns.com/
 * @see        shortcodes_helper.php, functions_helper.php
 * @since      1.1.0
 * @date       06/12/2014
 * @version    1.1.0
 * @modified   File updated 09/11/2015
 *
 * -------------------------
 * Table of Contents:
 * -------------------------
 * - shortcode_empty_paragraph_fix()
 * - page_excerpt()
 * - next_live_sermon_counter()
 */ 

/**
 * Shortcode Empty Paragraph Fix
 * 
 * This function fixes the empty paragraph tags around shortcodes
 * left by TinyMCE. 
 *
 * @author    http://www.johannheyne.de
 * @see       http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
 * @version   0.2
 * @since     Added in version 1.1.0
 * @return    $content
*/
function shortcode_empty_paragraph_fix( $content ) {

	$array = array (
		'<p>[' => '[',
		']</p>' => ']',
		']<br />' => ']'
	);

	$content = strtr( $content, $array );

	return $content;
}

/**
 * one_half() 
 * 
 * @syntax     one_half( $atts, $content = null ) 
 * @param      $atts, $content
 * @since      1.1.0
 * @return     $content;
 */ 
function one_half( $atts, $content = null ) {
		
	extract( 
		shortcode_atts( 
			array
			(
				'last'   => ''
			), $atts ) 
		);

	$position = ( $last == 'yes') ? 'last' : '';

	$content = '<div class="one_half ' . $position . '">' . do_shortcode( $content ) . '</div>';
	
	return $content;
}

/**
 * cols_3() 
 * 
 * @syntax     cols_3( $atts, $content = null ) 
 * @param      $atts, $content
 * @since      1.1.0
 * @return     $content;
 */ 
function cols_3( $atts, $content = null ) {
		
	extract( 
		shortcode_atts( 
			array
			(
				'first'   => '',
				'last'   => ''
			), $atts ) 
		);

	$first = ( $first == 'yes') ? 'alpha' : '';
	$last = ( $last == 'yes') ? 'omega' : '';

	$content = '<div class="rig columns-3 ' . $first . ' ' . $last . '">' . do_shortcode( $content ) . '</div>';
	
	return $content;
}

/**
 * Create Google map snippet
 *
 * Shortcode to create a Google map location avatar (image snippet)
 * with external page linking capabilities. 
 * @category    shortcode
 * @since       1.1.0
 */ 
function smp_map_it($atts,$content=null)
{	
	extract( 
		shortcode_atts( array( 
			'title' => 'Location:', 
			'address' => '', 
			'height' =>'200', 
			'width' => '200', 
			'border' => '', 
			'link' => 'false'
		), $atts)
	);
	
	/**
	 * Create a map with the desired height and width
	 */
	$base_map_url = 'http://maps.google.com/maps/api/staticmap?sensor=false&size=
		' . $width . 'x' . $height . '&format=png&center=';
	/**
	 * Add style to map image according to features
	 */
	$content = '<h2>' . $title . '</h2>';	
	$content .= ( $border == 'framed') ? ' <div class="map-frame">' : '';
	$content .= '<a href="' . $link . '" target="_blank">';
	$content .= '<img class="scale-with-grid ';
	$content .= ( $border == 'framed') ? ' map-border"' : '"';
	$content .=
		' width="
		' . $width . '" height="
		' . $height . 
		'" src="' . $base_map_url . urlencode($address) . '" />';
	$content .= '</a>';
	$content .= ( $border == 'framed') ? ' </div>' : '';
	
	return $content;
}

/**
 * This function copies the file containing the next live video countdown date.
 * DOES NOT NEED TO BE REGISTERED.
 * 
 * @syntax     copy_remote_file( file_directory_and_new_name, remote_file_dir_and_name ) 
 * @param      string $remote_file, 
 * @param      string $local_file
 * @modified   09/04/2014
 */ 
function copy_remote_file(
	$remote_file = 'http://www.sundaystreams.com/api/countdownxml/18/73422281/817/97799999/date.xml',
	$local_file = 'date.xml'
) {	
	/**
	 * Check if local file exists. Create a copy otherwise. 
	 */
	if (file_exists($local_file)) {
		$todays_date = date('Y-m-d');
		/**
		 * Get date file was last modified.
		 */
		$date_modified = date("Y-m-d", filemtime($local_file));
		
		if( $date_modified !== $todays_date ) {
			/**
			 * Delete original file
			 */
			unlink($local_file);
			/**
			 * Copy remote file to local directory.
			 */
			copy($remote_file, $local_file);
		}		
	} else {		
		/**
		 * The directory does not have a date file, create a copy. 
		 */ 
		copy($remote_file, $local_file);
	}	
}

/** 
 * Copy date.xml file from a remote location.
 * Used for the next_live_sermon shortcode.
 * @see         shortcode_list.php 
 */ 
copy_remote_file();	

/**
 * Next Live Sermon Countdown
 *
 * This shortcode adds a countdown to the next live sermon
 *
 * @version: 1.0.0
 */ 
function next_live_sermon_counter($atts,$content=null)
{	
	shortcode_atts( array( 
		'size' => 'large'
	), $atts);
	
	return '
		<ul class="countdown '. $atts['size'] .'">
			<li> 
				<span class="days">00</span>
				<p class="days_ref">days</p>
			</li>
			<li class="seperator">.</li>
			<li> 
				<span class="hours">00</span>
				<p class="hours_ref">hours</p>
			</li>
			<li class="seperator">:</li>
			<li> 
				<span class="minutes">00</span>
				<p class="minutes_ref">minutes</p>
			</li>
			<li class="seperator">:</li>
			<li> 
				<span class="seconds">00</span>
				<p class="seconds_ref">seconds</p>
			</li>
		</ul>
		';
}

/**
 * Retrieve text found within [page_excerpt] macros
 *
 * This shortcode is used in the featured section of the template. 
 *
 * @since     1.1.0
 * @param     (string) $atts (Required)
 * @return    $content
 *	function page_excerpt( $atts, $content = null )
 *	{	
 *		extract( 
 *			shortcode_atts( 
 *				array
 *				(
 *					'size'   => ''
 *				), $atts ) 
 *			);
 *
 *		echo $size;
 *		if( $size == 'large') {	
 *			$content = GetBetween( $atts, '[page_excerpt size="large"]', '[/page_excerpt]' );
 *			$content = '<div class="jumbotron">' . do_shortcode( $content ) . '</div>';		
 *		} 
 *		if( $size == '') {	
 *			$content = GetBetween( $atts, '[page_excerpt]', '[/page_excerpt]' );
 *			$content =  '<div class="text-white">' . do_shortcode( $content ) . '</div>';
 *		}
 *		
 *		return $content;
 * 	}
 */
function page_excerpt( $atts )
{	
	global $page;
	
	$content = GetBetween( $atts, '[page_excerpt size="large"]', '[/page_excerpt]' );
	if(!$content){
		$content = GetBetween( $atts, '[page_excerpt size="small"]', '[/page_excerpt]' );
		$content = '<div class="text-white">' . do_shortcode( $content ) . '</div>';
	} 
	elseif($content){	
		$content = '<div class="jumbotron">' . do_shortcode( $content ) . '</div>';		
	}
	
	return $content;
	//return $page->set('page_excerpt', $content);
}

/**
 * featured_heading() 
 * 
 * ShortCode that adds a styled h2 (heading) to the body area.
 * 
 * @param      (array) $atts
 * @param      (string) $content
 * @return     string
 */ 
function featured_heading( $atts, $content )
{
	$content = '
	<div class="featured-content">
		'. do_shortcode( $content ) .'
	</div><!-- featured-h2 .end -->';
			
	return $content;
}

/**
 * Shortcode to style a link to a button 
 */
function add_button( $atts, $content=null )
{	
	/*
	 */
	extract( shortcode_atts(array(
       'text' => 'button',
       'size' => 'btn-default',
       'alt' => '',
       'target' => 'self',
       'link' => '#'
    ), $atts) );
	
	return '<a href="' . $link . '" class="button lg" target="'.$target.'">' . $text . '</a>';	
}

function lorem_function() {
	return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec nec nulla vitae lacus mattis volutpat eu at sapien. Nunc interdum congue libero, quis laoreet elit sagittis ut. Pellentesque lacus erat, dictum condimentum pharetra vel, malesuada volutpat risus. Nunc sit amet risus dolor. Etiam posuere tellus nisl. Integer lorem ligula, tempor eu laoreet ac, eleifend quis diam. Proin cursus, nibh eu vehicula varius, lacus elit eleifend elit, eget commodo ante felis at neque. Integer sit amet justo sed elit porta convallis a at metus. Suspendisse molestie turpis pulvinar nisl tincidunt quis fringilla enim lobortis. Curabitur placerat quam ac sem venenatis blandit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam sed ligula nisl. Nam ullamcorper elit id magna hendrerit sit amet dignissim elit sodales. Aenean accumsan consectetur rutrum.';
}

function random_picture($atts) {
    extract(shortcode_atts(array(
       'width' => 400,
       'height' => 200,
    ), $atts));
	
    return '<img src="http://placehold.it/'. $width . 'x'. $height . '" />';
}

function add_slideshow($atts) {
    extract(shortcode_atts(array(
       'id' => 1,
       'width' => 400,
       'height' => 200,
    ), $atts));
	
    return '
        <!-- flexSlider -->
        <div class="flexslider">
            <ul class="slides">
                {{ galleries:gallery gallery_id="'.$id.'" }}
                <li>
                    <img src="{{ helper:image_thumb image=image crop="false"}}" alt="{{ alt }}" />
                </li>
                {{ /galleries:gallery }}
            </ul>
        </div>';
}

/** 
 * Register shortcodes.
 *
 * @usage    add_shortcode( name, function_name )
 */
add_shortcode('slideshow', 'add_slideshow');
add_shortcode('media', 'add_post_cover_img');
add_shortcode('post_cover', 'add_post_cover_img');
add_shortcode('home_blurb', 'home_blurb');
add_shortcode('page_excerpt', 'page_excerpt');
add_shortcode('callout', 'featured_heading');
add_shortcode('lorem', 'lorem_function');
add_shortcode('picture', 'random_picture');
add_shortcode('map-it','smp_map_it');
add_shortcode('button','add_button');
add_shortcode('one_half', 'one_half');
add_shortcode('cols_3', 'cols_3');
add_shortcode('live_sermon_counter', 'next_live_sermon_counter');