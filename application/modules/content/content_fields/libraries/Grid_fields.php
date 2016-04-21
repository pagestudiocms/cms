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
 * @link        http://pagestudioapp.com
 */

// ------------------------------------------------------------------------

/**
 * Grid Fields Content Type Library
 *
 * Provides the ability to add/update/delete grid content type field data.
 *
 * @todo        Add ability to save row sortable order
 * @todo        Add field validators such as: required, min/max chars, etc.
 * @todo        Add additional dynamic field types(i.e. dropdowns, ckedit) 
 *
 * @package		  PageStudio
 * @subpackage	Libraries
 * @category	  Module
 * @author		  Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		    http://pagestudioapp.com/user_guide/
 */ 
class Grid_fields 
{
    public  $fieldName,
            $post = '',
            $gridData = [],
            $CI, 
            $grid_col_data = 'grid_col_data';
    
    public function __construct($data = [])
    {
        $this->post = $data;
        $this->CI = get_instance();
    }
    
    /**
     * Default bootstrap method 
     *
     * Check if a grid field exist in the form submission and run default 
     * methods and actions 
     *
     * @access    public 
     * @return    void
     */
    public function run()
    {
		// var_dump($this->post['data']);
      if($this->post['data']){
        $this->gridData = $this->post['data']['grid_col_data'];
        $this->save($this->gridData); // Call the save method | true/false
      }
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
     * @access      private 
     * @param       array $gridData Array of post data
     * @return      bool true/false
     */
    private function save($gridData, $row_order = [])
    {
      if( ! empty($gridData)) {
        foreach($gridData as $id => $row_data) {
          // This empty foreach loop is responsible for assigning values 
          // for $grid_col_data, $col_data
          foreach($row_data as $grid_col_id => $col_data) {
          }
          $data = [
            'grid_col_id' => $grid_col_id,
            'row_data' => $col_data,
          ];
          
          // Update existing fields 
          $this->update($id, $data);
		  
          // Insert new fields in database if not exists
          if( ! $this->exists($id)) {
			// $data['row_order'] = 5;
			// var_dump($data);
            $this->insert($data);
          }
        }
		  // die();
        return true;
        
      } else {
        return false;
      }
    }

    // --------------------------------------------------------------------
    
    // Validate the grid field (required, min/max, etc.)
    public function validate()
    {
      
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Determines whether or not grid field is found in the table 
     *
     * @return      bool true/false
     */
    private function exists($id, $grid_col_id = '')
    {
      $results = $this->CI->db->where('id', $id)->get('grid_col_data');
      return ($results->result()) ? true : false;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Method to insert grid_cols data
     *
     * @param       array $data
     * @return      bool true/false
     */
    private function insert($data)
    {
      return $this->CI->db->insert($this->grid_col_data, $data);
    }
    
    /**
     * Method to udpdate grid_cols data
     *
     * @param       int $id
     * @param       array $data
     * @return      bool true/false
     */
    private function update($id, $data)
    {
      return $this->CI->db->where('id', $id)->update('grid_col_data', $data); 
    }
    
    // Delete
    private function delete()
    {
        
    }
}
