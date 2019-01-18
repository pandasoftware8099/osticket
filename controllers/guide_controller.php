<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guide_controller extends CI_Controller {
    
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

            $data = array(
            
            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE ispublic = '1' OR ispublic = '2' "),
            /*'faq' => $this->db->query("SELECT * FROM ost_faq_category_test INNER JOIN ost_faq_test ON ost_faq_category_test.category_guid = ost_faq_test.category_guid WHERE ispublic = '1' OR ispublic = '2' "),*/

            
            );

         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('guide/guide_main', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function faqsearch_process()

    {   $search = $this->input->post('search');

        $data = array(
            'search' => $this->db->query("SELECT * FROM ost_faq_test WHERE question LIKE '$search%';"),

            );
        $this->load->view('header');  
        $this->load->view('guide/guide_search', $data);    

    }

    public function category()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   $category_guid = $_REQUEST['id'];

            $data = array(

            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE ispublic = '1' OR ispublic = '2' AND category_guid = '$category_guid' ")->row(),
            'faq' => $this->db->query("SELECT * FROM ost_faq_test WHERE category_guid = '$category_guid' AND (ispublished = '1' or ispublished = '2') "),

            );

         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('guide/guide_category', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function info()
    {      
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {   $faqid = $_REQUEST['id'];
            $category_guid = $this->db->query("SELECT ost_faq_category_test.category_guid FROM ost_faq_category_test INNER JOIN ost_faq_test ON ost_faq_category_test.category_guid = ost_faq_test.category_guid WHERE ispublic = '1' OR ispublic = '2' AND faq_guid ='$faqid' ")->row('category_guid');

            $data = array(

            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE ispublic = '1' OR ispublic = '2' AND category_guid = '$category_guid'")->row(),
            'faq' => $this->db->query("SELECT * FROM ost_faq_test WHERE ispublished = '1' OR ispublished = '2' AND faq_guid = '$faqid' "),
            'faqrow' => $this->db->query("SELECT * FROM ost_faq_test WHERE ispublished = '1' OR ispublished = '2' AND faq_guid = '$faqid' ")->row(),
            'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test WHERE faq_guid = '$faqid' "),

            );

         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('guide/guide_info', $data);
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
                $this->load->view('header');
                $this->load->view('guide/guide_agent');
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function agent_login()
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
                $this->load->view('header');
                $this->load->view('guide/guide_agent_login');
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