<?php  defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * PageStudio
 *
 * A web application for managing website content. For use with PHP 5.4+
 * 
 * This application is based on CMS Canvas, a CodeIgniter based application, 
 * http://cmscanvas.com/. It has been greatly altered to work for the 
 * purposes of our development team. Additional resources and concepts have 
 * been borrowed from PyroCMS http://pyrocms.com, for further improvement
 * and reliability. 
 *
 * @package     PageStudio
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @copyright   Copyright (c) 2015, Cosmo Interactive, LLC
 * @license     MIT License
 * @link        http://pagestudiocms.com
 */

// ------------------------------------------------------------------------

/**
 * Url Plugin
 *
 * Brings the features of the url helper to the templates in the form of a plugin. 
 *
 * @package		PageStudio
 * @subpackage	codeigniter
 * @category	Helper
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudiocms.com/docs/
 * @license     MIT License
 * @since       Version 1.3.0
 */
class Url_plugin extends Plugin
{
    /**
     * Returns the base url of a provided path
     * 
     * @return string
     */
    public function base_url()
    {
        return base_url($this->attribute('path', ''));
    }
    
    // --------------------------------------------------------------------

    /**
     * 
     * 
     * @return string
     */
    public function current_url()
    {
        return current_url();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 
     * 
     * @return string
     */
    public function site_url()
    {
        return site_url($this->attribute('path', ''));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Returns part of the URI segment or a URL query parameter
     * 
     * Usage:
     * 
     *  {{ url:get segment="[int]" }} 
     * 
     *  {{ url:get param="[string]" }}
     *
     * @since      1.3.0
     * @access     public 
     * @return     string
     */
    public function get()
    {
        if($this->attribute('segment'))
        {
            return ci()->uri->segment($this->attribute('segment'));
        }
        elseif($this->attribute('param'))
        {
            return ci()->input->get($this->attribute('param'), TRUE);
        }
        
        return FALSE;
    }
    
    // --------------------------------------------------------------------
    
    /**
	 * Send the visitor to another location
	 *
	 * Usage:
	 * 
	 *  {{ url:redirect to="[string]" }}
	 *
	 * @return  void
	 */
	public function redirect()
	{
		redirect($this->attribute('to'));
	}
}
