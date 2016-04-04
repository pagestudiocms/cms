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
