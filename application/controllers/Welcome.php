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

			'enable_kb' => $this->db->query("SELECT value FROM ost_config_test WHERE id='26'")->row('value'),

			'feature_question' => $this->db->query("SELECT * FROM ost_faq_category_test a INNER JOIN ost_faq_test b ON a.`category_guid` = b.`category_guid` WHERE ispublic = '1' AND ispublished = '2' "),

			'feature_kb' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE ispublic = '2'"),

			'feature_kb_faq' => $this->db->query("SELECT * FROM ost_faq_test WHERE ispublished = '2'"),


			
		);

		$this->load->view('header');
		$this->load->view('welcome_message', $data);
	}

}
