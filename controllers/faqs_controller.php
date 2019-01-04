<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs_controller extends CI_Controller {
    
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

    public function main()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_main');
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function agent()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_agent');
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }


}
?>