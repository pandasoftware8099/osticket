<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_controller extends CI_Controller {
    
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Open_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');
 
	}

    public function staff_reset_password_page()
    {
        
         
         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
               /* $this->load->view('header');*/
                $this->load->view('staff/staffchangepass');
                /*$this->load->view('footer');*/
            }    

    }


    public function staffchangepassword()
    {
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $staff_guid = $_REQUEST['id'];
        
        $oripasswd = $this->input->post('oripasswd');
        $newpass1 = $this->input->post('passwd1');
        $newpass2 = $this->input->post('passwd2');
        $passwdreset = $this->db->query("SELECT value FROM ost_config_test WHERE id = '17'")->row('value');
        $getDate = date('Y-m-d');
        $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +".$passwdreset." months");
        $expiry_date = date('Y-m-d',$getDate);
        $stafforipasswd = $this->db->query("SELECT passwd FROM ost_staff_test WHERE staff_guid = '$staff_guid' ")->row('passwd');


        if($newpass1 == $newpass2 && $oripasswd == $stafforipasswd){
            $this->db->query("UPDATE ost_staff_test SET change_passwd = '0', passwd = '$newpass2' , updated = NOW(),passwdreset='$expiry_date' WHERE staff_guid = '$staff_guid'");
        
            echo "<script> alert('Succesfully activate account');</script>";
            echo "<script>
            document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open'
            </script>";
        }

        else{
            echo "<script> alert('Wrong original password or different new password');</script>"; 
            echo "<script>
            document.location='" . base_url() . "/index.php/staff_controller/staff_reset_password_page'
            </script>";  
        }
        }
    }
}
?>