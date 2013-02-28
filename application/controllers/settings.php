<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		session_start();
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('Authentication_model');

		if ( !isset($_SESSION['username']) || !$this->Authentication_model->has_updated_password() ) {
			redirect('login');
		}

		$data['object'] = $this->app_model->get_options();

		$this->load->view('settings', $data);
	}

	public function process() {
		$profileimg = $this->input->post('profileimgval');

		$config['upload_path'] = './images/uploads';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']    = '2000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' == $this->upload->display_errors());
			// Uploading failed. $error will hold the errors.
		}
		else
		{
			$image_data = array('upload_data' => $this->upload->data());
			$config['image_library'] = 'gd2';
			$config['source_image']	= $image_data['upload_data']['full_path'];
			$config['maintain_ratio'] = FALSE;
			$config['width'] = 320;
			$config['height'] = 400;

			$this->load->library('image_lib', $config); 
			$this->image_lib->resize();
			$profileimg = base_url(). 'images/uploads/' . $image_data['upload_data']['file_name'];
		}	

		$background = $this->input->post('bgcolor');

		if( $this->input->post('contentbgvis') ){
			$contentbg = 'none';
		}
		else {
			$contentbg = $this->input->post('contentbg');
		}

		if ($this->input->post('bgpattern')) {
			$background .= " url(" . base_url() . 'images/patterns/' . $this->input->post('bgpattern') . ");";
		}

		$data = array(
			'name'            	=> $this->input->post('name'),
			'tagline'         	=> $this->input->post('tagline'),
			'aboutme'         	=> $this->input->post('aboutme'),
			'profileimg'      	=> $profileimg,
			'resume'          	=> $this->input->post('resume'),
			'background'      	=> $background,
			'theme'           	=> '',
			'headercolor'     	=> $this->input->post('headercolor'),
			'fontcolor'       	=> $this->input->post('fontcolor'),
			'taglinecolor'     	=> $this->input->post('taglinecolor'),
			'linkcolor'       	=> $this->input->post('linkcolor'),
			'linkhovercolor'  	=> $this->input->post('linkhovercolor'),
			'headlinefont'    	=> $this->input->post('headfont'),
			'bodyfont'        	=> $this->input->post('bodyfont'),
			'imgbordercolor'  	=> $this->input->post('imgborder'),
			'contentbg'       	=> $contentbg,
			'footerbg'        	=> $this->input->post('footerbg'),
			'bgcolor'			=> $this->input->post('bgcolor'),
			'bgpattern'      	=> $this->input->post('bgpattern'),
			'contentbgvis'   	=> $this->input->post('contentbgvis'),
			'facebook'       	=> $this->input->post('facebook'),
			'twitter'        	=> $this->input->post('twitter'),
			'google'         	=> $this->input->post('google'),
			'pinterest'      	=> $this->input->post('pinterest'),
			'linkedin'       	=> $this->input->post('linkedin'),
			'github'         	=> $this->input->post('github'),
			'employers'			=> $this->input->post('companyNames'),
			'employerMessage'	=> $this->input->post('companyMsgs'),
			'googleAnalyticsId'	=> $this->input->post('googleAnalytics'),
			'phone'				=> $this->input->post('phone'),
			'email'				=> $this->input->post('email')
		);

		$this->db->where('id', 1);
		$this->db->update('options', $data); 
		redirect('settings');
	}

	public function password() {
		if ( !isset($_SESSION['username']) ) {
			redirect('login');
		}
		$data = '';

		$this->load->model('Authentication_model');

		if ( !$this->Authentication_model->has_updated_password() ){
			$data['prompt'] = '<p style="color: red;">You must change your password before using Forget Your Resume.</p>';
		}

		$this->load->view('update-pass', $data);
	}
}