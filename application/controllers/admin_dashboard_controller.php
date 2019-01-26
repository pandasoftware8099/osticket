<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_dashboard_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');
 
    }


    public function agents_dashboard()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
           $_SESSION['webserver'] = $_SERVER['SERVER_SOFTWARE'];
           $_SESSION['mysql'] = $this->db->query("SELECT VERSION() AS mysql_version")->row('mysql_version');
           $_SESSION['phpversion'] = phpversion();
           $_SESSION['schema'] = $this->db->query("SELECT CONCAT(DATABASE(),'(',SUBSTRING_INDEX(USER(), '@', -1),')') AS schemaa")->row('schemaa');
           $_SESSION['timezone'] = $this->db->query("SELECT @@system_time_zone AS timezone")->row('timezone');

           $databasename = $this->db->query("SELECT DATABASE() AS schemaa")->row('schemaa');

           $spaceused = $this->db->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) 'Size in MiB' FROM information_schema.tables WHERE table_schema = '$databasename'")->row('Size in MiB');

           $data = array(
                'extension' => get_loaded_extensions(),

                'spaceused' => $spaceused,


           );

           


    
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headeradmin');
                $this->load->view('admin_dashboard/admin_dashboard_information',$data);
                $this->load->view('footeradmin');
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }


 


}
?>