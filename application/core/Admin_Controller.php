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
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */
 
// ------------------------------------------------------------------------

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        $this->template->set_theme('admin', 'default', 'application/themes');
        $this->template->parse_views = FALSE;

        $this->secure
            ->group_types(array(ADMINISTRATOR))
            ->unauthenticated_redirect(ADMIN_PATH . '/users/login')
            ->require_auth();
                
        // -------------------------------------
		// Build Admin Navigation
		// -------------------------------------       
        $this->template->set('admin_menu_items', get_admin_module_menu_items());

        // Load jQuery by default
        $this->template->add_package(['jquery', 'jquerytools', 'admin_jqueryui']);
	}

    public function _remap($method, $params = array())
    {
        // Check group type Administrator's permissions for access
        if ($this->Group_session->type == ADMINISTRATOR)
        {
            $permissions = unserialize($this->Group_session->permissions);
            $access_options = unserialize(ADMIN_ACCESS_OPTIONS);

            // If page is set as a permission access option but not in groups permissions, show permission denied
            if ( ( ! isset($permissions['access']) || ! in_uri($permissions['access'])) && in_uri($access_options, null, TRUE))
            {
                // Access forbidden:
                header('HTTP/1.1 403 Forbidden');

                return $this->template->view('users/admin/permission_denied');
            }
        }

        // User has permission, continue like normal
        $method = $method;

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }

        show_404();
    }
}
