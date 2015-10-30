<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CMS Canvas
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://cmscanvas.com
 */

class Galleries_plugin extends Plugin
{
    public $images = array();

    /**
     * Gallery
     *
     * Returns the status of the gallery to the user. 
     * 
     * @author     Cosmo Mathieu <http://cosmointeractive.co>
     * @since      Version 1.2.0
     * @return     array
     */
    public function gallery_exists()
    {       
        $gallery_id = $this->attribute('gallery_id');

        // Check if we received a string or a tag with {{ open-and-close-braces }}
        // Match the tag key in the $data array and parse the corresponding info.
        if (
            (strpos($gallery_id,'{{') && strpos($gallery_id,'}}')) !== false || 
            (strpos($gallery_id,'{') && strpos($gallery_id,'}')) !== false 
        ) {
            $array = array (
                '{{' => '',
                '}}' => '',
                '{' => '',
                '}' => ''
            );
            $tag = trim(strtr( $gallery_id, $array ));
            $gallery_id = $data[$tag];
        } 
        
        $this->Gallery = $this->load->model('galleries_model');
        $this->Gallery->get_by_id($gallery_id); 

        return ($this->Gallery->exists()) ? true : false;
    }
    
    /*
     * Gallery
     *
     * Builds array of images to use for custom content
     *
     * @return array
     */
    public function gallery()
    {
        $this->_build_image_array();
        
        return $this->images;
    }

    // ------------------------------------------------------------------------

    /*
     * Initialize
     *
     * Queries and builds array of gallery images and thumbs
     *
     * @access private
     * @return void
     */
    private function _build_image_array()
    {
        $this->Gallery = $this->load->model('galleries_model');

        $this->Gallery->get_by_id($this->attribute('gallery_id'));

        if ( ! $this->Gallery->exists())
        {
            return false;
        }

        $Images = $this->Gallery->images->where('hide', 0)->order_by('sort', 'ASC')->get();
        
        foreach($Images as $Image)
        {
            $this->images[] = array(
                'title'       => $Image->title,
                'alt'         => $Image->alt,
                'description' => $Image->description,
                'image'       => $Image->filename,
            );
        }
    }

}

