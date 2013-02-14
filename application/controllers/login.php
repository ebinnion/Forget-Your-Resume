<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

   public function __construct()
   {
      session_start();
      parent::__construct();
   }

	public function index(){
      if ( isset($_SESSION['username']) ) {
         redirect('settings');
      }

      $this->load->library('form_validation');
      $this->form_validation->set_rules('user', 'Username', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');

      $user = $this->input->post('user');
      $password = $this->input->post('password');

      if ( $this->form_validation->run() !== false ) {
         // then validation passed. Get from db
         $q = $this->db
            ->where('user', $user)
            ->where('password', sha1($password))
            ->limit(1)
            ->get('users');

         if ( $q->num_rows > 0 ) {
            // person has account with us
            $_SESSION['username'] = $this->input->post('user');
            redirect('settings');
         }

      }

      $this->load->view('login');
   }

   public function logout(){
      session_destroy();
      redirect('login');
   }

   public function process() {

      $this->load->library('form_validation');
      $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('oldpass', 'Old Password', 'trim|required|min_length[4]');
      $this->form_validation->set_rules('newpass', 'New Password', 'trim|required|min_length[4]|matches[newpass2]');
      $this->form_validation->set_rules('newpass2', 'Password Confirmation', 'trim|required|min_length[4]');

      if ( $this->form_validation->run() !== false ) {
         $user = $this->input->post('username');
         $oldpass = $this->input->post('oldpass');
         $newpass = $this->input->post('newpass');
         $newpass2 = $this->input->post('newpass2');

         $q = $this->db
            ->where('user', $user)
            ->where('password', sha1($oldpass))
            ->limit(1)
            ->get('users');

         if ( $q->num_rows > 0 ) {
            // User exists
            $data = array(
               'user'      => $user,
               'password'  => sha1($newpass)
            );

            $this->db->where('id', 1);
            $this->db->update('users', $data); 

            redirect('settings');
         }

      }

      $this->load->view('update-pass');

   }
}
