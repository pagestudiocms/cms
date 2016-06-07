<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * CMS Canvas
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://cmscanvas.com
 */

class Users extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------

    public function login()
    {
        // Init
        $data = array();
        $this->load->model('users_model');

        // Prevent IE users from caching this page
        if( ! isset($_SESSION)) 
        {
            session_start();
        }

        // If redirect session var set redirect to home page
        if ( ! $redirect_to = $this->session->userdata('redirect_to'))
        {
            $redirect_to = '/';
        }

        // If user is already logged in redirect to desired location
        if ($this->secure->is_auth())
        {
            redirect($redirect_to);
        }

        // Check if user has a remember me cookie
        if ($this->users_model->check_remember_me())
        {
            redirect($redirect_to);
        }

        // Form Validation
        $this->form_validation->set_rules('email', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // Process Form
        if ($this->form_validation->run() == TRUE)
        {
            $Data = array_to_object($this->input->post());

            // Database query to lookup email and password
            if ($this->users_model->login($this->input->post('email'), $this->input->post('password')))
            {
                redirect($redirect_to);
            }

            redirect(current_url());
        }

        // If the user was attempting to log into the admin panel use the admin theme
        if ($this->uri->segment(1) == ADMIN_PATH)
        {
            $this->template->set_theme('admin', 'default', ADMIN_THEME_PATH);
            $this->template->set_layout('default_wo_errors');

            $this->template->add_package('jquery');
            $this->template->add_script("
                $(document).ready(function() { 
                    $('#email').focus();
                });");

            $this->template->view("admin/login", $data);
        }
        else
        {
            $this->template->view("/users/login", $data);
        }
    }
    
    // ------------------------------------------------------------------------

    public function register()
    {
        // Init
        $data = array();
        $data['states'] = unserialize(STATES);

        // Check that user registration is enabled
        if ( ! $this->settings->users_module->enable_registration)
        {
            return show_404();
        }

        // Validate Form
        $this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_email_check");
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        // $this->form_validation->set_rules('phone', 'Phone', 'required|format_phone');
        // $this->form_validation->set_rules('address', 'Address', 'trim|required');
        // $this->form_validation->set_rules('address2', 'Address 2', 'trim');
        // $this->form_validation->set_rules('city', 'City', 'trim|required');
        // $this->form_validation->set_rules('state', 'State', 'trim|required');
        // $this->form_validation->set_rules('zip', 'Zip', 'trim|required');
        $this->form_validation->set_rules('spam_check', 'Spam Check', 'trim');

        if ($this->form_validation->run() == TRUE)
        {
            // Use spam_check to filter spam 
            // Stops bots that attempt to fill the field which is hidden by CSS
            if ($this->input->post('spam_check') != '')
            {
                return $this->template->view('/users/register', $data);
            }

            $this->load->model('users_model');
            $this->users_model->from_array($this->input->post());
            $this->users_model->id = NULL; // Prevent someone from trying to post an ID
            $this->users_model->group_id = $this->settings->users_module->default_group;
            $this->users_model->password = md5($this->config->item('encryption_key') . $this->input->post('password'));
            $this->users_model->created_date = date('Y-m-d H:i:s');

            // Generate and send activation email
            if ($this->settings->users_module->email_activation)
            {
                $this->users_model->activation_code = md5($this->users_model->id . strtotime($this->users_model->created_date) . mt_rand());
                $this->users_model->activated = 0;
                $this->users_model->save();

                $subject = $this->settings->site_name . ' Activation';
                $message = "Thank you for your new member registration.\n\nTo activate your account, please visit the following URL\n\n" . site_url('users/activate/' . $this->users_model->id . '/' . $this->users_model->activation_code) . "\n\nThank You!\n\n" . $this->settings->site_name;
                
                // Generate and send email            
                $this->_sendmail(
                    $this->settings->mail_reply_email, // From  
                    $this->settings->site_name, // From name 
                    $this->users_model->email, // To 
                    $subject,  // Subject
                    $message // Message body
                );
                
                $this->session->set_flashdata('message', '<p class="success">An email containing your activation code has been sent to your email address.</p>');
                
                redirect('/users/login');
            }
            else
            {
                $this->users_model->save();
                $this->users_model->create_session(); // Create session and log the user in

                redirect('/');
            }
        }

        $this->template->view('/users/register', $data);
    }
    
    // ------------------------------------------------------------------------

    public function logout()
    {
        $this->load->model('users_model');    

        // Check if current user was an admin logged in as another user
        if (isset($this->secure->get_user_session()->admin_id))
        {
            $this->users_model->get_by_id($this->secure->get_user_session()->admin_id);

            // Return to admin session
            if ($this->users_model->exists())
            {
                $this->users_model->create_session();

                redirect(ADMIN_PATH);
            }
        }

        // Delete all session data
        $this->session->sess_destroy();
        $this->users_model->destroy_remember_me();
        // redirect('/');
        redirect(ADMIN_PATH);
    }
    
    // ------------------------------------------------------------------------

    public function forgot_password()
    {
        // Init
        $data = array();

        // Form Validation
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|callback_email_exists');

        if ($this->form_validation->run() == TRUE)
        {
            // Randomly string together a human readable 8 character password 
            $pass = ucfirst(random_readable_string(4)) . random_number(4);

            $User = $this->input->post('user');

            // Generate and send email            
            $this->_sendmail(
                $this->settings->mail_reply_email, // From  
                $this->settings->site_name, // From name 
                $User->email, // To 
                'Password Reset',   // Subject
                "Your " . $this->settings->site_name . " password has been reset.\n\nYour new password is: $pass"  // Message body
            );

            // Set users password in database
            $User->password = md5($this->config->item('encryption_key') . $pass);

            $this->load->model('users_model');
            $User->save();

            $this->session->set_flashdata('message', '<p class="success">An email containing your new password has been sent to your email address.</p>');

            if ($this->uri->segment(1) == ADMIN_PATH)
            {
                redirect(ADMIN_PATH . '/users/login');
            }
            else
            {
                redirect('users/login');
            }
        }

        // If user was in admin panel load admin view
        if ($this->uri->segment(1) == ADMIN_PATH)
        {
            $this->template->set_theme('admin', 'default', 'application/themes');
            $this->template->set_layout('default_wo_errors');
            
            $this->template->add_package('jquery');
            $this->template->add_script("
                $(document).ready(function() { 
                    $('#email').focus();
                });");
            $this->template->view("admin/forgot_password", $data);
        }
        else
        {
            $this->template->view("/users/forgot_password", $data);
        }
    }
    
    // ------------------------------------------------------------------------

    public function activate()
    {
        // Init
        $data = array();
        $this->load->model('users_model');
        $user_id = $this->uri->segment(3);
        $activation_code = $this->uri->segment(4);

        // Check that user email activation is enabled
        if ( ! $this->settings->users_module->email_activation)
        {
            return show_404();
        }

        if ( ! $user_id ||  ! $activation_code)
        {
            return show_404();
        }

        // Lookup user by id and activation code
        $data['User'] = $User = $this->users_model
            ->where('id', $user_id)
            ->where('activation_code', $activation_code)
            ->get();

        // Show 404 if user not found
        if ( ! $User->exists())
        {
            return show_404();
        }

        $data['new_activation'] = FALSE;

        if ( ! $User->activated)
        {
            $User->activated = 1;
            $User->save();
            $data['new_activation'] = TRUE;
        }

        $this->template->view('/users/activate', $data);
    }

    /*
     * Form Validation callback to check that the provided email address exists.
     */
    function email_exists($email)
    {
        $this->load->model('users_model');
        $User = $this->users_model->where("email = '$email'")->get();

        if ( ! $User->exists())
        {
            $this->form_validation->set_message('email_exists', "The email address $email was not found.");
            return FALSE;
        }
        else
        {
            $_POST['user'] = $User;
            return TRUE;
        }
    }

    /*
     * Form Validation callback to check if an email address is already in use.
     */
    function email_check($email)
    {
        $this->load->model('users_model');
        $User = $this->users_model->where("email = '$email'")->get();

        if ($User->exists())
        {
            $this->form_validation->set_message('email_check', "This email address is already in use.");
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    // ------------------------------------------------------------------------

    /**
     * Send Mail
     *
     * Builds and sends email to the specified address
     * Using PHPMailer to send email as html using SMTP service.
     *
     * @author     Cosmo Mathieu <cosmo@cosmointeractive.co>
     * @access     private
     * @return     bool
     */
    private function _sendmail($from, $fromName, $to, $subject, $message)
    {
        $config = array(
            'protocol'    => $this->settings->mail_protocol,
            'smtp_host'   => $this->settings->mail_server,
            'smtp_port'   => $this->settings->mail_outgoing_port,
            'smtp_user'   => $this->settings->mail_login,
            'smtp_pass'   => $this->settings->mail_password,
            'smtp_crypto' => $this->settings->mail_authen_srvc,
            'smtp_debug'  => ((ENVIRONMENT !== 'production') ? 2 : 0), // 2 to enable SMTP debug information
            'mailtype'    => 'html',
            'wrapchars'  => 76, 
            'wordwrap'   => true,
        );
        $this->load->library('email', $config);        
        // $this->load->library('parser');
		
		$result = $this->email
                ->from($from, $this->settings->site_name)
                ->reply_to($this->settings->mail_reply_email)    // Optional, an account where a human being reads.
                ->to($to)
                ->subject($subject)
                ->message($message)
                ->send();
                
        return $result;       
    }
}
