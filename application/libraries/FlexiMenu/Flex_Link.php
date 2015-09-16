<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PageStudio
 *
 * PageStudio, formerly CMS Canvas, was created by Mark Price, and is now a 
 * project of CosmoInteractive
 * 
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>   
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://cosmointeractive.co
 */

// ------------------------------------------------------------------------

class Flex_Link 
{	
	/**
	 * Hyperlink's text
	 *
	 * @var string
	 */
	public $text;
	
	/**
	 * Hyperlink's URL
	 *
	 * @var string
	 */
	public $url;
	
	/**
	 * Hyperlink's attributes
	 *
	 * @var array
	 */
	public $attributes;

	/**
	 * Creates a hyperlink
	 *
	 * @param  string $title
	 * @param  string  $url
	 * @param  array  $attributes
	 * @return void
	 */
	public function __construct($text, $url, $attributes = array())
	{
		$this->text = $text;
		
		$this->url = $url;
		
		$this->attributes = $attributes;
	}


	/**
	 * Return hyperlink's URL
	 *
	 * @return string $url
	 */
	public function get_url()
	{
		return $this->url;
	}

	/**
	 * Return hyperlink's title
	 *
	 * @return string $title
	 */
	public function get_text()
	{
		return $this->text;
	}


	/**
	 * Append content at the end of hyperlink's text
	 *
	 * @return Link
	 */
	public function append($content)
	{
		$this->text .= $content;
		
		return $this;
	}	

	/**
	 * Add content at the beginning of hyperlink's text
	 *
	 * @return Link
	 */
	public function prepend($content)
	{
		$this->text = $content . $this->text;
		
		return $this;
	}


	/**
	 * Add attributes to the hyperlink
	 *
	 * @param mixed $attributes
	 * @return Link
	 */
	public function attributes()
	{
		$args = func_get_args();

		if(is_array($args[0])) {
			$this->attributes = array_merge($this->attributes, $args[0]);
			return $this;
		}
		
		elseif(isset($args[0]) && isset($args[1])) {
			$this->attributes[$args[0]] = $args[1];
			return $this;
		} 
		
		elseif(isset($args[0])) {
			return isset($this->attributes[$args[0]]) ? $this->attributes[$args[0]] : null;
		}
		
		return $this->attributes;
	}

}	