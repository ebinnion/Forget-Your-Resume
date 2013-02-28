<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function check_if_user($user, $password) {
		$q = $this->db
			->where('user', $user)
			->where('password', sha1($password))
			->limit(1)
			->get('users');

		if ( $q->num_rows > 0 ) {
			// user exists
			
			$data = $q->result_array();
			return $data;
		}
		else {
			return false;
		}
    }

    public function has_updated_password() {
    	$q = $this->db->get('users')->result_array();

		if ( $q[0]['updatedPass'] == true) {
			return true;
		}

		return false;
    }

    public function get_email() {
    	$q = $this->db->get('users')->result_array();
    	if ( !empty($q[0]['email']) ) {
    		return $q[0]['email'];
    	}
    	return false;
    }

    public function update_users_db($data) {
    	$this->db->where('id', 1);
        $this->db->update('users', $data);
    }

    public function set_forgot_password() {
		$random = '';
		for ($i = 0; $i < 30; $i++) {
			$random .= chr(rand(ord('a'), ord('z')));
		}
		
    	$data = array('forgotPassHash'	=> $random);
    	$this->db->where('id', 1);
        $this->db->update('users', $data);

    	return $random;
    }

    public function get_password_hash() {
    	$q = $this->db->get('users')->result_array();
    
    	if ( !empty($q[0]['forgotPassHash']) ) {
    		return $q[0]['forgotPassHash'];
    	}
    	return false;
    }

    public function reset_password($password) {
    	$random = '';
		for ($i = 0; $i < 30; $i++) {
			$random .= chr(rand(ord('a'), ord('z')));
		}

    	$data = array(
    		'forgotPassHash'	=> $random,
    		'password'			=> sha1($password)
    	);

    	$this->update_users_db($data);
    }
}