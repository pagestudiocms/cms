<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on the on the CMS Canvas, the CodeIgniter 
 * application, http://cmscanvas.com/. It has been greatly altered to 
 * work for the purposes of our development team. Additional resources 
 * and concepts have been borrowed from PyroCMS http://pyrocms.com, 
 * for further improvement and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cimwebdesigns.com>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudio.com
 */

// ------------------------------------------------------------------------

/**
 * Grid
 *
 * Provides the ability to dynamically add / delete and sort rows of data 
 * similar to a spreadsheet. Each data row can have one or more cells which 
 * are assigned to different custom fields.
 * 
 * @note        Only the following fields are available: Text input, Textarea, 
 *              Select box, Checkbox, Dates
 *
 * @package		PageStudio
 * @subpackage	CodeIgniter
 * @category	Module
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudio.com/user_guide/
 */
class Grid_field extends Field_type
{
    public function settings()
    {
        $data = get_object_vars($this);
        
        return $this->load->view('settings/grid', $data, TRUE);
    }

    public function display_field()
    {        
        $data = get_object_vars($this);

        // Build options array
        $option_array = array();
        foreach (explode("\n", $this->Field->options) as $option)
        {
            $option = explode("=", $option, 2);
            $option_array[$option[0]] = (count($option) == 2) ? $option[1] : $option[0];
        }

        $data['Field']->options = $option_array;
        
        $data['table'] = $this->table();
        
        return $this->load->view('grid', $data, TRUE);
    }
    
    // ------------------------------------------------------------------
    
    private function table()
    {
        $entry_id = $this->uri->segment(5);
        // Get the table cols and headers 
        $this->db->select('*');
        $this->db->where('content_type_id', $entry_id);
        $grid_headers = $this->db->get('grid_cols');
        
        // Get the table rows
        $this->db->select('*');
        $this->db->join('grid_cols', 'grid_cols.id = grid_col_data.grid_col_id');
        $this->db->order_by("grid_col_data.row_order", 'asc'); 
        $grid_rows = $this->db->get('grid_col_data');
        
        return $this->output(
            $grid_headers->result(),
            $grid_rows->result(),
            $entry_id
        );
    }
    
    // ------------------------------------------------------------------
    
    public function output($grid_headers, $grid_rows, $entry_id)
    {
        $total_cols = count($grid_headers);     // Get number of columns
        $count = 0;
        $out  = '';
		$out .= '
        <table id="myTable" class="matrix order-list" border="0" cellpadding="0" cellspacing="0">
            <thead class="matrix">
                <tr class="matrix matrix-first matrix-last odd">
                    <th class="matrix matrix-first matrix-tr-header"></th>';
                foreach($grid_headers as $key => $col ) {
                    $out .= '
                    <th class="matrix'. (($count === $total_cols) ? 'matrix-last ' : '') .'">'. $col->label .'</th>';
                    $count++;
                }
		$out .= '</tr>
            </thead>
            <tbody class="matrix">';
                if( ! empty($grid_rows)) {
                    $count = 0;
                    
                    foreach($grid_rows as $key => $col ) {
                        if($count === $total_cols) {
                            $count = 0;
                            $out .= '<tr class="matrix matrix-first" id="tbl_row_1">';
                        }
                        if($count === 0) {
                            $out .= '
                            <th class="matrix matrix-first matrix-tr-header">
                                <div>
                                    <span>1</span><a style="opacity: 1; display: none;" title="Options"></a>
                                </div>
                            </th>';                            
                        }
                        $out .= $this->field_type(
                            $col->content_field_type_id,
                            $col->options,
                            $col->row_data
                        );
                        
                        $out .= ($count === $total_cols) ? '</tr>' : '';
                        $count++;
                    }
                    
                } else {
                    $out .= '
                    <tr class="matrix matrix-first matrix-last matrix-norows even">
                        <td colspan="'. $total_cols = $total_cols + 1 .'" class="matrix matrix-first matrix-firstcell matrix-last">No rows exist yet. <a>Create the first one.</a></td>
                    </tr>';
                }
        $out .= '
            </tbody>
        </table>
        <a class="matrix-btn matrix-add" id="addrow" title="Add row"></a>';
        
        return $out;
    }
    
    // ------------------------------------------------------------------
   
    public function field_type($type, $options, $row_data)
    {
        $field = '';
        
        switch($type) {
            case 3 : $field = '
                <td style="width: auto;" class="matrix matrix-text">
                    <textarea style="overflow: hidden; min-height: 14px;" class="matrix-textarea" name="field_id_30[row_new_1][col_id_34]" dir="ltr">'. $row_data .'</textarea>
                    <div class="matrix-charsleft-container"><div class="matrix-charsleft">'.$options.'</div></div>
                </td>';
            break;
            
            case 4 : 
                $select_field = '';
                foreach(explode("\r\n", $options) as $key => $option) {                    
                    $select_field .= '<option value="'.$option.'" '.(($row_data === $option) ? 'SELECTED' : '').'>'. $option .'</option>';
                }
                $field = '
                <td style="width: auto;" class="matrix matrix-firstcell">
                    <select name="field_id_30[row_new_1][col_id_33]">
                    '. $select_field .'  
                    </select>
                </td>';
            break;
        }
        
        return $field;
    }
}
