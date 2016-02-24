<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on the CodeIgniter CMS application; 
 * CMS Canvas <http://cmscanvas.com/>. It has been greatly altered to work 
 * for the purposes of our development team. Additional resources and 
 * concepts have been borrowed from PyroCMS http://pyrocms.com, for further 
 * improvement and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */

// ------------------------------------------------------------------------

/**
 * Grid Fields Content Type Model
 *
 * Provides the ability to add/update/delete grid content type field data.
 *
 * @package		  PageStudio
 * @subpackage	  Models
 * @category	  Module
 * @author		  Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		  http://pagestudiocms.com/docs/
 */ 
class Grid_fields_model extends CI_Model
{
    private $content_field_id;
    private $content_type_id;
    
    public function save($post_data)
    {
        $this->content_field_id = $this->uri->segment(6);
        $this->content_type_id = $this->uri->segment(5);
        
        $data = array(
           'content_field_id' => $this->content_field_id,
           'content_type_id' => $this->content_type_id,
        );
        
        foreach($post_data as $fields){
            foreach($fields as $field => $value){
                $data[$field] = $value;
            }
            $this->db->insert('grid_cols', $data);
        }
    }
    
    public function get_fields()
    {
        return [];
    }
}