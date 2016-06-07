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
     * Builds an array of Grid parent to child fields
     *
     * It receives an array containing all the fields relating to the entry 
     * to be viewed. Strips out all content types which are not of Grid type,
     * retrieves the child data for each Grid field type, and returns it to the caller.
     * 
     * Makes the following possible in templates: 
     * <code>
     * {{ grid_field_short_tag }}
     *    {{ child_field_one_short_tag }}
     *    {{ child_field_two_short_tag }}
     * {{ /grid_field_short_tag }}
     * <code>
     *
     * @param 		string $entry_id
     * @param 		array $content_fields
     * @access		public 
     * @return 		array
     */
    public function get_data($entry_id, $content_fields)
    {
        $data = []; // Holds processed data to be returned to the caller 
        
        // Remove all non-Grid content types from the $content_fields array
        $needle = 0;
        foreach($content_fields as $field) {
            if($field->content_field_type_id != '16') { // 16 is the Grid field type id
                unset($content_fields[$needle]);
                $needle++;
            }
        }
        
        // Fetch all child records per content type, and process each content type 
        // individually.
        foreach($content_fields as $key => $content_field) {
            $query = $this->db->select('short_tag, grid_col_data.row_data')
                ->where('grid_cols.content_field_id', $content_field->id)
                ->where('grid_col_data.entry_id', $entry_id)
                ->join('grid_cols', 'grid_cols.id = grid_col_data.grid_col_id', 'left')
                ->order_by("grid_col_data.row_order", 'asc')
                ->get('grid_col_data');
                
            $grid_cols_data = $query->result();
            $i          = 1;
            $needle     = 0;
            
            // Get the total tags each array should have
            $total_fields = $this->db->select('id')->where('content_field_id', $content_field->id)->get('grid_cols')->result();
            $total_fields = count($total_fields);

            // Create a new array (of unique short_tags) for later comparison
            $row_short_tags = array_unique( array_map( function ($i) { 
                    return $i->short_tag; 
                }, $grid_cols_data
            ));
            // Flip the array so we can later use array_key_exists() 
            $row_short_tag_keys = array_flip($row_short_tags);

            // Format $data array how the Lex Parser expects it
            foreach($grid_cols_data as $col_item) {
                if(array_key_exists($col_item->short_tag, $row_short_tag_keys)) {
                    $data[$content_field->short_tag][$needle][$col_item->short_tag] = $col_item->row_data;
                }
                
                if ($i < $total_fields) {
                    $needle = $needle;
                }
                else {
                    $needle++;
                    $i = 0;
                }
                $i++;
            }			
        }
        
        return $data;
    }
}
