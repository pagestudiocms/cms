<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CMS Canvas
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://cmscanvas.com
 */

/**
 * Contact Plugin
 *
 * Build and send contact forms
 *
 */
class Contact_plugin extends Plugin
{
    /*
     * Form
     *
     * Outputs and sets form validations. 
     * If no formatting content specified, the default form will be used
     *
     * @access private
     * @return void
     */
    public function form()
    {
        $parse_data = array();

        if (str_to_bool($this->attribute('captcha')))
        {
            $parse_data['captcha'] = '<img class="captcha_image" src="' . site_url('contact/captcha') . '" />';
            $parse_data['captcha_input'] = '<input class="captcha_input" type="text" name="captcha_input" />';
        }

        $data['id'] = $this->attribute('id');
        $data['class'] = $this->attribute('class');
        $data['anchor'] = $this->attribute('anchor');
        $data['captcha'] = str_to_bool($this->attribute('captcha'));
        $data['content'] = $this->parser->parse_string($this->content(), $parse_data, TRUE);

        // Wrap content with form tags and add a spam check field
        // A theory that spam bots do not read css and will attempt to fill all fields
        // The form will not submit if the hidden field has been filled
        $content = $this->load->view('contact', $data, TRUE);

        if ($this->attribute('id') == '' || $this->attribute('id') == $this->input->post('form_id'))
        {
            // We need at least one validation rule for run to work
            $this->form_validation->set_rules('spam_check', 'Spam Check', 'trim');

            // Repopulate form by default
            if ($this->input->post())
            {
                $content = $this->_repopulate_form($content);
            }

            // No custom content was set, use the default form validations
            if ($this->content() == '')
            {
                $this->form_validation->set_rules('name', 'Name', 'trim|required');
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
                $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
                $this->form_validation->set_rules('message', 'Message', 'trim|required');
            }

            // Set required fields
            if ($required = $this->attribute('required'))
            {
                foreach(explode('|', $required) as $name)
                {
                    $this->form_validation->set_rules($name, $name, 'required');
                }
            }

            if (str_to_bool($this->attribute('captcha')))
            {
                $this->form_validation->set_rules('captcha_input', 'CAPTCHA', 'validate_captcha|required');
            }

            // Process Form
            if ($this->form_validation->run() == TRUE && $this->input->post('spam_check') == '')
            {
                $this->_send_form();

                if ($this->attribute('success_redirect'))
                {
                    redirect($this->attribute('success_redirect'));
                }
                else
                {
                    return "Your message has been sent. Thank You";
                }
            }

            // Add validation errors to the content
            $content = validation_errors() . $content;
        }

        return array('_content' => $content);
    }

    // ------------------------------------------------------------------------

