<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

   public function __construct()
   {
      session_start();
      parent::__construct();
   }

	public function index(){
      $this->load->model('Authentication_model');
      
      if ( isset($_SESSION['username']) && !$this->Authentication_model->has_updated_password() ) {
         redirect('settings/password');
      }

      $data = '';

      $this->load->library('form_validation');
      $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');

      $user = $this->input->post('user');
      $password = $this->input->post('password');

      if ( $this->form_validation->run() !== false ) {

         $this->load->model('Authentication_model');
         
         $q = $this->Authentication_model->check_if_user($user, $password);
         
         if ($q != FALSE) {
            $_SESSION['username'] = $this->input->post('user');
            if ( !$this->Authentication_model->has_updated_password() ){
               redirect('settings/password');
            }
            else {
               redirect('settings');
            }
            
         }
         else {
            $data['prompt'] = '<p style="color: red;">Your login credentials are not correct. Please try again.</p>';
         }
      }

      $this->load->view('login', $data);
   }

   public function logout(){
      session_destroy();
      redirect('login');
   }

   public function process() {
      $data = '';

      $this->load->library('form_validation');
      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|min_length[4]');
      $this->form_validation->set_rules('oldpass', 'Old Password', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[4]|matches[newpass2]');
      $this->form_validation->set_rules('newpass2', 'Password Confirmation', 'trim|required|min_length[4]');

      if ( $this->form_validation->run() !== false ) {
         $user = $this->input->post('username');
         $oldpass = $this->input->post('oldpass');
         $newpass = $this->input->post('newpass');
         $newpass2 = $this->input->post('newpass2');
         $email = $this->input->post('email');

         if ($newpass != $oldpass) {
            $this->load->model('Authentication_model');
         
            $q = $this->Authentication_model->check_if_user($user, $oldpass);
            
            if ( isset($q) ) {
               // User exists
               $data = array(
                  'user'         => $user,
                  'password'     => sha1($newpass),
                  'email'        => $email,
                  'updatedPass'  => true
               );

               $this->Authentication_model->update_users_db($data); 

               redirect('settings');
            }
         }
         else {
               $data['prompt'] = '<p style="color: red;">Your new and old password must be different.</p>';
            }
      }

      $this->load->view('update-pass', $data);

   }

   public function forgot_pass() {
      $data = '';

      $this->load->library('form_validation');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|min_length[4]');

      $email = $this->input->post('email');

      if ( $this->form_validation->run() !== false ) {

         $this->load->model('Authentication_model');
         
         $q = $this->Authentication_model->get_email();

         if ($q == $email){
            $hash = $this->Authentication_model->set_forgot_password();
            $data['hash'] = $hash;

            $msg = $this->load->view('reset-pass-email', $data, true);

            $this->load->library('email');

            $config['protocol'] = 'mail';
            $config['wordwrap'] = FALSE;
            $config['mailtype'] = 'html'; 

            $this->email->initialize($config);

            $this->email->from($email);
            $this->email->to($email);

            $this->email->subject('Reset your website password');
            $this->email->message($msg); 

            $this->email->send();

            $data['prompt'] = '<p style="color: red;">Please check your email for a reset link.</p>';
         }    
         else {
            $data['prompt'] = '<p style="color: red;">That email address was not found.</p>';
         }     
      }
      $this->load->view('forgotpass', $data);
   }

   public function reset_password() {
      $hash = $this->uri->segment(3);

      $this->load->model('Authentication_model');
      $q = $this->Authentication_model->get_password_hash();

      if( $q == $hash){
         $this->load->view('reset-pass');
      }
      else {
         
         $data['prompt'] = '<p style="color: red;">Your password reset URL is not valid or outdated.</p>';
         $this->load->view('login', $data);
      }
   }

   public function do_reset() {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('verifypass', 'Verify Passowrd', 'trim|required|min_length[4]|matches[newpass]');

      if ( $this->form_validation->run() !== false ) {
         $this->load->model('Authentication_model');

         $password = $this->input->post('newpass');

         $this->Authentication_model->reset_password($password);
         redirect('login');
      }

      $this->load->view('reset-pass');
   }
}