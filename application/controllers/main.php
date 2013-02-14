<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
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

		$this->load->view('template1', $data);
	}
}