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
 * @author      Cosmo Mathieu <cosmo@cimwebdesigns.com>
 * @copyright   Copyright (c) 2015, CosmoInteractive, LLC
 * @license     MIT License
 * @link        http://pagestudio.com
 */
 
// ------------------------------------------------------------------------

/**
 * Plugin Functions
 *
 * Provides the ability to execute code via template tags. 
 * 
 * @note        You need to add this to the plugin.module install file: 
 *              "ALTER TABLE entries ADD FULLTEXT(title);" and to any other 
 *              table or you will get an error from one of the methods.
 * @note        During this module's installation create a new content entry
 *              named Search for the results to be displayed upon.
 *
 * @package		PageStudio
 * @subpackage	CodeIgniter
 * @category	Plugin
 * @author		Cosmo Mathieu <cosmo@cosmointeractive.co>
 * @link		http://pagestudio.com/user_guide/
 */
class Search_plugin extends Plugin
{
    /**
     * Builds a search form
     *  
     * <code>
     *  {{ search:form label="yes|Search Site:" placeholder="Search..." content="entries|blog|calendar" limit="5" redirect="page-name" }}
     * </code>
     *
     * @return string
     */
    public function form()
    {
        $attributes   = $this->attributes();
        $search_terms = '';
        $form_label   = 'Search:';
        $placeholder  = '';
        
        $this->form_validation->set_rules('search_terms', 'Search', 'trim|required');
        
        $form = '';
        $form = form_open($this->uri->uri_string);
        
        // Show or hide form label
        if($this->attribute('label', 0)) {
            $atts = explode('|', $this->attribute('label', 0));
            if ($atts[0] === 'yes') {
                if( isset($atts[1]) && ! empty($atts[1])) {
                    $form_label = $atts[1];
                }
                $form .= form_label($form_label, 'search-box');
            }
        }
        
        $form .= form_input([
            'terms' => 'q', 
            'id' => 'search-box', 
            'name' => 'search_terms', 
            'value' => $search_terms,
            'placeholder' => ($this->attribute('placeholder', 0)) ? $this->attribute('placeholder', 0) : $placeholder
        ]); 
        $form .= form_submit('search', 'Search');        
        $form .= form_close();
        
        $this->form_process();
        
        // Add validation errors to the content
        $content = validation_errors();
        
        $attributes['_content'] = $form . $content;

        return $attributes;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Builds a search form
     * The simple form does not have an input label nor search button
     *  
     * <code>
     *  {{ search:form_simple content="entries|blog|calendar" limit="5" label="y|Search" redirect="page-name" }}
     * </code>
     *
     * @return string
     */
    public function form_simple()
    {
        $attributes   = $this->attributes();
        $search_terms = '';
        $form_label   = 'Search:';
        $placeholder  = '';
        
        $this->form_validation->set_rules('search_terms', 'Search', 'trim|required');
        
        $form = '<div class="inline-search-form">';
        $form .= form_open($this->uri->uri_string);
        
        // Show or hide form label
        if($this->attribute('label', 0)) {
            $atts = explode('|', $this->attribute('label', 0));
            if ($atts[0] === 'yes') {
                if( isset($atts[1]) && ! empty($atts[1])) {
                    $form_label = $atts[1];
                }
                $form .= form_label($form_label, 'search-box');
            }
        }

        $form .= form_input([
            'terms' => 'q', 
            'id' => 'search-box', 
            'name' => 'search_terms', 
            'value' => $search_terms,
            'placeholder' => ($this->attribute('placeholder', 0)) ? $this->attribute('placeholder', 0) : $placeholder
        ]);              
        $form .= form_close();
        $form .= '</div>';
        
        $this->form_process();
        
        // Add validation errors to the content
        // $content = validation_errors();
        
        $attributes['_content'] = $form;

        return $attributes;
    }
    
    // --------------------------------------------------------------------
    
    private function form_process()
    {
        // Process form if it was submitted
        if ($this->form_validation->run() == true) {
            if ($this->input->post('search_terms')) {
                $this->session->set_userdata(array(
                    'search_terms' => array(
                        'terms' => $this->input->post('search_terms'), 
                        'title' => true,
                        'snippet' => 100, // Show an ellipsis after 100 characters
                        'pagination' => 5, // Paginate after 5 results
                        'highlight' => true // Highlights the keywords from the search query
                    )
                ));
                
                // Redirect to custom search page or default
                if ($this->attribute('redirect')) {
                    redirect($this->attribute('redirect'));
                } else {
                    redirect(site_url() . 'search');
                }
            }
        }
    }
    
}
