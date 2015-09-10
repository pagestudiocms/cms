<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Entries extends Admin_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
    // ------------------------------------------------------------------------

    /*
     * Index
     *
     * Display entries and apply any search filters

     * @return void
     */
	function index()
	{
        $data = array();
        $data['breadcrumb'] = set_crumbs(array('calendar/entries' => 'Calendar', current_url() => 'Entries'));

        // Load libraries and models
        $this->load->model('entries_model');
        $this->load->model('calendar_model');
        $this->load->model('content_types_model');
        $this->load->model('revisions_model');
        $this->load->library('pagination');
        $data['query_string'] = ( ! empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '';
        $data['content_types_filter'] = array('' => '');
        $data['content_types_add_entry'] = array();

        // Process Filter using Admin Helper
        $filter = process_filter('entries');

        // Define fields the search filter searches
        $search = array();

        if (isset($filter['search']))
        {
            $search['title'] = $filter['search'];
            $search['slug'] = $filter['search'];
            $search['id'] = $filter['search'];
            unset($filter['search']);
        }
        
        // -------------------------------
        $query = $this->db->get('calendar');
        $data['Events'] = $query->result();
        // foreach ($query->result() as $row) {
            // echo $row->title;
        // }
        // var_dump($query);
        // -------------------------------

        // Pagination Settings
        $per_page = 50;

        // If user not a super admin only get the content types and entires allowed for access
        if ($this->Group_session->type != SUPER_ADMIN)
        {
            $this->content_types_model
                ->where('restrict_admin_access', 0)
                ->or_where_related('admin_groups', 'group_id', $this->Group_session->id);

            $this->entries_model
                ->group_start()
                ->where('restrict_admin_access', 0)
                ->or_where_related('content_types/admin_groups', 'group_id', $this->Group_session->id)
                ->group_end();
        }

        // Build content type filter dropdown 
        // and add entry's list of content types
        $Content_types = $this->content_types_model->order_by('title', 'asc')->get();

        foreach($Content_types as $Content_type)
        {
            $entries_count = $Content_type->entries->count();

            // Only add the content type to the Add Entry dropdown if it has not reached the
            // limit of entries allowed. An empty entries_allowed is unlimited
            if ($Content_type->entries_allowed == '' ||  $entries_count < $Content_type->entries_allowed || ($entries_count == 0 && $Content_type->entries_allowed > 0))
            {
                $data['content_types_add_entry'][$Content_type->id] = $Content_type->title;
            }

            // Only add the content type to the filter dropdown if it has one or more entries
            if ($entries_count > 0)
            {
                $data['content_types_filter'][$Content_type->id] = $Content_type->title;
            }
        }

        $this->entries_model->include_related('content_types', 'title');

        // Filter by search string
        if ( ! empty($search))
        {
            $this->entries_model
                ->group_start()
                ->or_like($search)
                ->group_end();
        }

        // Filter by dropdowns
        if ( ! empty($filter))
        {
            $this->entries_model
                ->group_start()
                ->where($filter)
                ->group_end();
        }

        // Finalize and sort entries query
        $data['Entries'] = $this->entries_model
            ->order_by(($this->input->get('sort')) ? $this->input->get('sort') : 'modified_date', ($this->input->get('order')) ? $this->input->get('order') : 'desc')
            ->get_paged($this->uri->segment(5), $per_page, TRUE);

        // Create Pagination
        $config['base_url']     = site_url(ADMIN_PATH . '/calendar/entries/index/');
        $config['total_rows']   = $data['Entries']->paged->total_rows;
        $config['per_page']     = $per_page; 
        $config['uri_segment']  = '5';
        $config['num_links']    = 5;
        $config['suffix']       = $data['query_string'];
        $this->pagination->initialize($config); 

        $this->template->view('admin/entries/entries', $data);
	}

    // ------------------------------------------------------------------------

    /**
     * Edit
     *
     * Add and edit entries
     *
     * @author     Cosmo Mathieu <cosmo@cosmointeractive.co>
     * @access     public 
     * @return     void
     */
    public function edit()
    {
        // Init
        $data = array();
        $data['edit_mode']  = $edit_mode = FALSE;
        $data['breadcrumb'] = set_crumbs(array('calendar/entries' => 'Calendar', current_url() => 'Event Edit'));
        $data['id']         = $event_id = $this->uri->segment(5);
        // Load Model
        $this->model = $this->load->model('calendar_model');

        // Load content fields library
        $query = $this->db->get_where('calendar', array('id' => $event_id), 1);
        $EventInfo = $query->result();
        $data['Event'] = $EventInfo[0];

        // Get Admins and Super Admins for the setting's
        // author dropdown
        // $Users = $this->users_model->where_in_related('groups', 'type', array(SUPER_ADMIN, ADMINISTRATOR))->order_by('first_name')->get();
        // $data['authors'] = array('' => '');
        // foreach ($Users as $User) {
            // $data['authors'][$User->id] = $User->full_name();
        // }
        
        if($this->input->post()) {
            // Form Validation Rules
            $this->form_validation->set_rules('title', 'Event Title', 'trim|required');
            $this->form_validation->set_rules('description', 'Event Description', 'trim|required');

            // Validation and process form
            if ($this->form_validation->run() == TRUE)
            {
                $Event = array();
                // Populate from post and prep for insert / update
                $post = $this->input->post();
                $Event['modified']  = date('Y-m-d H:i:s');
                $Event['start']     = date('Y-m-d H:i:s', strtotime($this->input->post('start')));
                $Event['end']       = date('Y-m-d H:i:s', strtotime($this->input->post('end')));
                $Event['title']     = ($this->input->post('title') != '') ? $this->input->post('title') : NULL;
                $Event['description'] = ($this->input->post('description') != '') ? $this->input->post('description') : NULL;
                $Event['featured']  = ($this->input->post('featured') != '') ? $this->input->post('featured') : NULL;
                // var_dump($post);
                
                // Ensure the id wasn't overwritten by an id in the post
                if ($edit_mode) {
                    $Event->id = $event_id;
                }
                
                // Set a success message
                if ($this->model->update($event_id, $Event)) {             
                    $this->session->set_flashdata('message', '<p class="success">Changes Saved.</p>');
                } else{
                    $this->session->set_flashdata('message', '<p class="error">Changes were not saved.</p>');
                }
                
                // Deteremine where to redirect user
                if ($this->input->post('save_exit')) {
                    redirect(ADMIN_PATH . "/calendar/entries");
                } else {
                    redirect(ADMIN_PATH . "/calendar/entries/edit/" . $event_id);
                }
            }
        }

        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;
        $_SESSION['isLoggedIn'] = true;
        // $this->template->add_javascript('/application/modules/content/content_fields/assets/js/ckeditor/ckeditor.js');
        // $this->template->add_javascript('/application/modules/content/content_fields/assets/js/ckeditor_inline_editable.js');
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/image.js');
        $this->template->add_javascript('/application/modules/content/content_fields/assets/js/image_inline_editable.js');
        $this->template->view('admin/entries/edit', $data);
    }

    // ------------------------------------------------------------------------

    /*
     * Delete
     *
     * Delete entries and data associated to it

     * @return void
     */
    function delete()
    {
        $this->load->helper('file');
        $this->load->model('entries_model');

        if ($this->input->post('selected'))
        {
            $selected = $this->input->post('selected');
        }
        else
        {
            $selected = (array) $this->uri->segment(5);
        }

        $Entries = new Entries_model();
        $Entries->where_in('id', $selected)->get();

        if ($Entries->exists())
        {
            $message = '';
            $entries_deleted = FALSE;
            $entries_required = FALSE;
            $this->load->model('navigations/navigation_items_model');

            foreach($Entries as $Entry)
            {
                if ($Entry->id == $this->settings->content_module->site_homepage)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is set as the site homepage and cannot be deleted.</p>';
                }
                else if ($Entry->id == $this->settings->content_module->custom_404)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is set as the custom 404 and cannot be deleted.</p>';
                }
                else if ($Entry->required)
                {
                    $message .= '<p class="error">Entry ' . $Entry->title . ' (#' . $Entry->id . ') is required by the system and cannot be deleted.</p>';
                }
                else
                {
                    // Remove the entry from navigations
                    $Navigation_items = new Navigation_items_model();
                    $Navigation_items->where('entry_id', $Entry->id)->get();
                    $Navigation_items->delete_all();

                    $Entries_data = $Entry->entries_data->get();
                    $Entries_data->delete_all();

                    $Entry_revisions = $Entry->get_entry_revisions();
                    $Entry_revisions->delete_all();

                    $Entry->delete();
                    $entries_deleted = TRUE; 
                }
            }

            if ($entries_deleted)
            {
                // Clear cache so updates will show on next entry load
                $this->load->library('cache');
                $this->cache->delete_all('entries');

                // Clear navigation cache so updates will show on next page load
                $this->load->library('navigations/navigations_library');
                $this->navigations_library->clear_cache();

                $message .= '<p class="success">The selected items were successfully deleted.</p>';
            }

            $this->session->set_flashdata('message', $message);
        }

        redirect(ADMIN_PATH . '/content/entries');
    }

    // ------------------------------------------------------------------------

    /*
     * Links
     *
     * Used by TinyMCE to build a list of of pages and get their URL

     * @return void
     */
	function links() {
        header('Content-type: text/javascript');

        $Entries = $this->load->model('content/entries_model');
        $Entries->where('status', 'published')
            ->where('slug !=', 'NULL')
            ->or_where('id =', $this->settings->content_module->site_homepage)
            ->order_by('title')
            ->get();

        $output = "var tinyMCELinkList = new Array(";

        foreach($Entries as $Entry)
        {
            $output .= "['$Entry->title', '{{ content:entry_url entry_id=\'$Entry->id\' }}'],";
        }

        $output = rtrim($output, ',');

        $output .= ");";

        echo $output;
	}

    // ------------------------------------------------------------------------

    /*
     * CSS
     *
     * Called by CKEditor and TinyMCE for custom styles

     * @return void
     */
    function css()
    {
        // No long use the entry_id variable but maybe some day
        $entry_id = $this->uri->segment(5);

        $css = @file_get_contents(base_url('themes/' . $this->settings->theme . '/' . trim($this->settings->editor_stylesheet, '/'))) . "\n";

        header('Content-type: text/css');

        echo $css;
    }

    // ------------------------------------------------------------------------

    /*
     * Unique Slug Check
     *
     * Used to validate that the slug is a valid URL 
     * and is unique in the database

     * @return bool or string
     */
    function unique_slug_check($slug, $current_slug = '')
    {
        $slug = trim($slug, '/');

        $regex = "(\/?([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor 

        if (preg_match("/^$regex$/", $slug))
        {
            $Entries = new Entries_model();
            $Entries->get_by_slug($slug);

            if ($Entries->exists() && $slug != stripslashes($current_slug))
            {
                $this->form_validation->set_message('unique_slug_check', 'This %s provided is already in use.');
                return FALSE;
            }
            else
            {
                return $slug;
            }
        }
        else
        {
            $this->form_validation->set_message('unique_slug_check', 'The %s provided is not valid.');
            return FALSE;
        }
    }

    // ------------------------------------------------------------------------

    /*
     * Create Thumb
     *
     * Called by AJAX to create thumbnails of selected images
     * 
     * @return void
     */
    function create_thumb()
    {
        if ( ! is_ajax())
        {
            return show_404();
        }

        if ($this->input->post('image_path'))
        {
            echo image_thumb($this->input->post('image_path'), 150, 150, FALSE, array('no_image_image' => ADMIN_NO_IMAGE));
        }
    }

    // ------------------------------------------------------------------------

    /*
     * Pre Save Output
     *
     * Called by AJAX to return processed output content from its
     * content field type before it has been saved to the db
     * 
     * @return string
     */
    function pre_save_output()
    {
        if ( ! is_ajax())
        {
            return show_404();
        }

        // Init
        $this->load->model('entries_model');
        $this->load->model('content_fields_model');
        $response = array();

        $editable_id = $this->input->post('editable_id');
        $content = $this->input->post('content');

        // Preg match the entry id and the field id from the html element's id attribute
        if (preg_match("/cc_field_(\d+)_(\d+)/", $editable_id, $matches))
        {
            $entry_id = $matches[1];
            $field_id = $matches[2];
        }
        else
        {
            $response['status'] = 'error';
            $response['message'] = 'Unable to parse the entry id and field id.';
            echo json_encode($response);
        }

        $Entry = new Entries_model();
        $Entry->get_by_id($entry_id);

        if ( ! $Entry->exists())
        {
            $response['status'] = 'error';
            $response['message'] = 'The entry id provided does not exist.';
            echo json_encode($response);
        }

        $Field = new Content_fields_model();
        $Field->order_by('sort', 'ASC')
            ->include_related('content_field_types', array('model_name'))
            ->get_by_id($field_id);

        if ( ! $Field->exists())
        {
            $response['status'] = 'error';
            $response['message'] = 'The field id provided does not exist.';
            echo json_encode($response);
        }

        $Content_object = new stdClass();
        $Content_object->{'field_id_' . $Field->id} = $content;

        $Field_type = Field_type::factory($Field->content_field_types_model_name, $Field, $Entry, $Content_object);
        $output = $Field_type->output();

        $response['status'] = 'success';
        $response['content'] = $output;
        echo json_encode($response);
    }
}

