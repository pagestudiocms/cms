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
 * Contact module 
 * 
 * @author      Cosmo Mathieu <cosmo@cosmointeractive.co>
 */
class Contact extends Public_Controller 
{
    /**
     * @var     array 
     */
    private $e_config = [];
	
    /**
	 * List of form fields to exclude from the email body message
	 *
     * @var     array
     */
    private $excluded = [
        'form_id', 'spam_check'
    ];
    
    function __construct()
    {
        parent::__construct();
        
        $this->from       = $this->settings->mail_reply_email;
        $this->fromName   = $this->settings->site_name;
        $this->to         = $this->settings->notification_email;
        $this->subject    = 'Contact Form Submission';
        $this->e_config = [
            'protocol'    => $this->settings->mail_protocol,
            'smtp_host'   => $this->settings->mail_server,
            'smtp_port'   => $this->settings->mail_outgoing_port,
            'smtp_user'   => $this->settings->mail_login,
            'smtp_pass'   => $this->settings->mail_password,
            'smtp_crypto' => $this->settings->mail_authen_srvc,
            'smtp_debug'  => 0,
            'mailtype'    => 'html', 
            // 'charset'   => 'iso-8859-1'
            // 'wrapchars'  => 76,
            // 'wordwrap'   => true,
            // 'smtp_reply' => ''
        ];
    }
    
    // --------------------------------------------------------------------
    
	/**
	 * This method should never be called as long as the custom route exits 
	 * to map /contact to content/pages 
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
    public function ajax()
    {
        // Only process ajax requests from this method
        if(is_ajax()) 
		{
            $this->load->library('service_result');
            $result     = $this->service_result;
            $message    = '';
            $result->start_timer('send_email');
            
            // Loop over form field values and store them in the [$message] viariable
            foreach($this->input->post() as $key => $value) {
                if ( ! in_array($key, $this->excluded)) {
                    if (is_array($value)) {
                        $message .= ucwords(str_replace('_', ' ', $key)) . ' : ' . "<br>\r\n";
                        foreach ($value as $arr_val) {
                            $message .= "\t" . $arr_val . "<br>\r\n";
                        }
                    } else {
                        $message .= ucwords(str_replace('_', ' ', $key)) . ' : ' . $value . "<br>\r\n";
                    }
                }
            }
            
            // Build the email body and attempt to send 
            $data = [
                'subject' => $this->subject,
                'paragraphs' => [
                    ['paragraph' => $message],
                ],
                'company' => [
                    'name' => $this->fromName, 
                    'website' => site_url(),
                ], 
                'signature' => 'Cheers,<br>'.$this->fromName.' Team'
            ];
            $submit = $this->sendmail($data, ['view' => 'system_plain', 'folder' => ADMIN_THEME_PATH . 'email/views']);
            
            // Prepare json response data and print to screen 
			$result->status     = ($submit) ? 'success' : 'error';
            $result->message    = ($submit) ? 'The query executed successfully.' : $result->message;
            
            header('Content-Type: application/json');
            echo json_encode([
                'status' => $result->status, 
                'message' => $result->message, 
                'result' => $result->result,
                'time' => $result->stop_timer('send_email'),
            ]);
            exit;
        } 
		else 
		{
            show_404();
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Method to send email via smtp using pre-defined settings 
     * 
     * @access  private
     * @param   array $data 
     * @param   string $template 
     * @return  bool
     */
    private function sendmail($data = null, $template = null)
    {
        if( ! is_null($data) && is_array($data))
        {            
            $this->load->library('parser');
            $this->load->library('email', $this->e_config);
            
            $body = $this->parser->parse($template, $data, TRUE, FALSE, TRUE);

            $result = $this->email
                ->from($this->from)
                ->reply_to($this->from)    // Optional, an account where a human being reads.
                ->to($this->to)
                ->subject($data['subject'])
                ->message($body)
                ->send();
            return $result;
        }
    }
}