    /**
     * Send Form
     *
     * Builds and sends email to the specified address
     *
     * Updated: Use PHPMailer to sent email as html using SMTP service.
     *
     * @author     Cosmo Mathieu <cosmo@cosmointeractive.co>
     * @access     private
     * @return     void
     */
    private function _send_form()
    {
        $config = array(
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
        // $config['crlf'] = "\r\n";
        // $config['newline'] = "\r\n";
        // $this->load->library('email', $config);
        // $this->email->initialize($config);
        // $this->email->from($this->attribute('from', 'noreply@' . domain_name()), $this->attribute('from_name', $this->settings->site_name));
        // $this->email->to($this->attribute('to', $this->settings->notification_email)); 
        // $this->email->subject($this->attribute('subject', 'Contact Form Submission'));

        $from       = $this->attribute('from', $this->settings->mail_reply_email);
        $fromName   = $this->attribute('from_name', $this->settings->site_name);
        $to         = $this->attribute('to', $this->settings->notification_email); 
        $subject    = $this->attribute('subject', 'Contact Form Submission');
        
        // Remove Spam Check
        unset($_POST['spam_check']);
        unset($_POST['form_id']);
        unset($_POST['captcha_input']);

        // Build message from $_POST array
        $message = '';
        foreach($_POST as $field => $value) {
            if (is_array($value)) {
                $message .= ucwords(str_replace('_', ' ', $field)) . ' : ' . "<br>\r\n";

                foreach ($value as $arr_val)
                {
                    $message .= "\t" . $arr_val . "<br>\r\n";
                }
            } else {
                $message .= ucwords(str_replace('_', ' ', $field)) . ' : ' . $value . "<br>\r\n";
            }
        }
        
        $this->load->helper('contact_helper');
        $message = html_template($subject, $message);

        $this->mailForm(
            $from, 
            $fromName,
            $to, 
            $subject,
            $message,
            $config
        );

        // $this->email->message($message);  
        // $this->email->send();
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

		/*
		 * send via SMTP
		 */
		$mail->IsSMTP(); 
		
		/*
		 * SMTP server setup
		 */
		$mail->Host = $config['smtp_host']; 
		$mail->Port = $config['smtp_port'];
		$mail->SMTPSecure = $config['mail_authen_srvc'];
        
        // 2 to enable SMTP debug information
        if (defined('ENVIRONMENT')) {
            if(ENVIRONMENT !== 'production') {
                $mail->SMTPDebug   = 2; 
            }
        }
        
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_user'];
        $mail->Password = $config['smtp_pass']; 
		
		/*
		 * phpMailer email configuration
		 */
		$mail->From 		= $from;
		$mail->FromName 	= $fromName;
		$mail->AddAddress($to);
		$mail->AddReplyTo($config['smtp_reply']);		
		$mail->WordWrap 	= $config['wrapchars']; // set word wrap
		$mail->IsHTML(true);		
		$mail->Subject  	= $subject;
		$mail->Body 		= $message;
		
		/**
		 * Log error message if delivery failed. 
		 */
		if ( $mail->Send() ) {
			return 1;
		} else {
            log_message('error', $mail->ErrorInfo);
			return 0;
		}
    }
    
    // ------------------------------------------------------------------------

    /*
     * Repopulate Form
     *
     * Repopulates a custom formatted form
     *
     * @access private
     * @return string
     */
    private function _repopulate_form($content)
    {
        $DOM = new DOMDocument;
        @$DOM->loadHTML($content);
        $Xpath = new DOMXPath($DOM);

        // Remove <!DOCTYPE 
        $DOM->removeChild($DOM->firstChild);            

        // Remove <html><body></body></html> 
        $DOM->replaceChild($DOM->firstChild->firstChild->firstChild, $DOM->firstChild);

        // Repopulate Text and Password Inputs
        $inputs = $Xpath->query('//input[@type="text"] | //input[@type="password"]');
        foreach ($inputs as $Input) 
        {
            if ($name = $Input->getAttribute('name')) 
            {
                $Input->setAttribute('value', $this->input->post($name));
            }
        }

        // Repopulate Radio and Checkbox Inputs
        $inputs = $Xpath->query('//input[@type="radio"] | //input[@type="checkbox"]');
        foreach ($inputs as $Input) 
        {
            if ($name = $Input->getAttribute('name')) 
            {
                $value = $Input->getAttribute('value');
                if ($this->input->post($name) == $value)
                {
                    $Input->setAttribute('checked', 'checked');
                }
            }
        }

        // Repopulate Textareas
        $textareas = $Xpath->query('//textarea');
        foreach ($textareas as $Textarea) 
        {
            if ($name = $Textarea->getAttribute('name')) 
            {
                $Textarea->nodeValue = $this->input->post($name);
            }
        }

        // Repopulate Dropdowns
        $options = $Xpath->query('//select/option');
        foreach ($options as $Option) 
        {
            if ($name = $Option->parentNode->getAttribute('name')) 
            {
                $value = $Option->getAttribute('value');
                if ($this->input->post($name) == $value)
                {
                    $Option->setAttribute('selected', 'selected');
                }
            }
        }

        return $DOM->saveHTML();
    }
}
