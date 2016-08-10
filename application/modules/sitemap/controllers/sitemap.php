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
 * Sitemap module public controller
 *
 * Also renders a machine-readable sitemap for search engines
 * 
 * @todo        Render a human-readable sitemap with all public pages and 
 *              blog categories
 * 
 * @package		PageStudio
 * @subpackage	Codeigniter
 * @category	Modules
 * @category	Common Functions
 * @author  	Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudiocms.com/docs/
 * @version 	1.1
 * @since       Version 1.2.0
 * @uses        https://github.com/chemicaloliver/codeigniter-sitemaps
 */
class Sitemap extends Public_Controller 
{    
    function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->xml();
    }

    // --------------------------------------------------------------------
    
	/**
	 * XML method - output sitemap in XML format for search engines.
	 * Saves the file to the root dir of your site.
	 * 
	 * @return void
	 */    
    public function xml()
    {        
        $this->load->library('sitemaps');
        $this->load->model('sitemap_model');
        
        // Override default required fields
        $this->sitemaps->set_item_keys(['loc', 'lastmod']);
        
        // First get a list of published entries and their urls 
        $posts = $this->sitemap_model->get_entries();       

        foreach ($posts as $post)
        {
            $item = array(
                "loc" => site_url($post->slug),
                "lastmod" => date("c", strtotime($post->modified_date)),
                // **CHANGED** 20160810 - Not sure these are helping at all...
                // "changefreq" => "monthly",
                // "priority" => "0.8"
            );

            $this->sitemaps->add_item($item);
        }

        // Save the file to the root dir of the site
        // File name may change when compression is enabled
        // $file_name = $this->sitemaps->build("sitemap.xml", false);
        $file_name = $this->sitemaps->build(null, false);
        
        // Notify search engines of our changes 
        $reponses = $this->sitemaps->ping(site_url($file_name));
        
        header ("Content-Type:text/xml");
        print($file_name);
        exit;
    }
}
