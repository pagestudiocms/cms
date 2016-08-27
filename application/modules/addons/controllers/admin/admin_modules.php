<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * PageStudio CMS
 *
 * @author      Cosmo Mathieu
 * @copyright   Copyright (c) 2015
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */
 
// -------------------------------------------------------------------

class Admin_modules extends Admin_Controller 
{
	function __construct()
	{
		parent::__construct();	
	}
	
	public function index()
	{
        // Init
        $data = array();
        $data['breadcrumb'] = set_crumbs([current_url() => 'Modules']);
        $data['modules'] = [];
        
        $folders = scandir(APPPATH . 'modules');
        
        // var_dump($folders);
        foreach($folders as $folder)
        {
            if(file_exists(APPPATH . "modules/{$folder}/details.php"))
            {
                $data['modules'][] = $this->get_module_details(APPPATH . "modules/{$folder}/details.php", 0);
            }
        }
        
        $addons_model = $this->load->model('addons_model');
        $module_list  = $addons_model->table('modules')->get_modules();
        $data['modules_exists'] = ( ! empty($module_list)) ? true : false;
        $data['modules'] = $module_list;

        $this->template->view('admin/modules/index', array_to_object($data));
	}   
    
    // ---------------------------------------------------------------
    
    /**
     * Doc block parser
     * 
     * @access  Private
     * @param   string $file 
     * @return  string
     */
    private function get_module_details($file) 
    {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen( $file, 'r' );

        // Pull only the first 8kiB of the file in.
        $file_data = fread( $fp, 8192 );

        // PHP will close file handle, but we are good citizens.
        fclose( $fp );

        // Make sure we catch CR-only line endings.
        $file_data = str_replace( "\r", "\n", $file_data );
        
        $description = [];
        
        // split at each line
        foreach(preg_split("/(\r?\n)/", $file_data) as $line)
        {
            if( ! empty($line))
            {
                // if starts with an asterisk
                if( preg_match('/^(?=\s+?\*[^\/])(.+)/', $line, $matches) ) 
                {
                    $info = $matches[1];
                    
                    // If we find a leading asterisk, parse the value after as 
                    // the array key, and the value after that as the value
                    if(preg_match('~/*(.*?):~', $info, $output))
                    {
                        $param_name = trim(str_replace('*', '', $output[1]));
                        // remove leading asterisk, colon, and wrapping whitespace
                        $description[$param_name] = trim(str_replace(
                            '* :', '', str_replace($param_name, '', $info)
                        ));
                    }
                }
            }
        }
        
        return $description;
    }
}
