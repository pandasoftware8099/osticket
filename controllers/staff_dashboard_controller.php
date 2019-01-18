<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_dashboard_controller extends CI_Controller {
    
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

     public function dashboard()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $userid = $_SESSION["staffid"];    
        $data = array(
            
            'depart' => $this->db->query("SELECT * FROM  ost_department_test ORDER BY name"),
            'topic' => $this->db->query("SELECT * FROM  ost_help_topic_test ORDER BY topic"),
            'staff' => $this->db->query("SELECT * FROM  ost_staff_test ORDER BY firstname"),      
        );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_dashboard',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function profile()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $userid = $_SESSION["staffid"];   
        
        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_staff_test WHERE staff_guid = '$userid'"),
            'hide_staff_name' => $this->db->query("SELECT value FROM ost_config_test WHERE id='67'")->row('value'),
        );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_profile',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function profileedit()
        
    {

           
            $cfirst = $this->input->post('firstname');
            $clast = $this->input->post('lastname');
            $cemail = $this->input->post('email');
            $cphone = $this->input->post('phone');
            $cphoneext = $this->input->post('phone_ext');
            $cmoblie = $this->input->post('mobile');
            $vaca = $this->input->post('onvacation');
            $cshowticket = $this->input->post('show_assigned_tickets');
            $cpagesize = $this->input->post('max_page_size');
            $crefresh = $this->input->post('auto_refresh_rate');
            $csigntype = $this->input->post('default_signature_type');
            $cpapersize = $this->input->post('default_paper_size');
            $ctimezone = $this->input->post('timezone');
            $csignature = $this->input->post('signature');
            $cdefaultname = $this->input->post('default_from_name');

            if ($crefresh != '')
                $crefresh *= 60;
            else
                $crefresh = NULL;

            $user_guid = $_SESSION["staffid"];

            /*$updatesessiondata = array(
                              
                        'staffname' => $cname,
                        'userpass' => $newpass2,
                        'useremail' =>  $cemail,
                        'userphone' => $cphone,
                        'userphoneext' =>$cphoneext,
                    ); */     
                  
                   $this->db->query("UPDATE ost_staff_test SET 

                    firstname = '$cfirst' , 
                    lastname ='$clast', 
                    email = '$cemail', 
                    phone ='$cphone' , 
                    phone_ext ='$cphoneext' , 
                    mobile ='$cmoblie' , 
                    show_assigned_tickets ='$cshowticket',
                    onvacation = '$vaca',
                    max_page_size = '$cpagesize' , 
                    auto_refresh_rate = '$crefresh' , 
                    default_signature_type = '$csigntype' ,
                    default_paper_size = '$cpapersize',
                    timezone = '$ctimezone',
                    signature = '$csignature',
                    defaultname = '$cdefaultname',
                    updated = NOW()

                    WHERE staff_guid='$user_guid'");

                   $sessiondata = array(
                        
                        'auto_refresh_rate' => $crefresh,
                        'default_signature_type'=>$csigntype,

                             
                    );              
                    $this->session->set_userdata($sessiondata);
                   

                   /* $this->session->set_userdata($updatesessiondata);*/

                echo "<script> alert('Succesfully change profile');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/staff_dashboard_controller/profile' </script>";
            
            
        
    } 

    public function passwordchange()
        
    {

           
            $currentpass = $this->input->post('currentpass');
            $newpass1 = $this->input->post('newpass1');
            $newpass2 = $this->input->post('newpass2');


            $user_guid = $_SESSION["staffid"];

            /*$updatesessiondata = array(
                              
                        'staffname' => $cname,
                        'userpass' => $newpass2,
                        'useremail' =>  $cemail,
                        'userphone' => $cphone,
                        'userphoneext' =>$cphoneext,
                    ); */     

            $checking = $this->db->query("SELECT * FROM osticket.ost_staff_test WHERE staff_guid='$user_guid' AND passwd='$currentpass'")->num_rows();
          
            if ($checking  > 0) {

                if ($newpass1 == $newpass2) {
                    $this->db->query("UPDATE ost_staff_test SET 

                    passwd = '$newpass1', updated = now()

                    WHERE staff_guid='$user_guid'");

                   /* $this->session->set_userdata($updatesessiondata);*/

                echo "<script> alert('Succesfully change password');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/staff_dashboard_controller/profile' </script>";
                    
                }


                else{

                    echo "<script> alert('Different New Password');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_dashboard_controller/profile' </script>";
                }


            }

            else  {
                echo "<script> alert('Wrong current password');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/staff_dashboard_controller/profile' </script>"; 
            }



            
                   
            
            
        
    } 

    public function agent()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $userid = $_SESSION["staffid"];    
        $data = array(
            
            'result' => $this->db->query("SELECT * FROM  ost_staff_test ORDER BY staff_guid DESC"),
            'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'), 

        );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('staff/staff_agent',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    
}

?>