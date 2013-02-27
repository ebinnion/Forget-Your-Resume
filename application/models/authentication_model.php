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

    public function set_has_updated_password() {

    }
}