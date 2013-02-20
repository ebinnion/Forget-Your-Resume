<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{        
		$data['object'] = $this->app_model->get_options();
		
		$this->load->view('template1', $data);
	}
}