<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class App_model extends CI_Model {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function get_options() {
		$data = $this->db->get('options')->result_array();

		$data['styles'] = '';

		if ( !empty( $data[0]['background'] ) ){
			$data['styles'] .= 'body { background:' . $data[0]['background'] . '}';
		}
		else {
			$data['styles'] .= 'body {background: url('. base_url().'images/patterns/bright_squares.png);}';
		}

		if ( isset( $data[0]['headercolor'] ) ){
			$data['styles'] .= '[role="banner"] h1 a { color: ' . $data[0]['headercolor'] . ';}';
		}

		if ( isset( $data[0]['fontcolor'] ) ){
			$data['styles'] .= 'body { color: ' . $data[0]['fontcolor'] . ';}';
		}

		if ( isset( $data[0]['taglinecolor'] ) ){
			$data['styles'] .= '[role="banner"] h2 { color: ' . $data[0]['taglinecolor'] . ';}';
		}

		if ( isset( $data[0]['linkcolor'] ) ){
			$data['styles'] .= 'a { color: ' . $data[0]['linkcolor'] . ';}';
		}

		if ( isset( $data[0]['linkhovercolor'] ) ){
			$data['styles'] .= 'a:hover { color: ' . $data[0]['linkhovercolor'] . ';}';
		}

		if ( isset( $data[0]['imgbordercolor'] ) ){
			$data['styles'] .= '[role="complementary"] img { border: 4px solid  ' . $data[0]['imgbordercolor'] . ';}';
		}

		if ( isset( $data[0]['contentbg'] ) ){
			$data['styles'] .= '.content { background:  ' . $data[0]['contentbg'] . ';}';
		}

		if ( isset( $data[0]['footerbg'] ) ){
			$data['styles'] .= '[role="contentinfo"] { background:' . $data[0]['footerbg'] . ';}';
		}

		if ( isset( $data[0]['headlinefont'] ) ){
			$data['styles'] .= '[role="banner"] h1 { font-family:"' . $data[0]['headlinefont'] . '";}';
		}

		$temp = array (
			'facebook'		=> array (
								'url' 	=> $data[0]['facebook'],
								'name' 	=> 'facebook'
								),
			'twitter' 		=> array (
								'url' 	=> $data[0]['twitter'],
								'name' 	=> 'twitter'
								),
			'google'		=> array (
								'url' 	=> $data[0]['google'],
								'name' 	=> 'google-plus'
								),
			'pinterest'		=> array (
								'url' 	=> $data[0]['pinterest'],
								'name' 	=> 'pinterest'
								),
			'linkedin'		=> array (
								'url' 	=> $data[0]['linkedin'],
								'name' 	=> 'linkedin'
								),
			'github'		=> array (
								'url' 	=> $data[0]['github'],
								'name' 	=> 'github'
								)
		);
	
		foreach ( $temp as $t ){
			if ( $t['url']){
				$data['social_icons'][] = '<a href="' . $t['url'] . '" class="icon-' . $t['name'] . ' icon-large"></a>';
			}
		}

		return $data;
	}
}