<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class insertdepartment_c extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
 
	}

	public function main()
    {
	$insert = $this->db->query("SELECT * FROM osticket.ost_staff_test WHERE CONCAT('\'',staff_guid, '\'') NOT IN (SELECT CONCAT('\'',staff_guid, '\'') FROM osticket.ost_staff_dept_access_test WHERE dept_guid = '".$_REQUEST['id']."') AND dept_guid = '".$_REQUEST['id1']."'");
	
	$a = array(
		'a' => array(),
	);

	$i = 0;

	foreach ($insert->result() as $value ) {
		$array['a'][$i++] = $value;
	}

	echo json_encode($array);

}
}
?>