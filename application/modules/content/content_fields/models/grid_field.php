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
    public $tracker = [];
    
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
        $entry_id = $this->uri->segment(6);
        $content_type_id = $this->uri->segment(5);
        $content_fields_array = ($this->session->userdata('content_fields')) ? $this->session->userdata('content_fields') : [];
        
        // Get all elligible fields 
        $content_fields = $this->db->select('*')->where('content_type_id', $content_type_id)->get('content_fields');

        for($i=0;$i<count($content_field_array = $content_fields->result());$i++) {
            if( ! array_key_exists($i, $content_fields_array)) {
                $content_fields_array[] = $content_field_array[$i]->id;
                $this->session->set_userdata(['content_fields' => $content_fields_array]);
                
                // Get the table cols and headers 
                $this->db->select('*');
                $this->db->where('content_field_id', $content_field_array[$i]->id);
                $grid_headers = $this->db->get('grid_cols');
                
                // Get the table rows
                $this->db->select('*, grid_col_data.id');
                $this->db->where('grid_cols.content_field_id', $content_field_array[$i]->id);
                $this->db->join('grid_cols', 'grid_cols.id = grid_col_data.grid_col_id', 'left');
                $this->db->order_by("grid_col_data.row_order", 'asc'); 
                $grid_rows = $this->db->get('grid_col_data');
                
                // Get the field settings
                $field_settings = $this->db->select('settings, sort')
                    ->where('content_type_id', $content_type_id)
                    ->get('content_fields')
                    ->result();
                return $this->table_output([
                    'grid_headers' => $grid_headers->result(),
                    'grid_rows' => $grid_rows->result(),
                    'content_field_id' => $content_field_array[$i]->id,
                    'content_type_id' => $content_type_id,
                    'entry_id' => $entry_id,
                    'field_settings' => $field_settings[0]->settings,
                    'field_sort' => $field_settings[0]->sort
                ]);
            }
        }
    }
    
    // ------------------------------------------------------------------
    
    private function table_output($params)
    {
        extract($params);
        extract(unserialize($field_settings));
        $max_rows = ( ! empty($max_rows)) ? $max_rows : 50;
        $total_cols = count($grid_headers);     // Get number of columns
        $row_count = 1;
        $count = 0;
        $out  = '';
		$out .= '
        <table id="content_type_'.$content_field_id.'" class="matrix order-list" border="0" cellpadding="0" cellspacing="0">
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
                            $row_count++;
                        }
                        if($count === 0) {
                            $out .= '
                            <th class="matrix matrix-first matrix-tr-header">
                                <div>
                                    <span>'.$row_count.'</span><a class="delRow" style="opacity: 1; display: inline;" title="Options"></a>
                                </div>
                            </th>';                            
                        }
                        $out .= $this->field_type(
                            $col->content_field_type_id,
                            $col->options,
                            $col->row_data,
                            $col->id
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
        <a class="matrix-btn matrix-add" id="field_'.$content_field_id.'_addrow_btn" title="Add row"></a>';
        
        $dynamic_rows = '';
        $count = 0;
        foreach($grid_headers as $key => $col ) {
            // if($count === 0) {
                // $dynamic_rows .= '
                // <th class="matrix matrix-first matrix-tr-header">
                    // <div>
                        // <span>'.$row_count.'</span><a style="opacity: 1; display: none;" title="Options"></a>
                    // </div>
                // </th>';                            
            // }
            $dynamic_rows .= $this->field_type(
                $col->content_field_type_id,
                $col->options,
                ''
            );
            $count++;
        }
        $dynamic_rows = json_encode($dynamic_rows);
        
        // Add module level javascript to head
        $script = "$(document).ready( function() {
            var counter = ". (($row_count >= 0) ? $row_count + 1 : 1) .";
            
            $('table#content_type_".$content_field_id.".matrix tbody').sortable({
                axis: 'y',
                placeholder: \"ui-state-highlight\",
                update: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    // POST to server using $.post or $.ajax
                    // $.ajax({
                        // data: data,
                        // type: 'POST',
                        // url: '/your/url/here'
                    // });
                }
            });

            $('#field_{$content_field_id}_addrow_btn').on('click', function(){

                // counter    = $('#content_type_".$content_field_id." table.matrix tr').length - 2;
                var newRow = $('<tr class=\"matrix\" id=\"tbl_row_\"+ counter +\"\">');
                var cols   = \"\";
                $('.matrix-norows').hide();
                
                cols += 
                '<th class=\"matrix matrix-first matrix-tr-header\">' +
                '    <div>' +
                '        <span>'+ counter +'</span><a class=\"delRow\" style=\"display: inline; opacity: 1;\" title=\"Options\"></a>' +
                '    </div>' +
                '    <input name=\"content_type_".$content_field_id."[row_order][]\" value=\"row_new_1\" type=\"hidden\">' +
                '</th>';
                cols += 'jQuery.parseJSON({$dynamic_rows})';
                newRow.append(cols);
                
                if (counter === ".$max_rows.") {
                    $('#field_{$content_field_id}_addrow_btn').hide();
                }
                $('table#content_type_{$content_field_id}').append(newRow);
                
                counter++;
            });

            $('table#content_type_{$content_field_id}').on('click', '.delRow', function(event){
                if (confirm('Are you sure you want to delete this?')) {
                    $(this).closest(\"tr\").remove();
                    counter -= 1;
                    if(counter <= ".$max_rows.") {
                        $('#field_{$content_field_id}_addrow_btn').show();
                    }
                }
            });
        });";
        $this->template->add_script($script);
        
        return $out;
    }
    
    // ------------------------------------------------------------------
   
    private function field_type($type, $options, $row_data, $grid_col_data_id = '')
    {
        $field = '';
        
        switch($type) {
            case 3 : $field = '
                <td style="width: auto;" class="matrix matrix-text">
                    <textarea style="overflow: hidden; min-height: 14px;" class="matrix-textarea" name="grid_col_data['.$grid_col_data_id.']" dir="ltr">'. $row_data .'</textarea>
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
                    <select name="grid_col_data['.$grid_col_data_id.']">
                    '. $select_field .'  
                    </select>
                </td>';
            break;
        }
        
        return $field;
    }
}
