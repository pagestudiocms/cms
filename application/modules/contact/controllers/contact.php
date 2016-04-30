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
        $this->e_config = array(
            'protocol'   => $this->settings->mail_protocol,
            'smtp_host'  => $this->settings->mail_server,
            'smtp_port'  => $this->settings->mail_outgoing_port,
            'smtp_user'  => $this->settings->mail_login,
            'smtp_pass'  => $this->settings->mail_password,
            'mailtype'   => $this->settings->mail_send_as_html, 
            'mail_authen_srvc' => $this->settings->mail_authen_srvc,
            // 'charset'   => 'iso-8859-1'
            'wrapchars'  => 76, 
            'wordwrap'   => true,
            'smtp_reply' => ''
        );
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
        if(is_ajax()) {
            $message = '';
            include_once CMS_ROOT . APPPATH . 'modules/contact/helpers/contact_helper.php';
            
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
            
            $message = html_template($this->subject, $message);

            $submit = $this->mailForm(
                $this->from, 
                $this->fromName,
                $this->to, 
                $this->subject,
                $message,
                $this->e_config
            );
            
            echo ($submit) ? true : false;
            
        } else {
            show_404();
        }
    }
    
    // ------------------------------------------------------------------------
    
    private function mailForm(
        $from, 
        $fromName,
        $to, 
        $subject,
        $message,
        $config
    ) {
        $this->load->library('SMTP');
        $this->load->library('PHPMailer');
        
        $mail = new PHPMailer();

		// send via SMTP
		$mail->IsSMTP(); 
		
		// SMTP server setup
		$mail->Host = $config['smtp_host']; 
		$mail->Port = $config['smtp_port'];
		$mail->SMTPSecure = $config['mail_authen_srvc'];
        
        // 2 to enable SMTP debug information
        if (defined('ENVIRONMENT')) {
            if(ENVIRONMENT === 'production') {
                $mail->SMTPDebug = false;
                $mail->do_debug = 0;
            } else {
                // $mail->SMTPDebug   = 2; 
                $mail->SMTPDebug = false;
                $mail->do_debug = 0;
            }
        }
        
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_user'];
        $mail->Password = $config['smtp_pass']; 
		
		// phpMailer email configuration
		$mail->From 		= $from;
		$mail->FromName 	= $fromName;
		$mail->AddAddress($to);
		$mail->AddReplyTo($config['smtp_reply']);		
		$mail->WordWrap 	= $config['wrapchars']; // set word wrap
		$mail->IsHTML(true);		
		$mail->Subject  	= $subject;
		$mail->Body 		= $message;
		
		// Log error message if delivery failed. 
		if ( $mail->Send() ) {
			return 1;
		} else {
            log_message('error', $mail->ErrorInfo);
			return 0;
		}
    }
}