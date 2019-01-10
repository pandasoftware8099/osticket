<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_user_controller extends CI_Controller {
    
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
        $this->load->library('form_validation');
    }

    public function main()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

            $staffid = $_SESSION["staffid"];    
            $data = array(
                'result' => $this->db->query("SELECT * FROM  ost_user_test 
                    LEFT JOIN ost_user_status_test ON ost_user_test.status = ost_user_status_test.user_status_id"), 

                'adduserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.create%'")->num_rows(),

                'edituserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.edit%'")->num_rows(),

                'deleteallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.delete%'")->num_rows(),

                'activeallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.manage%'")->num_rows(),

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
                $this->load->view('staff/staff_user',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/login');
        }

    }

    public function createuser()
    {
        $direct = $_REQUEST['direct'];
        $poster_id = $_SESSION['staffid'];
        $user_email = addslashes($this->input->post('email'));
        $user_name = addslashes($this->input->post('fullname'));
        $user_phone = addslashes($this->input->post('phone'));
        $user_phoneext = addslashes($this->input->post('phoneext'));
        $user_note = addslashes($this->input->post('note'));

        $splitemail = explode('@', $user_email);
        $domain = '@'.$splitemail[1];
        $org = $this->db->query("SELECT * FROM ost_organization_test");

        $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' OR user_email = '$user_email' ");
        $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email' ");
        $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' ");

        if($usercheck->num_rows() == 0)
        {
            $sql = $this->db->query("INSERT INTO ost_user_test ( user_name , user_created_at, user_updated_at, user_depart, user_email, user_phone, user_phoneext, notes, status ,active)
            VALUES ( '$user_name', now(), now(), '1', '$user_email', '$user_phone', '$user_phoneext' ,'$user_note', '4' , '0')");

            $user_id = $this->db->query("SELECT user_id FROM ost_user_test WHERE user_name = '$user_name'")->row('user_id');

            if ($user_note != "")
                $this->db->query("UPDATE ost_user_test SET usernote_poster = '$poster_id', usernote_created = now() WHERE user_id = $user_id ");

            foreach ($org->result() as $orgdomain)
            {
                if ($orgdomain->domain == $domain)
                    $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");
            }

            $ticketid = $_REQUEST['id'];

            if ($direct == 'tinfo')
            {
                $ticketinfo = $this->db->query("SELECT assigned_to, ticket_updated, ticket_updated_by_id, ticket_updated_by_role FROM ost_ticket_test WHERE ticket_id = '$ticketid'");
                $autolock_minutes = $this->db->query("SELECT value FROM ost_config_test WHERE id = '23'");
                $autolock_time = date("Y-m-d H:i:s", strtotime("+{$autolock_minutes->row('value')} minutes", strtotime($ticketinfo->row('ticket_updated'))));

                if ($ticketinfo->row('assigned_to') == $poster_id || date('Y-m-d H:i:s') > $autolock_time || $ticketinfo->row('ticket_updated_by_id') == $poster_id || $ticketinfo->row('ticket_updated_by_role') == 'user')
                {
                    $this->db->query("UPDATE ost_ticket_test SET user_id = '$user_id', ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE ticket_id = '$ticketid'");
                }

                else
                {
                    echo "<script> alert('Ticket has been locked for {$autolock_minutes->row('value')} minute(s) due to recent modifying from another agent.');</script>";
                }

                echo "<script> document.location='" . base_url() . "/index.php/staff_ticket_controller/ticketinfo?id=$ticketid' </script>";
            }
            else if ($direct == 'tinfoedit')
            {
                redirect('staff_ticket_controller/ticketinfoedit?id='.$ticketid.'&uid='.$user_id);
            }
            else if ($direct == 'user')
            {
                redirect('staff_user_controller/user_info?id='.$user_id);
            }
        }

        else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
        {
            echo "<script> alert('User already exists');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
        }

        else if ($emailcheck->num_rows() !== 0)
        {
            echo "<script> alert('Email duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
        }

        else if ($namecheck->num_rows() !== 0)
        {
            echo "<script> alert('Name duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
        }
    }

    public function importcopy()
    {   
        $direct = $_REQUEST['direct'];

        // user page import
        if ($direct == 'user') {

            $pasted = explode("\n", $_POST["pasted"]);

            foreach($pasted as $line) {
                $total = count(explode(",", $line));

                if($total == 3)
                {
                    list($FIELD1, $FIELD2, $FIELD3 ) = explode(",", $line);
                    $username = TRIM($FIELD1);
                    $useremail = TRIM($FIELD2);
                    $userphone = TRIM($FIELD3);
                }
                elseif($total == 2)
                {
                    list($FIELD1, $FIELD2) = explode(",", $line);
                    $username = TRIM($FIELD1);
                    $useremail = TRIM($FIELD2);
                    $userphone = '';                  
                }                
                else
                {   
                    echo "<script> alert('Import failed. Please insert the requirement fields (Username and User Email).');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                }

                $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' OR user_email = '$useremail' ");
                $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$useremail' ");
                $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' ");
                
                if ($usercheck->num_rows() == 0)
                {
                    $this->db->query("INSERT INTO ost_user_test (user_org_id , user_name, user_email, user_phone, user_created_at, user_updated_at, status, active ) VALUES ('0', '$username', '$useremail', '$userphone', now(), now(), '4', '0' )");

                    $splitemail = explode('@', $useremail);
                    $domain = '@'.$splitemail[1];
                    $org = $this->db->query("SELECT * FROM ost_organization_test");
                    $user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username'")->row('user_id');

                    foreach ($org->result() as $orgdomain)
                    {
                        if ($orgdomain->domain == $domain)
                            $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");
                    }

                    echo "<script> alert('Import Successfully');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                }
                else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
                {
                    echo "<script> alert('Users already exist');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                }
                else if ($emailcheck->num_rows() !== 0)
                {
                    echo "<script> alert('Email duplicated');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                }
                else if ($namecheck->num_rows() !== 0)
                {
                    echo "<script> alert('Name duplicated');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                }
            }
        }

        // org page import
        elseif ($direct == "org") {
            $pasted = explode("\n", $_POST["pasted"]);
            $org_id = $_REQUEST['id'];

            foreach($pasted as $line) {
                $total = count(explode(",", $line));

                if($total == 3)
                {
                    list($FIELD1, $FIELD2, $FIELD3 ) = explode(",", $line);
                    $username = TRIM($FIELD1);
                    $useremail = TRIM($FIELD2);
                    $userphone = TRIM($FIELD3);
                }
                elseif($total == 2)
                {
                    list($FIELD1, $FIELD2) = explode(",", $line);
                    $username = TRIM($FIELD1);
                    $useremail = TRIM($FIELD2);
                    $userphone = '';                  
                }                
                else
                {   
                    echo "<script> alert('Import failed. Please insert the requirement fields (Username and User Email).');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                }

                $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' OR user_email = '$useremail' ");
                $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$useremail' ");
                $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' ");

                if ($usercheck->num_rows() == 0)
                {
                    $splitemail = explode('@', $useremail);
                    $domain = '@'.$splitemail[1];
                    $org = $this->db->query("SELECT * FROM ost_organization_test");
                    $user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username'")->row('user_id');

                    foreach ($org->result() as $orgdomain)
                    {
                        if ($orgdomain->id != $org_id && $orgdomain->domain == $domain)
                        {
                            echo "<script> alert('Users email domain have been set as default domain for organization $orgdomain->name. Kindly change the setting in organization page if you want to add users to another organization.');</script>";
                            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";die;
                        }
                    }
                  
                    $this->db->query("INSERT INTO ost_user_test (user_org_id, user_name, user_email, user_phone, user_created_at, user_updated_at, status, active ) VALUES ($org_id , '$username', '$useremail', '$userphone', now(), now(), '4', '0' )");

                    echo "<script> alert('Import Successfully');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                }
                else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
                {
                    echo "<script> alert('Users already exist');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                }
                else if ($emailcheck->num_rows() !== 0)
                {
                    echo "<script> alert('Email duplicated');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                }
                else if ($namecheck->num_rows() !== 0)
                {
                    echo "<script> alert('Name duplicated');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                }
            }
        }
    }

    public function importcsv()
    {
        $direct = $_REQUEST['direct'];
        // user page import
        if ($direct == 'user')
        {
            if(isset($_POST["submit_file"]))
            {
                $file = $_FILES["file"]["tmp_name"];
                $file_open = fopen($file,"r");
                fgetcsv($file_open, 1000, ",");  // pop the headers
                while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
                {
                    $username = $csv[0];
                    $email = $csv[1];
                    $phone = $csv[2];

                    $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' OR user_email = '$email' ");
                    $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$email' ");
                    $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' ");

                    if ($usercheck->num_rows() == 0)
                    {
                        $this->db->query("INSERT INTO ost_user_test (user_org_id , user_name, user_email, user_phone, user_created_at, user_updated_at, status, active) VALUES ('0', '$username','$email','$phone', now(), now(), '4', '0')");

                        $splitemail = explode('@', $email);
                        $domain = '@'.$splitemail[1];
                        $org = $this->db->query("SELECT * FROM ost_organization_test");
                        $user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username'")->row('user_id');

                        foreach ($org->result() as $orgdomain)
                        {
                            if ($orgdomain->domain == $domain)
                                $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");
                        }

                        echo "<script> alert('Import Successfully');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                    }
                    else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Users already exist');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                    }
                    else if ($emailcheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Email duplicated');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                    }
                    else if ($namecheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Name duplicated');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
                    }
                }
            }
        }
        // ORG page import
        elseif ($direct == 'org')
        {
            if(isset($_POST["submit_file"]))
            {
                $org_id = $_REQUEST['id'];
                $file = $_FILES["file"]["tmp_name"];
                $file_open = fopen($file,"r");
                fgetcsv($file_open, 1000, ",");  // pop the headers

                while(($csv = fgetcsv($file_open, 1000, ",")) !== false)
                {
                    $username = $csv[0];
                    $email = $csv[1];
                    $phone = $csv[2];

                    $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' OR user_email = '$email' ");
                    $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$email' ");
                    $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username' ");

                    if ($usercheck->num_rows() == 0)
                    {
                        $splitemail = explode('@', $email);
                        $domain = '@'.$splitemail[1];
                        $org = $this->db->query("SELECT * FROM ost_organization_test");
                        $user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$username'")->row('user_id');

                        foreach ($org->result() as $orgdomain)
                        {
                            if ($orgdomain->id != $org_id && $orgdomain->domain == $domain)
                            {
                                echo "<script> alert('Users email domain have been set as default domain for organization $orgdomain->name. Kindly change the setting in organization page if you want to add users to another organization.');</script>";
                                echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";die;
                            }
                        }

                        $this->db->query("INSERT INTO ost_user_test (user_org_id , user_name, user_email, user_phone, user_created_at, user_updated_at, status, active) VALUES ('$org_id' , '$username', '$email', '$phone', now(), now(), '4' , '0')");

                        echo "<script> alert('Import Successfully');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                    }
                    else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Users already exist');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                    }
                    else if ($emailcheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Email duplicated');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                    }
                    else if ($namecheck->num_rows() !== 0)
                    {
                        echo "<script> alert('Name duplicated');</script>";
                        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
                    }
                }
            }
        }
    }

    public function more()
    {

        $moreoption = addslashes($this->input->post('moreoption'));
        $check = $this->input->post('tids[]');
        $deleteticket = $this->input->post('deletetickets');


        foreach ($check as $value) {


            $checkstatus = $this->db->query("SELECT status FROM osticket.ost_user_test WHERE user_id = '$value'")->row('status');
            $checkactive = $this->db->query("SELECT active FROM osticket.ost_user_test WHERE user_id = '$value'")->row('active');
            $user_email = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_id = '$value'")->row('user_email');
            $user_name = $this->db->query("SELECT user_name FROM osticket.ost_user_test WHERE user_id = '$value'")->row('user_name');


            if($moreoption == 1)
            {    
                if ($checkstatus == '4' || $checkstatus == '3'){

                    $this->db->query("UPDATE osticket.ost_user_test SET 
                        status = '3' , 
                        user_updated_at = NOW() WHERE user_id = '$value'");

                    $this->load->library('email');

                    $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
                    $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'");

                    $data = array(
                        'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                            REPLACE(REPLACE(body, '%user_name%', '".$result->row('user_name')."'), '%user_id%', '".$result->row('user_id')."') AS email FROM ost_content_test WHERE type = 'registration-client'"),
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

                    $bodyContent = $this->load->view('email_template', $data, TRUE);
      
                    $result = $this->email
                        ->initialize($config)
                        ->from($sender_email->userid)
                        ->reply_to($sender_email->userid)     // Optional, an account where a human being reads.
                        ->to($user_email)
                        ->subject($data['body']->row('subject'))
                        ->message($bodyContent)
                        ->send();

            /*        var_dump($result);
                    echo '<br />';
                    echo $this->email->print_debugger();

                    exit;*/
                    echo "<script> alert('Account activation link had sent to $user_name, registered email is $user_email');</script>";
                    
                
                }

                else if ($checkstatus != '4') {

                    echo "<script> alert('$user_name Already Registered');</script>";

                }
            }

            else if ($moreoption == 2)
            {
                if ($checkstatus == '4'){

                    echo "<script> alert('$user_name Not yet Registered');</script>";
                
                }

                else if ($checkstatus != '4') {
                    
                    $this->db->query("UPDATE osticket.ost_user_test SET status = '2',user_updated_at =NOW() WHERE user_id = '$value'");

                     echo "<script> alert('$user_name Locked');</script>";

                }
            }

            else if ($moreoption == 3)
            {
                if ($checkstatus == '4'){

                    echo "<script> alert('$user_name Not yet Registered'); </script>";
                
                }

                else if ($checkstatus == '2') {

                    if ($checkactive == '1') {

                        $this->db->query("UPDATE osticket.ost_user_test SET status = '1', user_updated_at =NOW() WHERE user_id = '$value'");

                        echo "<script> alert('$user_name Unlocked'); </script>";

                    }

                    else if ($checkactive == '0') {
                    
                        $this->db->query("UPDATE osticket.ost_user_test SET status = '3' ,user_updated_at =NOW() WHERE user_id = '$value'");
                        echo "<script> alert('$user_name Unlocked'); </script>";

                    }
                }

                else {

                    if ($checkactive == '1') {

                 

                        echo "<script> alert('$user_name previouly had unlocked'); </script>";

                    }

                    else if ($checkactive == '0') {
                    
                        
                        echo "<script> alert('$user_name previously had unlocked'); </script>";

                    }
                }
            }

            else if ($moreoption == 4 && $deleteticket == 1)
            {

                $this->db->query("DELETE FROM osticket.ost_user_test WHERE user_id = '$value'");
                $this->db->query("DELETE FROM osticket.ost_ticket_test WHERE user_id = '$value'");

            }

            else if ($moreoption == 4 && $deleteticket != 1)
            {

                $this->db->query("DELETE FROM osticket.ost_user_test WHERE user_id = '$value'");
                
            }

            else if ($moreoption == 0)
            {   

                    if ($checkactive == '1') {

                        $this->load->library('email');

                        $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
                        $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'")->row('user_name');

                        $data = array(
                            'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                                REPLACE(body, '%user_name%', '$result') AS email FROM ost_content_test WHERE type = 'pwreset-client'"),
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

                        $bodyContent = $this->load->view('email_template', $data, TRUE);

                        $result = $this->email
                            ->initialize($config)
                            ->from($sender_email->userid)
                            ->reply_to($sender_email->userid)     // Optional, an account where a human being reads.
                            ->to($user_email)
                            ->subject($data['body']->row('subject'))
                            ->message($bodyContent)
                            ->send();

                        /*var_dump($result);
                        echo '<br />';
                        echo $this->email->print_debugger();

                        exit;*/

                        echo "<script> alert('Reset password request had sent to $user_name, registered email is $user_email');</script>";

                    }

                    else if ($checkactive == '0') {
                    
                        echo "<script> alert('$user_name no yet register.');</script>";

                    }

                
                
            }

        }
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
    }

    public function moreorg()
    {

        $moreoption = addslashes($this->input->post('moreoption'));
        $check = $this->input->post('tids[]');

        foreach ($check as $value) {
            if ($moreoption == 4)
            {
                $this->db->query("DELETE FROM osticket.ost_organization_test WHERE id = '$value'");
                $this->db->query("UPDATE osticket.ost_user_test SET user_org_id = '0', user_updated_at = now() WHERE user_org_id = '$value'");
            }

        }
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/organization' </script>";
    }

    public function user_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $user_id = $_REQUEST['id'];
            $staffid = $_SESSION["staffid"];
            
            $org_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_id = $user_id")->row('user_org_id');
            if ($org_id != "")
            {
                $orgphone = $this->db->query("SELECT * FROM ost_organization__cdata_test WHERE org_id = $org_id")->row('phone');
                $splitarr = explode('X', $orgphone);

                if (count($splitarr) == "2")
                {
                    $phone = $splitarr[0];
                    $phoneext = $splitarr[1];
                }
                else
                {
                    $phone = "";
                    $phoneext = "";
                }
            }
            else
            {
                $phone = "";
                $phoneext = "";
            }

            $data = array(
                'organization' => $this->db->query("SELECT * FROM ost_organization_test 
                    INNER JOIN ost_user_test ON ost_user_test.user_org_id = ost_organization_test.id
                    INNER JOIN ost_organization__cdata_test ON ost_organization__cdata_test.org_id = ost_organization_test.id
                    WHERE user_id = '$user_id'"),
                'inforesult' => $this->db->query("SELECT * FROM ost_user_test
                    INNER JOIN ost_user_status_test ON ost_user_test.status = ost_user_status_test.user_status_id
                    WHERE user_id = $user_id"),
                'inforesultcheckbox' => $this->db->query("SELECT a.*, b.*, c.*, a.notes AS usernote, c.notes AS staffnote FROM ost_user_test AS a
                    INNER JOIN ost_user_status_test AS b ON a.status = b.user_status_id
                    LEFT JOIN ost_staff_test AS c ON a.usernote_poster = c.staff_id
                    WHERE a.user_id = $user_id")->row(),
                'ticketinfo' => $this->db->query("SELECT * FROM ost_ticket_test AS a
                    INNER JOIN ost_ticket_status_test AS b ON a.status_id = b.id
                    INNER JOIN ost_help_topic_test AS c ON a.topic_id = c.topic_id
                    WHERE a.user_id = $user_id"),
                'phone' => $phone,
                'phoneext' => $phoneext,
                'edituserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.edit%'")->num_rows(),
                'deleteallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.delete%'")->num_rows(),
                'activeallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.manage%'")->num_rows(),
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
                    $this->load->view('staff/staff_user_info', $data);
                    /*$this->load->view('footer');*/
                }    
            }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    

    public function user_info_register()

    {

        $sendemail = $this->input->post('sendemail');
        $user_id = $_REQUEST['id'];
        $user_email = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_id = '$user_id'")->row('user_email');

            if ($sendemail == 1)
            {
                $this->load->library('email');

                $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
                $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'");

                $data = array(
                    'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                        REPLACE(REPLACE(body, '%user_name%', '".$result->row('user_name')."'), '%user_id%', '".$result->row('user_id')."') AS email FROM ost_content_test WHERE type = 'registration-client'"),
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

                $bodyContent = $this->load->view('email_template', $data, TRUE);

                $result = $this->email
                    ->initialize($config)
                    ->from($sender_email->userid) 
                    ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
                    ->to($user_email)
                    ->subject($data['body']->row('subject'))
                    ->message($bodyContent)
                    ->send();

                /*var_dump($result);
                echo '<br />';
                echo $this->email->print_debugger();

                exit;*/
                echo "<script> alert('Account activation link had sent.');</script>";

            }

            else if ($sendemail != 1)
            {
                $passwd1 = $this->input->post('passwd1');
                $passwd2 = $this->input->post('passwd2');
                $pwreset = $this->input->post('pwreset-flag');
                $changepass = $this->input->post('forbid-pwreset-flag');


                if ($passwd1 == "" || $passwd2 == "")
                    echo "<script> alert('Do no leave blank password');</script>";

                else if ($passwd1 == $passwd2) {
                    $this->db->query("UPDATE ost_user_test SET user_pas = '$passwd2', status = '1', active = '1', resetpass = '$pwreset', changepass = '$changepass', user_updated_at = NOW() WHERE user_id = '$user_id'");
                    echo "<script> alert('Successfully Register');</script>";
                }

                else if ($passwd1 != $passwd2)
                    echo "<script> alert('Confirm Password Wrong');</script>";
            }

        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";
    }

    public function user_infoupdate()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $user_id = $_REQUEST['id'];
            $direct = $_REQUEST['direct'];
            $poster_id = $_SESSION['staffid'];
            $cemail = addslashes($this->input->post('cemail'));
            $cusername = addslashes($this->input->post('cusername'));
            $cphone = addslashes($this->input->post('cphone'));
            $cphoneext = addslashes($this->input->post('cphoneext'));
            $cnote = addslashes($this->input->post('cnote'));
            $cpass1 = addslashes($this->input->post('passwd1'));
            $cpass2 = addslashes($this->input->post('passwd2'));
            $adminlock = addslashes($this->input->post('locked-flag'));
            $resetpass = addslashes($this->input->post('pwreset-flag'));
            $changepass = addslashes($this->input->post('forbid-pwchange-flag'));

            $usernamecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_name = '$cusername' ")->num_rows();

            $useremailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_id != '$user_id' AND user_email = '$cemail' ")->num_rows();

            $splitemail = explode('@', $cemail);
            $domain = '@'.$splitemail[1];
            $org = $this->db->query("SELECT * FROM ost_organization_test");
            $user_orgid = $this->db->query("SELECT * FROM ost_user_test AS a
                LEFT JOIN ost_organization_test AS b ON a.user_org_id = b.id
                WHERE user_id = '$user_id'")->row('id');

            if ($cpass1 != $cpass2)
                echo "<script> alert('Confirm Password Wrong');</script>";

            else if ($usernamecheck != '0' && $useremailcheck != '0')
                echo "<script> alert('Name and email duplicated');</script>";

            else if ($usernamecheck != '0')
                echo "<script> alert('Name duplicated');</script>";

            else if ($useremailcheck != '0')
                echo "<script> alert('Email duplicated');</script>";

            else
            {
                $this->db->query("UPDATE ost_user_test SET 
                    user_name = '$cusername', 
                    user_email = '$cemail' , 
                    user_phone = '$cphone', 
                    user_phoneext = '$cphoneext' ,
                    notes = '$cnote',
                    user_updated_at = NOW()
                    WHERE user_id = $user_id ");

                foreach ($org->result() as $orgdomain)
                {
                    if ($orgdomain->id != $user_orgid && $orgdomain->domain == $domain)
                    {
                        $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");

                        echo "<script> alert('User has been auto add into organization $orgdomain->name due to email domain setting in organization page.');</script>";
                    }
                }

                if ($cnote != "")
                    $this->db->query("UPDATE ost_user_test SET usernote_poster = '$poster_id', usernote_created = now() , user_updated_at = NOW() WHERE user_id = $user_id ");
                else
                    $this->db->query("UPDATE ost_user_test SET usernote_poster = '0', usernote_created = NULL, user_updated_at = NOW() WHERE user_id = $user_id ");

                if ($direct == 'manageuser')
                {
                    $this->db->query("UPDATE ost_user_test SET
                        resetpass = '$resetpass',
                        changepass = '$changepass'
                        WHERE user_id = $user_id ");

                    if ($cpass1 == "" && $adminlock == "2")
                        $this->db->query("UPDATE ost_user_test SET status = '$adminlock' ,user_updated_at = NOW() WHERE user_id = $user_id ");
                    else if ($cpass1 == "" && $adminlock == "")
                        $this->db->query("UPDATE ost_user_test SET status = '1' , user_updated_at = NOW() WHERE user_id =$user_id ");
                    else if ($cpass1 != "" && $adminlock == "2")
                        $this->db->query("UPDATE ost_user_test SET user_pas = '$cpass2', status = '$adminlock' , user_updated_at = NOW() WHERE user_id = $user_id "); 
                    else if ($cpass1 != "" && $adminlock == "")
                        $this->db->query("UPDATE ost_user_test SET user_pas = '$cpass2', status = '1', user_updated_at = NOW() WHERE user_id = $user_id ");
                }

                echo "<script> alert('Edit Profile Successfully');</script>";
            }

            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";
        }
        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function user_infodelete()

    {

        $deleteticket = $this->input->post('deleteticket');
        $user_id = $_REQUEST['id'];

            if ($deleteticket == 1)
            {

                $this->db->query("DELETE FROM osticket.ost_user_test WHERE user_id = '$user_id'");
                $this->db->query("DELETE FROM osticket.ost_ticket_test WHERE user_id = '$user_id'");

            }

            else if ($deleteticket != 1)
            {

                $this->db->query("DELETE FROM osticket.ost_user_test WHERE user_id = '$user_id'");
                
            }

        
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
    

    }

    public function user_info_resetpass()
    {
        $user_id = $_REQUEST['id'];
        $user_email = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_id = '$user_id'")->row('user_email');

        $this->load->library('email');
        $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
        $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'")->row('user_name');

        $data = array(
            'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                REPLACE(body, '%user_name%', '$result') AS email FROM ost_content_test WHERE type = 'pwreset-client'"),
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
        
        $bodyContent = $this->load->view('email_template', $data, TRUE);

        $result = $this->email
            ->initialize($config)
            ->from($sender_email->userid)
            ->reply_to($sender_email->userid)   // Optional, an account where a human being reads.
            ->to($user_email)
            ->subject($data['body']->row('subject'))
            ->message($bodyContent)
            ->send();

/*        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;*/
        echo "<script> alert('Reset password request sent.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";

    }

    public function user_info_activationemail()
    {
        $user_id = $_REQUEST['id'];
        $user_email = $this->db->query("SELECT user_email FROM osticket.ost_user_test WHERE user_id = '$user_id'")->row('user_email');

        $this->load->library('email');

        $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
        $result = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'");

        $data = array(
            'body' => $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject,
                REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$result->row('user_name')."'), 'activateuserguest', 'activateuser'), '%user_id%', '".$result->row('user_id')."') AS email FROM ost_content_test WHERE type = 'registration-client'"),
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

        $bodyContent = $this->load->view('email_template', $data, TRUE);

        $result = $this->email
            ->initialize($config)
            ->from($sender_email->userid)
            ->reply_to($sender_email->userid)    // Optional, an account where a human being reads.
            ->to($user_email)
            ->subject($data['body']->row('subject'))
            ->message($bodyContent)
            ->send();

/*        var_dump($result);
        echo '<br />';
        echo $this->email->print_debugger();

        exit;*/
        echo "<script> alert('Account activation link had sent to your registered email.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";

    }

    public function user_orgupdate()
    {
        $user_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];
        $org_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_id = $user_id")->row('user_org_id');
        $org_name = addslashes($this->input->post('orgname'));
        $org_address = addslashes($this->input->post('orgadd'));
        $org_phone = addslashes($this->input->post('orgphone'));
        $org_phoneext = addslashes($this->input->post('orgphoneext'));
        $org_web = addslashes($this->input->post('orgweb'));
        $org_notes = addslashes($this->input->post('orgnotes'));

        if ($org_phoneext == '')
            $org_ph = "$org_phone";
        else if ($org_phoneext != '')
        {
            $org_ph = "X$org_phoneext";
            $org_ph = "$org_phone$org_ph";
        }

        $orgnamecheck = $this->db->query("SELECT * FROM ost_organization_test WHERE id != '$org_id' AND name = '$org_name' ")->num_rows();

            if ($orgnamecheck != '0'){
                echo "<script> alert(' Organization name duplicated');</script>";
            }

            else{

        $this->db->query("UPDATE ost_organization_test 
            SET name = '$org_name', updated = NOW() WHERE id = '$org_id'");

        $this->db->query("UPDATE ost_organization__cdata_test
            SET address = '$org_address' ,
                phone = '$org_ph',
                website = '$org_web',
                notes = '$org_notes'
            WHERE org_id = '$org_id'");

        if ($org_notes != "")
            $this->db->query("UPDATE ost_organization__cdata_test 
                SET orgnote_poster = '$poster_id', orgnote_created = now() WHERE org_id = '$org_id'");
        else
            $this->db->query("UPDATE ost_organization__cdata_test 
                SET orgnote_poster = '0', orgnote_created = NULL WHERE org_id = '$org_id'");

        echo "<script> alert('Edit successfuly');</script>";
        }
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";
    }

    public function user_notes()
    {
        $user_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];
        $usernote = addslashes($this->input->post('usernote'));

        $this->db->query("UPDATE ost_user_test 
            SET notes = '$usernote', usernote_poster = '$poster_id', usernote_created = now() ,user_updated_at = NOW() WHERE user_id = '$user_id'");

        redirect('staff_user_controller/user_info?id='.$user_id);
    }

    public function deleteusernote()
    {
        $user_id = $_REQUEST['id'];

        $this->db->query("UPDATE ost_user_test SET notes = NULL, usernote_poster = '0', usernote_created = NULL, user_updated_at = NOW() WHERE user_id = '$user_id'");

        redirect('staff_user_controller/user_info?id='.$user_id);
    }

    public function organization()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

        $staffid = $_SESSION["staffid"];    
        $data = array(
            'organization' => $this->db->query("SELECT * FROM ost_organization_test"), 

            'creteorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%org.create%'")->num_rows(),

            'deleteorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%org.delete%'")->num_rows(),

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
                $this->load->view('staff/staff_organization',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function createorg()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $poster_id = $_SESSION["staffid"]; 
            $org_name = addslashes($this->input->post('orgname'));
            $org_address = addslashes($this->input->post('orgadd'));
            $org_phone = addslashes($this->input->post('orgphone'));
            $org_phoneext = addslashes($this->input->post('orgphoneext'));
            $org_web = addslashes($this->input->post('orgweb'));
            $org_notes = addslashes($this->input->post('orgnotes'));

            if ($org_phoneext == '')
                $org_ph = "$org_phone";
            else if ($org_phoneext != '')
            {
                $org_ph = "X$org_phoneext";
                $org_ph = "$org_phone$org_ph";
            }

            $orgnamecheck = $this->db->query("SELECT * FROM ost_organization_test WHERE name = '$org_name' ");

            if ($orgnamecheck->num_rows() == 0)
            {
                $createorg = $this->db->query("INSERT INTO ost_organization_test ( name, autoassignment, ticketsharing, status, created, updated )
                VALUES ( '$org_name', '0', '0', '8', now(), now() )");

                $org_id = $this->db->query("SELECT * FROM ost_organization_test WHERE name = '$org_name'")->row('id');

                $orgdata = $this->db->query("INSERT INTO ost_organization__cdata_test ( org_id, address, phone, website, notes )
                VALUES ( '$org_id', '$org_address', '$org_ph', '$org_web', '$org_notes' )");

                if ($org_notes !="")
                    $this->db->query("UPDATE ost_organization__cdata_test SET orgnote_poster = '$poster_id', orgnote_created = now() WHERE org_id = '$org_id'");

                redirect('staff_user_controller/org_info?id='.$org_id);
            }

            else if ($orgnamecheck->num_rows() != 0)
            {
                echo "<script> alert('Name Duplicated');
                    window.location = 'organization';</script>";
            }
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function org_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $staffid = $_SESSION["staffid"];
            $org_id = $_REQUEST['id'];

            $orgphone = $this->db->query("SELECT * FROM ost_organization__cdata_test WHERE org_id = $org_id")->row('phone');
            $splitarr = explode('X', $orgphone);

            if (count($splitarr) == "2")
            {
                $phone = $splitarr[0];
                $phoneext = $splitarr[1];
            }
            else
            {
                $phone = "";
                $phoneext = "";
            }

            $data = array(
                'orgresult' => $this->db->query("SELECT a.*, b.*, c.*, b.notes AS orgnote, c.notes AS staffnote, a.created AS orgcreated, a.updated AS orgupdated FROM ost_organization_test AS a
                    INNER JOIN ost_organization__cdata_test AS b ON a.id = b.org_id
                    LEFT JOIN ost_staff_test AS c ON c.staff_id = b.orgnote_poster
                    WHERE id = $org_id"),
                'userinfo' => $this->db->query("SELECT * FROM ost_user_test
                    WHERE user_org_id = $org_id"),
                'tinfo' => $this->db->query("SELECT * FROM ost_user_test AS a
                    INNER JOIN ost_ticket_test AS b ON a.user_id = b.user_id
                    INNER JOIN ost_ticket_status_test AS c ON b.status_id = c.id
                    INNER JOIN ost_help_topic_test AS d ON b.topic_id = d.topic_id
                    WHERE a.user_org_id = $org_id"),
                'orgstaff' => $this->db->query("SELECT * FROM ost_staff_test"),
                'orgteam' => $this->db->query("SELECT * FROM ost_team_test"),
                'phone' => $phone,
                'phoneext' => $phoneext,
                'adduserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.create%'")->num_rows(),
                'deleteuserallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%user.delete%'")->num_rows(),
                'editorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%org.edit%'")->num_rows(),
                'deleteorgallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_id = ' $staffid' AND permissions LIKE '%org.delete%'")->num_rows(),
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
                $this->load->view('staff/staff_organization_info', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

        public function org_infodelete()

    {

        $deleteticket = $this->input->post('deleteticket');
        $org_id = $_REQUEST['id'];


                $this->db->query("DELETE FROM osticket.ost_organization_test WHERE id = '$org_id'");
                $this->db->query("DELETE FROM osticket.ost_organization__cdata_test WHERE org_id = '$org_id'");
                $this->db->query("UPDATE osticket.ost_user_test SET user_org_id = '0', user_updated_at = now() WHERE user_org_id = '$org_id'");
        
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/organization' </script>";
    }

    public function org_infoadduser()
    {
        $user_email = addslashes($this->input->post('email'));
        $user_name = addslashes($this->input->post('fullname'));
        $user_phone = addslashes($this->input->post('phone'));
        $user_phoneext = addslashes($this->input->post('phoneext'));
        $user_note = addslashes($this->input->post('note'));
        $org_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];

        $splitemail = explode('@', $user_email);
        $domain = '@'.$splitemail[1];
        $org = $this->db->query("SELECT * FROM ost_organization_test");

        $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' OR user_email = '$user_email' ");
        $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email' ");
        $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' ");

        if($usercheck->num_rows() == 0)
        {
            foreach ($org->result() as $orgdomain)
            {
                if ($orgdomain->id != $org_id && $orgdomain->domain == $domain)
                {
                    echo "<script> alert('Users email domain have been set as default domain for organization $orgdomain->name. Kindly change the setting in organization page if you want to add users to another organization.');</script>";
                    echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";die;
                }
            }

            $sql = $this->db->query("INSERT INTO osticket.ost_user_test ( user_org_id, user_name, user_created_at, user_updated_at, user_depart, user_email, user_phone, user_phoneext, notes, status, active)
            VALUES ('$org_id', '$user_name', now(), now(), '1', '$user_email', '$user_phone', '$user_phoneext' ,'$user_note', '4' , '0')");

            $user_id = $this->db->query("SELECT user_id FROM ost_user_test WHERE user_created_at = now()")->row('user_id');

            if ($user_note != "")
                $this->db->query("UPDATE ost_user_test SET usernote_poster = '$poster_id', usernote_created = now(), user_updated_at = NOW() WHERE user_name = '$user_name'");
            
            redirect('staff_user_controller/org_info?id='.$org_id);
        }

        else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
        {
            echo "<script> alert('User already exists');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/main' </script>";
        }

        else if ($emailcheck->num_rows() !== 0)
        {
            echo "<script> alert('Email duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
        }

        else if ($namecheck->num_rows() !== 0)
        {
            echo "<script> alert('Name duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
        }
    }

    public function org_infodeleteuser()
    {

        $check = $this->input->post('tids[]');
        $org_id = $_REQUEST['id'];

        foreach ($check as $value) {

            $this->db->query("UPDATE osticket.ost_user_test SET user_org_id = '0', user_updated_at = NOW() WHERE user_id = '$value' ");

        }
        echo "<script> alert('Successfully Remove');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
    }

    public function org_infoeditorg()
    {
        $org_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];
        $org_name = addslashes($this->input->post('orgname'));
        $org_address = addslashes($this->input->post('orgadd'));
        $org_phone = addslashes($this->input->post('orgphone'));
        $org_phoneext = addslashes($this->input->post('orgphoneext'));
        $org_web = addslashes($this->input->post('orgweb'));
        $org_notes = addslashes($this->input->post('orgnotes'));

        if ($org_phoneext == '')
            $org_ph = "$org_phone";
        else if ($org_phoneext != '')
        {
            $org_ph = "X$org_phoneext";
            $org_ph = "$org_phone$org_ph";
        }

        $orgnamecheck = $this->db->query("SELECT * FROM ost_organization_test WHERE id != '$org_id' AND name = '$org_name' ")->num_rows();

        if ($orgnamecheck != '0'){
            echo "<script> alert(' Organization name duplicated');</script>";
        }

        else{

            $createorg = $this->db->query("UPDATE ost_organization_test 
                SET name = '$org_name', updated = NOW() WHERE id = '$org_id'");

            $orgdata = $this->db->query("UPDATE ost_organization__cdata_test
                SET address = '$org_address',
                    phone = '$org_ph',
                    website = '$org_web',
                    notes = '$org_notes'
                WHERE org_id = '$org_id'");

            if ($org_notes != "")
                $this->db->query("UPDATE ost_organization__cdata_test 
                    SET orgnote_poster = '$poster_id', orgnote_created = now() WHERE org_id = '$org_id'");
            else
                $this->db->query("UPDATE ost_organization__cdata_test 
                    SET orgnote_poster = '0', orgnote_created = NULL WHERE org_id = '$org_id'");

            $manager = $this->input->post('manager');
            $autoassign = $this->input->post('autoassign');
            $contacts = $this->input->post('contacts[]');
            $autoassign = $this->input->post('autoassign');
            $sharing = $this->input->post('sharing');
            $domain = addslashes($this->input->post('domain'));
            $user = $this->db->query("SELECT * FROM ost_user_test");

            $this->db->query("UPDATE ost_user_test SET user_primary = '0', user_updated_at = now() WHERE user_org_id = $org_id");

            if ($contacts != "") {
                foreach($contacts as $contact)
                {
                    $data['contacts'] = $contact;
                }

                for($i=0; $i<count($contacts); $i++)
                {
                    $this->db->query("UPDATE ost_user_test SET user_primary = '1' WHERE user_id = $contacts[$i]");
                }
            }

            $this->db->query("UPDATE ost_organization_test
                SET manager = '$manager' ,
                    autoassignment = '$autoassign',
                    ticketsharing = '$sharing',
                    domain = '$domain',
                    updated = now()
                WHERE id = '$org_id'");

            if ($autoassign == '1' && $manager != '')
            {
                if ($manager{0} == 'a')
                {
                    $autostaff_id = substr($manager, 1);
                    $autoteam_id = '0';
                }
                else if ($manager{0} == 't')
                {
                    $autoteam_id = substr($manager, 1);
                    $autostaff_id = '0';
                }

                $userid = $this->db->query("SELECT * FROM ost_user_test AS a
                    LEFT JOIN ost_organization_test AS b ON a.user_org_id = b.id
                    WHERE b.id = '$org_id'");

                foreach ($userid->result() as $userassign)
                {
                    $this->db->query("UPDATE ost_ticket_test SET assigned_to = '$autostaff_id', team_id = '$autoteam_id', ticket_updated = now(), ticket_updated_by_id = '$poster_id', ticket_updated_by_role = 'agent' WHERE user_id = '$userassign->user_id'");
                }
            }
            
            foreach ($user->result() as $userorg) {
                $splitemail = explode('@', $userorg->user_email);
                $userdomain = '@'.$splitemail[1];
                $org = $this->db->query("SELECT * FROM ost_organization_test");
                $user_id = $userorg->user_id;

                foreach ($org->result() as $orgdomain)
                {
                    if ($domain == $userdomain)
                        $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");
                }
            }

            echo "<script> alert('Successfully edit');</script>";
        }
        
        echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
    }

    public function org_notes()
    {
        $org_id = $_REQUEST['id'];
        $poster_id = $_SESSION['staffid'];
        $orgnote = addslashes($this->input->post('orgnote'));

        $this->db->query("UPDATE ost_organization__cdata_test
            SET notes = '$orgnote', orgnote_poster = '$poster_id', orgnote_created = now() WHERE org_id = '$org_id'");

        redirect('staff_user_controller/org_info?id='.$org_id);
    }

    public function deleteorgnote()
    {
        $org_id = $_REQUEST['id'];

        $this->db->query("UPDATE ost_organization__cdata_test SET notes = NULL, orgnote_poster = '0', orgnote_created = NULL WHERE org_id = '$org_id'");

        redirect('staff_user_controller/org_info?id='.$org_id);
    }

    public function userinfo_assignorg()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $org_id = $_REQUEST['oid'];
            $user_id = $_REQUEST['id'];

            $this->db->query("UPDATE ost_user_test SET user_org_id = '$org_id',user_updated_at = NOW() WHERE user_id='$user_id' ");
            echo "<script> alert('Successfully Assigned');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/user_info?id=$user_id' </script>";
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    //ajax search user assign org
    public function fetch_org()
    {
        $user_id = $_REQUEST['id'];
        $output = '';
        $query = '';
        $this->load->model('ajaxsearch_model');
        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
       
        $data = $this->ajaxsearch_model->fetch_data($query);
        
        if ($query == '') {
            $output .= '
          
            ';
        }

        else if($data->num_rows() > 0)
        {
            $output .= '
                <div style="background-color: lightyellow;border-style:groove;border-width:1px;">
            ';

            foreach($data->result() as $row)
            {
                $output .= '
                <div style="border-style:groove;border-width:1px;">
                    -- <b><a href ="userinfo_assignorg?oid='.$row->id.'&id='.$user_id.'">
                        '.$row->name.'
                    </a></b><br>
                </div>
                ';
            }

            $output .= '
                </div>
            ';
        }
      
        else
        {
            $output .= '<tr>
                <td colspan="5">No Data Found</td>
            </tr>';
        }
      
        echo $output;
    }

    public function userinfo_assignuser()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
            $org_id = $_REQUEST['oid'];
            $user_id = $_REQUEST['id'];

            $this->db->query("UPDATE ost_user_test SET user_org_id = '$org_id',user_updated_at = NOW() WHERE user_id='$user_id' ");
            echo "<script> alert('Successfully Assigned');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_user_controller/org_info?id=$org_id' </script>";
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    //ajax search user assign org
    public function fetch_user()
    {
        $org_id = $_REQUEST['id'];
        $output = '';
        $query = '';
        $this->load->model('ajaxsearch_model');

        if($this->input->post('query'))
        {
            $query = $this->input->post('query');
        }
       
        $data = $this->ajaxsearch_model->fetch_data_user($query);
        
        if ($query == '') {
            $output .= '
            ';
        }

        else if($data->num_rows() > 0)
        {
            $output .= '
                <div style="background-color: lightyellow;border-style:groove;border-width:1px;">
            ';

            foreach($data->result() as $row)
            {
                $output .= '
                <div style="border-style:groove;border-width:1px;">
                    -- <a href ="userinfo_assignuser?id='.$row->user_id.'&oid='.$org_id.'">
                        <b>'.$row->user_name.' ('.$row->user_email.')</b>
                    </a>
                <br></div>
                ';
            }

            $output .= '
                </div>
            ';
        }
      
        else
        {
            $output .= '<tr>
                <td colspan="5">No Data Found</td>
            </tr>';
        }
      
        echo $output;
    }

}

?>