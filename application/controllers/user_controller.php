<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function login()
    {
        $data = array(
            'block_period' => '',
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
                $this->load->view('user/login.php',$data);
                /*$this->load->view('footer');*/
            }    

    }

    public function register()
    {   
        if (isset($_REQUEST['id']))
        {
            $user_guid = $_REQUEST['id'];

            $data = array(
                'user_info' => $this->db->query("SELECT * FROM ost_user_test WHERE user_guid = '$user_guid'"),
            );
        }
        else
        {
            $data = array();
        }

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
        {

            /*$this->load->view('WinCe/header');
            $this->load->view('WinCe/po/po_main',$data);*/
            
        }
        else
        {
            $this->load->view('header');
            $this->load->view('user/register', $data);
            /*$this->load->view('footer');*/
        }
    }

    public function superlogin()
    {
        $data = array(
            'offline' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'"),
            'allow_pw_reset' => $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id = '106'")->row('value'),
            'block_period' => '',
        );
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
        {

            /*$this->load->view('WinCe/header');
            $this->load->view('WinCe/po/po_main',$data);*/
            
        }
        else
        {
            /*$this->load->view('header');*/
            $this->load->view('user/superlogin', $data);
            /*$this->load->view('footer');*/
        }    
    }

    public function create()
    {
        $user_email = addslashes($this->input->post('email'));
        $user_name = addslashes($this->input->post('fullname'));
        $user_phone = addslashes($this->input->post('phone'));
        $user_pas = addslashes($this->input->post('passwd1'));
        $user_phoneext = addslashes($this->input->post('phoneext'));

        $result = $this->User_model->add_process($user_name, $user_pas, $user_email, $user_phone, $user_phoneext);

        $user_guid = $this->db->query("SELECT user_guid FROM ost_user_test WHERE user_email = '$user_email'")->row('user_guid');

        $this->load->library('email');

        $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
        $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'");

        $data = array(
            'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                REPLACE(REPLACE(body, '%user_name%', '".$result->row('user_name')."'), '%user_guid%', '".$result->row('user_guid')."') AS email FROM ost_content_test WHERE type = 'registration-client'"),
            'template' => $this->db->query("SELECT * FROM ost_company_test"),
        );

        $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
        $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

        $config = array(
            
            'smtp_user' => $sender_email->userid,
            'smtp_pass' => $sender_email->userpass,
            'smtp_host' => $sender_email->smtp_host,
            'smtp_port' => $sender_email->smtp_port,
                            
        );
        $bodyContent = $this->load->view('email_template', $data, TRUE);
        
        $result = $this->email
            ->initialize($config)
            ->from($sender_email->userid)
            ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
            ->to($user_email)
            ->subject($data['body']->row('subject'))
            ->message($bodyContent)
            ->send();

/*      var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;*/
        redirect('user_controller/email_confirmation?direct=registration-confirm');
        /*echo "<script>
            document.location='" . base_url() . "/index.php/welcome/index'
        </script>";*/
    }

    public function email_confirmation()
    {
        $direct = $_REQUEST['direct'];
        $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');

        if ($direct == 'registration-confirm')
        {
            $data = array(
                'confirm_page' => $this->db->query("SELECT name, body AS content FROM ost_content_test WHERE type ='registration-confirm'"),
            );
        }
        else if ($direct == 'registration-thanks')
        {
            $data = array(
                'confirm_page' => $this->db->query("SELECT name, REPLACE(body, '%company_name%', '$company_name') AS content FROM ost_content_test WHERE type = 'registration-thanks'"),
            );
        }
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
        {

            /*$this->load->view('WinCe/header');
            $this->load->view('WinCe/po/po_main',$data);*/
            
        }
        else
        {
            $this->load->view('header');
            $this->load->view('user/email_confirmation', $data);
            /*$this->load->view('footer');*/
        }
    }

    public function activateuser()
    {
        $user_guid = $_REQUEST['id'];
        $getuserinfo = $this->db->query("SELECT a.user_name, a.user_pas, a.user_email, a.user_phone, a.user_phoneext, b.name FROM ost_user_test a INNER JOIN ost_department_test b ON a.user_depart = b.department_guid WHERE a.user_guid = '$user_guid'");
        
        $sessiondata = array(
            'username' => $getuserinfo->row('user_name'),
            'userpass' => $getuserinfo->row('user_pas'),
            'userid' => $user_guid,
            'userdepname' => $getuserinfo->row('name'),
            'useremail' =>  $getuserinfo->row('user_email'),
            'userphone' => $getuserinfo->row('user_phone'),
            'userphoneext' => $getuserinfo->row('user_phoneext'),
            'loginuser' => TRUE,
            'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
        );
        $this->session->set_userdata($sessiondata);

        $this->db->query("UPDATE ost_user_test SET status = '1', active = '1', user_updated_at = now() WHERE user_guid = '$user_guid' ");

        redirect('user_controller/email_confirmation?direct=registration-thanks');
    }

    public function activateuserguestconfirm()
    {
        $cemail = $this->input->post('email');
        $cname = $this->input->post('fullname');
        $cphone = $this->input->post('phone');
        $cphoneext = $this->input->post('phoneext');
        $newpass1 = $this->input->post('passwd1');
        $newpass2 = $this->input->post('passwd2');
        $user_guid = $_REQUEST['id'];

        if($newpass1 == $newpass2){
            $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name = '$cname', user_pas = '$newpass2', user_phone = '$cphone', user_phoneext = '$cphoneext', status = '1', active = '1', user_updated_at = now() WHERE user_guid = '$user_guid'");

            $getuserinfo = $this->db->query("SELECT b.name FROM ost_user_test a INNER JOIN ost_department_test b ON a.user_depart = b.department_guid WHERE a.user_guid = '$user_guid'");

            $sessiondata = array(
                'username' => $cname,
                'userpass' => $newpass2,
                'userid' => $user_guid,
                'userdepname' => $getuserinfo->row('name'),
                'useremail' =>  $cemail,
                'userphone' => $cphone,
                'userphoneext' => $cphoneext,
                'loginuser' => TRUE,
                'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
            );
            $this->session->set_userdata($sessiondata);

            redirect('user_controller/email_confirmation?direct=registration-thanks');
        }

        else{
            echo "<script> alert('Different New Password');</script>"; 
            return false;   
        }
    }

    public function edit()
    {
        $user_guid = $_SESSION["userid"];

        $disallow_change_password = $this->db->query("SELECT changepass FROM osticket.ost_user_test WHERE user_guid = '$user_guid' ");

        $data = array(

            'disallow_change_password' => $disallow_change_password
     
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
                $this->load->view('user/edit', $data);
                /*$this->load->view('footer');*/
            }    

    }

    public function editconfirm()
    {
        $this->form_validation->set_rules('cpasswd', 'Password', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$data);
            
            }   
                
            else
            {
                $this->load->view('header');
                $this->load->view('user/edit');
                //$this->load->view('footer');
            }
        }
        else
        {
            $cemail = $this->input->post('cemail');
            $cname = $this->input->post('cname');
            $cphone = $this->input->post('cphone');
            $cphoneext = $this->input->post('cphoneext');
            $userpass = $this->input->post('cpasswd');
            $newpass1 = $this->input->post('passwd1');
            $newpass2 = $this->input->post('passwd2');
            $user_guid = $_SESSION["userid"];

            $usernamecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid != '$user_guid' AND user_name = '$cname' ")->num_rows();

            $useremailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_guid != '$user_guid' AND user_email = '$cemail' ")->num_rows();

            if ($usernamecheck != '0' && $useremailcheck != '0')
            {
                echo "<script> alert('Name and email duplicated');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/user_controller/edit' </script>";
            }

            else if ($usernamecheck != '0')
            {
                echo "<script> alert('Name duplicated');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/user_controller/edit' </script>";
            }

            else if ($useremailcheck != '0')
            {
                echo "<script> alert('Email duplicated');</script>";
                echo "<script> document.location='" . base_url() . "/index.php/user_controller/edit' </script>";
            }

            else
            {

                $updatesessiondata = array(
                    'username' => $cname,
                    'userpass' => $newpass2,
                    'useremail' =>  $cemail,
                    'userphone' => $cphone,
                    'userphoneext' =>$cphoneext,
                );      

                $result  = $this->User_model->checkpass($user_guid, $userpass);
                if($result > 0)
                {
                    if($newpass1 == $newpass2){
                        $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name = '$cname', user_phone = '$cphone', user_phoneext = '$cphoneext', user_updated_at = now() WHERE user_guid = '$user_guid'");

                        if ($newpass2 != '')
                            $this->db->query("UPDATE ost_user_test SET user_pas = '$newpass2' WHERE user_guid = '$user_guid'");

                        $splitemail = explode('@', $cemail);
                        $domain = '@'.$splitemail[1];
                        $org = $this->db->query("SELECT * FROM ost_organization_test");
                        $user_orgid = $this->db->query("SELECT * FROM ost_user_test AS a
                            LEFT JOIN ost_organization_test AS b ON a.user_org_guid = b.organization_guid
                            WHERE user_guid = '$user_guid'")->row('organization_guid');

                        foreach ($org->result() as $orgdomain)
                        {
                            if ($orgdomain->organization_guid != $user_orgid && $orgdomain->domain == $domain)
                            {
                                $this->db->query("UPDATE ost_user_test SET user_org_guid = '$orgdomain->organization_guid' WHERE user_guid = '$user_guid' ");

                                echo "<script> alert('You have been auto add into organization $orgdomain->name due to email domain');</script>";
                            }
                        }

                        $this->session->set_userdata($updatesessiondata);

                        echo "<script> alert('Succesfully change profile');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/welcome/index' </script>";
                    }

                    else{
                        echo "<script> alert('Different New Password');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/welcome/index' </script>";
                    }
                    
                    $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name ='$cname', user_phone = '$cphone', user_phoneext ='$cphoneext', user_updated_at = now() WHERE user_guid='$user_guid'");
                }

                else
                {
                    echo "<script> alert('Incorrect current password');</script>";
                    $this->load->database();

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                        {

                            $this->load->view('WinCe/header');
                            $this->load->view('WinCe/index',$data);
                            
                        }
                    else 
                    {   
                        $this->load->view('header');
                        $this->load->view('user/edit');
                        /*$this->load->view('footer');*/
                    }    
                }
            
            }
        }
    }

    public function login_form()
    {
        $this->form_validation->set_rules('luser', 'Username', 'trim|required');
        $this->form_validation->set_rules('lpasswd', 'Password', 'trim|required');
         $client_login_timeout = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='19'")->row('value');
         $current_time = date("Y-m-d H:i:s");

         $data = array(
            'block_period' => $client_login_timeout,
        );

          if(isset($_SESSION['block_period2']) && $current_time < $_SESSION['block_period2'])
        {
           
                $_SESSION['blocked2'] = 'on';
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                    {

                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/index',$data);
                    
                    }   
                    
                else
                    {
                        echo "<script> alert('Access Blocked for certain period for excessive logging in');</script>";
                        $this->load->view('header');
                        $this->load->view('user/login', $data);
                        //$this->load->view('footer');
                    }
            }
            else
            {
                unset($_SESSION['block_period2']);
                unset($_SESSION['blocked2']);

        if($this->form_validation->run() == FALSE)
        {

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                {

                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index',$data);
                
                }   
                
            else
                {
                    echo "<script> alert('Please insert email/username and password');</script>";
                    $this->load->view('header');
                    $this->load->view('user/login',$data);
                    //$this->load->view('footer');
                }
        }
        else
        {   
            $username1 = addslashes($this->input->post('luser'));
            $userpass = addslashes($this->input->post('lpasswd'));
            $username = $this->db->query("SELECT user_name FROM osticket.ost_user_test WHERE user_name = '$username1' OR user_email = '$username1'")->row('user_name');
            $userid = $this->db->query("SELECT user_guid FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_guid');
            $userdep =  $this->db->query("SELECT user_depart FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_depart');
            $userdepname = $this->db->query("SELECT name FROM osticket.ost_department_test WHERE department_guid = '$userdep'")->row('name');
            $useremail = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_email');
            $phone = $this->db->query("SELECT user_phone FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phone');
            $phoneext = $this->db->query("SELECT user_phoneext FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phoneext');

                $result  = $this->User_model->login_data($username, $userpass);
                if($result > 0)
                {
                    $changepass = $this->db->query("SELECT resetpass FROM ost_user_test WHERE user_name = '$username'")->row('resetpass');

                    if(isset($_SESSION['loginsecond2']))
                    {
                        unset($_SESSION['loginsecond2']);
                    }

                    if($changepass == '1')
                    {
                        echo "<script> alert('You need to reset your password to continue logging in.');</script>"; 
                        echo "<script>
                        document.location='" . base_url() . "index.php/user_controller/user_reset_forgot_pw?id=".$userid."'
                        </script>";
                        die();
                    }
                    
                    //set the session variables
                    $sessiondata = array(
                              
                        'username' => $username,
                        'userpass' => $userpass,
                        'userid' => $userid,
                        'userdepname' => $userdepname,
                        'useremail' =>  $useremail,
                        'userphone' => $phone,
                        'userphoneext' =>$phoneext,
                        'loginuser' => TRUE,
                        'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
                             
                    );              
                    $this->session->set_userdata($sessiondata);
                    redirect("ticket_controller/main", $sessiondata);
                    echo "<script> alert('succesfully loged in');</script>";     
                }
                else
                {
                    if(isset($_SESSION['loginsecond2'])){
                        $_SESSION['loginsecond2'] +=1;
                    }
                    else
                    {
                        $_SESSION['loginsecond2'] ='1';
                    }
                    $client_max_login = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='18'")->row('value');
                     $client_login_timeout = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='19'")->row('value');

                    if($_SESSION['loginsecond2']%$client_max_login == 0){
                        $_SESSION['block_period2'] = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$client_login_timeout minutes"));
                    }

                    echo "<script> alert('Incorrect username or password');</script>";
                    $this->load->database();

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                    {

                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/index',$data);
                        
                    }
                    else 
                    {   
                        $this->load->view('header');
                        $this->load->view('user/login',$data);
                        /*$this->load->view('footer');*/
                    }    
                }
            }
        }
    }



    public function super_login_form()
    {
        $this->form_validation->set_rules('userid', 'Username', 'trim|required');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required');
        $staff_login_timeout = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='15'")->row('value');
        $current_time = date("Y-m-d H:i:s");

        $data = array(
            'offline' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'"),
            'allow_pw_reset' => $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id = '106'")->row('value'),
            'block_period' => $staff_login_timeout,
        );

        if(isset($_SESSION['block_period']) && $current_time < $_SESSION['block_period'])
        {
            $_SESSION['blocked'] = 'on';
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$data);
            
            }   
                
            else
            {
                echo "<script> alert('Access Blocked for certain period for excessive logging in');</script>";
               /* $this->load->view('header');*/
                $this->load->view('user/superlogin', $data);
                //$this->load->view('footer');
            }
        }
        else
        {
            unset($_SESSION['block_period']);
            unset($_SESSION['blocked']);

            if($this->form_validation->run() == FALSE)
            {

                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                {

                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index',$data);
                
                }   
                    
                else
                {
                    echo "<script> alert('Please insert email/username and password');</script>";
                   /* $this->load->view('header');*/
                    $this->load->view('user/superlogin', $data);
                    //$this->load->view('footer');
                }
            }
            else
            {
                $username1 = addslashes($this->input->post('userid'));
                $userpass = addslashes($this->input->post('passwd'));
                $username = $this->db->query("SELECT username FROM osticket.ost_staff_test WHERE username = '$username1' OR email = '$username1'")->row('username');
                $staffid = $this->db->query("SELECT staff_guid FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('staff_guid');
                $pw_expire = $this->db->query("SELECT passwdreset FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('passwdreset');
                $staffemail = $this->db->query("SELECT email FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('email');
                $staffdept = $this->db->query("SELECT dept_guid FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('dept_guid');
                $change_passwd = $this->db->query("SELECT change_passwd FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('change_passwd');
                $isactive = $this->db->query("SELECT isactive FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('isactive');
                $auto_refresh_rate = $this->db->query("SELECT auto_refresh_rate FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('auto_refresh_rate');
                $default_signature_type = $this->db->query("SELECT default_signature_type FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('default_signature_type');

                $result  = $this->User_model->super_login_data($username, $userpass);

                if ($isactive == '0') {
                    echo "<script> alert('Your account is deactive, please contact admin of the site.');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/user_controller/superlogin' </script>";
                }

                else if($result > 0)
                {

                    if(isset($_SESSION['loginsecond']))
                    {
                        unset($_SESSION['loginsecond']);
                    }


                    //set the session variables
                    $sessiondata = array(
                              
                        'staffname' => $username,
                        /*'userpass' => $userpass,*/
                        'staffpass' => $userpass,
                        'change_passwd' => $change_passwd,
                        'staffid' =>$staffid,
                        /*'userdepname' => $userdepname,*/
                        'staffemail' =>  $staffemail,
                        'staffdept' => $staffdept ,
                        'auto_refresh_rate' => $auto_refresh_rate,
                        'default_signature_type' => $default_signature_type,
                        'loginstaff' => TRUE,
                        'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
                             
                    );              
                    $this->session->set_userdata($sessiondata);

                    if($pw_expire != null && $pw_expire<date('Y-m-d'))
                    {
                        echo "<script> alert('Password already expired, Please change password to continue log in.');</script>";
                        $this->load->view('user/reset_forgot_pw', $sessiondata);
                    }
                    else
                    {
                        if ($_SESSION['change_passwd'] != 0 )
                        {    
                            $this->load->view('user/reset_forgot_pw', $sessiondata);
                        }
                        else
                        {
                            redirect("staff_ticket_controller/main?title=Open&direct=open", $sessiondata);
                            echo "<script> alert('succesfully loged in');</script>";     
                        }
                    }  
                }
                else
                {
                    if(isset($_SESSION['loginsecond']))
                    {
                        $_SESSION['loginsecond'] +=1;
                    }
                    else
                    {
                        $_SESSION['loginsecond'] ='1';
                    }
                    $staff_max_login = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='14'")->row('value');
                    $staff_login_timeout = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='15'")->row('value');

                    if($_SESSION['loginsecond']%$staff_max_login == 0)
                    {
                        $_SESSION['block_period'] = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$staff_login_timeout minutes"));
                    }

                    echo "<script> alert('Incorrect username or password');</script>";
                    $this->load->database();

                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                    {

                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/index',$data);
                        
                    }
                    else 
                    {   
                        /*$this->load->view('header');*/
                        $this->load->view('user/superlogin', $data);
                        /*$this->load->view('footer');*/
                    }    
                }
            }
        }
    }

    public function user_forgot_pw()
    {
        $email = $this->input->post('useremail');
        
        if(!isset($email))
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$data);
            
            }
                
            else
            {
                $this->load->view('header');
                $this->load->view('user/user_pwreset');
                /*$this->load->view('footer');*/
            }
        }
        else
        {
            $useremail = $this->db->query("SELECT * FROM osticket.ost_user_test WHERE user_email='$email'");
            $username = $this->db->query("SELECT * FROM osticket.ost_user_test WHERE user_name='$email'");

            if($useremail->num_rows() < 1 && $username->num_rows() < 1)
            {     
                echo "<script> alert('Incorrect username or email');</script>"; 
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                {

                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index',$data);
                
                }
                else
                {
                    echo $this->load->view('header','',TRUE);
                    echo $this->load->view('user/user_pwreset','',TRUE);
                    die();

                    /*$this->load->view('footer');*/
                }
            }
            else if($useremail->num_rows() < 1 && $username->num_rows() > 0)
            {
                $getemail = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_name='$email'");
                $email = $getemail->row('user_email');
            }

            $token_life = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='107'")->row('value');
            $expiretime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$token_life minutes"));

            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $this->db->query("UPDATE osticket.ost_user_test SET token='$token', token_expire='$expiretime' WHERE user_email='$email'");

            $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$email'");

            $email_data = array(
                'body' => $this->db->query("SELECT REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$result->row('user_name')."'), '%token%', '$token'), '%user_guid%', '".$result->row('user_guid')."') AS email, name FROM ost_content_test WHERE type = 'pwreset-client'"),
                'template' => $this->db->query("SELECT * FROM ost_company_test"),
            );

            $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
            $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

            $config = array(
                
                'smtp_user' => $sender_email->userid,
                'smtp_pass' => $sender_email->userpass,
                'smtp_host' => $sender_email->smtp_host,
                'smtp_port' => $sender_email->smtp_port,
                                
            );

            $bodyContent = $this->load->view('email_template', $email_data, TRUE);

            $result = $this->email
                ->initialize($config)
                ->from($sender_email->userid)
                ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
                ->to($email)
                ->subject($email_data['body']->row('name'))
                ->message($bodyContent)
                ->send();

            $view_data = array(
                'block_period' => '',
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$view_data);
            
            }   
            else
            {
                unset($_SESSION['loginsecond2']);
                echo "<script> alert('Password reset email has been sent,please check your email.');</script>";
                $this->load->view('header');
                $this->load->view('user/login', $view_data);
                /*$this->load->view('footer');*/
            }
        }
    }
    

    public function forgot_pw()
    {
        $email = $this->input->post('useremail');
        
        if(!isset($email))
        {
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$data);
            
            }
                
            else
            {
                $this->load->view('user/pwreset');
                /*$this->load->view('footer');*/
            }
        }
        else
        {
            $useremail = $this->db->query("SELECT * FROM osticket.ost_staff_test WHERE email='$email'");
            $username = $this->db->query("SELECT * FROM osticket.ost_staff_test WHERE username='$email'");

            if($useremail->num_rows() < 1 && $username->num_rows() < 1)
            {     
                echo "<script> alert('Incorrect username or email');</script>"; 
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                {

                    $this->load->view('WinCe/header');
                    $this->load->view('WinCe/index',$data);
                
                }
                else
                {
                    $this->load->view('user/pwreset');
                    /*$this->load->view('footer');*/
                }
            }
            else if($useremail->num_rows() < 1 && $username->num_rows() > 0)
            {
                $getemail = $this->db->query("SELECT email FROM osticket.ost_staff_test WHERE username='$email'");
                $email = $getemail->row('email');
            }

            $token_life = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='107'")->row('value');
            $expiretime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$token_life minutes"));

            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $this->db->query("UPDATE osticket.ost_staff_test SET token='$token', token_expire='$expiretime' WHERE email='$email'");

            $result = $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email'");

            $email_data = array(
                'body' => $this->db->query("SELECT REPLACE(REPLACE(REPLACE(body, '%firstname%', '".$result->row('firstname')."'), '%token%', '$token'), '%staff_guid%', '".$result->row('staff_guid')."') AS email, name FROM ost_content_test WHERE type = 'pwreset-staff'"),
                'template' => $this->db->query("SELECT * FROM ost_company_test"),
            );

            $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
            $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

            $config = array(
                
                'smtp_user' => $sender_email->userid,
                'smtp_pass' => $sender_email->userpass,
                'smtp_host' => $sender_email->smtp_host,
                'smtp_port' => $sender_email->smtp_port,
                                
            );

            $bodyContent = $this->load->view('email_template', $email_data, TRUE);

            $result = $this->email
                ->initialize($config)
                ->from($sender_email->userid)
                ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
                ->to($email)
                ->subject($email_data['body']->row('name'))
                ->message($bodyContent)
                ->send();

            $view_data = array(
                'offline' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'"),
                'allow_pw_reset' => $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id = '106'")->row('value'),
                'block_period' => '',
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                $this->load->view('WinCe/header');
                $this->load->view('WinCe/index',$view_data);
            
            }   
                
            else
            {
                unset($_SESSION['loginsecond']);
                echo "<script> alert('Password reset email has been sent,please check your email.');</script>";
               /* $this->load->view('header');*/
                $this->load->view('user/superlogin', $view_data);
                /*$this->load->view('footer');*/
            }
        }
    }
    

    public function resetforgotpassword()
    {
        $user_guid = $this->input->post('id');
        $old_pw = $this->input->post('old_pw');
        $newpw = $this->input->post('new_pw');
        $newpw2 = $this->input->post('confirm');
        $passwdreset = $this->db->query("SELECT value FROM ost_config_test WHERE id = '17'")->row('value');
        $getDate = date('Y-m-d');
        $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +".$passwdreset." months");
        $expiry_date = date('Y-m-d',$getDate);
        $staff_info = $this->db->query("SELECT token, token_expire, passwd FROM ost_staff_test WHERE staff_guid = '$user_guid' ");

        $curtime=date("Y-m-d H:i:s");
        if($staff_info->row('token') != null && $staff_info->row('token_expire') != null)
        {   
            if($curtime>$staff_info->row('token_expire'))
            {
                echo "<script> alert('Temporary Password has expired! Please send another temporary password to reset your password.');</script>";
                echo "<script>
                document.location='" . base_url() . "/index.php/user/pwreset'
                </script>";
            }
            else if($newpw == $newpw2 && $old_pw == ($staff_info->row('token') || $staff_info->row('passwd')))
            {
                $this->db->query("UPDATE ost_staff_test SET change_passwd = '0', passwd = '$newpw2' , updated = NOW(),passwdreset='$expiry_date' WHERE staff_guid = '$user_guid'");

                $this->db->query("UPDATE ost_staff_test SET token = null, token_expire = null WHERE staff_guid = '$user_guid'");
            
                echo "<script> alert('Succesfully update password');</script>";
                echo "<script>
                document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open&direct=open'
                </script>";
            }
            else
            {
                echo "<script> alert('Wrong original password or different new password');</script>"; 
                echo "<script>
                document.location='" . base_url() . "index.php/user_controller/reset_forgot_pw?id=".$user_guid."'
                </script>";  
            }
        }
        else
        {
            $stafforipasswd = $this->db->query("SELECT passwd FROM ost_staff_test WHERE staff_guid = '$user_guid' ")->row('passwd');
            if($newpw == $newpw2 && $old_pw == $stafforipasswd)
            {
                $this->db->query("UPDATE ost_staff_test SET change_passwd = '0', passwd = '$newpw2' , updated = NOW(),passwdreset='$expiry_date' WHERE staff_guid = '$user_guid'");
            
                echo "<script> alert('Succesfully change password');</script>";
                echo "<script>
                    document.location='" . base_url() . "/index.php/user_controller/superlogin'
                    </script>";
            }
            else
            {
                echo "<script> alert('Wrong original password or different new password');</script>"; 
                echo "<script>
                document.location='" . base_url() . "/index.php/user_controller/reset_forgot_pw?id=".$user_guid."'
                </script>";  
            }
        }
    }

    public function user_resetforgotpassword()
    {
        $user_guid = $this->input->post('id');
        $old_pw = $this->input->post('old_pw');
        $newpw = $this->input->post('new_pw');
        $newpw2 = $this->input->post('confirm');
        $user_info = $this->db->query("SELECT token, token_expire, user_pas FROM ost_user_test WHERE user_guid = '$user_guid' ");

        $curtime=date("Y-m-d H:i:s");
        if($user_info->row('token') != null && $user_info->row('token_expire') != null)
        {   
            if($curtime > $user_info->row('token_expire'))
            {
                echo "<script> alert('Temporary Password has expired! Please send another temporary password to reset your password.');</script>";
                echo "<script>
                    document.location='" . base_url() . "/index.php/user_controller/user_forgot_pw'
                    </script>";
            }
            else if($newpw == $newpw2 && $old_pw == ($user_info->row('token') || $user_info->row('user_pas')))
            {
                $this->db->query("UPDATE ost_user_test SET  user_pas = '$newpw2', resetpass = '0', user_updated_at = NOW() WHERE user_guid = '$user_guid'");

                $this->db->query("UPDATE ost_user_test SET token = null, token_expire = null WHERE user_guid = '$user_guid'");
            
                echo "<script> alert('Succesfully change password');</script>";
                echo "<script>
                    document.location='" . base_url() . "/index.php/user_controller/login'
                    </script>";
            }
            else
            {
                echo "<script> alert('Wrong original password or different new password');</script>"; 
                echo "<script>
                document.location='" . base_url() . "index.php/user_controller/user_reset_forgot_pw?id=".$user_guid."'
                </script>";  
            }
        }else
        {
            $useroripasswd = $this->db->query("SELECT user_pas FROM ost_user_test WHERE user_guid = '$user_guid' ")->row('user_pas');
            if($newpw == $newpw2 && $old_pw == $useroripasswd)
            {
                $this->db->query("UPDATE ost_user_test SET resetpass = '0', user_pas = '$newpw2' , user_updated_at = NOW() WHERE user_guid = '$user_guid'");
            
                echo "<script> alert('Succesfully change password');</script>";
                echo "<script>
                    document.location='" . base_url() . "/index.php/user_controller/login'
                    </script>";
            }
            else
            {
                echo "<script> alert('Wrong original password or different new password');</script>"; 
                echo "<script>
                document.location='" . base_url() . "/index.php/user_controller/user_reset_forgot_pw?id=".$user_guid."'
                </script>";  
            }
        }
        
    }
    
    public function reset_forgot_pw()
    {
        $data['id'] = $_REQUEST['id'];
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
               /* $this->load->view('header');*/
                $this->load->view('user/reset_forgot_pw',$data);
                /*$this->load->view('footer');*/
            }    

    }

    public function user_reset_forgot_pw()
    {
        $data['id'] = $_REQUEST['id'];
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('user/user_reset_forgot_pw',$data);
                /*$this->load->view('footer');*/
            }    

    }

    public function allow_auth()
    {
        // session_unset();
        // session_destroy();
        // session_start();

        $id = $_REQUEST['id'];

        $getuser = $this->db->query("SELECT a.user_name, a.user_pas FROM ost_user_test a INNER JOIN ost_ticket_test b ON a.user_guid = b.user_guid WHERE b.ticket_guid = '$id'");
        $username = $getuser->row('user_name');
        $userpass = $getuser->row('user_pas');
        $userid = $this->db->query("SELECT user_guid FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_guid');
        $userdep =  $this->db->query("SELECT user_depart FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_depart');
        $userdepname = $this->db->query("SELECT name FROM osticket.ost_department_test WHERE department_guid = '$userdep'")->row('name');
        $useremail = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_email');
        $phone = $this->db->query("SELECT user_phone FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phone');
        $phoneext = $this->db->query("SELECT user_phoneext FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phoneext');
        
        $sessiondata = array(
                              
            'username' => $username,
            'userpass' => $userpass,
            'userid' => $userid,
            'userdepname' => $userdepname,
            'useremail' =>  $useremail,
            'userphone' => $phone,
            'userphoneext' =>$phoneext,
            'loginuser' => TRUE,
            'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
                 
        );
        $this->session->set_userdata($sessiondata);

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
        {

            /*$this->load->view('WinCe/header');
            $this->load->view('WinCe/po/po_main',$data);*/
            
        }
        else
        {
            redirect('ticket_controller/info?id='.$id);
            /*$this->load->view('footer');*/
        }
    }
}
?>