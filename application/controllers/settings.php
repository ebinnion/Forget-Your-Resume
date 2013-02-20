<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		session_start();
		parent::__construct();
	}

	public function index()
	{
		if ( !isset($_SESSION['username']) ) {
			redirect('login');
		}

		$data['object'] = $this->db->get('options')->result_array();

		$data['styles'] = '';

		if ( isset( $data['object'][0]['background'] ) ){
			$data['styles'] .= 'body { background:' . $data['object'][0]['background'] . '}';
		}

		if ( isset( $data['object'][0]['headercolor'] ) ){
			$data['styles'] .= 'h1 { color: ' . $data['object'][0]['headercolor'] . ';}';
		}

		if ( isset( $data['object'][0]['fontcolor'] ) ){
			$data['styles'] .= 'body { color: ' . $data['object'][0]['fontcolor'] . ';}';
		}

		if ( isset( $data['object'][0]['taglinecolor'] ) ){
			$data['styles'] .= 'hgroup h2 { color: ' . $data['object'][0]['taglinecolor'] . ';}';
		}

		if ( isset( $data['object'][0]['linkcolor'] ) ){
			$data['styles'] .= 'a { color: ' . $data['object'][0]['linkcolor'] . ';}';
		}

		if ( isset( $data['object'][0]['linkhovercolor'] ) ){
			$data['styles'] .= 'a:hover { color: ' . $data['object'][0]['linkhovercolor'] . ';}';
		}

		if ( isset( $data['object'][0]['imgbordercolor'] ) ){
			$data['styles'] .= '[role="complementary"] img { border: 4px solid  ' . $data['object'][0]['imgbordercolor'] . ';}';
		}

		if ( isset( $data['object'][0]['contentbg'] ) ){
			$data['styles'] .= '.content { background:  ' . $data['object'][0]['contentbg'] . ';}';
		}

		if ( isset( $data['object'][0]['footerbg'] ) ){
			$data['styles'] .= '[role="contentinfo"] { background:' . $data['object'][0]['footerbg'] . ';}';
		}

		if ( isset( $data['object'][0]['headlinefont'] ) ){
			$data['styles'] .= 'h1 { font-family:"' . $data['object'][0]['headlinefont'] . '";}';
		}

		$this->load->view('settings', $data);
	}

	public function process() {
		$profileimg = NULL;
		$config['upload_path'] = './images/uploads';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']    = '2000';

		// You can give video formats if you want to upload any video file.

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' == $this->upload->display_errors());
			// Uploading failed. $error will holds the errors.
		}
		else
		{
			$image_data = array('upload_data' => $this->upload->data());
			$config['image_library'] = 'gd2';
			$config['source_image']	= $image_data['upload_data']['full_path'];
			$config['maintain_ratio'] = FALSE;
			$config['width'] = 320;
			$config['width'] = 400;

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
		'github'         	=> $this->input->post('github')
		);

		$this->db->where('id', 1);
		$this->db->update('options', $data); 
		redirect('settings');
	}

	public function password() {
		if ( !isset($_SESSION['username']) ) {
			redirect('login');
		}
		$this->load->view('update-pass');
	}
}