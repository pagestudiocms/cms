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
        
        $addons_model = $this->load->model('addons_model')->table('modules');
        $folders      = scandir(APPPATH . 'modules');
        
        foreach($folders as $folder)
        {
            if(file_exists(APPPATH . "modules/{$folder}/details.php"))
            {
                $Module = '\\Modules\\'. ucfirst($folder). '\\Details';
                $Module_info = $Module::info();
                
                $Module_info['is_enabled'] = $addons_model->is_enabled($folder);
                $data['modules'][] = array_to_object($Module_info);
            }
        }
        
        $data['modules_exists'] = ( ! empty($data['modules'])) ? true : false;

        $this->template->view('admin/modules/index', array_to_object($data, true));
	}   
    
    // ---------------------------------------------------------------
    
    /**
     * Method to enable a module
     * 
     * @return void
     */
    public function enable()
    {
        // Init
        $module_id    = $this->uri->segment(5);
        $addons_model = $this->load->model('addons_model');
        $status       = $addons_model->table('modules')->enable_module($module_id);
        
        // Set a success/error message
        if($status)
        {
            $this->session->set_flashdata('message', '<p class="success">Module activated.</p>');
        } 
        else 
        {
            $this->session->set_flashdata('message', '<p class="error">Something went wrong, the module was not activated.</p>');
        }

        redirect(ADMIN_PATH . "/addons/admin-modules");
    }
    
    // ---------------------------------------------------------------
    
    /**
     * Method to disable a module
     * 
     * @return void
     */
    public function disable()
    {
        // Init
        $module_slug    = $this->uri->segment(5);
        $addons_model = $this->load->model('addons_model');
        $status       = $addons_model->table('modules')->disable_module($module_slug);
        
        // Set a success/error message
        if($status)
        {
            $this->session->set_flashdata('message', '<p class="success">Module successfully deactivated.</p>');
        } 
        else 
        {
            $this->session->set_flashdata('message', '<p class="error">Something went wrong, the module was not deactivated.</p>');
        }

        redirect(ADMIN_PATH . "/addons/admin-modules");
    }
    
    // ---------------------------------------------------------------
    
    public function install()
    {
        // Init
        $module_slug = $this->uri->segment(5);
        $module      = '\\Modules\\'. ucfirst($module_slug). '\\Details';
        $status      = $module::run()->install();
        
        // Set a success/error message
        if($status)
        {
            $this->session->set_flashdata('message', '<p class="success">Module successfully activated.</p>');
        } 
        else 
        {
            $this->session->set_flashdata('message', '<p class="error">Something went wrong, the module was not activated.</p>');
        }

        redirect(ADMIN_PATH . "/addons/admin-modules");
    }
    
    // ---------------------------------------------------------------
    
    public function uninstall()
    {
        // Init
        $module_slug = $this->uri->segment(5);
        $module      = '\\Modules\\'. ucfirst($module_slug). '\\Details';
        $status      = $module::run()->uninstall();
        
        // Set a success/error message
        if($status)
        {
            $this->session->set_flashdata('message', '<p class="success">Module successfully deactivated.</p>');
        } 
        else 
        {
            $this->session->set_flashdata('message', '<p class="error">Something went wrong, the module was not deactivated.</p>');
        }

        redirect(ADMIN_PATH . "/addons/admin-modules");
    }
}
