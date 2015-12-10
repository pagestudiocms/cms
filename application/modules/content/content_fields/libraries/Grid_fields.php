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
 * @author      Cosmo Mathieu <cosmo@cimwebdesigns.com>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudio.com
 */

// ------------------------------------------------------------------------

/**
 * Grid Fields Content Type Library
 *
 * Provides the ability to add/update/delete grid content type fields.
 *
 * @todo        Save field data to database
 * @todo        Add ability to use tags in templates 
 * @todo        Add ability to save row sortable order
 * @todo        Add field validators such as: required, min/max chars, etc.
 * @todo        Add additional dynamic field types(i.e. dropdowns, ckedit) 
 *
 * @package		PageStudio
 * @subpackage	Content
 * @category	Module
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudio.com/user_guide/
 */ 
class Grid_fields 
{
    public  $fielName,
            $post = '',
            $gridData = [],
            $CI;
    
    public function __construct($data)
    {
        $this->post = $data;
        $this->CI = get_instance();
    }
    
    // Check if a grid field exist in the form submission
    public function run()
    {
        if($this->post['data']){
            $this->gridData = $this->post['data']['grid_col_data'];
            $this->validate($this->gridData);
            // var_dump($this->post['data']);
        }
    }

    // --------------------------------------------------------------------
    
    // Validate the grid field (required, min/max, etc.)
    public function validate($data)
    {
        if( ! empty($data)) {
            foreach($data as $id => $row_data) {
                $data = [
                   'row_data' => $row_data,
                ];
                $this->CI->db->where('id', $id);
                $this->CI->db->update('grid_col_data', $data); 
                
                echo $this->exists($id);
            }
        }
    }
    
    // --------------------------------------------------------------------
    
    public function exists($id, $grid_col_id = '')
    {
        $results = $this->CI->db->where('id', $id)->get('grid_col_data');
        return ($results->result()) ? true : false;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Method to update/insert/delete grid_cols data. 
     *
     * Receives an array containing column names and row data from a form. 
     * Logic: In the data passed, if the id of the fields are not already in 
     * the table, perform an insert. If it already exists, perform an update. 
     * Delete when the id exists in the table but isn't part of the form data 
     * passed. 
     * 
     * @access      public 
     * @return      
     */
    public function edit()
    {
        
    }
    
    // --------------------------------------------------------------------
    
    // Insert
    public function insert()
    {
        
    }
    
    // Update
    public function update()
    {
        
    }
    
    // Delete
    public function delete()
    {
        
    }
}
