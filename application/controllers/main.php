<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{        
		$data['object'] = $this->app_model->get_options();
		
		$this->load->view('template1', $data);
	}

	public function company () {
		$company = $this->uri->segment(3);

		if ($company === false) {
			redirect('/');
		}

		$data['object'] = $this->app_model->get_options();

		if ( isset($data['object'][0]['employers']) ){
			$employerList = explode(';', $data['object'][0]['employers']);
		}

		if ( isset($data['object'][0]['employerMessage']) ){
			$employerMsgList = explode(';', $data['object'][0]['employerMessage']);
		}

		$i = 0;
		$flag = false;
		while ($i < count($employerList) - 1){
			if ($company === preg_replace("/[\s_]/", "-", strtolower($employerList[$i]))){
				$flag = true;
				break;
			}

			$i++;
		}

		if ($flag == true){
			$data['company'] = $employerList[$i];
			$data['companyMsg'] = $employerMsgList[$i];
		}
		else {
			redirect('/');
		}
		
		$this->load->view('template1', $data);
	}
}