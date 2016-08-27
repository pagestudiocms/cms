<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    /**
     * @var  The currently loaded module
     */
    public $module;
    
	public function __construct()
	{
		parent::__construct();
        
        // Only allow access to installed modules
        $this->module_install_check();

        // Load in the admin helper functions if the current user is an administrator
        if ($this->secure->group_types(array(ADMINISTRATOR))->is_auth())
        {
            $this->load->helper('admin_helper');
        }

        $this->cms_parameters = array();
        $this->cms_base_route = '';

        // Check if to force ssl on controller
        if (in_uri($this->config->item('ssl_pages')))
        {
            force_ssl();
        } 
        else 
        {
            remove_ssl();
        }

        // Create Dynamic Page Title
        if ( ! $title = str_replace('-', ' ', $this->uri->segment(1)))
        {
            $title = 'Home';
        }

        if ($segment2 = str_replace('-', ' ', $this->uri->segment(2)))
        {
            $title = $segment2 . " - " . $title;
        }

        $this->template->set_meta_title(ucwords($title) . " | " . $this->settings->site_name);
        
        // Set Group
        if ($this->session->userdata('user_session'))
        {
            $this->group_id = $this->session->userdata('user_session')->group_id;
            $this->Group_session = $this->session->userdata('group_session');
        }
	}
    
    // ---------------------------------------------------------------
    
    /**
     * Only allow access to registered/activate modules
     * 
     * @return  bool True or False
     */
    public function module_install_check()
    {
        ci()->load->ext_model('addons_model', APPPATH . 'modules/addons/models');
        $module_model = new Addons_model('modules');
        
        $this->module = ci()->router->fetch_module();
        
        // Load all modules (the Events library uses them all) and make their details widely available
		ci()->enabled_modules = $module_model->get_modules(1);
        
        if( ! $module_model->is_enabled($this->module))
        {
            // If module is not installed and is front controller show 404
            if (is_a($this, 'Admin_Controller'))
            {
            }
            show_error('The <b>' . ucfirst($this->module) . '</b> module has been deactivated or has yet to be installed, please refer to your system administrator.', 500);
        }
    }
}

/**
 * Returns the CodeIgniter object.
 *
 * Example: ci()->db->get('table');
 *
 * @return \CI_Controller
 */
function ci()
{
	return get_instance();
}