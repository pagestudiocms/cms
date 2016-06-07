<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Contact extends Public_Controller 
{
    private $e_config = [];
	
	// List of form fields to exclude in mailing list
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
    
	/**
	 * This method should never be called as long as the custom 
	 * route exits to map /contact to content/pages 
	 *
	 * @access 	public 
	 * @return  void
	 */
    public function index()
    {
        show_404();
    }
    
    public function ajax()
    {            
        // Only process ajax requests from this method
        if(is_ajax()) 
		{
			$result = []; // Stores the json result set
            $message = '';
            
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
            
			// $submit = true; // Uncomment for testing purposes only
           
			$result['errors'] = '';
			$result['result'] = ($submit) ? 'success' : 'fail';
			
			echo json_encode($result);
        } 
		else 
		{
            show_404();
        }
    }
    
    // --------------------------------------------------------------------
    
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