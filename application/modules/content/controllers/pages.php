<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Pages extends Public_Controller 
{
	private $theme_config = '';

	function __construct()
	{
		parent::__construct();	
		
		$this->load->helper('shortcodes');
		include_once $this->theme_config = THEME_PATH . $this->settings->theme . '/config.php';
		
		$theme = array_to_object($config['theme_config'], true);
		if(isset($theme->shortcodes)) {
			include_once $this->theme_config = THEME_PATH . $this->settings->theme . '/' . $theme->shortcodes;
		}
	}
	
	function index()
	{
        $this->load->model('pages_model');
        $this->load->helper('functions');

        if ($this->settings->enable_profiler)
        {
            $this->output->enable_profiler(TRUE);
        }

        // Check if website has been suspended
        if ($this->settings->suspend)
        {
            return $this->load->view('settings/suspend', array());
        }

        $this->load->library('cache');
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
             * @since       Version 1.1.6
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
        // ------------------------------------------------------------
        // Added to support the calendar events rendering as a page
        // @todo    Pull content type from the content_type table
        // @author  Cosmo Mathieu <cosmo@cosmointeractive.co>
        // ------------------------------------------------------------
        elseif($this->uri->segment(1) === 'calendar' && $this->uri->segment(2)) {
            
            // Get the event id from the url 
            $segment       = explode('-', $this->uri->segment(2));
            $event_id       = trim($segment[0]);
            
            $query          = $this->db->get_where('calendar', array('id' => $event_id), 1);
            $EventInfo      = $query->result();
            $data['Event']  = $EventInfo[0];
            $event          = $data['Event'];
            
            $query          = $this->db->get_where('content_types', ['id' => 12], 1);
            $result         = $query->result();
            $content_type   = $result[0];

            // Display admin toolbar
            // $this->pages_model->admin_toolbar($Page->content_type_id, $Page->id);

            $this->template->set('event_id', $event->id);
            $this->template->set('content_type', $content_type->short_name);
            $this->template->set('title', $event->title);
            $this->template->set('featured_image', '<img src="'.$event->featured_image.'" />');

            // $data['_content'] = $Page->build_content();
            $data['_content'] = do_shortcode( 
                shortcode_empty_paragraph_fix( 
                    html_entity_decode($event->description)
                ));

            // Set Metadata
            $this->template->set_meta_title(strip_tags($event->title) . ' | ' . $this->settings->site_name);
                           // ->set_meta_title($event->meta_title)
                           // ->set_meta_description( ($event->meta_description) ? $event->meta_description : $this->settings->site_description)
                           // ->set_meta_keywords($event->meta_keywords);

            // Set the content type's theme layout, css, and javascript
            $this->pages_model->content_type_template($content_type);
            
            // Output Page
            $this->template->view('pages', $data);
        }
        elseif($this->uri->segment(1) === 'news' && $this->uri->segment(2) === 'page') {
            echo 'Pagination found.';
        }
        else
        {
            return $this->_404_error();
        }
	}

    private function _404_error()
    {
        $Page = $this->cache->model('entries_cache_model', 'cacheable_get_by', array('id' => $this->settings->content_module->custom_404), 'entries');

        // Send a 404 Header
        header("HTTP/1.0 404 Not Found");

        if ($Page->exists())
        {
            // Show admin_toolbar on page
            $this->pages_model->admin_toolbar($Page->content_type_id, $Page->id);

            $this->template->set('entry_id', $Page->id);
            $this->template->set('content_type', $Page->content_types->short_name);

            // Set content type's theme layout, css and javascript
            $this->pages_model->content_type_template($Page->content_types);

            $data['_content'] = $Page->build_content();
            $data['_content'] = shortcode_empty_paragraph_fix( 
                html_entity_decode($data['_content'])
            );
            $data['_content'] = do_shortcode( $data['_content'] );
        }
        else
        {
            $data['_content'] = "Page not found.";
        }


        $this->template->view('pages', $data);
    }
}
