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
    public $ajax = [];
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
        
        // Set ajax attributes
        if ($this->attribute('ajax') !== '')
        {
            $ajax = $this->attribute('ajax');
            foreach(explode('|', $ajax) as $atts) {
                $this->ajax[] = $atts;
            }
            
            $this->ajax_submit = ( ! empty($this->ajax) && $this->ajax[0] === 'true') ? true : false;
            $this->ajax_result_class = ( ! empty($this->ajax) && ! empty($this->ajax[1])) ? $this->ajax[1] : null;
            $data['ajax_submit'] = $this->ajax_submit;
            $data['ajax_result_class'] = $this->ajax_result_class;
        }

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
        $config = [
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

        $from       = $this->attribute('from', $this->settings->mail_reply_email);
        $fromName   = $this->attribute('from_name', $this->settings->site_name);
        $to         = $this->attribute('to', $this->settings->notification_email); 
        $subject    = $this->attribute('subject', 'Contact Form Submission');
        $template   = ['view' => 'system_plain', 'folder' => ADMIN_THEME_PATH . 'email/views'];
        
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
        
        $this->load->library('parser');
        $this->load->library('email', $config);
        
        $data = [
            'subject' => $subject,
            'paragraphs' => [
                ['paragraph' => $message],
            ],
            'company' => [
                'name' => $fromName, 
                'website' => site_url(),
            ], 
            'signature' => 'Cheers,<br>'.$fromName.' Team'
        ];
        $body = $this->parser->parse($template, $data, TRUE, FALSE, TRUE);

        $result = $this->email
            ->from($from)
            ->reply_to($to)    // Optional, an account where a human being reads.
            ->to($to)
            ->subject($subject)
            ->message($body)
            ->send();
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
