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
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudioapp.com
 */

// ------------------------------------------------------------------------

/**
 * Search Module
 *
 * Provides the ability to perform keyword search on your site. You can 
 * search both the calendar module and normal entries.
 *
 * @package		PageStudio
 * @subpackage	codeigniter
 * @category	Common Functions
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudio.com/user_guide/
 * @since       Version 1.2.0
 */
class Search extends Public_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function index()
    {
        $session = $this->session->userdata('search_terms');
        $results = $this->search($session['terms']);
        $this->session->unset_userdata('search_terms');
        
        // var_dump($session);
        // var_dump($results);
        
        $this->build($results);
    }
    
    /**
	 * Perform a FULLTEXT search on the page content for the specified search
	 * terms.
	 * 
	 * This method supports pagination. To enable pagination,
	 * $results_per_page must be set.
	 *
	 * @param string $terms The search terms.
	 * @param integer $start The record to start at (default is 0). Only applicable if $results_per_page is also set.
	 * @param integer $results_per_page The maximum number of results to return at once.
	 * @return array The search results.
	 * @author Joe Freeman
	 */
	private function search_old($terms, $start = 0, $results_per_page = 0)
	{
		// Determine whether we need to limit the results
		if ($results_per_page > 0) {
			$limit = "LIMIT $start, $results_per_page";
		} else {
			$limit = '';
		}
		
		// Execute our SQL statement and return the result
		$sql = "SELECT slug, title
				FROM entries
				WHERE MATCH (title) AGAINST (?) > 0
				$limit";
		$query = $this->db->query($sql, array($terms, $terms));
		return $query->result();
	}
    
    // --------------------------------------------------------------------
    
    /**
     * Loops through the content_type table and gets the ID's where searchable 
     * is set to true, and returns an array containing the ID's
     * 
     * Select all content data where field_id_xx matches items in the ID's array 
     * and return results array 
     * 
     * Loop through the results array and perform a kwyword search and return result
     *
     * @return  array
     */ 
    private function search($terms, $start = 0, $results_per_page = 0)
    {
        // Declare our vars
        $field_ids = '';        // Stores field_id_xx etc
        $fields = [];
        $terms = trim($terms);
        $tracker = [];
        
        // Returns an empty array if the search form was submitted empty
        if(empty($terms)) {
            return [];
        }
        
        // Determine whether we need to limit the results
		if ($results_per_page > 0) {
			$limit = "LIMIT $start, $results_per_page";
		} else {
			$limit = '';
		}
        
        // Loops through the content_type table and gets the ID's where 
        // searchable is set to true, and returns an array containing the ID's
        $searchFields = $this->db->select('id')->where('is_searchable','y')->get('content_fields');

        // Build query partial
        foreach($searchFields->result() as $key => $field) {
            $field_ids .= 'field_id_' . $field->id . ',';
            $fields[] = 'field_id_' . $field->id;
        }
        $field_ids = rtrim($field_ids, ','); // Remove final comma from string
        
        // Select all content data where field_id_xx matches items in the ID's 
        // array and return results array
        $this->db->select('
            entries_data.id,
            entry_id,
            entries.title,
            entries.meta_description,
            entries.slug,
            entries.status,
            ' . $field_ids
        );
        $this->search_helper($fields, $terms, true); // Query builder helper 
        $this->search_helper($fields, $terms, false); // Query builder helper 
        // $this->db->where('entries.status', 'drafts'); 
        $this->db->join('entries', 'entries.id = entries_data.entry_id');
        $search = $this->db->get('entries_data');
        
        // return $search->result();
        return [
            'terms' => $terms, 
            'results' => $search->result(), 
        ];
    }

    // --------------------------------------------------------------------
    
    /**
     * Helper function to search method
     *
     * @return  array
     */
    private function search_helper($fields, $terms, $search_rank = false)
    {
        $count = 0;
        for($i = 0;$i < count($fields); $i++) {
            // Keyword search | ranks lower
            if($search_rank === true) {
                $this->db->like($fields[0], $terms); // Produces ['field_id_xx', 'key phrase']
                if($i > 0) {
                    $this->db->or_like($fields[$i], $terms);
                }
            } else { // Phrase search | ranks higher
                $keywords = explode(' ', $terms);
                foreach($keywords as $keyword) {
                    if($count < 1) {                            
                        $this->db->like($fields[0], $keyword); // Produces ['field_id_xx', 'key word']
                    }
                    if($count > 0) {
                        $this->db->or_like($fields[$i], $keyword);
                    }
                    $count++;
                }
            }
        }
    }
    
    // --------------------------------------------------------------------
    
    // List results to the view 
    private function build($search = array())
	{
        $this->load->model('content/pages_model');
        $this->load->helper('functions');
        $this->load->helper('shortcodes');
        $this->load->helper('shortcode_list');
        $this->load->library('cache');

        if ($this->settings->enable_profiler) {
            $this->output->enable_profiler(TRUE);
        }

        // Check if website has been suspended
        if ($this->settings->suspend) {
            return $this->load->view('settings/suspend', array());
        }

        $slug = trim($this->uri->uri_string(), '/');

        if ( ! $slug)
        {
            // No segments found in URI, load the site homepage
            $Page = $this->cache->model('entries_cache_model', 'cacheable_get_by', array('id' => $this->settings->content_module->site_homepage), 'entries');
        }
        else
        {
            // Query and cache a list of all page slugs
            $all_pages = $this->cache->model('entries_cache_model', 'cacheable_page_slugs', array(), 'entries');

            // Find a page slug matching
            // the URI segments from cache/db
            if (isset($all_pages[$slug]))
            {
                $Page = $this->cache->model('entries_cache_model', 'cacheable_get_by', array('id' => $all_pages[$slug]), 'entries');                
            }
            else
            {
                // A static page was not found with this URI, 
                // Check if the URI matches a content type's dynamic route
                $Content_type_routes = $this->cache->model('content_types_cache_model', 'cacheable_dynamic_routes', array(), 'content_types');

                foreach ($Content_type_routes as $Content_type_route)
                {
                    // Check if URI starts with a dynamic route
                    if (strpos($slug, $Content_type_route->dynamic_route) === 0)
                    {
                        $array_offset = substr_count($Content_type_route->dynamic_route, '/') + 1;

                        $this->cms_base_route = $Content_type_route->dynamic_route;
                        $this->cms_parameters = array_slice($this->uri->segment_array(), $array_offset);

                        $Content_type = $this->cache->model('content_types_cache_model', 'cacheable_get_by_id', $Content_type_route->id, 'content_types');
                        break;
                    }
                }
            }
        }
      
        if (isset($Page) && $Page->exists())
        {
            // Check and enforce access permissions
            $this->pages_model->check_permissions($Page->content_types);

            // Only show published pages and
            // make drafts only visible to super admins and administrators
            if ($Page->status != 'published')
            {
                if ($Page->status != 'draft' || ($Page->status == 'draft' &&  ! $this->secure->group_types(array(ADMINISTRATOR))->is_auth()))
                {
                    return $this->_404_error();
                }
            }
            
            /**
             * Applying Shortcodes to all content_types tag content
             *
             * @since       Version 1.2.0
             * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
             */
            foreach($Page->content_fields as $key => $field) {
                $id = 'field_id_'.$field->id;
                $Page->entry_data->$id = do_shortcode( 
                    shortcode_empty_paragraph_fix( 
                        html_entity_decode($Page->entry_data->$id)
                    ));
            }

            // Display admin toolbar
            $this->pages_model->admin_toolbar($Page->content_type_id, $Page->id);

            $this->template->set('entry_id', $Page->id);
            $this->template->set('content_type', $Page->content_types->short_name);

            $data['_content'] = $Page->build_content();
            
            // List search results 
            if( ! empty($search)) {
                $data['search_term'] = $search['terms'];
                $data['_content'] .= '<h2>Search Results</h2>';
                if( isset($search['results']) && ! empty($search['results']) ) {            
                    foreach($search['results'] as $item) {
                        $data['_content'] .= '<a href="' . $item->slug . '">' . $item->title . '</a><br>';
                        $data['_content'] .= ( ! empty($item->meta_description)) ? shorten_phrase( $item->meta_description, 100 ) . '<hr>' : '...<hr>';
                    }
                } else {
                    $data['_content'] = '<h2>Search Results </h2>
                        <p>Your search for <strong><em>'. $search['terms'] .'</em></strong> did not return any results.</p>';
                }
            } else {
                $data['_content'] = '<h2>Search Results </h2> 
                    <p>Please enter something in the search field to begin your search.</p><br />';
            }

            // Set Metadata
            $this->template->set_meta_title(strip_tags($Page->title) . ' | ' . $this->settings->site_name)
                           ->set_meta_title($Page->meta_title)
                           ->set_meta_description( ($Page->meta_description) ? $Page->meta_description : $this->settings->site_description)
                           ->set_meta_keywords($Page->meta_keywords);

            // Set the content type's theme layout, css, and javascript
            $this->pages_model->content_type_template($Page->content_types);
            
            // Output Page
            $this->template->view('pages', $data);
        }
        elseif (isset($Content_type) && $Content_type->exists())
        {
            // Check and enforce access permissions
            $this->pages_model->check_permissions($Content_type);

            // Display admin toolbar
            $this->pages_model->admin_toolbar($Content_type->id);

            $data['title'] = $Content_type->title;
            $data['_content'] = $Content_type->build_content();
            $data['_content'] = shortcode_empty_paragraph_fix( 
                html_entity_decode($data['_content'])
            );
            $data['_content'] = do_shortcode( $data['_content'] );
            

            $this->template->set('content_type', $Content_type->short_name);

            // Set content type's theme layout, css and javascript
            $this->pages_model->content_type_template($Content_type);

            // Output Content Type
            $this->template->view('pages', $data);
        }
        elseif($this->uri->segment(1) === 'search' && $this->uri->segment(2) === 'page') {
            echo 'Pagination found.';
        }
        else
        {
            return $this->_404_error();
        }
	}
}
