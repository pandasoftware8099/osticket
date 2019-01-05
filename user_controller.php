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
        
         
         $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('header');
                $this->load->view('user/register.php');
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
            $this->load->view('user/superlogin.php', $data);
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

        $user_id = $this->db->query("SELECT user_id FROM ost_user_test WHERE user_email = '$user_email'")->row('user_id');

        $this->load->library('email');

        $subject = 'Panda Ticketing System Activation Email';

        $data = array(
            'result' => $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'"),
            'template' => $this->db->query("SELECT * FROM ost_company_test"),
        );

        $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
        $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_id='$default_email'")->row();

        $config = array(
            
            'smtp_user' => $sender_email->userid,
            'smtp_pass' => $sender_email->userpass,
            'smtp_host' => $sender_email->smtp_host,
            'smtp_port' => $sender_email->smtp_port,
                            
        );
        $bodyContent = $this->load->view('activateemail', $data, TRUE);
        
        $result = $this->email
            ->initialize($config)
            ->from($sender_email->userid)
            ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
            ->to($user_email)
            ->subject($subject)
            ->message($bodyContent)
            ->send();

/*        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;*/
        echo "<script> alert('Account activation link had sent to your registered email.');</script>";
        echo "<script>
                document.location='" . base_url() . "/index.php/welcome/index'
              </script>";



    }

    public function activateuser()
    {
        $user_id = $_REQUEST['id'];
        $this->db->query("UPDATE ost_user_test SET status = '1', active = '1', user_updated_at = now() WHERE user_id = $user_id ");
        echo "<script> alert('Your account had been activate.');</script>";
        echo "<script>
                document.location='" . base_url() . "/index.php/user_controller/login'
              </script>";

    }

    public function activateuserguest()
    {
        $user_id = $_REQUEST['id'];
        $data = array(
            'result' => $this->db->query("SELECT * FROM ost_user_test WHERE user_id = '$user_id'")        
        );

                $this->load->view('user/guestuseractivate', $data); 

    }

    public function activateuserguestconfirm()
    {
        
        $cemail = $this->input->post('cemail');
        $cname = $this->input->post('cname');
        $cphone = $this->input->post('cphone');
        $cphoneext = $this->input->post('cphoneext');
        $newpass1 = $this->input->post('passwd1');
        $newpass2 = $this->input->post('passwd2');
        $user_id = $_REQUEST['id'];

        if($newpass1 == $newpass2){
            $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name = '$cname', user_pas = '$newpass2', user_phone = '$cphone', user_phoneext = '$cphoneext',status = '1', active = '1', user_updated_at = now() WHERE user_id = '$user_id'");
        
            echo "<script> alert('Succesfully activate account');</script>";
            echo "<script>
            document.location='" . base_url() . "/index.php/user_controller/login'
            </script>";
        }

        else{
            echo "<script> alert('Different New Password');</script>"; 
            return false;   
        }
    }

    public function edit()
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
                $this->load->view('user/edit');
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
            $user_id = $_SESSION["userid"];

            $usernamecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_name = '$cname' ")->num_rows();

            $useremailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_email = '$cemail' ")->num_rows();

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

                $result  = $this->User_model->checkpass($user_id, $userpass);
                if($result > 0)
                {
                    if($newpass1 == $newpass2){
                        $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name = '$cname', user_phone = '$cphone', user_phoneext = '$cphoneext', user_updated_at = now() WHERE user_id = '$user_id'");

                        if ($newpass2 != '')
                            $this->db->query("UPDATE ost_user_test SET user_pas = '$newpass2' WHERE user_id = '$user_id'");

                        $splitemail = explode('@', $cemail);
                        $domain = '@'.$splitemail[1];
                        $org = $this->db->query("SELECT * FROM ost_organization_test");
                        $user_orgid = $this->db->query("SELECT * FROM ost_user_test AS a
                            LEFT JOIN ost_organization_test AS b ON a.user_org_id = b.id
                            WHERE user_id = '$user_id'")->row('id');

                        foreach ($org->result() as $orgdomain)
                        {
                            if ($orgdomain->id != $user_orgid && $orgdomain->domain == $domain)
                            {
                                $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");

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
                    
                    $this->db->query("UPDATE ost_user_test SET user_email = '$cemail' , user_name ='$cname', user_phone = '$cphone', user_phoneext ='$cphoneext', user_updated_at = now() WHERE user_id='$user_id'");
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
            $username1 = $this->input->post('luser');
            $userpass = $this->input->post('lpasswd');
            $username = $this->db->query("SELECT user_name FROM osticket.ost_user_test WHERE user_name = '$username1' OR user_email = '$username1'")->row('user_name');
            $userid = $this->db->query("SELECT user_id FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_id');
            $userdep =  $this->db->query("SELECT user_depart FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_depart');
            $userdepname = $this->db->query("SELECT name FROM osticket.ost_department_test WHERE id = '$userdep'")->row('name');
            $useremail = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_email');
            $phone = $this->db->query("SELECT user_phone FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phone');
            $phoneext = $this->db->query("SELECT user_phoneext FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_phoneext');

                $result  = $this->User_model->login_data($username, $userpass);
                if($result > 0)
                {
                    if(isset($_SESSION['loginsecond2']))
                    {
                        unset($_SESSION['loginsecond2']);
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
            $username1 = $this->input->post('userid');
            $userpass = $this->input->post('passwd');
            $username = $this->db->query("SELECT username FROM osticket.ost_staff_test WHERE username = '$username1' OR email = '$username1'")->row('username');
            $staffid = $this->db->query("SELECT staff_id FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('staff_id');
            $pw_expire = $this->db->query("SELECT passwdreset FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('passwdreset');
            
/*            $userdep =  $this->db->query("SELECT user_depart FROM osticket.ost_user_test WHERE user_name = '$username' AND passwd = '$userpass'")->row('user_depart');
            $userdepname = $this->db->query("SELECT name FROM osticket.ost_department_test WHERE id = '$userdep'")->row('name');*/
            $staffemail = $this->db->query("SELECT email FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('email');
            $staffdept = $this->db->query("SELECT dept_id FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('dept_id');
            $change_passwd = $this->db->query("SELECT change_passwd FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('change_passwd');
            $auto_refresh_rate = $this->db->query("SELECT auto_refresh_rate FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('auto_refresh_rate');
            $default_signature_type = $this->db->query("SELECT default_signature_type FROM osticket.ost_staff_test WHERE username = '$username' AND passwd = '$userpass'")->row('default_signature_type');




                $result  = $this->User_model->super_login_data($username, $userpass);

                if($result > 0)
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
                        'staffid' => $staffid,
                        /*'userdepname' => $userdepname,*/
                        'staffemail' =>  $staffemail,
                        'staffdept' => $staffdept ,
                        'auto_refresh_rate' => $auto_refresh_rate,
                        'default_signature_type' => $default_signature_type,
                        'loginstaff' => TRUE,
                        'LAST_ACTIVITY' => $_SERVER['REQUEST_TIME'],
                             
                    );              
                    $this->session->set_userdata($sessiondata);


                    if($pw_expire != null && $pw_expire<date('Y-m-d')){

                        echo "<script> alert('Password already expired, Please change password to continue log in.');</script>";
                        $this->load->view('user/reset_forgot_pw', $sessiondata);
                    }
                    else
                    {
                    if ($_SESSION['change_passwd'] != 0 ) {
                        
                        $this->load->view('user/reset_forgot_pw', $sessiondata);

                    } else{

                    redirect("staff_ticket_controller/main?title=Open&direct=open", $sessiondata);
                    echo "<script> alert('succesfully loged in');</script>";     

                    }
                  }  
                }
                else
                {
                    if(isset($_SESSION['loginsecond'])){
                        $_SESSION['loginsecond'] +=1;
                    }
                    else
                    {
                        $_SESSION['loginsecond'] ='1';
                    }
                    $staff_max_login = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='14'")->row('value');
                    $staff_login_timeout = $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='15'")->row('value');

                    if($_SESSION['loginsecond']%$staff_max_login == 0){
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

    public function forgot_pw()
    {
        $email = $this->input->post('useremail');
        
        if(!isset($email)){

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

                if($useremail->num_rows() < 1 && $username->num_rows() < 1){
                     
                    echo "<script> alert('Incorrect username or email');</script>"; 
                    $browser_id = $_SERVER["HTTP_USER_AGENT"];
                    if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                    {

                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/index',$data);
                    
                    }
                else
                    {
                        echo $this->load->view('user/pwreset','',TRUE);
                        die();
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
                $this->db->query("UPDATE osticket.ost_staff_test SET token='$token',token_expire='$expiretime' WHERE email='$email'");

                    $data = array(
                        'result' => $this->db->query("SELECT * FROM ost_staff_test WHERE email = '$email'"),
                        'template' => $this->db->query("SELECT * FROM ost_company_test"),
                        'token' => $token,
                    );

                $subject = 'Panda Ticketing System Agent Reset Password';
                $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
                $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_id='$default_email'")->row();

                $config = array(
                    
                    'smtp_user' => $sender_email->userid,
                    'smtp_pass' => $sender_email->userpass,
                    'smtp_host' => $sender_email->smtp_host,
                    'smtp_port' => $sender_email->smtp_port,
                                    
                );
                
                $bodyContent = $this->load->view('resetforgotpw', $data, TRUE);
                $result = $this->email
                    ->initialize($config)
                    ->from($sender_email->userid)
                    ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
                    ->to($email)
                    ->subject($subject)
                    ->message($bodyContent)
                    ->send();

                $data = array(
                    'offline' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '12'"),
                    'allow_pw_reset' => $this->db->query("SELECT value FROM osticket.ost_config_test WHERE id = '106'")->row('value'),
                    'block_period' => '',
                );

             
                $browser_id = $_SERVER["HTTP_USER_AGENT"];
                if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
                    {

                        $this->load->view('WinCe/header');
                        $this->load->view('WinCe/index',$data);
                    
                    }   
                    
                else
                    {
                        unset($_SESSION['loginsecond']);
                        echo "<script> alert('Password reset email has been sent,please check your email.');</script>";
                       /* $this->load->view('header');*/
                        $this->load->view('user/superlogin', $data);
                        /*$this->load->view('footer');*/
                    }



            }
            

        }

    public function resetforgotpassword()
    {
       

        $user_id = $this->input->post('id');
        $old_pw = $this->input->post('old_pw');
        $newpw = $this->input->post('new_pw');
        $newpw2 = $this->input->post('confirm');
        $passwdreset = $this->db->query("SELECT value FROM ost_config_test WHERE id = '17'")->row('value');
        $getDate = date('Y-m-d');
        $getDate = strtotime(date("Y-m-d", strtotime($getDate)) . " +".$passwdreset." months");
        $expiry_date = date('Y-m-d',$getDate);
        $user_token_pw = $this->db->query("SELECT token FROM ost_staff_test WHERE staff_id = '$user_id' ")->row('token');
        $token_expire = $this->db->query("SELECT token_expire FROM ost_staff_test WHERE staff_id='$user_id' ")->row('token_expire');

        $curtime=date("Y-m-d H:i:s");
        if($user_token_pw != null && $token_expire != null)
        {   
            if($curtime>$token_expire)
            {
                 echo "<script> alert('Temporary Password has expired! Please send another temporary password to reset your password.');</script>";
                echo "<script>
                document.location='" . base_url() . "/index.php/user/pwreset'
                </script>";
            }
            else if($newpw == $newpw2 && $old_pw == $user_token_pw)
            {
                $this->db->query("UPDATE ost_staff_test SET change_passwd = '0', passwd = '$newpw2' , updated = NOW(),passwdreset='$expiry_date' WHERE staff_id = '$user_id'");

                $this->db->query("UPDATE ost_staff_test SET token = null, token_expire = null WHERE staff_id = '$user_id'");
            
                echo "<script> alert('Succesfully update password');</script>";
                echo "<script>
                document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open&direct=open'
                </script>";
            }
            else
            {
                echo "<script> alert('Wrong original password or different new password');</script>"; 
                echo "<script>
                document.location='" . base_url() . "index.php/user_controller/reset_forgot_pw?id=".$user_id."'
                </script>";  
            }
        }
        else
        {
            $stafforipasswd = $this->db->query("SELECT passwd FROM ost_staff_test WHERE staff_id = '$user_id' ")->row('passwd');
            if($newpw == $newpw2 && $old_pw == $stafforipasswd)
            {
            $this->db->query("UPDATE ost_staff_test SET change_passwd = '0', passwd = '$newpw2' , updated = NOW(),passwdreset='$expiry_date' WHERE staff_id = '$user_id'");
        
            echo "<script> alert('Succesfully change password');</script>";
           echo "<script>
                document.location='" . base_url() . "/index.php/staff_ticket_controller/main?title=Open&direct=open'
                </script>";
            }
            else
            {
            echo "<script> alert('Wrong original password or different new password');</script>"; 
            echo "<script>
            document.location='" . base_url() . "/index.php/user_controller/reset_forgot_pw?id=".$user_id."'
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

     public function allow_auth()
    {
        // session_unset();
        // session_destroy();
        // session_start();

        $id = $_REQUEST['id'];

        $getuser = $this->db->query("SELECT a.user_name, a.user_pas FROM ost_user_test a INNER JOIN ost_ticket_test b ON a.user_id = b.user_id WHERE b.ticket_id = '667'");
        $username = $getuser->row('user_name');
        $userpass = $getuser->row('user_pas');
        $userid = $this->db->query("SELECT user_id FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_id');
        $userdep =  $this->db->query("SELECT user_depart FROM osticket.ost_user_test WHERE user_name = '$username' AND user_pas = '$userpass'")->row('user_depart');
        $userdepname = $this->db->query("SELECT name FROM osticket.ost_department_test WHERE id = '$userdep'")->row('name');
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