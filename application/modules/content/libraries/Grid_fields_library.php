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
 * @link        http://pagestudio.com
 */

// ------------------------------------------------------------------------

/**
 * Grid Fields Library
 *
 * 
 * @package		PageStudio
 * @subpackage	Modules
 * @category	Library
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudio.com/user_guide/
 */
class Grid_Fields_library
{
    private $CI,
            $pagenum_segment = NULL,
            $db = NULL;

    public  $entries = array(),
            $content_fields = array(),
            $entry_id = NULL,
            $content_type_id = NULL,
            $content_type = NULL;
            
    public function __construct()
    {
        $this->CI =& get_instance();    
        $this->CI->load->add_package_path(APPPATH . 'modules/content/content_fields');

        // Create a new instance of the activerecord class
        // And clear benchmarks for profiling
        $this->db =& $this->CI->db;
    }
	
	// --------------------------------------------------------------------
    
    /**
     * This method builds the grid field data to be displayed to the view
     * 
     * @param 		mixed|array $content_fields
     * @access		public 
     * @return 		array 
     */
    public function get_data($content_fields)
    {
        $data = []; // Final data to be returned to the caller 
        
        foreach($content_fields as $key => $content_field) {
			// Get field names associated with the content field 
			$this->db->select('id, short_tag');
			$this->db->where('content_field_id', $content_field->id);
			$grid_cols = count($this->db->get('grid_cols')->result());
          
			if ($grid_cols) 
			{
				// Get the table rows
				$query = $this->db->select('short_tag, grid_col_data.row_data');
				$query = $this->db->where('grid_cols.content_field_id', $content_field->id)
					->join('grid_cols', 'grid_cols.id = grid_col_data.grid_col_id', 'left')
					->order_by("grid_col_data.row_order", 'asc')
					->get('grid_col_data');
					
				$grid_rows = $query->result();
				$grid_data = [];
				$break = $grid_cols * 2;
				$count = 1;
				$array = [];
				$fields = [];
				$rows = 3;
				$new_array = [];
				
				foreach($grid_rows as $row => $data_set) {
					foreach($data_set as $key => $value) {
						if($count % 2) {
							$label = $value;
						} else {
							$new_array[$label] = $value;
							if($count % $rows === 0) {
								$data[$content_field->short_tag][] = $new_array;
								$new_array = [];
							}
						}
						$count++;
					}
				}				
			}
        }
        
		// var_dump($data); die();
        
        return $data;
    }
}
