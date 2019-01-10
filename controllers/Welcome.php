<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$offline = $this->db->query("SELECT * FROM ost_config_test WHERE id = '12'");

		$data = array(
			'landpages' => $this->db->query("SELECT * FROM ost_content_test WHERE type = 'landing' AND in_use = '1' AND field = 'pages'"),
			
		);

		$this->load->view('header');
		$this->load->view('welcome_message', $data);
	}

}
