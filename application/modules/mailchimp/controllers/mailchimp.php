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
 * MailChimp integration for PageStudioCMS 
 * 
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
class Mailchimp extends Public_Controller 
{
    /**
     * @var     array
     */
    private $errors = [];
    
    /**
     * @var     array 
     */
    private $m_config = [];
	
    /**
	 * List of form fields to exclude from the email body message
	 *
     * @var     array
     */
    private $excluded = [
        'form_id', 'spam_check', 'api_key', 'list_id', 'email',
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------
    
	/**
	 * This method should never return any result 
	 *
	 * @access 	public 
	 * @return  void
	 */
    public function index()
    {
        show_404();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Ajax handler method 
     * 
	 * @access 	public 
     * @return  void
     */
    public function subscribe()
    {
        // Only process ajax requests from this method
        if($this->input->post()) 
		{
            /**
             * Mailchimp Account API Key
             * @var string
             */
            $api_key    = '';
            
            /**
             * Mailchimp List ID
             * @var string
             */
            $list_id    = '';
            
            /**
             * Subscriber email address
             * @var string
             */
            $email      = '';
            
            $merge_vars = [];
            
            $this->load->library('service_result');
            $result     = $this->service_result;
            $result->start_timer('send_email');
            
            $api_key    = ($this->input->post('api_key')) ? $this->input->post('api_key') : '';
            $list_id    = ($this->input->post('list_id')) ? $this->input->post('list_id') : '';
            $this->load->library('mcapi', $api_key);
            
            if($this->input->post('email')) {
                // Validate and sanitize email address
                if ( ! filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL) === false) {
                    $email = $this->input->post('email');
                }
            }
            
            foreach($this->input->post() as $key => $value) {
                if ( ! in_array($key, $this->excluded)) {
                    $merge_vars[$key] = $value;
                }
            }
            
            if(count($this->errors) <= 0)
            {
                // Submit subscriber data to MailChimp
                // For parameters doc, refer to: http://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php
                $request = $this->mcapi->listSubscribe( $list_id, $email, $merge_vars, 'html', false, true );

                if ($this->mcapi->errorCode){
                    $result->message = "Please try again.";
                    $this->errors[] = [$this->mcapi->errorCode => $this->mcapi->errorMessage];
                } else {
                    $result->message = "Thank you, you have been added to our mailing list.";
                }
                
                // Prepare json response data and print to screen 
                $result->status = ($request) ? 'success' : 'error';
            }
            else 
            {
                $result->message = 'Unable to subscribe user';
            }
            
            $result->errors = $this->errors;
            $result->stop_timer('send_email');
            $result->show_results();
        } 
		else 
		{
            show_error('Improper page access. Only post requests are allowed to be processed.');
        }
    }
    
}
